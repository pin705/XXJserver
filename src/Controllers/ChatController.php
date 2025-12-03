<?php

namespace XXJ\Controllers;

use XXJ\Core\Controller;
use XXJ\Repositories\ChatRepository;

class ChatController extends Controller
{
    private $chatRepo;

    public function __construct()
    {
        parent::__construct();
        $this->chatRepo = new ChatRepository();
    }

    public function index()
    {
        $ltlx = $_GET['ltlx'] ?? 'all';
        $sid = $this->sid;
        $player = $this->player;
        
        $messages = [];
        if ($ltlx == 'all') {
            $messages = $this->chatRepo->getGlobalMessages();
        } elseif ($ltlx == 'im') {
            $messages = $this->chatRepo->getPrivateMessages($player->uid);
        }

        $data = [
            'messages' => $messages,
            'ltlx' => $ltlx,
            'player' => $player,
            'sid' => $sid
        ];

        $this->render('chat/index', $data);
    }

    public function send()
    {
        $ltlx = $_GET['ltlx'] ?? 'all';
        $msg = $_GET['ltmsg'] ?? '';
        $imuid = $_GET['imuid'] ?? 0; // Target UID for private chat
        
        if ($msg && $this->player) {
            $msg = htmlspecialchars($msg);
            
            if ($ltlx == 'all') {
                $this->chatRepo->sendGlobalMessage($this->player->uid, $this->player->uname, $msg);
            } elseif ($ltlx == 'im' && $imuid) {
                // Need to get target name? Or just store ID. Legacy stored name too.
                // For now, just store sender name.
                $this->chatRepo->sendPrivateMessage($this->player->uid, $imuid, $this->player->uname, $msg);
            }
        }
        
        // Redirect back to chat
        $params = ['cmd' => 'liaotian', 'ltlx' => $ltlx, 'sid' => $this->sid];
        $url = '?' . http_build_query($params);
        header("Location: $url");
        exit;
    }
}

