<?php

namespace XXJ\Controllers;

use XXJ\Core\Controller;
use XXJ\Repositories\ItemRepository;

class InventoryController extends Controller
{
    private ItemRepository $itemRepo;

    public function __construct()
    {
        parent::__construct();
        $this->itemRepo = new ItemRepository();
    }

    public function showPillBag()
    {
        $_GET['type'] = 'pill';
        $this->showBag();
    }

    public function showBag()
    {
        $sid = $this->sid;
        $player = $this->player;
        if (!$player) return;

        $type = $_GET['type'] ?? 'equip'; // equip, potion, item, skill

        if ($type == 'equip') {
            $page = $_GET['page'] ?? 1;
            $limit = 10;
            $offset = ($page - 1) * $limit;

            $items = $this->itemRepo->getPlayerEquipment($sid, $offset, $limit);
            $totalItems = $this->itemRepo->countPlayerEquipment($sid);
            $totalPages = ceil($totalItems / $limit);

            $this->render('game/bagzb', [
                'items' => $items,
                'page' => $page,
                'totalPages' => $totalPages,
                'type' => 'equip'
            ]);
        } elseif ($type == 'potion') {
            $items = $this->itemRepo->getPlayerPotions($sid);
            $this->render('game/bagyp', [
                'items' => $items,
                'type' => 'potion'
            ]);
        } elseif ($type == 'item') {
            $items = $this->itemRepo->getPlayerDaoju($sid);
            $this->render('game/bagdj', [
                'items' => $items,
                'type' => 'item'
            ]);
        } elseif ($type == 'pill') {
            $items = $this->itemRepo->getPlayerYaoDan($sid);
            $this->render('game/bagyd', [
                'items' => $items,
                'type' => 'pill'
            ]);
        }
    }

    public function showDetail()
    {
        $type = $_GET['type'] ?? 'equip';
        $id = $_GET['id'] ?? 0;
        $sid = $this->sid;

        if ($type == 'equip') {
            $item = $this->itemRepo->findById($id);
            $this->render('game/zbinfo', ['item' => $item]);
        } elseif ($type == 'potion') {
            $item = $this->itemRepo->getPotionTemplate($id);
            $playerPotion = $this->itemRepo->getPlayerPotion($sid, $id);
            $this->render('game/ypinfo', ['item' => $item, 'playerPotion' => $playerPotion]);
        } elseif ($type == 'item') {
            $item = $this->itemRepo->getItemTemplate($id);
            $playerItem = $this->itemRepo->getPlayerDaojuSingle($sid, $id);
            $this->render('game/djinfo', ['item' => $item, 'playerItem' => $playerItem]);
        } elseif ($type == 'pill') {
            $item = $this->itemRepo->getYaoDanTemplate($id);
            $playerItem = $this->itemRepo->getPlayerYaoDanSingle($sid, $id);
            $this->render('game/ydinfo', ['item' => $item, 'playerItem' => $playerItem]);
        }
    }

    public function showTemplateDetail()
    {
        $zbid = $_GET['zbid'] ?? 0;
        $item = $this->itemRepo->getEquipmentTemplate($zbid);
        $this->render('game/zbinfo_sys', ['item' => $item]);
    }

    public function usePill()
    {
        $ydid = $_GET['ydid'] ?? 0;
        $sid = $this->sid;
        
        $success = $this->itemRepo->useYaoDan($sid, $ydid);
        
        $message = $success ? "Sử dụng đan dược thành công! Thuộc tính đã tăng." : "Sử dụng thất bại!";
        
        // Render detail with message
        $item = $this->itemRepo->getYaoDanTemplate($ydid);
        $playerItem = $this->itemRepo->getPlayerYaoDanSingle($sid, $ydid);
        
        $this->render('game/ydinfo', [
            'item' => $item, 
            'playerItem' => $playerItem,
            'message' => $message
        ]);
    }

    public function usePotion()
    {
        $ypid = $_GET['ypid'] ?? 0;
        $sid = $this->sid;
        
        // Logic to use potion (heal, etc.)
        // For now, just decrease count and show message
        // Real logic should be in Repo or Service
        
        $this->itemRepo->usePotion($sid, $ypid);
        $this->redirect('ypinfo', ['type' => 'potion', 'id' => $ypid, 'sid' => $sid]);
    }

    public function setPotionSlot()
    {
        $ypid = $_GET['ypid'] ?? 0;
        $slot = $_GET['slot'] ?? 1; // 1, 2, 3
        $sid = $this->sid;

        $this->playerRepo->setPotionSlot($sid, $slot, $ypid);
        $this->redirect('ypinfo', ['type' => 'potion', 'id' => $ypid, 'sid' => $sid]);
    }

    public function upgradeEquipment()
    {
        $zbid = $_GET['zbid'] ?? 0;
        $sid = $this->sid;
        
        // Logic to upgrade equipment
        // For now, just redirect back
        $this->redirect('zbinfo', ['zbid' => $zbid, 'sid' => $sid]);
    }

    public function deleteEquipment()
    {
        $zbid = $_GET['zbid'] ?? 0;
        $sid = $this->sid;
        
        $this->itemRepo->deleteItem($zbid, $sid);
        $this->redirect('getbagzb', ['sid' => $sid]);
    }
}
