<?php

namespace XXJ\Controllers;

use XXJ\Core\Controller;
use XXJ\Repositories\PlayerRepository;
use XXJ\Repositories\ShopRepository;
use XXJ\Utils\Encoder;

class ShopController extends Controller
{
    private $playerRepo;
    private $shopRepo;
    private $encoder;

    public function __construct()
    {
        $this->playerRepo = new PlayerRepository();
        $this->shopRepo = new ShopRepository();
        $this->encoder = new Encoder();
    }

    public function index()
    {
        $sid = $_GET['sid'];
        $player = $this->playerRepo->findBySid($sid);
        
        // Handle buy actions if present
        $canshu = $_GET['canshu'] ?? null;
        $canshu1 = $_GET['canshu1'] ?? null;
        $ydid = $_GET['ydid'] ?? null;
        $ydcount = $_GET['ydcount'] ?? null;
        
        $message = '';
        $messageType = ''; // success, error

        if ($canshu === 'gogoumai' && $ydid && $ydcount) {
            $result = $this->shopRepo->buyItem($sid, $ydid, $ydcount, 1); // 1 = uyxb
            if ($result) {
                $message = "Thao tác thành công";
                $messageType = 'success';
            } else {
                $message = "Thao tác thất bại";
                $messageType = 'error';
            }
        } elseif ($canshu1 === 'gogoumai1' && $ydid && $ydcount) {
            $result = $this->shopRepo->buyItem($sid, $ydid, $ydcount, 2); // 2 = uczb
            if ($result) {
                $message = "Thao tác thành công";
                $messageType = 'success';
            } else {
                $message = "Thao tác thất bại";
                $messageType = 'error';
            }
        }

        // Get all items
        $items = $this->shopRepo->getAllItems();
        
        // Re-fetch player to get updated currency
        $player = $this->playerRepo->findBySid($sid);

        $data = [
            'player' => $player,
            'sid' => $sid,
            'items' => $items,
            'encode' => $this->encoder,
            'message' => $message,
            'messageType' => $messageType,
            'canshu' => $canshu,
            'canshu1' => $canshu1
        ];

        $this->render('shangdian', $data);
    }
}
