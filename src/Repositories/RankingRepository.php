<?php

namespace XXJ\Repositories;

use XXJ\Core\Database;
use PDO;

class RankingRepository
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getLevelRanking($limit = 10)
    {
        $sql = "SELECT g.uid, g.uname, g.ulv, g.sid, c.clubname 
                FROM game1 g 
                LEFT JOIN clubplayer cp ON g.uid = cp.uid 
                LEFT JOIN club c ON cp.clubid = c.clubid 
                ORDER BY g.ulv DESC, g.uexp DESC 
                LIMIT " . (int)$limit;
        
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    
    public function getAttackRanking($limit = 10)
    {
        $sql = "SELECT uid, uname, ulv, ugj FROM game1 ORDER BY ugj DESC LIMIT " . (int)$limit;
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function getDefenseRanking($limit = 10)
    {
        $sql = "SELECT uid, uname, ulv, ufy FROM game1 ORDER BY ufy DESC LIMIT " . (int)$limit;
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    
    public function getWealthRanking($limit = 10)
    {
        $sql = "SELECT uid, uname, ulv, uyxb FROM game1 ORDER BY uyxb DESC LIMIT " . (int)$limit;
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}
