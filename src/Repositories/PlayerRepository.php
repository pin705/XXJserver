<?php

namespace XXJ\Repositories;

use XXJ\Core\Database;
use XXJ\Models\Player;
use PDO;

class PlayerRepository
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function findBySid(string $sid): ?Player
    {
        $stmt = $this->db->prepare("SELECT * FROM game1 WHERE sid = ?");
        $stmt->execute([$sid]);
        $data = $stmt->fetch();

        if ($data) {
            $player = new Player($data);
            $this->calculateStats($player);
            return $player;
        }

        return null;
    }

    private function calculateStats(Player $player)
    {
        $tools = [$player->tool1, $player->tool2, $player->tool3, $player->tool4, $player->tool5, $player->tool6, $player->tool7];
        $itemRepo = new ItemRepository();

        foreach ($tools as $toolId) {
            if ($toolId != 0) {
                $item = $itemRepo->findById($toolId);
                if ($item) {
                    $player->ugj += $item->zbgj;
                    $player->ufy += $item->zbfy;
                    $player->ubj += $item->zbbj;
                    $player->uxx += $item->zbxx;
                    $player->umaxhp += $item->zbhp;
                }
            }
        }

        if ($player->tfgj != 0) $player->ugj += $player->tfgj * 5;
        if ($player->tfbj != 0) $player->ubj += $player->tfbj * 1.5;
        if ($player->tfxx != 0) $player->uxx += $player->tfxx * 2;
        if ($player->tfhp != 0) $player->umaxhp += $player->tfhp * 10;
        if ($player->tffy != 0) $player->ufy += $player->tffy * 5;
        
        // Set jingjie property for compatibility
        if (method_exists($player, 'getJingjie')) {
            $player->jingjie = $player->getJingjie();
        }
    }


    public function findByToken(string $token): ?Player
    {
        $stmt = $this->db->prepare("SELECT * FROM game1 WHERE token = ?");
        $stmt->execute([$token]);
        $data = $stmt->fetch();

        if ($data) {
            return new Player($data);
        }

        return null;
    }

    public function create(array $data): bool
    {
        $sql = "INSERT INTO game1(token, sid, uname, ulv, uyxb, uczb, uexp, uhp, umaxhp, ugj, ufy, uwx, usex, vip, nowmid, endtime, sfzx, shenfen) 
                VALUES (?, ?, ?, '1', '2000', '100', '0', '35', '35', '12', '5', '0', ?, '0', ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $data['token'], 
            $data['sid'], 
            $data['uname'], 
            $data['sex'], 
            $data['nowmid'], 
            $data['endtime'], 
            $data['shenfen'], 
            $data['shenfen']
        ]);
    }

    public function updateLoginStatus(string $sid, string $time): void
    {
        $stmt = $this->db->prepare("UPDATE game1 SET endtime=?, sfzx=1 WHERE sid=?");
        $stmt->execute([$time, $sid]);
    }

    public function updateMap($sid, $mid)
    {
        $stmt = $this->db->prepare("UPDATE game1 SET nowmid = ? WHERE sid = ?");
        $stmt->execute([$mid, $sid]);
    }

    public function unequipItem($sid, $slot)
    {
        // Validate slot to prevent SQL injection if not using prepared statement for column name
        // But here we use column name in query, so we must validate
        if (!in_array($slot, [1, 2, 3, 4, 5, 6, 7])) return;
        
        $sql = "UPDATE game1 SET tool{$slot} = 0 WHERE sid = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$sid]);
    }

    public function equipItem($sid, $slot, $itemId)
    {
        if (!in_array($slot, [1, 2, 3, 4, 5, 6, 7])) return;

        $sql = "UPDATE game1 SET tool{$slot} = ? WHERE sid = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$itemId, $sid]);
    }

    public function updateHp($sid, $hp)
    {
        $stmt = $this->db->prepare("UPDATE game1 SET uhp = ? WHERE sid = ?");
        $stmt->execute([$hp, $sid]);
    }

    public function usePotion($sid, $ypid)
    {
        $player = $this->findBySid($sid);
        if ($player->uhp <= 0) {
            return false;
        }

        // Check if player has potion
        $stmt = $this->db->prepare("SELECT * FROM playeryaopin WHERE ypid = ? AND sid = ?");
        $stmt->execute([$ypid, $sid]);
        $potion = $stmt->fetch(PDO::FETCH_OBJ);

        if (!$potion || $potion->ypsum < 1) {
            return false;
        }

        // Deduct potion
        $stmt = $this->db->prepare("UPDATE playeryaopin SET ypsum = ypsum - 1 WHERE ypid = ? AND sid = ?");
        $stmt->execute([$ypid, $sid]);

        // Get potion template for stats
        $stmt = $this->db->prepare("SELECT * FROM yaopin WHERE ypid = ?");
        $stmt->execute([$ypid]);
        $template = $stmt->fetch(PDO::FETCH_OBJ);

        if ($template) {
            // Heal HP
            $heal = $template->yphp;
            $missingHp = $player->umaxhp - $player->uhp;
            $actualHeal = min($heal, $missingHp);
            
            if ($actualHeal > 0) {
                $stmt = $this->db->prepare("UPDATE game1 SET uhp = uhp + ? WHERE sid = ?");
                $stmt->execute([$actualHeal, $sid]);
            }

            // Apply buffs (Permanent? Or temporary?)
            // Legacy code uses addplayersx which updates game1 table. So it's permanent stats increase?
            // That seems powerful for a potion.
            // Or maybe game1 stats are temporary/current stats?
            // ugj, ufy are base stats.
            // If potions permanently increase stats, that's a mechanic.
            // I will follow legacy code: update game1.
            
            $updates = [];
            $params = [];
            
            if ($template->ypgj > 0) {
                $updates[] = "ugj = ugj + ?";
                $params[] = $template->ypgj;
            }
            if ($template->ypfy > 0) {
                $updates[] = "ufy = ufy + ?";
                $params[] = $template->ypfy;
            }
            if ($template->ypbj > 0) {
                $updates[] = "ubj = ubj + ?"; // Fixed from ugj
                $params[] = $template->ypbj;
            }
            if ($template->ypxx > 0) {
                $updates[] = "uxx = uxx + ?"; // Fixed from ugj
                $params[] = $template->ypxx;
            }
            
            if (!empty($updates)) {
                $sql = "UPDATE game1 SET " . implode(', ', $updates) . " WHERE sid = ?";
                $params[] = $sid;
                $stmt = $this->db->prepare($sql);
                $stmt->execute($params);
            }
        }
        return true;
    }

    public function updateCurrency($sid, $type, $amount)
    {
        // type: uyxb (Linh thạch), uczb (Ma thạch/Premium)
        if (!in_array($type, ['uyxb', 'uczb'])) return;
        
        $sql = "UPDATE game1 SET $type = $type + ? WHERE sid = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$amount, $sid]);
    }

    public function updateExp($sid, $exp)
    {
        $stmt = $this->db->prepare("UPDATE game1 SET uexp = uexp + ? WHERE sid = ?");
        $stmt->execute([$exp, $sid]);
        
        // Check for level up
        $player = $this->findBySid($sid);
        if ($player) {
            $maxExp = $player->ulv * ($player->ulv + round($player->ulv/2)) * 100 + $player->ulv; // Legacy formula approximation?
            // Legacy formula in class/player.php: $maxexp = $ulv *($ulv+round($ulv/2))*100+$ulv;
            
            if ($player->uexp >= $maxExp) {
                // Level up
                $stmt = $this->db->prepare("UPDATE game1 SET ulv = ulv + 1, uexp = uexp - ?, uhp = umaxhp WHERE sid = ?");
                $stmt->execute([$maxExp, $sid]);
            }
        }
    }

    public function checkNameExists(string $username): bool
    {
        $stmt = $this->db->prepare("SELECT uname FROM game1 WHERE uname = ?");
        $stmt->execute([$username]);
        return (bool)$stmt->fetch();
    }

    public function findByUid($uid): ?Player
    {
        $stmt = $this->db->prepare("SELECT sid FROM game1 WHERE uid = ?");
        $stmt->execute([$uid]);
        $data = $stmt->fetch();

        if ($data) {
            return $this->findBySid($data['sid']);
        }
        return null;
    }

    public function setPotionSlot($sid, $slot, $ypid)
    {
        if (!in_array($slot, [1, 2, 3])) return;
        $field = "yp" . $slot;
        $stmt = $this->db->prepare("UPDATE game1 SET $field = ? WHERE sid = ?");
        $stmt->execute([$ypid, $sid]);
    }

    public function updateCultivation($sid, $status, $time = null)
    {
        $sql = "UPDATE game1 SET sfxl = ?";
        $params = [$status];
        
        if ($time) {
            $sql .= ", xiuliantime = ?";
            $params[] = $time;
        }
        
        $sql .= " WHERE sid = ?";
        $params[] = $sid;
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
    }

    public function addExp($sid, $exp)
    {
        // Logic to add exp and check level up/breakthrough cap
        // For now just add exp
        $stmt = $this->db->prepare("UPDATE game1 SET uexp = uexp + ? WHERE sid = ?");
        return $stmt->execute([$exp, $sid]);
    }
}
