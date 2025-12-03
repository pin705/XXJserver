<?php

namespace XXJ\Controllers;

use XXJ\Core\Controller;
use XXJ\Repositories\RankingRepository;

class RankingController extends Controller
{
    private RankingRepository $rankingRepo;

    public function __construct()
    {
        parent::__construct();
        $this->rankingRepo = new RankingRepository();
    }

    public function index()
    {
        $type = $_GET['type'] ?? 'level';
        
        switch ($type) {
            case 'attack':
                $rankings = $this->rankingRepo->getAttackRanking();
                $title = 'Bảng Xếp Hạng Công Kích';
                break;
            case 'defense':
                $rankings = $this->rankingRepo->getDefenseRanking();
                $title = 'Bảng Xếp Hạng Phòng Thủ';
                break;
            case 'wealth':
                $rankings = $this->rankingRepo->getWealthRanking();
                $title = 'Bảng Xếp Hạng Tài Phú';
                break;
            case 'level':
            default:
                $rankings = $this->rankingRepo->getLevelRanking();
                $title = 'Bảng Xếp Hạng Đẳng Cấp';
                break;
        }

        $this->render('game/ranking', [
            'rankings' => $rankings,
            'type' => $type,
            'title' => $title,
            'player' => $this->player
        ]);
    }
}
