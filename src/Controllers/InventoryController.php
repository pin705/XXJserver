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

    public function showBag()
    {
        $sid = $this->sid;
        $player = $this->player;
        if (!$player) return;

        $page = $_GET['page'] ?? 1;
        $limit = 10;
        $offset = ($page - 1) * $limit;

        $items = $this->itemRepo->getPlayerItems($sid, $offset, $limit);
        $totalItems = $this->itemRepo->countPlayerItems($sid);
        $totalPages = ceil($totalItems / $limit);

        $this->render('bagzb', [
            'items' => $items,
            'page' => $page,
            'totalPages' => $totalPages
        ]);
    }
}
