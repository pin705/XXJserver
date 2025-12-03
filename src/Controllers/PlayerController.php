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

    public function showCultivation()
    {
        $sid = $this->sid;
        $player = $this->player;
        
        $now = time();
        $startTime = strtotime($player->xiuliantime);
        $minutes = floor(($now - $startTime) / 60);
        if ($minutes > 1440) $minutes = 1440; // Max 24 hours
        
        $exp = round($minutes * $player->ulv * 1);
        
        $this->render('xiulian', [
            'minutes' => $minutes,
            'exp' => $exp,
            'cost_yxb' => 32 * $player->ulv,
            'cost_czb' => round(($player->ulv + 1) / 2)
        ]);
    }

    public function startCultivation()
    {
        $sid = $this->sid;
        $player = $this->player;
        $type = $_GET['type'] ?? 1; // 1: yxb, 2: czb
        
        if ($player->sfxl == 1) {
            $this->redirect('goxiulian', ['sid' => $sid, 'msg' => 'Đã trong tu luyện']);
            return;
        }
        
        $cost = ($type == 1) ? (32 * $player->ulv) : round(($player->ulv + 1) / 2);
        $currency = ($type == 1) ? 'uyxb' : 'uczb';
        
        if ($player->$currency < $cost) {
            $this->redirect('goxiulian', ['sid' => $sid, 'msg' => 'Không đủ tiền']);
            return;
        }
        
        // Deduct cost
        $this->playerRepo->updateCurrency($sid, $currency, -$cost);
        
        // Start
        $this->playerRepo->updateCultivation($sid, 1, date('Y-m-d H:i:s'));
        
        $this->redirect('goxiulian', ['sid' => $sid, 'msg' => 'Bắt đầu tu luyện...']);
    }

    public function endCultivation()
    {
        $sid = $this->sid;
        $player = $this->player;
        
        if ($player->sfxl == 0) {
            $this->redirect('goxiulian', ['sid' => $sid]);
            return;
        }
        
        $now = time();
        $startTime = strtotime($player->xiuliantime);
        $minutes = floor(($now - $startTime) / 60);
        if ($minutes > 1440) $minutes = 1440;
        
        $exp = round($minutes * $player->ulv * 1);
        
        $this->playerRepo->addExp($sid, $exp);
        $this->playerRepo->updateCultivation($sid, 0);
        
        $this->redirect('goxiulian', ['sid' => $sid, 'msg' => "Kết thúc tu luyện. Nhận được $exp kinh nghiệm."]);
    }
}
