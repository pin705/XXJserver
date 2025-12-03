<?php

namespace XXJ\Controllers;

use XXJ\Core\Controller;
use XXJ\Repositories\BossRepository;
use XXJ\Repositories\ItemRepository;
use XXJ\Repositories\SkillRepository;

class BossController extends Controller
{
    private $bossRepo;
    private $itemRepo;
    private $skillRepo;

    public function __construct()
    {
        parent::__construct();
        $this->bossRepo = new BossRepository();
        $this->itemRepo = new ItemRepository();
        $this->skillRepo = new SkillRepository();
    }

    public function index()
    {
        // Alias for info if needed, or list bosses
        $this->info();
    }

    public function info()
    {
        $sid = $this->sid;
        $bossid = $_GET['bossid'] ?? 0;
        
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
            'drops' => $drops
        ]);
    }

    public function combat()
    {
        $this->fight();
    }

    public function fight()
    {
        $sid = $this->sid;
        $player = $this->player;
        $bossid = $_GET['bossid'] ?? 0;
        $cmd = $_GET['cmd'] ?? '';
        $canshu = $_GET['canshu'] ?? null;
        $nowmid = $_GET['nowmid'] ?? $player->nowmid;
        
        $boss = $this->bossRepo->findById($bossid);
        
        if (!$boss) {
            echo "Boss not found.";
            return;
        }
        
        if ($boss->bosshp <= 0) {
            $this->bossRepo->upgradeBoss($bossid);
            $this->render('boss_escaped', ['boss' => $boss, 'nowmid' => $nowmid]);
            return;
        }
        
        if ($nowmid && $player->nowmid != $nowmid) {
             $backLink = $this->encoder->encode("cmd=gomid&newmid=$player->nowmid&sid=$sid");
             echo "Map mismatch. <a href='?cmd=$backLink'>Return</a>";
             return;
        }
        
        if (($boss->sid != $sid && $boss->sid != '') || ($boss->bossid == '')) {
            $backLink = $this->encoder->encode("cmd=gomid&newmid=$player->nowmid&sid=$sid");
            echo "Boss is fighting someone else! <a href='?cmd=$backLink'>Return</a>";
            return;
        }
        
        if ($boss->sid == '') {
            $boss->sid = $sid;
            $this->bossRepo->update($boss);
        }
        
        if ($canshu == 'useyp' && isset($_GET['ypid'])) {
            $this->playerRepo->usePotion($sid, $_GET['ypid']);
            // Refresh player
            $player = $this->playerRepo->findBySid($sid);
            $this->player = $player;
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
                    $this->playerRepo->updateHp($sid, $player->uhp);
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
                $this->render('boss_lose', ['boss' => $boss, 'nowmid' => $nowmid]);
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
            'boss' => $boss,
            'combatLog' => $combatLog,
            'nowmid' => $nowmid,
            'potions' => $potions
        ]);
    }
}
