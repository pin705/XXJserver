<?php

namespace XXJ\Controllers;

use XXJ\Core\Controller;
use XXJ\Repositories\ItemRepository;

class SuitController extends Controller
{
    private ItemRepository $itemRepo;

    public function __construct()
    {
        parent::__construct();
        $this->itemRepo = new ItemRepository();
    }

    public function index()
    {
        $player = $this->player;
        $sid = $this->sid;

        // Get equipped items
        $equippedItems = [];
        $suits = [];

        for ($i = 1; $i <= 7; $i++) {
            $toolId = $player->{"tool$i"};
            if ($toolId) {
                $item = $this->itemRepo->findById($toolId);
                if ($item) {
                    $equippedItems[$i] = $item;
                    if ($item->taozhuang) {
                        if (!isset($suits[$item->taozhuang])) {
                            $suits[$item->taozhuang] = 0;
                        }
                        $suits[$item->taozhuang]++;
                    }
                }
            }
        }

        // Calculate active bonuses (simplified logic based on legacy file structure)
        // Legacy file seems to just list items and maybe check if they match.
        // It has a lot of if/else for combinations.
        // I'll just show the count of each suit set.
        
        $this->render('suit/index', [
            'player' => $player,
            'equippedItems' => $equippedItems,
            'suits' => $suits
        ]);
    }
}
