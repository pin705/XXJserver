<?php

namespace XXJ\Repositories;

use XXJ\Core\Database;
use PDO;

class GiftCodeRepository
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function findByCode($code)
    {
        $stmt = $this->db->prepare("SELECT * FROM duihuan WHERE dhm = ?");
        $stmt->execute([$code]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function deleteCode($code)
    {
        // If codes are one-time use globally
        // $stmt = $this->db->prepare("DELETE FROM duihuan WHERE dhm = ?");
        // return $stmt->execute([$code]);
        return true; // Legacy code commented out deletion, so maybe reusable?
        // But usually gift codes are one-time per player or one-time global.
        // The legacy code logic for 'vip666' checks player column 'dhvip'.
        // For 'duihuan' table, it doesn't seem to check player history, so maybe one-time global?
        // Or maybe it's just a template and anyone can use it?
        // The legacy code says "Kịp thời xóa bỏ hối đoái mã" (Timely delete exchange code), but it's commented out.
        // So it seems they are reusable by multiple players? Or maybe not implemented fully.
        // Let's assume reusable for now, or check if there is a log table.
    }
    
    public function checkPlayerUsed($sid, $code)
    {
        // Check hardcoded codes
        if ($code == 'vip666') {
            $stmt = $this->db->prepare("SELECT dhvip FROM game1 WHERE sid = ?");
            $stmt->execute([$sid]);
            return $stmt->fetchColumn() > 0;
        }
        if ($code == 'vip666888') {
            $stmt = $this->db->prepare("SELECT dhvip1 FROM game1 WHERE sid = ?");
            $stmt->execute([$sid]);
            return $stmt->fetchColumn() > 0;
        }
        return false;
    }

    public function markPlayerUsed($sid, $code)
    {
        if ($code == 'vip666') {
            $stmt = $this->db->prepare("UPDATE game1 SET dhvip = 1 WHERE sid = ?");
            $stmt->execute([$sid]);
        }
        if ($code == 'vip666888') {
            $stmt = $this->db->prepare("UPDATE game1 SET dhvip1 = 1 WHERE sid = ?");
            $stmt->execute([$sid]);
        }
    }
}
