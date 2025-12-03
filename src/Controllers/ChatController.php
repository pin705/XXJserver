<?php

namespace XXJ\Controllers;

use XXJ\Core\Controller;
use XXJ\Repositories\ChatRepository;

class ChatController extends Controller
{
    private ChatRepository $chatRepo;

    public function __construct()
    {
        parent::__construct();
        $this->chatRepo = new ChatRepository();
    }

    public function index()
    {
        $ltlx = $_GET['ltlx'] ?? 'all';
        
        $messages = [];
        if ($ltlx == 'all') {
            $messages = $this->chatRepo->getGlobalMessages();
        }

        $this->render('liaotian', [
            'messages' => $messages,
            'ltlx' => $ltlx
        ]);
    }

    public function send()
    {
        $ltlx = $_GET['ltlx'] ?? 'all';
        $msg = $_GET['ltmsg'] ?? '';
        
        if ($msg && $this->player) {
            $msg = htmlspecialchars($msg);
            if ($ltlx == 'all') {
                $this->chatRepo->addMessage($this->player->uid, $this->player->uname, $msg);
            }
        }
        
        $this->redirect('liaotian', ['ltlx' => $ltlx]);
    }
}

