<?php

namespace XXJ\Repositories;

use XXJ\Core\Database;
use XXJ\Models\Map;
use PDO;

class MapRepository
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function findById($mid): ?Map
    {
        $stmt = $this->db->prepare("SELECT * FROM mid WHERE mid = ?");
        $stmt->execute([$mid]);
        $data = $stmt->fetch();

        if ($data) {
            return new Map($data);
        }

        return null;
    }

    public function updatePlayerInfo($mid, $info)
    {
        $stmt = $this->db->prepare("UPDATE mid SET playerinfo = ? WHERE mid = ?");
        $stmt->execute([$info, $mid]);
    }
    
    public function getRegion($qyid) {
        $stmt = $this->db->prepare("SELECT * FROM qy WHERE qyid = ?");
        $stmt->execute([$qyid]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }
}
