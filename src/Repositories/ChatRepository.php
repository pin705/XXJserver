<?php

namespace XXJ\Repositories;

use XXJ\Core\Database;
use PDO;

class ChatRepository
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getGlobalMessages($limit = 15)
    {
        $stmt = $this->db->prepare("SELECT * FROM ggliaotian ORDER BY id DESC LIMIT :limit");
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addMessage($uid, $name, $msg)
    {
        $stmt = $this->db->prepare("INSERT INTO ggliaotian(name, msg, uid) VALUES (?, ?, ?)");
        return $stmt->execute([$name, $msg, $uid]);
    }
}
