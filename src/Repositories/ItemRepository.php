<?php

namespace XXJ\Repositories;

use XXJ\Core\Database;
use XXJ\Models\Item;
use PDO;

class ItemRepository
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function findById($zbnowid): ?Item
    {
        $stmt = $this->db->prepare("SELECT * FROM playerzhuangbei WHERE zbnowid = ?");
        $stmt->execute([$zbnowid]);
        $data = $stmt->fetch();

        if ($data) {
            return new Item($data);
        }
        return null;
    }

    public function getPlayerItems($sid, $offset = 0, $limit = 10)
    {
        $stmt = $this->db->prepare("SELECT * FROM playerzhuangbei WHERE sid = ? LIMIT ?, ?");
        // PDO limit params need to be integers
        $stmt->bindValue(1, $sid, PDO::PARAM_STR);
        $stmt->bindValue(2, (int)$offset, PDO::PARAM_INT);
        $stmt->bindValue(3, (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        
        $items = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $items[] = new Item($row);
        }
        return $items;
    }

    public function countPlayerItems($sid)
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM playerzhuangbei WHERE sid = ?");
        $stmt->execute([$sid]);
        return $stmt->fetchColumn();
    }

    public function deleteItem($zbnowid, $sid)
    {
        $stmt = $this->db->prepare("DELETE FROM playerzhuangbei WHERE zbnowid = ? AND sid = ?");
        return $stmt->execute([$zbnowid, $sid]);
    }
}
