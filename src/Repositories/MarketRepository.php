<?php

namespace XXJ\Repositories;

use XXJ\Core\Database;
use PDO;

class MarketRepository
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getMarketItems($type, $page = 1, $limit = 10)
    {
        $offset = ($page - 1) * $limit;
        if ($type == 'daoju') {
            $sql = "SELECT * FROM fangshi_dj WHERE djcount > 0 ORDER BY payid DESC LIMIT :limit OFFSET :offset";
        } elseif ($type == 'zhuangbei') {
            $sql = "SELECT * FROM fangshi_zb WHERE 1=1 ORDER BY payid DESC LIMIT :limit OFFSET :offset";
        } else {
            return [];
        }

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function getMarketItem($type, $payid)
    {
        if ($type == 'daoju') {
            $sql = "SELECT * FROM fangshi_dj WHERE payid = :payid";
        } elseif ($type == 'zhuangbei') {
            $sql = "SELECT * FROM fangshi_zb WHERE payid = :payid";
        } else {
            return null;
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':payid' => $payid]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function buyItem($buyerSid, $type, $payid, $count)
    {
        // Transaction logic is complex, better handled in Controller or Service
        // But Repository should handle DB operations.
        // Let's keep it simple here and do transaction in Controller for now, 
        // or encapsulate the whole buy process here.
        
        // For now, just return the item info, Controller will handle the transaction.
        return $this->getMarketItem($type, $payid);
    }
    
    public function updateMarketItemCount($type, $payid, $count)
    {
        if ($type == 'daoju') {
            $sql = "UPDATE fangshi_dj SET djcount = djcount - :count WHERE payid = :payid AND djcount >= :count";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':count' => $count, ':payid' => $payid]);
            return $stmt->rowCount() > 0;
        }
        return false;
    }

    public function removeMarketItem($type, $payid)
    {
        if ($type == 'zhuangbei') {
            $sql = "DELETE FROM fangshi_zb WHERE payid = :payid";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':payid' => $payid]);
            return $stmt->rowCount() > 0;
        } elseif ($type == 'daoju') {
             $sql = "DELETE FROM fangshi_dj WHERE payid = :payid AND djcount <= 0";
             $stmt = $this->db->prepare($sql);
             $stmt->execute([':payid' => $payid]);
        }
        return false;
    }
}
