<?php

namespace XXJ\Controllers;

use XXJ\Core\View;
use XXJ\Utils\Encoder;
use XXJ\Repositories\PlayerRepository;
use XXJ\Repositories\ItemRepository;
use XXJ\Core\Database;

class PlayerController
{
    private PlayerRepository $playerRepo;
    private ItemRepository $itemRepo;
    private Encoder $encoder;
    private $db;

    public function __construct()
    {
        $this->playerRepo = new PlayerRepository();
        $this->itemRepo = new ItemRepository();
        $this->encoder = new Encoder();
        $this->db = Database::getInstance()->getConnection();
    }

    public function showStatus($params)
    {
        $sid = $params['sid'];
        $player = $this->playerRepo->findBySid($sid);
        if (!$player) return;

        // Handle unequip
        if (isset($params['cmd']) && $params['cmd'] == 'xxzb' && isset($params['zbwz'])) {
            $slot = $params['zbwz'];
            $this->playerRepo->unequipItem($sid, $slot);
            $player = $this->playerRepo->findBySid($sid); // Refresh player
        }

        // Handle equip
        $errorMsg = '';
        if (isset($params['cmd']) && $params['cmd'] == 'setzbwz' && isset($params['zbnowid']) && isset($params['zbwz'])) {
            $zbnowid = $params['zbnowid'];
            $slot = $params['zbwz'];
            
            // Check if item exists and belongs to player
            // Note: In a real scenario, we should check inventory, but for now we check if item exists
            $item = $this->itemRepo->findById($zbnowid);
            
            if (!$item || $item->uid != $player->uid) {
                $errorMsg = "Ngươi không có nên trang bị, không cách nào trang bị";
            } elseif ($item->zblv - $player->ulv > 5) {
                $errorMsg = "Trang bị lớn hơn người chơi đẳng cấp, không cách nào trang bị";
            } elseif ($item->tool != $slot && $item->tool) {
                $errorMsg = "Trang bị chủng loại không phù hợp, không cách nào trang bị";
            } else {
                $this->playerRepo->equipItem($sid, $slot, $zbnowid);
                $player = $this->playerRepo->findBySid($sid); // Refresh
            }
        }

        // Load equipped items details
        $equippedItems = [];
        for ($i = 1; $i <= 7; $i++) {
            $toolProp = "tool$i";
            if ($player->$toolProp != 0) {
                $equippedItems[$i] = $this->itemRepo->findById($player->$toolProp);
            }
        }

        View::render('zhuangtai', [
            'player' => $player,
            'equippedItems' => $equippedItems,
            'encoder' => $this->encoder,
            'sid' => $sid,
            'errorMsg' => $errorMsg
        ]);
    }
}
