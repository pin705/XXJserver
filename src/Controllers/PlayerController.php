<?php

namespace XXJ\Controllers;

use XXJ\Core\Controller;
use XXJ\Repositories\ItemRepository;

class PlayerController extends Controller
{
    private ItemRepository $itemRepo;

    public function __construct()
    {
        parent::__construct();
        $this->itemRepo = new ItemRepository();
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
}
