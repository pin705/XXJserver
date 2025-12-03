<?php

namespace XXJ\Controllers;

use XXJ\Core\Controller;
use XXJ\Repositories\ItemRepository;

class ShopController extends Controller
{
    private $itemRepo;

    public function __construct()
    {
        parent::__construct();
        $this->itemRepo = new ItemRepository();
    }

    public function index()
    {
        $sid = $this->sid;
        $player = $this->player;
        
        // Handle buy actions
        $cmd = $_GET['cmd'] ?? '';
        $buyId = $_GET['buy_id'] ?? null;
        $amount = intval($_GET['amount'] ?? 1);
        $currency = $_GET['currency'] ?? 'uyxb'; // uyxb or uczb
        
        $message = '';
        
        if ($buyId && $amount > 0) {
            $item = $this->itemRepo->getShopItem($buyId);
            
            if (!$item) {
                $message = "Vật phẩm không tồn tại!";
            } else {
                $cost = 0;
                $canAfford = false;
                
                if ($currency === 'uyxb') {
                    $cost = $item['jiage'] * $amount;
                    if ($player->uyxb >= $cost) {
                        $canAfford = true;
                        // Deduct currency
                        $player->uyxb -= $cost;
                    } else {
                        $message = "Bạn không đủ linh thạch!";
                    }
                } elseif ($currency === 'uczb') {
                    $cost = $item['jiage'] * $amount; // Assuming same price for now, or check if there's a separate premium price field
                    // Legacy code usually has different logic or price for premium currency, 
                    // but based on shangdian.php, it seems to use 'jiage' for both but different buy actions.
                    // Let's assume standard price for now.
                    if ($player->uczb >= $cost) {
                        $canAfford = true;
                        $player->uczb -= $cost;
                    } else {
                        $message = "Bạn không đủ tiên thạch!";
                    }
                }
                
                if ($canAfford) {
                    // Update player currency in DB
                    $stmt = $this->db->prepare("UPDATE game1 SET uyxb = ?, uczb = ? WHERE sid = ?");
                    $stmt->execute([$player->uyxb, $player->uczb, $sid]);
                    
                    // Add item to inventory
                    $this->itemRepo->addPlayerShopItem($sid, $item, $amount);
                    
                    $message = "Mua thành công {$amount} {$item['ydname']}!";
                }
            }
        }

        // Get shop items
        $items = $this->itemRepo->getAllShopItems();

        $data = [
            'player' => $player,
            'items' => $items,
            'message' => $message,
            'sid' => $sid
        ];

        $this->render('shop/index', $data);
    }
}
