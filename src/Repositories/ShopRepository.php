<?php

namespace XXJ\Repositories;

use XXJ\Core\Database;
use XXJ\Repositories\PlayerRepository;
use PDO;

class ShopRepository
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getAllItems()
    {
        $stmt = $this->db->prepare("SELECT * FROM yaodan");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getItem($ydid)
    {
        $stmt = $this->db->prepare("SELECT * FROM yaodan WHERE ydid = ?");
        $stmt->execute([$ydid]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function buyItem($sid, $ydid, $count, $currencyType)
    {
        // currencyType: 1 = uyxb (Linh thạch), 2 = uczb (Ma thạch)
        // Note: In legacy code, changeyxb(2, ...) means subtract. Here we just pass the type of currency to use.
        
        $item = $this->getItem($ydid);
        if (!$item) {
            return false;
        }

        $cost = 0;
        if ($currencyType === 1) {
            $cost = $item['ydjg'] * $count;
        } else {
            $cost = $item['ydjgm'] * $count;
        }

        try {
            $this->db->beginTransaction();

            // Check and deduct currency
            $playerRepo = new PlayerRepository();
            $player = $playerRepo->findBySid($sid);

            if ($currencyType === 1) {
                if ($player->uyxb < $cost) {
                    $this->db->rollBack();
                    return false;
                }
                $stmt = $this->db->prepare("UPDATE game1 SET uyxb = uyxb - ? WHERE sid = ?");
                $stmt->execute([$cost, $sid]);
            } else {
                if ($player->uczb < $cost) {
                    $this->db->rollBack();
                    return false;
                }
                $stmt = $this->db->prepare("UPDATE game1 SET uczb = uczb - ? WHERE sid = ?");
                $stmt->execute([$cost, $sid]);
            }

            // Add item
            // Check if player has item
            $stmt = $this->db->prepare("SELECT * FROM playeryaodan WHERE ydid = ? AND sid = ?");
            $stmt->execute([$ydid, $sid]);
            $existing = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($existing) {
                $stmt = $this->db->prepare("UPDATE playeryaodan SET ydsum = ydsum + ? WHERE ydid = ? AND sid = ?");
                $stmt->execute([$count, $ydid, $sid]);
            } else {
                $stmt = $this->db->prepare("INSERT INTO playeryaodan(ydname, ydhp, ydgj, ydfy, ydbj, ydxx, ydid, ydjg, ydsum, sid, ydjgm) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->execute([
                    $item['ydname'], $item['ydhp'], $item['ydgj'], $item['ydfy'], 
                    $item['ydbj'], $item['ydxx'], $ydid, $item['ydjg'], 
                    $count, $sid, $item['ydjgm']
                ]);
            }

            $this->db->commit();
            return true;
        } catch (\Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }
}
