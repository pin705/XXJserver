<?php

namespace XXJ\Repositories;

use XXJ\Core\Database;
use XXJ\Models\Task;
use PDO;

class TaskRepository
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function findById($id): ?Task
    {
        $stmt = $this->db->prepare("SELECT * FROM renwu WHERE id = ?");
        $stmt->execute([$id]);
        $data = $stmt->fetch();

        if ($data) {
            return new Task($data);
        }
        return null;
    }

    public function getPlayerTask($sid, $rwid)
    {
        $stmt = $this->db->prepare("SELECT * FROM playerrenwu WHERE sid = ? AND rwid = ?");
        $stmt->execute([$sid, $rwid]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function acceptTask($sid, $task)
    {
        $day = 0;
        if ($task->rwlx == 2) {
            $day = date('d');
        }
        $sql = "INSERT INTO playerrenwu(rwname, rwzl, rwdj, rwzb, rwexp, rwyxb, sid, rwzt, rwid, rwyq, rwcount, rwlx, `data`) 
                VALUES (?, ?, ?, ?, ?, ?, ?, '1', ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            $task->rwname, $task->rwzl, $task->rwdj, $task->rwzb, $task->rwexp, $task->rwyxb, 
            $sid, $task->id, $task->rwyq, $task->rwcount, $task->rwlx, $day
        ]);
    }

    public function updateTaskStatus($sid, $rwid, $status)
    {
        $stmt = $this->db->prepare("UPDATE playerrenwu SET rwzt = ? WHERE sid = ? AND rwid = ?");
        $stmt->execute([$status, $sid, $rwid]);
    }
}
