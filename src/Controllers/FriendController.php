<?php

namespace XXJ\Controllers;

use XXJ\Core\Controller;
use XXJ\Repositories\FriendRepository;
use XXJ\Repositories\PlayerRepository;

class FriendController extends Controller
{
    private FriendRepository $friendRepo;
    private PlayerRepository $playerRepo;

    public function __construct()
    {
        parent::__construct();
        $this->friendRepo = new FriendRepository();
        $this->playerRepo = new PlayerRepository(); // To get friend names
    }

    public function index()
    {
        $friends = $this->friendRepo->getFriends($this->sid);
        $friendList = [];
        
        foreach ($friends as $friend) {
            $uid = $friend['imuid'];
            $p = $this->playerRepo->findByUid($uid);
            if ($p) {
                $friendList[] = [
                    'uid' => $uid,
                    'name' => $p->uname,
                    'cmd' => 'getplayerinfo&uid=' . $uid . '&sid=' . $this->sid
                ];
            }
        }

        $this->render('friend_list', [
            'friends' => $friendList,
            'back_cmd' => 'gomid&newmid=' . $this->player->nowmid . '&sid=' . $this->sid
        ]);
    }

    public function add()
    {
        $uid = $_GET['uid'] ?? 0;
        if ($uid) {
            $this->friendRepo->addFriend($this->sid, $uid);
        }
        // Redirect back to player info
        $this->redirect('getplayerinfo', ['uid' => $uid, 'sid' => $this->sid]);
    }

    public function remove()
    {
        $uid = $_GET['uid'] ?? 0;
        if ($uid) {
            $this->friendRepo->removeFriend($this->sid, $uid);
        }
        $this->redirect('im', ['sid' => $this->sid]);
    }
}
