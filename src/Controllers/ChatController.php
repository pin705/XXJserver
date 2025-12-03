<?php

namespace XXJ\Controllers;

use XXJ\Core\View;
use XXJ\Utils\Encoder;
use XXJ\Repositories\PlayerRepository;
use XXJ\Core\Database;

class ChatController
{
    private PlayerRepository $playerRepo;
    private Encoder $encoder;
    private $db;

    public function __construct()
    {
        $this->playerRepo = new PlayerRepository();
        $this->encoder = new Encoder();
        $this->db = Database::getInstance()->getConnection();
    }

    public function showChat($params)
    {
        $sid = $params['sid'];
        $ltlx = $params['ltlx'] ?? 'all';
        $player = $this->playerRepo->findBySid($sid);

        // Handle Send Message
        if (isset($params['cmd']) && $params['cmd'] == 'sendliaotian' && isset($params['ltmsg'])) {
            $msg = htmlspecialchars($params['ltmsg']);
            if ($ltlx == 'all') {
                $stmt = $this->db->prepare("INSERT INTO ggliaotian(name, msg, uid) VALUES (?, ?, ?)");
                $stmt->execute([$player->uname, $msg, $player->uid]);
            }
            // Handle IM logic if needed
        }

        // Fetch Messages
        $messages = [];
        if ($ltlx == 'all') {
            $stmt = $this->db->query("SELECT * FROM ggliaotian ORDER BY id DESC LIMIT 10");
            $messages = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }

        View::render('liaotian', [
            'player' => $player,
            'messages' => $messages,
            'ltlx' => $ltlx,
            'encoder' => $this->encoder,
            'sid' => $sid
        ]);
    }
}
