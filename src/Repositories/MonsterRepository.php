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
        // Join with template table 'guaiwu' to get base stats
        // midguaiwu: id, mid, gyid, sid, ghp (current hp)
        // guaiwu: id, gname, glv, ghp (max hp), ggj, gfy, ...
        
        $sql = "SELECT m.*, 
                       y.gname, y.glv, y.gexp, y.ghp as gmaxhp, 
                       y.ggj, y.gfy, y.gbj, y.gxx, 
                       y.gdj, y.gzb, y.gyp 
                FROM midguaiwu m 
                LEFT JOIN guaiwu y ON m.gyid = y.id 
                WHERE m.id = ?";
                
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

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

    public function getTemplate($id): ?Monster
    {
        $stmt = $this->db->prepare("SELECT * FROM guaiwu WHERE id = ?");
        $stmt->execute([$id]);
        $data = $stmt->fetch();

        if ($data) {
            return new Monster($data);
        }
        return null;
    }
}
