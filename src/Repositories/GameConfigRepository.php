<?php

namespace XXJ\Repositories;

use XXJ\Core\Database;
use XXJ\Models\GameConfig;
use PDO;

class GameConfigRepository
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getConfig(): GameConfig
    {
        $stmt = $this->db->query("SELECT * FROM gameconfig");
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $config = new GameConfig();
        if ($data) {
            $config->firstmid = $data['firstmid'];
        }
        return $config;
    }
}
