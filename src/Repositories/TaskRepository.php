<?php

namespace XXJ\Repositories;

use XXJ\Core\Database;
use XXJ\Models\Task;
use PDO;

class TaskRepository
{
    private PDO $db;
    private PlayerRepository $playerRepo;
    private ItemRepository $itemRepo;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
        $this->playerRepo = new PlayerRepository();
        $this->itemRepo = new ItemRepository();
    }

    public function findById($rwid): ?Task
    {
        $stmt = $this->db->prepare("SELECT * FROM renwu WHERE rwid = ?");
        $stmt->execute([$rwid]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($data) {
            return new Task($data);
        }
        return null;
    }

    public function getPlayerTasks($sid)
    {
        $stmt = $this->db->prepare("SELECT * FROM playerrenwu WHERE sid = ? AND rwzt != 3");
        $stmt->execute([$sid]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function getPlayerTask($sid, $rwid)
    {
        $stmt = $this->db->prepare("SELECT * FROM playerrenwu WHERE sid = ? AND rwid = ?");
        $stmt->execute([$sid, $rwid]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function acceptTask($sid, Task $task)
    {
        $day = 0;
        if ($task->rwlx == 2) {
            $day = date('d');
        }
        
        // Check if already accepted
        if ($this->getPlayerTask($sid, $task->rwid)) {
            return false;
        }

        $rwzt = 1;
        // If Dialogue task (3), set status to 2 immediately?
        // Legacy: if ($task->rwzl==3){ $sql = "update `playerrenwu` set rwzt = 2 ..."; }
        // So yes, start with 2 if type 3.
        if ($task->rwzl == 3) {
            $rwzt = 2;
        }

        $sql = "INSERT INTO playerrenwu(rwname, rwzl, rwdj, rwzb, rwexp, rwyxb, sid, rwzt, rwid, rwyq, rwcount, rwlx, `data`) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            $task->rwname, $task->rwzl, $task->rwdj, $task->rwzb, $task->rwexp, $task->rwyxb, 
            $sid, $rwzt, $task->rwid, $task->rwyq, $task->rwcount, $task->rwlx, $day
        ]);
        
        // If Collection task (1), check if player already has items and update progress
        if ($task->rwzl == 1) {
            // rwyq is item ID
            $stmt = $this->db->prepare("SELECT djsum FROM playerdaoju WHERE sid = ? AND djid = ?");
            $stmt->execute([$sid, $task->rwyq]);
            $count = $stmt->fetchColumn();
            if ($count) {
                $this->updateTaskProgress($sid, $task->rwid, $count);
            }
        }
        
        return true;
    }

    public function updateTaskProgress($sid, $rwid, $progress)
    {
        // Update rwnowcount. If >= rwcount, set rwzt = 2
        $playerTask = $this->getPlayerTask($sid, $rwid);
        if (!$playerTask) return;
        
        $newCount = $progress; // Or $playerTask->rwnowcount + $progress? 
        // For collection, it's usually current inventory count.
        // For kills, it's incremental.
        // Legacy `changerwyq` sets it to specific value.
        
        $rwzt = $playerTask->rwzt;
        if ($newCount >= $playerTask->rwcount) {
            $rwzt = 2;
        }
        
        $stmt = $this->db->prepare("UPDATE playerrenwu SET rwnowcount = ?, rwzt = ? WHERE sid = ? AND rwid = ?");
        $stmt->execute([$newCount, $rwzt, $sid, $rwid]);
    }
    
    public function incrementTaskProgress($sid, $rwid, $amount = 1)
    {
        $playerTask = $this->getPlayerTask($sid, $rwid);
        if (!$playerTask) return;
        
        $newCount = $playerTask->rwnowcount + $amount;
        $rwzt = $playerTask->rwzt;
        if ($newCount >= $playerTask->rwcount) {
            $rwzt = 2;
        }
        
        $stmt = $this->db->prepare("UPDATE playerrenwu SET rwnowcount = ?, rwzt = ? WHERE sid = ? AND rwid = ?");
        $stmt->execute([$newCount, $rwzt, $sid, $rwid]);
    }

    public function updateTaskStatus($sid, $rwid, $status)
    {
        $stmt = $this->db->prepare("UPDATE playerrenwu SET rwzt = ? WHERE sid = ? AND rwid = ?");
        $stmt->execute([$status, $sid, $rwid]);
    }
    
    public function submitTask($sid, $rwid)
    {
        $task = $this->findById($rwid);
        $playerTask = $this->getPlayerTask($sid, $rwid);
        
        if (!$task || !$playerTask || $playerTask->rwzt != 2) {
            return "Điều kiện không thỏa mãn.";
        }
        
        // Double check requirements
        if ($task->rwzl == 1) {
            // Check items again
             $stmt = $this->db->prepare("SELECT djsum FROM playerdaoju WHERE sid = ? AND djid = ?");
             $stmt->execute([$sid, $task->rwyq]);
             $count = $stmt->fetchColumn();
             if ($count < $task->rwcount) {
                 return "Không đủ vật phẩm.";
             }
             // Consume items
             $this->itemRepo->removeItem($sid, $task->rwyq, $task->rwcount);
        }
        
        // Mark as finished (3)
        $this->updateTaskStatus($sid, $rwid, 3);
        $stmt = $this->db->prepare("UPDATE playerrenwu SET rwnowcount = 0 WHERE sid = ? AND rwid = ?");
        $stmt->execute([$sid, $rwid]);
        
        // Rewards
        if ($task->rwexp > 0) {
            $this->playerRepo->updateExp($sid, $task->rwexp);
        }
        if ($task->rwyxb > 0) {
            $this->playerRepo->updateCurrency($sid, 'uyxb', $task->rwyxb);
        }
        
        // Item Rewards (rwdj format: id|count,id|count)
        if ($task->rwdj) {
            $items = explode(',', $task->rwdj);
            foreach ($items as $itemStr) {
                $parts = explode('|', $itemStr);
                if (count($parts) == 2) {
                    $this->itemRepo->addItem($sid, $parts[0], $parts[1]);
                }
            }
        }
        
        // Potion Rewards (rwyp format: id|count)
        if ($task->rwyp) {
            $potions = explode(',', $task->rwyp);
            foreach ($potions as $potionStr) {
                $parts = explode('|', $potionStr);
                if (count($parts) == 2) {
                    $this->itemRepo->addPotion($sid, $parts[0], $parts[1]);
                }
            }
        }
        
        // Equipment Rewards (rwzb format: id,id)
        if ($task->rwzb) {
            $zbs = explode(',', $task->rwzb);
            foreach ($zbs as $zbid) {
                $this->itemRepo->addEquipment($sid, $zbid);
            }
        }
        
        return "Nhiệm vụ hoàn thành!";
    }
    
    public function getNpcTasks($nid, $sid)
    {
        // Placeholder logic. Real logic involves checking task requirements vs player state.
        // For now return empty array or fetch from DB if table exists.
        // Legacy `npc/npc.php` calls `player\gettask($nid, $dblj)`.
        return [];
    }
}
