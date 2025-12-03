<?php

namespace XXJ\Repositories;

use XXJ\Core\Database;
use XXJ\Models\Monster;
use PDO;

class MonsterRepository
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function findById($id): ?Monster
    {
        $stmt = $this->db->prepare("SELECT * FROM midguaiwu WHERE id = ?");
        $stmt->execute([$id]);
        $data = $stmt->fetch();

        if ($data) {
            return new Monster($data);
        }
        return null;
    }

    public function getMonstersByMap($mid)
    {
        $stmt = $this->db->prepare("SELECT * FROM midguaiwu WHERE mid = ?");
        $stmt->execute([$mid]);
        $results = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $results[] = new Monster($row);
        }
        return $results;
    }

    public function updateMonster($monster)
    {
        $stmt = $this->db->prepare("UPDATE midguaiwu SET sid = ?, ghp = ? WHERE id = ?");
        $stmt->execute([$monster->sid, $monster->ghp, $monster->id]);
    }
    
    public function setAttacker($gid, $sid) {
        $stmt = $this->db->prepare("UPDATE midguaiwu SET sid = ? WHERE id = ?");
        $stmt->execute([$sid, $gid]);
    }
}
