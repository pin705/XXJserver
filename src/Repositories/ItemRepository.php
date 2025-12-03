<?php

namespace XXJ\Repositories;

use XXJ\Core\Database;
use XXJ\Models\Item;
use PDO;

class ItemRepository
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function findById($zbnowid): ?Item
    {
        $stmt = $this->db->prepare("SELECT * FROM playerzhuangbei WHERE zbnowid = ?");
        $stmt->execute([$zbnowid]);
        $data = $stmt->fetch();

        if ($data) {
            return new Item($data);
        }
        return null;
    }

    public function getPlayerEquipment($sid, $offset = 0, $limit = 10)
    {
        $stmt = $this->db->prepare("SELECT * FROM playerzhuangbei WHERE sid = ? LIMIT ?, ?");
        // PDO limit params need to be integers
        $stmt->bindValue(1, $sid, PDO::PARAM_STR);
        $stmt->bindValue(2, (int)$offset, PDO::PARAM_INT);
        $stmt->bindValue(3, (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        
        $items = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $items[] = new Item($row);
        }
        return $items;
    }

    public function countPlayerEquipment($sid)
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM playerzhuangbei WHERE sid = ?");
        $stmt->execute([$sid]);
        return $stmt->fetchColumn();
    }

    public function getPlayerPotions($sid)
    {
        $stmt = $this->db->prepare("SELECT p.*, y.ypname, y.yphp, y.ypmp FROM playeryaopin p LEFT JOIN yaopin y ON p.ypid = y.ypid WHERE p.sid = ? AND p.djsum > 0");
        $stmt->execute([$sid]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function getPlayerDaoju($sid)
    {
        $stmt = $this->db->prepare("SELECT * FROM playerdaoju WHERE sid = ? AND djsum > 0");
        $stmt->execute([$sid]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function deleteItem($zbnowid, $sid)
    {
        $stmt = $this->db->prepare("DELETE FROM playerzhuangbei WHERE zbnowid = ? AND sid = ?");
        return $stmt->execute([$zbnowid, $sid]);
    }

    public function getEquipmentTemplate($zbid): ?Item
    {
        $stmt = $this->db->prepare("SELECT * FROM zhuangbei WHERE zbid = ?");
        $stmt->execute([$zbid]);
        $data = $stmt->fetch();

        if ($data) {
            return new Item($data);
        }
        return null;
    }

    public function getItemTemplate($djid): ?Item
    {
        $stmt = $this->db->prepare("SELECT * FROM daoju WHERE djid = ?");
        $stmt->execute([$djid]);
        $data = $stmt->fetch();

        if ($data) {
            // Map daoju fields to Item model if necessary, or just return object
            // Assuming Item model is flexible or I should use stdClass/array
            // For now, let's assume Item model can handle it or I'll return object
            return (object)$data;
        }
        return null;
    }

    public function getPotionTemplate($ypid): ?Item
    {
        $stmt = $this->db->prepare("SELECT * FROM yaopin WHERE ypid = ?");
        $stmt->execute([$ypid]);
        $data = $stmt->fetch();

        if ($data) {
            return (object)$data;
        }
        return null;
    }

    public function getPlayerPotion($sid, $ypid)
    {
        $stmt = $this->db->prepare("SELECT * FROM playeryaopin WHERE sid = ? AND ypid = ?");
        $stmt->execute([$sid, $ypid]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function addEquipment($sid, $zbid)
    {
        $template = $this->getEquipmentTemplate($zbid);
        if (!$template) return false;
        
        $sql = "INSERT INTO playerzhuangbei (zbname, zbinfo, zbgj, zbfy, zbbj, zbxx, zbid, zbhp, sid, zblv, zbqianghua) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 0)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $template->zbname, $template->zbinfo, $template->zbgj, $template->zbfy, 
            $template->zbbj, $template->zbxx, $zbid, $template->zbhp, $sid, $template->zblv
        ]);
    }

    public function addItem($sid, $djid, $amount)
    {
        // Check if exists
        $stmt = $this->db->prepare("SELECT * FROM playerdaoju WHERE sid = ? AND djid = ?");
        $stmt->execute([$sid, $djid]);
        $existing = $stmt->fetch(PDO::FETCH_OBJ);
        
        if ($existing) {
            $stmt = $this->db->prepare("UPDATE playerdaoju SET djsum = djsum + ? WHERE sid = ? AND djid = ?");
            return $stmt->execute([$amount, $sid, $djid]);
        } else {
            $template = $this->getItemTemplate($djid);
            if (!$template) return false;
            
            $sql = "INSERT INTO playerdaoju (djname, djinfo, djsum, djid, sid) VALUES (?, ?, ?, ?, ?)";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$template->djname, $template->djinfo, $amount, $djid, $sid]);
        }
    }

    public function removeItem($sid, $djid, $amount)
    {
        $stmt = $this->db->prepare("UPDATE playerdaoju SET djsum = djsum - ? WHERE sid = ? AND djid = ? AND djsum >= ?");
        return $stmt->execute([$amount, $sid, $djid, $amount]);
    }

    public function addPotion($sid, $ypid, $amount)
    {
        // Similar to addItem but for playeryaopin
        $stmt = $this->db->prepare("SELECT * FROM playeryaopin WHERE sid = ? AND ypid = ?");
        $stmt->execute([$sid, $ypid]);
        $existing = $stmt->fetch(PDO::FETCH_OBJ);
        
        if ($existing) {
            $stmt = $this->db->prepare("UPDATE playeryaopin SET ypsum = ypsum + ? WHERE sid = ? AND ypid = ?");
            return $stmt->execute([$amount, $sid, $ypid]);
        } else {
            $template = $this->getPotionTemplate($ypid);
            if (!$template) return false;
            
            $sql = "INSERT INTO playeryaopin (ypname, yphp, ypgj, ypfy, ypbj, ypxx, ypid, ypsum, sid) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                $template->ypname, $template->yphp, $template->ypgj, $template->ypfy, 
                $template->ypbj, $template->ypxx, $ypid, $amount, $sid
            ]);
        }
    }

    public function getPlayerDaojuSingle($sid, $djid)
    {
        $stmt = $this->db->prepare("SELECT * FROM playerdaoju WHERE sid = ? AND djid = ?");
        $stmt->execute([$sid, $djid]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function usePotion($sid, $ypid)
    {
        $potion = $this->getPlayerPotion($sid, $ypid);
        if (!$potion || $potion->djsum <= 0) {
            return false;
        }

        // Get template for effect
        $template = $this->getPotionTemplate($ypid);
        if (!$template) return false;

        // Deduct count
        if ($potion->djsum > 1) {
            $stmt = $this->db->prepare("UPDATE playeryaopin SET djsum = djsum - 1 WHERE sid = ? AND ypid = ?");
            $stmt->execute([$sid, $ypid]);
        } else {
            $stmt = $this->db->prepare("DELETE FROM playeryaopin WHERE sid = ? AND ypid = ?");
            $stmt->execute([$sid, $ypid]);
        }

        // Apply Effect (HP)
        // Need PlayerRepository to update HP. 
        // But Repositories shouldn't depend on each other circularly if possible.
        // Ideally Controller handles the effect application, or we use a Service.
        // But for now, I'll just update HP directly here or return the effect to Controller.
        // Returning effect is better.
        
        // Actually, let's update HP here using direct SQL to avoid circular dependency with PlayerRepo if it uses ItemRepo.
        // Or just instantiate PlayerRepo inside method if needed, or pass it.
        // Let's do direct SQL for simplicity and speed.
        
        if ($template->yphp > 0) {
            $stmt = $this->db->prepare("UPDATE game1 SET uhp = LEAST(umaxhp, uhp + ?) WHERE sid = ?");
            $stmt->execute([$template->yphp, $sid]);
        }
        
        return true;
    }

    public function getPlayerYaoDan($sid)
    {
        $stmt = $this->db->prepare("SELECT * FROM playeryaodan WHERE sid = ? AND ydsum > 0");
        $stmt->execute([$sid]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function getPlayerYaoDanSingle($sid, $ydid)
    {
        $stmt = $this->db->prepare("SELECT * FROM playeryaodan WHERE sid = ? AND ydid = ?");
        $stmt->execute([$sid, $ydid]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function getYaoDanTemplate($ydid)
    {
        $stmt = $this->db->prepare("SELECT * FROM yaodan WHERE ydid = ?");
        $stmt->execute([$ydid]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function useYaoDan($sid, $ydid)
    {
        $playerPill = $this->getPlayerYaoDanSingle($sid, $ydid);
        if (!$playerPill || $playerPill->ydsum < 1) return false;

        // Deduct
        if ($playerPill->ydsum > 1) {
            $stmt = $this->db->prepare("UPDATE playeryaodan SET ydsum = ydsum - 1 WHERE sid = ? AND ydid = ?");
            $stmt->execute([$sid, $ydid]);
        } else {
            $stmt = $this->db->prepare("DELETE FROM playeryaodan WHERE sid = ? AND ydid = ?");
            $stmt->execute([$sid, $ydid]);
        }

        // Apply Stats
        // ydhp, ydgj, ydfy, ydbj, ydxx
        $stmt = $this->db->prepare("
            UPDATE game1 
            SET uhp = uhp + ?, 
                ugj = ugj + ?, 
                ufy = ufy + ?, 
                ubj = ubj + ?, 
                uxx = uxx + ? 
            WHERE sid = ?
        ");
        $stmt->execute([
            $playerPill->ydhp,
            $playerPill->ydgj,
            $playerPill->ydfy,
            $playerPill->ydbj,
            $playerPill->ydxx,
            $sid
        ]);

        return true;
    }

    public function getAllShopItems()
    {
        $stmt = $this->db->query("SELECT * FROM yaodan");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getShopItem($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM yaodan WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addPlayerShopItem($sid, $item, $count)
    {
        // Check if player already has this item
        $stmt = $this->db->prepare("SELECT * FROM playeryaodan WHERE sid = ? AND ydid = ?");
        $stmt->execute([$sid, $item['ydid']]);
        $existing = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($existing) {
            $stmt = $this->db->prepare("UPDATE playeryaodan SET ydsum = ydsum + ? WHERE sid = ? AND ydid = ?");
            $stmt->execute([$count, $sid, $item['ydid']]);
        } else {
            $stmt = $this->db->prepare("INSERT INTO playeryaodan (ydname, ydhp, ydgj, ydfy, ydbj, ydxx, ydid, ydjg, ydsum, sid, ydjgm) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([
                $item['ydname'],
                $item['ydhp'],
                $item['ydgj'],
                $item['ydfy'],
                $item['ydbj'],
                $item['ydxx'],
                $item['ydid'],
                $item['jiage'], // Assuming jiage is price
                $count,
                $sid,
                $item['ydjgm'] ?? 0
            ]);
        }
    }
}
