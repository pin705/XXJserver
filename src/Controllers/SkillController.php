<?php

namespace XXJ\Controllers;

use XXJ\Core\Controller;
use XXJ\Repositories\SkillRepository;

class SkillController extends Controller
{
    private $skillRepo;

    public function __construct()
    {
        parent::__construct();
        $this->skillRepo = new SkillRepository();
    }

    public function index()
    {
        $sid = $this->sid;
        $player = $this->player;
        $wgid = $player->wugong;
        
        $skill = $this->skillRepo->getSkill($sid, $wgid);
        
        $cmd = $_GET['cmd'] ?? '';
        $canshu = $_GET['canshu'] ?? null;
        
        $message = '';
        $xlsjc = 'Chưa bắt đầu tu luyện'; // Cultivation time string
        
        // Handle actions
        if ($cmd === 'wgxiulian') {
            if ($skill->xlzt == 1) {
                $message = 'Đã trong tu luyện<br/>';
            } else {
                $cost = $skill->wgdj * 3;
                $currencyType = ($canshu == 1) ? 1 : 2;
                
                $result = $this->skillRepo->startCultivation($sid, $wgid, $cost, $currencyType);
                if ($result) {
                    $message = 'Hắc hưu hắc hưu, thao luyện...<br/>';
                    $xlsjc = 0;
                    // Refresh skill data
                    $skill = $this->skillRepo->getSkill($sid, $wgid);
                } else {
                    $message = 'Thất bại thất bại thất bại 404';
                }
            }
        }
        
        // Calculate cultivation status
        $now = time();
        $startTime = strtotime($skill->xlsj);
        $minutes = floor(($now - $startTime) / 60);
        $expGain = round($minutes * 0.8);
        $bonus = round(10 + $expGain * 1.2);
        
        if ($minutes > 1440) {
            $minutes = 1440;
            $expGain = round($minutes * 1.2);
            $bonus = round(10 + $expGain * 1.6);
        }
        
        if ($cmd === 'jswg') {
            if ($skill->xlzt == 1) {
                $totalExp = $expGain + $skill->wgxl;
                $isLevelUp = false;
                $levelUpData = [];
                
                if ($totalExp > $skill->wgxlmax) {
                    $isLevelUp = true;
                    $levelUpData = [
                        'new_exp' => $totalExp - $skill->wgxlmax,
                        'max_exp_increase' => $bonus
                    ];
                    $message = 'nhận được tu vi:'.$expGain.' (Thăng cấp!)<br/>';
                } else {
                    $message = 'nhận được tu vi:'.$expGain.'<br/>';
                }
                
                $this->skillRepo->endCultivation($sid, $wgid, $expGain, $isLevelUp, $levelUpData);
                $xlsjc = 'Kết thúc tu luyện...<br/>Thời gian tu luyện：'.$minutes;
                
                // Refresh skill data
                $skill = $this->skillRepo->getSkill($sid, $wgid);
            } else {
                $message = 'Ngươi còn chưa có bắt đầu tu luyện...<br/>';
            }
        } elseif ($skill->xlzt == 1) {
             $xlsjc = $minutes;
        }

        $data = [
            'player' => $player,
            'sid' => $sid,
            'skill' => $skill,
            'encode' => $this->encoder,
            'message' => $message,
            'xlsjc' => $xlsjc,
            'expGain' => $expGain,
            'minutes' => $minutes
        ];

        $this->render('wugong', $data);
    }

    public function showBag()
    {
        $sid = $this->sid;
        $skills = $this->skillRepo->getPlayerSkills($sid);
        
        $this->render('bagjn', [
            'skills' => $skills
        ]);
    }

    public function showDetail()
    {
        $sid = $this->sid;
        $wgid = $_GET['jnid'] ?? 0;
        
        $skill = $this->skillRepo->getSkill($sid, $wgid);
        
        $this->render('jninfo', [
            'skill' => $skill
        ]);
    }
}
