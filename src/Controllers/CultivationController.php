<?php

namespace XXJ\Controllers;

use XXJ\Core\Controller;
use XXJ\Repositories\PlayerRepository;

class CultivationController extends Controller
{
    private PlayerRepository $playerRepo;

    public function __construct()
    {
        parent::__construct();
        $this->playerRepo = new PlayerRepository();
    }

    public function index()
    {
        $player = $this->playerRepo->findBySid($this->sid);
        
        $trainingTime = 0;
        $expGain = 0;
        
        if ($player->sfxl == 1) {
            $start = strtotime($player->xiuliantime);
            $now = time();
            $trainingTime = floor(($now - $start) / 60);
            
            if ($trainingTime > 1440) {
                $trainingTime = 1440;
                $expGain = round($trainingTime * $player->ulv * 1); // Legacy: round($xlsjc * $player->ulv*1)
            } else {
                $expGain = round($trainingTime * $player->ulv * 1);
            }
        }

        // Costs
        $spiritStoneCost = 32 * $player->ulv;
        $magicStoneCost = round(($player->ulv + 1) / 2);

        $this->render('cultivation/index', [
            'player' => $player,
            'trainingTime' => $trainingTime,
            'expGain' => $expGain,
            'spiritStoneCost' => $spiritStoneCost,
            'magicStoneCost' => $magicStoneCost
        ]);
    }

    public function start()
    {
        $player = $this->playerRepo->findBySid($this->sid);
        $type = $_GET['type'] ?? 1; // 1 = Spirit Stone, 2 = Magic Stone

        if ($player->sfxl == 1) {
            $this->redirect('?cmd=cultivation');
            return;
        }

        $spiritStoneCost = 32 * $player->ulv;
        $magicStoneCost = round(($player->ulv + 1) / 2);
        $success = false;

        if ($type == 1) {
            if ($player->uyxb >= $spiritStoneCost) {
                $this->playerRepo->updateCurrency($this->sid, 'uyxb', -$spiritStoneCost);
                $success = true;
            }
        } else {
            if ($player->uczb >= $magicStoneCost) {
                $this->playerRepo->updateCurrency($this->sid, 'uczb', -$magicStoneCost);
                $success = true;
            }
        }

        if ($success) {
            $this->playerRepo->updateCultivation($this->sid, 1, date('Y-m-d H:i:s'));
            $this->redirect('?cmd=cultivation');
        } else {
            $currencyName = ($type == 1) ? 'Linh thạch' : 'Ma thạch';
            $this->render('cultivation/index', [
                'player' => $player,
                'trainingTime' => 0,
                'expGain' => 0,
                'spiritStoneCost' => $spiritStoneCost,
                'magicStoneCost' => $magicStoneCost,
                'error' => "Không đủ $currencyName!"
            ]);
        }
    }

    public function end()
    {
        $player = $this->playerRepo->findBySid($this->sid);

        if ($player->sfxl != 1) {
            $this->redirect('?cmd=cultivation');
            return;
        }

        $start = strtotime($player->xiuliantime);
        $now = time();
        $minutes = floor(($now - $start) / 60);
        
        if ($minutes > 1440) $minutes = 1440;
        
        $expGain = round($minutes * $player->ulv * 1);
        if ($expGain < 0) $expGain = 0;

        $this->playerRepo->updateCultivation($this->sid, 0);
        $this->playerRepo->addExp($this->sid, $expGain);

        $this->render('cultivation/index', [
            'player' => $this->playerRepo->findBySid($this->sid), // Refresh player data
            'trainingTime' => 0,
            'expGain' => 0,
            'spiritStoneCost' => 32 * $player->ulv,
            'magicStoneCost' => round(($player->ulv + 1) / 2),
            'success' => "Kết thúc tu luyện. Thời gian: $minutes phút. Nhận được $expGain tu vi."
        ]);
    }
}
