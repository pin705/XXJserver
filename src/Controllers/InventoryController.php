<?php

namespace XXJ\Controllers;

use XXJ\Core\View;
use XXJ\Utils\Encoder;
use XXJ\Repositories\PlayerRepository;
use XXJ\Repositories\ItemRepository;
use XXJ\Core\Database;

class InventoryController
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

    public function showBag($params)
    {
        $sid = $params['sid'];
        $player = $this->playerRepo->findBySid($sid);
        if (!$player) return;

        $page = $params['page'] ?? 1;
        $limit = 10;
        $offset = ($page - 1) * $limit;

        $items = $this->itemRepo->getPlayerItems($sid, $offset, $limit);
        $totalItems = $this->itemRepo->countPlayerItems($sid);
        $totalPages = ceil($totalItems / $limit);

        View::render('bagzb', [
            'player' => $player,
            'items' => $items,
            'page' => $page,
            'totalPages' => $totalPages,
            'encoder' => $this->encoder,
            'sid' => $sid
        ]);
    }
}
