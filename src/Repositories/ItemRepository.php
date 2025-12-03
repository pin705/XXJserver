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

    public function getPlayerItems($sid, $offset = 0, $limit = 10)
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

    public function countPlayerItems($sid)
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM playerzhuangbei WHERE sid = ?");
        $stmt->execute([$sid]);
        return $stmt->fetchColumn();
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
}
