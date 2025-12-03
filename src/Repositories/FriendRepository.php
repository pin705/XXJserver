<?php

namespace XXJ\Repositories;

use XXJ\Core\Database;
use PDO;

class FriendRepository
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getFriends($sid)
    {
        $stmt = $this->db->prepare("SELECT * FROM im WHERE sid = ?");
        $stmt->execute([$sid]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addFriend($sid, $uid)
    {
        // Check if already exists
        if ($this->isFriend($sid, $uid)) return false;
        
        $stmt = $this->db->prepare("INSERT INTO im (sid, imuid) VALUES (?, ?)");
        return $stmt->execute([$sid, $uid]);
    }

    public function removeFriend($sid, $uid)
    {
        $stmt = $this->db->prepare("DELETE FROM im WHERE sid = ? AND imuid = ?");
        return $stmt->execute([$sid, $uid]);
    }

    public function isFriend($sid, $uid)
    {
        $stmt = $this->db->prepare("SELECT * FROM im WHERE sid = ? AND imuid = ?");
        $stmt->execute([$sid, $uid]);
        return (bool)$stmt->fetch();
    }
}
