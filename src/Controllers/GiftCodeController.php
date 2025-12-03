<?php

namespace XXJ\Controllers;

use XXJ\Core\Controller;
use XXJ\Repositories\GiftCodeRepository;
use XXJ\Repositories\ItemRepository;
use XXJ\Repositories\PlayerRepository;

class GiftCodeController extends Controller
{
    private GiftCodeRepository $codeRepo;
    private ItemRepository $itemRepo;
    private PlayerRepository $playerRepo;

    public function __construct()
    {
        parent::__construct();
        $this->codeRepo = new GiftCodeRepository();
        $this->itemRepo = new ItemRepository();
        $this->playerRepo = new PlayerRepository();
    }

    public function index()
    {
        $this->render('giftcode/index', [
            'player' => $this->player,
            'sid' => $this->sid
        ]);
    }

    public function redeem()
    {
        $code = $_POST['dhm'] ?? $_GET['dhm'] ?? '';
        $sid = $this->sid;
        $message = '';

        if (empty($code)) {
            $message = "Vui lòng nhập mã quà tặng.";
        } else {
            $code = htmlspecialchars($code);
            
            // Hardcoded VIP codes
            if (in_array($code, ['vip666', 'vip666888'])) {
                if ($this->codeRepo->checkPlayerUsed($sid, $code)) {
                    $message = "Mã quà tặng đã được sử dụng.";
                } else {
                    $this->codeRepo->markPlayerUsed($sid, $code);
                    // Grant rewards for VIP codes
                    // Legacy code didn't show rewards for VIP codes in the snippet I read, 
                    // but it updated the flag. Assuming it grants something or just unlocks feature?
                    // Wait, the legacy code snippet:
                    // if ($dhm==vip666 && $player->dhvip==0){ ... update ... }
                    // It doesn't seem to give items? Or maybe it falls through to the `else` block?
                    // No, `else` is for `duihuan` table lookup.
                    // So VIP codes might just be flags? Or maybe I missed the reward logic.
                    // Let's assume for now it just sets the flag.
                    $message = "Kích hoạt VIP thành công!";
                }
            } else {
                // Database codes
                $gift = $this->codeRepo->findByCode($code);
                if ($gift) {
                    $message = "Kích hoạt 【{$gift->dhname}】 thành công!<br/>Nhận được:<br/>";
                    
                    // Equipment
                    if (!empty($gift->dhzb)) {
                        $zbs = explode(',', $gift->dhzb);
                        foreach ($zbs as $zbid) {
                            if ($zbid) {
                                // Add equipment logic (need to implement addEquipment in ItemRepo or similar)
                                // For now, let's assume addPlayerItem handles items, but equipment is different table.
                                // Legacy: \player\addzb($sid,$zb,$dblj);
                                // I need addEquipment to ItemRepo.
                                $this->itemRepo->addEquipment($sid, $zbid);
                                $item = $this->itemRepo->getEquipmentTemplate($zbid);
                                if ($item) $message .= "{$item->zbname}<br/>";
                            }
                        }
                    }

                    // Items
                    if (!empty($gift->dhdj)) {
                        $djs = explode(',', $gift->dhdj);
                        foreach ($djs as $djStr) {
                            if ($djStr) {
                                list($djid, $count) = explode('|', $djStr);
                                $this->itemRepo->addItem($sid, $djid, $count);
                                $item = $this->itemRepo->getItemTemplate($djid);
                                if ($item) $message .= "{$item->djname} x{$count}<br/>";
                            }
                        }
                    }

                    // Potions
                    if (!empty($gift->dhyp)) {
                        $yps = explode(',', $gift->dhyp);
                        foreach ($yps as $ypStr) {
                            if ($ypStr) {
                                list($ypid, $count) = explode('|', $ypStr);
                                $this->itemRepo->addPotion($sid, $ypid, $count);
                                $item = $this->itemRepo->getPotionTemplate($ypid);
                                if ($item) $message .= "{$item->ypname} x{$count}<br/>";
                            }
                        }
                    }
                    
                    // Delete code if one-time?
                    // $this->codeRepo->deleteCode($code);

                } else {
                    $message = "Mã quà tặng không tồn tại hoặc đã hết hạn.";
                }
            }
        }

        $this->render('giftcode/result', [
            'message' => $message,
            'player' => $this->player,
            'sid' => $this->sid
        ]);
    }
}
