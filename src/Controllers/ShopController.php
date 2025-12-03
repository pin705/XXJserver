<?php

namespace XXJ\Controllers;

use XXJ\Core\Controller;
use XXJ\Repositories\ShopRepository;

class ShopController extends Controller
{
    private $shopRepo;

    public function __construct()
    {
        parent::__construct();
        $this->shopRepo = new ShopRepository();
    }

    public function index()
    {
        $sid = $this->sid;
        $player = $this->player;
        
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
        
        $items = $this->shopRepo->getAllItems();
        $mode = ($canshu1 === 'gogoumai1') ? 'mathach' : 'linhthach';

        $this->render('shop/index', [
            'items' => $items,
            'mode' => $mode,
            'message' => $message,
            'messageType' => $messageType,
            'player' => $this->player
        ]);
    }
}
