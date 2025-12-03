<?php

namespace XXJ\Repositories;

use XXJ\Core\Database;
use XXJ\Models\Pet;
use PDO;

class PetRepository
{
    private PDO $db;
    private ItemRepository $itemRepo;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
        $this->itemRepo = new ItemRepository();
    }

    public function findById($cwid): ?Pet
    {
        $stmt = $this->db->prepare("SELECT * FROM playerchongwu WHERE cwid = ?");
        $stmt->execute([$cwid]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($data) {
            $pet = new Pet($data);
            $this->calculatePetStats($pet);
            return $pet;
        }
        return null;
    }

    public function findBySid($sid): array
    {
        $stmt = $this->db->prepare("SELECT * FROM playerchongwu WHERE sid = ?");
        $stmt->execute([$sid]);
        $pets = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $pet = new Pet($row);
            $this->calculatePetStats($pet);
            $pets[] = $pet;
        }
        return $pets;
    }

    private function calculatePetStats(Pet $pet)
    {
        // Base stats
        $pet->total_gj = $pet->cwgj;
        $pet->total_fy = $pet->cwfy;
        $pet->total_hp = $pet->cwmaxhp;
        $pet->total_bj = $pet->cwbj;
        $pet->total_xx = $pet->cwxx;

        $tools = [$pet->tool1, $pet->tool2, $pet->tool3, $pet->tool4, $pet->tool5, $pet->tool6, $pet->tool7];
        
        foreach ($tools as $toolId) {
            if ($toolId != 0) {
                $item = $this->itemRepo->findById($toolId);
                if ($item) {
                    $pet->total_gj += $item->zbgj;
                    $pet->total_fy += $item->zbfy;
                    $pet->total_hp += $item->zbhp;
                    $pet->total_bj += $item->zbbj;
                    $pet->total_xx += $item->zbxx;
                }
            }
        }
    }

    public function create($sid)
    {
        $cw4 = array('Lanh lợi chuột','Ngây ngốc trâu','Uy uy hổ', 'Nhảy nhót thỏ','Lạnh lùng rồng','Tiêu xài một chút rắn','Linh lợi ngựa','Be be dê','Đẹp trai đẹp trai khỉ','Trứng gà đẻ','Ngoan ngoãn chó','Heo thần tài');
        
        $uphp = mt_rand(8, 25);
        $upgj = mt_rand(2, 5);
        $upfy = mt_rand(3, 8);
        $cwpz = mt_rand(0, 500);
        
        if ($cwpz < 200) {
            $cwpz = 0;
        } elseif ($cwpz < 350) {
            $cwpz = 1;
        } elseif ($cwpz < 430) {
            $cwpz = 2;
        } elseif ($cwpz < 470) {
            $cwpz = 3;
        } elseif ($cwpz < 495) {
            $cwpz = 4;
        } elseif ($cwpz < 600) {
            $cwpz = 5;
        }
        
        $sjs1 = mt_rand(0, 15);
        $cwlv = 1;
        $cwmaxhp = 100;
        $cwhp = 100;
        $cwgj = 6 + $sjs1;
        $cwfy = $sjs1;
        $sjs = mt_rand(0, 11);
        $cwname = $cw4[$sjs];
        
        // Note: cwmaxexp is set to string 'cwmaxexp' in legacy code, which seems wrong or relies on DB default/trigger?
        // Looking at legacy code: VALUES (..., 'cwmaxexp')
        // But cwmaxexp column is likely integer. 
        // Wait, in legacy code: `cwmaxexp` is a column name, but it's passed as a string value in the query?
        // "VALUES (...,'cwmaxexp')" -> This inserts the string "cwmaxexp" into the column?
        // If the column is int, it becomes 0.
        // Let's check the Pet model logic. It calculates max exp based on level.
        // I will set it to a reasonable initial value or 0.
        
        $cwmaxexp = 0; // Initial value, will be recalculated on load/level up

        $stmt = $this->db->prepare("INSERT INTO playerchongwu (cwname, cwlv, cwhp, cwmaxhp, cwgj, cwfy, uphp, upgj, upfy, cwpz, sid, cwmaxexp) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$cwname, $cwlv, $cwhp, $cwmaxhp, $cwgj, $cwfy, $uphp, $upgj, $upfy, $cwpz, $sid, $cwmaxexp]);
        
        return $this->db->lastInsertId();
    }

    public function delete($cwid, $sid)
    {
        $stmt = $this->db->prepare("DELETE FROM playerchongwu WHERE cwid = ? AND sid = ?");
        return $stmt->execute([$cwid, $sid]);
    }

    public function deploy($sid, $cwid)
    {
        // Update game1 table to set cw = cwid
        $stmt = $this->db->prepare("UPDATE game1 SET cw = ? WHERE sid = ?");
        return $stmt->execute([$cwid, $sid]);
    }

    public function recall($sid)
    {
        // Update game1 table to set cw = 0
        $stmt = $this->db->prepare("UPDATE game1 SET cw = 0 WHERE sid = ?");
        return $stmt->execute([$sid]);
    }
    
    public function updateName($cwid, $sid, $newName)
    {
        $stmt = $this->db->prepare("UPDATE playerchongwu SET cwname = ? WHERE cwid = ? AND sid = ?");
        return $stmt->execute([$newName, $cwid, $sid]);
    }
}
