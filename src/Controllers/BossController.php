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
        
        $boss = $this->bossRepo->findById($bossid);
        
        if (!$boss) {
            echo "Không tìm thấy Boss.";
            return;
        }
        
        // Check if boss is already dead/escaped
        if ($boss->bosshp <= 0) {
            $this->bossRepo->upgradeBoss($bossid);
            $this->render('game/boss_escaped', ['boss' => $boss]);
            return;
        }

        $msg = '';
        // Handle Potion Usage
        if ($canshu == 'useyp') {
            $ypid = $_GET['ypid'] ?? 0;
            if ($ypid) {
                $res = $this->itemRepo->usePotion($sid, $ypid);
                if ($res) {
                    $msg .= "Đã sử dụng dược phẩm.<br>";
                    $player = $this->playerRepo->findById($sid); // Refresh player
                }
            }
        }

        // Combat Logic
        $combatLog = [];
        
        if ($cmd == 'pvbgj') {
            // 1. Player attacks Boss
            $playerDamage = $this->calculatePlayerDamage($player, $boss);
            $this->bossRepo->decreaseHp($bossid, $playerDamage);
            $boss->bosshp -= $playerDamage;
            $combatLog[] = "Bạn tấn công {$boss->bossname} gây {$playerDamage} sát thương.";

            // Check Boss Death
            if ($boss->bosshp <= 0) {
                $drops = $this->handleBossDrops($boss, $player);
                
                if ($boss->sid == $player->sid) {
                     $this->bossRepo->upgradeBoss($bossid);
                } else {
                     $this->bossRepo->upgradeBoss($bossid);
                }
                
                $this->render('game/boss_win', ['boss' => $boss, 'drops' => $drops]);
                return;
            }

            // 2. Boss attacks Player
            $bossDamage = $this->calculateBossDamage($boss, $player);
            $player->uhp -= $bossDamage;
            if ($player->uhp < 0) $player->uhp = 0;
            $this->playerRepo->update($player);
            $combatLog[] = "{$boss->bossname} tấn công bạn gây {$bossDamage} sát thương.";

            if ($player->uhp <= 0) {
                $this->render('game/boss_lose', ['boss' => $boss]);
                return;
            }
        }



        // Render Combat View
        $this->render('game/boss_combat', [
            'boss' => $boss,
            'player' => $player,
            'combatLog' => $combatLog,
            'msg' => $msg,
            'potions' => $this->itemRepo->getPlayerPotions($sid),
            'skills' => $this->skillRepo->getPlayerConsumableSkills($sid)
        ]);
    }

    private function calculatePlayerDamage($player, $boss)
    {
        // Formula: Player Attack + Pet Attack - (Boss Defense * 0.75)
        // Simplified for now (ignoring pets as I don't have PetRepo yet)
        $petDamage = 0; 
        $damage = round($petDamage + $player->ugj - ($boss->bossfy * 0.75));
        
        // Min damage check
        if ($damage < $player->ugj * 0.15) {
            $damage = round($player->ugj * 0.15);
        }
        
        // Crits
        $critChance = mt_rand(1, 200);
        if ($player->ubj >= $critChance) {
            $damage = round($damage * 1.5); // 1.5x crit
        }
        
        return max(1, $damage);
    }

    private function calculateBossDamage($boss, $player)
    {
        // Formula: Boss Attack - (Player Defense * 0.75)
        $damage = round($boss->bossgj - ($player->ufy * 0.75));
        
        if ($damage < $boss->bossgj * 0.15) {
            $damage = round($boss->bossgj * 0.15);
        }
        
        // Boss Crits
        $critChance = mt_rand(1, 100);
        if ($boss->bossbj >= $critChance) {
            $damage = round($damage * 2.25);
        }
        
        return max(1, $damage);
    }

    private function handleBossDrops($boss, $player)
    {
        $drops = [];
        $sid = $player->sid;
        
        // Currency
        $yxb = round($boss->bosslv * mt_rand(1, 5) * 30) + 100;
        $this->playerRepo->addCurrency($sid, 'uyxb', $yxb);
        $drops[] = "Nhận được $yxb Linh thạch.";
        
        // Equipment
        if ($boss->bosszb) {
            $ids = explode(',', $boss->bosszb);
            if (!empty($ids)) {
                $chance = mt_rand(1, 100);
                // Use boss drop chance if available, else 20%
                if ($chance <= 20) {
                    $zbid = $ids[array_rand($ids)];
                    // Add equipment to player
                    // Need ItemRepo->addEquipment($sid, $zbid)
                    // For now, just log it
                    $drops[] = "Rơi trang bị ID: $zbid (Chưa thêm vào túi)";
                }
            }
        }
        
        return $drops;
    }



}
