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
            return new Player($data);
        }

        return null;
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
}
