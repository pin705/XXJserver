<?php

namespace XXJ\Controllers;

use XXJ\Core\Controller;
use XXJ\Repositories\ItemRepository;
use XXJ\Repositories\ClubRepository;
use XXJ\Repositories\FriendRepository;

class PlayerController extends Controller
{
    private ItemRepository $itemRepo;
    private ClubRepository $clubRepo;
    private FriendRepository $friendRepo;

    public function __construct()
    {
        parent::__construct();
        $this->itemRepo = new ItemRepository();
        $this->clubRepo = new ClubRepository();
        $this->friendRepo = new FriendRepository();
    }

    public function showStatus()
    {
        $sid = $this->sid;
        $player = $this->player;
        if (!$player) return;

        $cmd = $_GET['cmd'] ?? '';

        // Handle unequip
        if ($cmd == 'xxzb' && isset($_GET['zbwz'])) {
            $slot = $_GET['zbwz'];
            $this->playerRepo->unequipItem($sid, $slot);
            // Refresh player
            $player = $this->playerRepo->findBySid($sid);
            $this->player = $player;
        }

        // Handle equip
        $errorMsg = '';
        if ($cmd == 'setzbwz' && isset($_GET['zbnowid']) && isset($_GET['zbwz'])) {
            $zbnowid = $_GET['zbnowid'];
            $slot = $_GET['zbwz'];
            
            // Check if item exists and belongs to player
            $item = $this->itemRepo->findById($zbnowid);
            
            if (!$item || $item->uid != $player->uid) {
                $errorMsg = "Ngươi không có nên trang bị, không cách nào trang bị";
            } else {
                $this->playerRepo->equipItem($sid, $zbnowid, $slot);
                // Refresh player
                $player = $this->playerRepo->findBySid($sid);
                $this->player = $player;
            }
        }

        // Get equipped items details
        $equippedItems = [];
        foreach (['tool1', 'tool2', 'tool3', 'tool4', 'tool5', 'tool6'] as $slot) {
            if ($player->$slot) {
                $equippedItems[$slot] = $this->itemRepo->getEquipmentTemplate($player->$slot);
            }
        }

        $this->render('zhuangtai', [
            'errorMsg' => $errorMsg,
            'equippedItems' => $equippedItems
        ]);
    }

    public function viewOtherPlayer()
    {
        $uid = $_GET['uid'] ?? 0;
        $target = $this->playerRepo->findByUid($uid);
        
        if (!$target) {
             $this->render('other_player', [
                'error' => 'Người chơi không tồn tại',
                'back_cmd' => 'gomid&newmid=' . $this->player->nowmid . '&sid=' . $this->sid
            ]);
            return;
        }

        // Club info
        $clubMember = $this->clubRepo->findMemberBySid($target->sid);
        $clubName = "Không môn không phái";
        $clubCmd = "";
        if ($clubMember) {
            $club = $this->clubRepo->findClubById($clubMember->clubid);
            if ($club) {
                $clubName = $club->clubname;
                $clubCmd = 'club&clubid=' . $club->clubid . '&sid=' . $this->sid;
            }
        }

        // Friend/IM menu
        $imMenu = "";
        if ($this->sid != $target->sid) {
            $pkCmd = 'pvp&uid=' . $uid . '&sid=' . $this->sid;
            $imMenu .= "<a href='?cmd=$pkCmd' style='color:#ff0000'>Công kích</a>";
            
            if (!$this->friendRepo->isFriend($this->sid, $uid)) {
                $addCmd = 'addim&uid=' . $uid . '&sid=' . $this->sid;
                $imMenu .= "<a href='?cmd=$addCmd' style='color: #009688;'>Kết giao</a><hr>";
            } else {
                $removeCmd = 'deim&uid=' . $uid . '&sid=' . $this->sid;
                $imMenu .= "</a><a href='?cmd=$removeCmd'>Xóa bỏ hảo hữu</a>";
                // Chat form
                $imMenu .= "<form><input type='hidden' name='cmd' value='sendliaotian'><input type='hidden' name='ltlx' value='im'><input type='hidden' name='sid' value='{$this->sid}'><input type='hidden' name='imuid' value='{$uid}'><input name='ltmsg'><input type='submit' value='Gửi đi nói chuyện riêng'></form>";
            }
            $imMenu .= "<br/>";
        }

        $this->render('other_player', [
            'target' => $target,
            'clubName' => $clubName,
            'clubCmd' => $clubCmd,
            'imMenu' => $imMenu,
            'back_cmd' => 'gomid&newmid=' . $this->player->nowmid . '&sid=' . $this->sid
        ]);
    }
}
