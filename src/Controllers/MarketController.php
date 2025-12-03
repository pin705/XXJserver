<?php

namespace XXJ\Controllers;

use XXJ\Core\Controller;
use XXJ\Repositories\MarketRepository;
use XXJ\Repositories\PlayerRepository;
use XXJ\Repositories\ItemRepository;
use PDO;
use PDOException;

class MarketController extends Controller
{
    private MarketRepository $marketRepo;
    private PlayerRepository $playerRepo;
    private ItemRepository $itemRepo;

    public function __construct()
    {
        parent::__construct();
        $this->marketRepo = new MarketRepository();
        $this->playerRepo = new PlayerRepository();
        $this->itemRepo = new ItemRepository();
    }

    public function index()
    {
        $type = $_GET['fangshi'] ?? 'daoju'; // daoju, zhuangbei
        $page = $_GET['page'] ?? 1;
        
        $items = $this->marketRepo->getMarketItems($type, $page);
        
        $this->render('market/index', [
            'items' => $items,
            'type' => $type,
            'page' => $page,
            'player' => $this->player
        ]);
    }

    public function buy()
    {
        $type = $_GET['fangshi'] ?? 'daoju';
        $payid = $_GET['payid'] ?? 0;
        $count = $_GET['buycount'] ?? 1;
        $sid = $this->sid;
        $player = $this->player;

        $item = $this->marketRepo->getMarketItem($type, $payid);
        if (!$item) {
            echo "Vật phẩm không tồn tại hoặc đã bán hết.";
            return;
        }

        $price = $item->pay * $count;
        if ($player->uyxb < $price) {
            echo "Linh thạch không đủ.";
            return;
        }

        // Transaction
        $db = \XXJ\Core\Database::getInstance()->getConnection();
        try {
            $db->beginTransaction();

            // Deduct money from buyer
            $this->playerRepo->deductCurrency($sid, 'uyxb', $price);

            // Add money to seller
            $this->playerRepo->addCurrencyByUid($item->uid, 'uyxb', $price);

            if ($type == 'daoju') {
                // Update market count
                if (!$this->marketRepo->updateMarketItemCount($type, $payid, $count)) {
                    throw new PDOException("Số lượng không đủ.");
                }
                // Add item to buyer
                $this->itemRepo->addPlayerItem($sid, $item->djid, $count);
                
                // Clean up if count is 0
                $this->marketRepo->removeMarketItem($type, $payid);

            } elseif ($type == 'zhuangbei') {
                // Remove from market
                if (!$this->marketRepo->removeMarketItem($type, $payid)) {
                    throw new PDOException("Trang bị đã bị mua.");
                }
                // Add equipment to buyer
                // Need to copy equipment data from market to player_equip
                // Assuming fangshi_zb has all equip data or references it.
                // Legacy code: update game1 set uid=buyer_uid where id=zbid?
                // Or insert into game1 (equipment table)?
                // Let's check legacy fangshi.php for zhuangbei logic.
                
                // Legacy: update `zhuangbei` set uid = $player->uid, sid = '' WHERE zbid = $fszb->zbid
                $sql = "UPDATE zhuangbei SET uid = :uid, sid = '' WHERE zbid = :zbid";
                $stmt = $db->prepare($sql);
                $stmt->execute([':uid' => $player->uid, ':zbid' => $item->zbid]);
            }

            $db->commit();
            echo "Giao dịch thành công!";
            
            // Refresh player
            $this->player = $this->playerRepo->findBySid($sid);

        } catch (PDOException $e) {
            $db->rollBack();
            echo "Giao dịch thất bại: " . $e->getMessage();
        }
        
        // Redirect or show link back
        $backCmd = "fangshi&fangshi=$type&sid=$sid";
        echo "<br/><a href='?cmd=$backCmd'>Quay lại</a>";
    }
}
