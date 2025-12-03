<?php

namespace XXJ\Repositories;

use XXJ\Core\Database;
use PDO;

class NpcRepository
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getNpcsByMap($mid)
    {
        $stmt = $this->db->prepare("SELECT * FROM midnpc WHERE mid = ?");
        $stmt->execute([$mid]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function findById($nid)
    {
        $stmt = $this->db->prepare("SELECT * FROM npc WHERE id = ?");
        $stmt->execute([$nid]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }
}
