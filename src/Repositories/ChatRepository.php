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

    public function getPrivateMessages($uid, $limit = 15)
    {
        $stmt = $this->db->prepare("SELECT * FROM imliaotian WHERE uid = :uid OR imuid = :uid ORDER BY id DESC LIMIT :limit");
        $stmt->bindValue(':uid', $uid, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function sendGlobalMessage($uid, $name, $msg)
    {
        $stmt = $this->db->prepare("INSERT INTO ggliaotian(name, msg, uid) VALUES (?, ?, ?)");
        return $stmt->execute([$name, $msg, $uid]);
    }

    public function sendPrivateMessage($uid, $imuid, $name, $msg)
    {
        $stmt = $this->db->prepare("INSERT INTO imliaotian (uid, imuid, name, msg) VALUES (:uid, :imuid, :name, :msg)");
        return $stmt->execute([
            ':uid' => $uid,
            ':imuid' => $imuid,
            ':name' => $name,
            ':msg' => $msg
        ]);
    }
}
