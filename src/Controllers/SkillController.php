<?php

namespace XXJ\Controllers;

use XXJ\Core\Controller;
use XXJ\Repositories\SkillRepository;
use XXJ\Repositories\PlayerRepository;

class SkillController extends Controller
{
    private SkillRepository $skillRepo;
    private PlayerRepository $playerRepo;

    public function __construct()
    {
        parent::__construct();
        $this->skillRepo = new SkillRepository();
        $this->playerRepo = new PlayerRepository();
    }

    public function index()
    {
        $player = $this->playerRepo->findBySid($this->sid);
        $skills = $this->skillRepo->getAllSkills($this->sid);
        
        $this->render('skill/index', [
            'player' => $player,
            'skills' => $skills,
            'activeSkillId' => $player->wugong
        ]);
    }

    public function draw()
    {
        $player = $this->playerRepo->findBySid($this->sid);
        $cost = 200;

        if ($player->uczb < $cost) {
            $this->render('skill/index', [
                'player' => $player,
                'skills' => $this->skillRepo->getAllSkills($this->sid),
                'activeSkillId' => $player->wugong,
                'error' => 'Tiên ngọc không đủ! Cần 200 Tiên ngọc.'
            ]);
            return;
        }

        $this->playerRepo->updateCurrency($this->sid, 'uczb', -$cost);
        $isVip = $player->vip > 0;
        $result = $this->skillRepo->drawSkill($this->sid, $player->uid, $isVip);

        $message = '';
        if ($result['type'] === 'duplicate') {
            $message = "Bạn đã có bí tịch này, số lượng +1: " . $result['skill']->wgname;
        } else {
            $message = "Chúc mừng bạn nhận được bí tịch mới: " . $result['skill']->wgname;
        }

        $this->render('skill/index', [
            'player' => $player,
            'skills' => $this->skillRepo->getAllSkills($this->sid),
            'activeSkillId' => $player->wugong,
            'success' => $message
        ]);
    }

    public function learn()
    {
        $skillId = $_GET['wgid'] ?? 0;
        if ($skillId) {
            $this->skillRepo->learnSkill($this->sid, $skillId);
        }
        $this->redirect('?cmd=skill');
    }

    public function unlearn()
    {
        // Legacy "biguan" (Close/Unlearn)
        $this->skillRepo->unlearnSkill($this->sid);
        $this->redirect('?cmd=skill');
    }

    public function discard()
    {
        $skillId = $_GET['wgid'] ?? 0;
        if ($skillId) {
            $this->skillRepo->deleteSkill($this->sid, $skillId);
        }
        $this->redirect('?cmd=skill');
    }

    public function train()
    {
        $player = $this->playerRepo->findBySid($this->sid);
        $skillId = $player->wugong;
        
        if (!$skillId) {
            $this->redirect('?cmd=skill');
            return;
        }

        $skill = $this->skillRepo->getSkill($this->sid, $skillId);
        
        // Calculate training time if currently training
        $trainingTime = 0;
        $expGain = 0;
        if ($skill->xlzt == 1) {
            $start = strtotime($skill->xlsj);
            $now = time();
            $trainingTime = floor(($now - $start) / 60);
            if ($trainingTime > 1440) $trainingTime = 1440; // Max 24 hours
            
            // Preview exp gain
            if ($trainingTime > 1440) {
                $expGain = round(1440 * 1.2);
            } else {
                $expGain = round($trainingTime * 0.8);
            }
        }

        // Calculate consumption (Currency for start)
        $currencyCost = $skill->wgdj * 3;
        if ($currencyCost == 0) $currencyCost = 1;

        $this->render('skill/train', [
            'player' => $player,
            'skill' => $skill,
            'trainingTime' => $trainingTime,
            'currencyCost' => $currencyCost,
            'expGain' => $expGain
        ]);
    }

    public function startTraining()
    {
        $player = $this->playerRepo->findBySid($this->sid);
        $skillId = $player->wugong;
        $type = $_GET['type'] ?? 1; // 1 = Linh thạch, 2 = Ma thạch
        
        if (!$skillId) {
            $this->redirect('?cmd=skill');
            return;
        }

        $skill = $this->skillRepo->getSkill($this->sid, $skillId);
        
        if ($skill->xlzt == 1) {
            $this->redirect('?cmd=skill_train');
            return;
        }

        // Check currency
        $cost = $skill->wgdj * 3;
        if ($cost == 0) $cost = 1;

        $currencyType = ($type == 1) ? 'uyxb' : 'uczb';
        $currencyName = ($type == 1) ? 'Linh thạch' : 'Ma thạch';
        $currentAmount = ($type == 1) ? $player->uyxb : $player->uczb;

        if ($currentAmount < $cost) {
             $this->render('skill/train', [
                'player' => $player,
                'skill' => $skill,
                'trainingTime' => 0,
                'currencyCost' => $cost,
                'expGain' => 0,
                'error' => "Không đủ $currencyName để tu luyện!"
            ]);
            return;
        }

        // Deduct currency
        $this->playerRepo->updateCurrency($this->sid, $currencyType, -$cost);

        $this->skillRepo->startTraining($this->sid, $skillId);
        $this->redirect('?cmd=skill_train');
    }

    public function endTraining()
    {
        $player = $this->playerRepo->findBySid($this->sid);
        $skillId = $player->wugong;
        
        if (!$skillId) {
            $this->redirect('?cmd=skill');
            return;
        }

        $skill = $this->skillRepo->getSkill($this->sid, $skillId);
        
        if ($skill->xlzt != 1) {
            $this->redirect('?cmd=skill_train');
            return;
        }

        $start = strtotime($skill->xlsj);
        $now = time();
        $minutes = floor(($now - $start) / 60);
        // if ($minutes > 1440) $minutes = 1440; // Handled in Repo

        // End training consumes 1 book
        $result = $this->skillRepo->endTraining($this->sid, $skillId, $minutes);
        
        $message = "Kết thúc tu luyện. Thời gian: $minutes phút. Nhận được " . $result['exp_gain'] . " kinh nghiệm.";
        if ($result['leveled_up']) {
            $message .= " Chúc mừng! Võ công đã thăng cấp lên cấp " . $result['new_level'] . "!";
        }

        // Refresh skill data
        $skill = $this->skillRepo->getSkill($this->sid, $skillId);
        $currencyCost = $skill->wgdj * 3;
        if ($currencyCost == 0) $currencyCost = 1;

        $this->render('skill/train', [
            'player' => $player,
            'skill' => $skill,
            'trainingTime' => 0,
            'currencyCost' => $currencyCost,
            'expGain' => 0,
            'success' => $message
        ]);
    }
}
