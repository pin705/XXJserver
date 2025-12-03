<?php

namespace XXJ\Repositories;

use XXJ\Core\Database;
use XXJ\Models\Boss;
use PDO;

class BossRepository
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function findById($id): ?Boss
    {
        $stmt = $this->db->prepare("SELECT * FROM boss WHERE id = ?");
        $stmt->execute([$id]);
        $data = $stmt->fetch();

        if ($data) {
            // Map DB columns to Model properties if names differ, or just pass data if they match
            // The old code mapped 'id' to 'bossid' manually in getyboss
            $data['bossid'] = $data['id']; 
            $data['glv'] = $data['bosslv'];
            return new Boss($data);
        }
        return null;
    }

    public function respawn($bossid)
    {
        $stmt = $this->db->prepare("UPDATE boss SET bosshp = bossmaxhp WHERE id = ?");
        $stmt->execute([$bossid]);
    }
}
