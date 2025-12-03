<?php

namespace XXJ\Controllers;

use XXJ\Core\Controller;
use XXJ\Repositories\MapRepository;
use XXJ\Repositories\PlayerRepository;

class PvpController extends Controller
{
    private MapRepository $mapRepo;

    public function __construct()
    {
        parent::__construct();
        $this->mapRepo = new MapRepository();
    }

    public function combat()
    {
        $uid = $_GET['uid'] ?? 0;
        $target = $this->playerRepo->findByUid($uid);
        
        if (!$target) {
             $this->render('game/pvp', [
                'error' => 'Người chơi không tồn tại',
                'back_cmd' => 'gomid&newmid=' . $this->player->nowmid . '&sid=' . $this->sid
            ]);
            return;
        }

        $map = $this->mapRepo->findById($this->player->nowmid);
        
        if ($map->ispvp == 0) {
             $this->render('game/pvp', [
                'error' => 'Trước mắt địa đồ không cho phép PK',
                'back_cmd' => 'gomid&newmid=' . $this->player->nowmid . '&sid=' . $this->sid
            ]);
            return;
        }

        if ($target->sfzx == 0) {
             $this->render('game/pvp', [
                'error' => 'Nên người chơi không có online',
                'back_cmd' => 'gomid&newmid=' . $this->player->nowmid . '&sid=' . $this->sid
            ]);
            return;
        }

        if ($target->nowmid != $this->player->nowmid) {
             $this->render('game/pvp', [
                'error' => 'Nên người chơi không có ở nơi đó đồ',
                'back_cmd' => 'gomid&newmid=' . $this->player->nowmid . '&sid=' . $this->sid
            ]);
            return;
        }

        if ($this->player->uhp <= 0) {
             $this->render('game/pvp', [
                'error' => 'Ngươi là thân bị trọng thương, không cách nào tiến hành chiến đấu',
                'back_cmd' => 'gomid&newmid=' . $this->player->nowmid . '&sid=' . $this->sid
            ]);
            return;
        }

        if ($target->uhp <= 0) {
             $this->render('game/pvp', [
                'error' => 'Nên người chơi đã nhận bạo lực một kích, trước mắt chính vùng vẫy giãy chết, còn xin đại hiệp giơ cao đánh khẽ。',
                'back_cmd' => 'gomid&newmid=' . $this->player->nowmid . '&sid=' . $this->sid
            ]);
            return;
        }

        // Combat Logic
        $damage = $this->player->ugj - $target->ufy;
        if ($damage <= 0) $damage = 1; // Minimum damage

        // Apply damage
        $target->uhp -= $damage;
        if ($target->uhp < 0) $target->uhp = 0;
        
        // Update target HP
        $this->playerRepo->updateHp($target->sid, $target->uhp);

        // Check death
        $msg = "Ngươi công kích {$target->uname}, tạo thành {$damage} điểm thương tổn!";
        if ($target->uhp <= 0) {
            $msg .= "<br/>{$target->uname} đã bị ngươi đánh bại!";
        }

        $this->render('game/pvp', [
            'msg' => $msg,
            'target' => $target,
            'back_cmd' => 'gomid&newmid=' . $this->player->nowmid . '&sid=' . $this->sid,
            'attack_cmd' => 'pvp&uid=' . $uid . '&sid=' . $this->sid
        ]);
    }
}
