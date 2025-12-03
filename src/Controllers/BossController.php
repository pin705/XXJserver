<?php

namespace XXJ\Controllers;

use XXJ\Core\Controller;
use XXJ\Repositories\PlayerRepository;
use XXJ\Repositories\BossRepository;
use XXJ\Repositories\ItemRepository;
use XXJ\Repositories\SkillRepository;
use XXJ\Utils\Encoder;

class BossController extends Controller
{
    private $playerRepo;
    private $bossRepo;
    private $itemRepo;
    private $skillRepo;
    private $encoder;

    public function __construct()
    {
        $this->playerRepo = new PlayerRepository();
        $this->bossRepo = new BossRepository();
        $this->itemRepo = new ItemRepository();
        $this->skillRepo = new SkillRepository();
        $this->encoder = new Encoder();
    }

    public function info()
    {
        $sid = $_GET['sid'];
        $bossid = $_GET['bossid'];
        
        $boss = $this->bossRepo->findById($bossid);
        
        // Parse drops
        $drops = [];
        if ($boss && $boss->bosshp > 0) {
            if ($boss->bosszb) {
                $ids = explode(',', $boss->bosszb);
                foreach ($ids as $id) {
                    $item = $this->itemRepo->getEquipmentTemplate($id);
                    if ($item) $drops[] = ['type' => 'zb', 'item' => $item];
                }
            }
            if ($boss->bossdj) {
                $ids = explode(',', $boss->bossdj);
                foreach ($ids as $id) {
                    $item = $this->itemRepo->getItemTemplate($id);
                    if ($item) $drops[] = ['type' => 'dj', 'item' => $item];
                }
            }
            if ($boss->bossyp) {
                $ids = explode(',', $boss->bossyp);
                foreach ($ids as $id) {
                    $item = $this->itemRepo->getPotionTemplate($id);
                    if ($item) $drops[] = ['type' => 'yp', 'item' => $item];
                }
            }
        }

        $this->render('bossinfo', [
            'boss' => $boss,
            'drops' => $drops,
            'sid' => $sid,
            'encode' => $this->encoder
        ]);
    }

    public function fight()
    {
        $sid = $_GET['sid'];
        $bossid = $_GET['bossid'];
        $cmd = $_GET['cmd'];
        $canshu = $_GET['canshu'] ?? null;
        $nowmid = $_GET['nowmid'] ?? null;
        
        $player = $this->playerRepo->findBySid($sid);
        $boss = $this->bossRepo->findById($bossid);
        
        if (!$boss) {
            echo "Boss not found.";
            return;
        }
        
        if ($boss->bosshp <= 0) {
            $this->bossRepo->upgradeBoss($bossid);
            $this->render('boss_escaped', ['sid' => $sid, 'player' => $player, 'boss' => $boss, 'encode' => $this->encoder, 'nowmid' => $nowmid]);
            return;
        }
        
        if ($nowmid && $player->nowmid != $nowmid) {
             echo "Map mismatch. <a href='?cmd=".$this->encoder->encode("cmd=gomid&newmid=$player->nowmid&sid=$sid")."'>Return</a>";
             return;
        }
        
        if (($boss->sid != $sid && $boss->sid != '') || ($boss->bossid == '')) {
            echo "Boss is fighting someone else! <a href='?cmd=".$this->encoder->encode("cmd=gomid&newmid=$player->nowmid&sid=$sid")."'>Return</a>";
            return;
        }
        
        if ($boss->sid == '') {
            $boss->sid = $sid;
            $this->bossRepo->update($boss);
        }
        
        if ($canshu == 'useyp' && isset($_GET['ypid'])) {
            $this->playerRepo->usePotion($sid, $_GET['ypid']);
            $player = $this->playerRepo->findBySid($sid);
        }
        
        $combatLog = "";
        
        if ($cmd == 'pvbgj') {
            $gj = $player->ugj;
            
            $damageToBoss = round(($gj - $boss->bossfy) * (rand(90, 110) / 100));
            if ($damageToBoss <= 0) $damageToBoss = 1;
            
            if ($player->ubj > rand(0, 100)) {
                $damageToBoss = round($damageToBoss * 1.5);
                $combatLog .= "Bạn tấn công Boss gây <font color='red'>$damageToBoss</font> sát thương (Bạo kích!).<br>";
            } else {
                $combatLog .= "Bạn tấn công Boss gây $damageToBoss sát thương.<br>";
            }
            
            $boss->bosshp -= $damageToBoss;
            
            if ($player->uxx > 0) {
                $heal = round($damageToBoss * ($player->uxx / 100));
                if ($heal > 0) {
                    $player->uhp += $heal;
                    if ($player->uhp > $player->umaxhp) $player->uhp = $player->umaxhp;
                    $combatLog .= "Bạn hút <font color='green'>$heal</font> máu.<br>";
                }
            }
            
            if ($boss->bosshp <= 0) {
                $boss->bosshp = 0;
                $this->bossRepo->update($boss);
                
                $droppedItems = [];
                // Drops logic placeholder
                if ($boss->bosszb && rand(1, $boss->dljv ?? 100) == 1) {
                    $droppedItems[] = "Trang bị";
                }
                
                $this->bossRepo->upgradeBoss($bossid);
                $this->bossRepo->clearBossOwner($sid);
                
                $this->render('boss_win', [
                    'boss' => $boss, 
                    'drops' => $droppedItems, 
                    'sid' => $sid, 
                    'encode' => $this->encoder,
                    'nowmid' => $nowmid
                ]);
                return;
            }
            
            $damageToPlayer = round(($boss->bossgj - $player->ufy) * (rand(90, 110) / 100));
            if ($damageToPlayer <= 0) $damageToPlayer = 1;
            
            $player->uhp -= $damageToPlayer;
            $combatLog .= "Boss tấn công bạn gây <font color='red'>$damageToPlayer</font> sát thương.<br>";
            
            $this->bossRepo->update($boss);
            $this->playerRepo->updateHp($sid, $player->uhp);
            
            if ($player->uhp <= 0) {
                $this->bossRepo->clearBossOwner($sid);
                $this->render('boss_lose', ['boss' => $boss, 'sid' => $sid, 'encode' => $this->encoder, 'nowmid' => $nowmid]);
                return;
            }
        }
        
        $potions = [];
        foreach (['yp1', 'yp2', 'yp3'] as $slot) {
            if ($player->$slot) {
                $p = $this->itemRepo->getPlayerPotion($sid, $player->$slot);
                if ($p) {
                    $potions[$slot] = $p;
                }
            }
        }
        
        $this->render('boss', [
            'player' => $player,
            'boss' => $boss,
            'sid' => $sid,
            'encode' => $this->encoder,
            'combatLog' => $combatLog,
            'nowmid' => $nowmid,
            'potions' => $potions
        ]);
    }
}
