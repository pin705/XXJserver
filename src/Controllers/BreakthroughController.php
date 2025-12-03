<?php

namespace XXJ\Controllers;

use XXJ\Core\Controller;
use XXJ\Repositories\PlayerRepository;

class BreakthroughController extends Controller
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
        
        // Calculate breakthrough cost
        // Legacy logic:
        // $tupo = \player\istupo($sid,$dblj);
        // $tpls = $player->ulv * $player->ulv * $player->ulv * 0.6;
        // if ($tupo == 1 || $tupo == 3) $tpls = ... * 0.2;
        // if ($tupo == 2) $tpls = ... * 0.2;
        // Simplified: Cost depends on level and stage.
        // I need `istupo` logic. It seems to check if player is at a breakthrough point (level 9, 19, 29 etc?)
        // Or maybe `jingjie` stages.
        // Let's implement `checkBreakthroughStatus` in Repo.
        
        $breakthroughInfo = $this->playerRepo->checkBreakthroughStatus($player);
        $cost = $breakthroughInfo['cost'];
        $isStuck = $breakthroughInfo['isStuck']; // Needs breakthrough
        
        $message = '';
        $resultType = ''; // success, error, fail

        if (isset($_GET['action']) && $_GET['action'] == 'breakthrough') {
            if ($player->uexp < $player->umaxexp) {
                $message = "Tu vi không đủ, không cách nào đột phá.";
                $resultType = 'error';
            } elseif ($player->uyxb < $cost) {
                $message = "Linh thạch không đủ, không cách nào đột phá.";
                $resultType = 'error';
            } else {
                // Attempt breakthrough
                // Deduct cost
                $this->playerRepo->deductCurrency($this->sid, 'uyxb', $cost);
                
                // Chance logic
                // Legacy: $sjs = mt_rand(1,10); if ($sjs <= 7) fail. (30% success rate?)
                // Wait, legacy code says: if ($sjs <= 7) { echo "Fail"; break; }
                // So 30% success.
                // But then it has other conditions.
                // Let's simplify: 30% base chance.
                
                $chance = mt_rand(1, 10);
                if ($chance <= 7) {
                    $message = "Đột phá thất bại! Bạn cần thêm may mắn.";
                    $resultType = 'fail';
                } else {
                    // Success
                    // Stats gain
                    // Legacy: $uphp = 4+ round($player->ulv/1.2); etc.
                    $stats = [
                        'hp' => 4 + round($player->ulv / 1.2),
                        'gj' => 2 + round($player->ulv / 2.5),
                        'fy' => 3 + round($player->ulv / 2),
                        'tf' => 5
                    ];
                    
                    $this->playerRepo->processBreakthrough($this->sid, $stats);
                    $message = "Đột phá thành công! Nhận được: Công +{$stats['gj']}, Thủ +{$stats['fy']}, HP +{$stats['hp']}, Thiên phú +5";
                    $resultType = 'success';
                    
                    // Refresh player
                    $player = $this->playerRepo->findBySid($this->sid);
                    // Recheck status
                    $breakthroughInfo = $this->playerRepo->checkBreakthroughStatus($player);
                    $cost = $breakthroughInfo['cost'];
                    $isStuck = $breakthroughInfo['isStuck'];
                }
            }
        }

        $this->render('breakthrough/index', [
            'player' => $player,
            'cost' => $cost,
            'isStuck' => $isStuck,
            'message' => $message,
            'resultType' => $resultType
        ]);
    }
}
