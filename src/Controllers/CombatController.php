<?php

namespace XXJ\Controllers;

use XXJ\Core\Controller;
use XXJ\Repositories\MonsterRepository;
use XXJ\Repositories\MapRepository;
use XXJ\Repositories\ItemRepository;
use XXJ\Repositories\SkillRepository;
use XXJ\Repositories\PlayerRepository;

class CombatController extends Controller
{
    private MonsterRepository $monsterRepo;
    private MapRepository $mapRepo;
    private ItemRepository $itemRepo;
    private SkillRepository $skillRepo;
    private PlayerRepository $playerRepo;

    public function __construct()
    {
        parent::__construct();
        $this->monsterRepo = new MonsterRepository();
        $this->mapRepo = new MapRepository();
        $this->itemRepo = new ItemRepository();
        $this->skillRepo = new SkillRepository();
        $this->playerRepo = new PlayerRepository();
    }

    public function pve()
    {
        $sid = $this->sid;
        $player = $this->player;
        $gid = $_GET['gid'] ?? 0;
        $cmd = $_GET['cmd'] ?? '';
        $canshu = $_GET['canshu'] ?? '';
        
        $monster = $this->monsterRepo->findById($gid);

        if (!$player || !$monster) {
            echo "Error: Player or Monster not found.";
            return;
        }

        // Check Map
        if ($player->nowmid != $monster->mid && $monster->mid) {
             $gonowmid = $this->encoder->encode("cmd=gomid&newmid=$player->nowmid&sid=$sid");
             echo "Mời bình thường chơi đùa！<br/><a href=\"?cmd=$gonowmid\">Trở về trò chơi</a>";
             return;
        }

        // Check if monster is engaged by someone else
        if ($monster->sid != '' && $monster->sid != $sid) {
             $gonowmid = $this->encoder->encode("cmd=gomid&newmid=$player->nowmid&sid=$sid");
             echo "Quái vật đã bị những người khác công kích！<br/>Mời thiếu hiệp luyện tập một chút tốc độ tay a<br/><a href=\"?cmd=$gonowmid\">Trở về trò chơi</a>";
             return;
        }

        // First encounter logic (pve cmd)
        if ($monster->sid == '') {
            $this->monsterRepo->setAttacker($gid, $sid);
            $monster->sid = $sid;
            // Pet logic: if player has pet, set pet HP?
            // Simplified: just engage.
        }

        $combatLog = "";
        $actionMessage = "";

        // Handle Item Use (canshu=useyp)
        if ($canshu == 'useyp' && isset($_GET['ypid'])) {
            $ypid = $_GET['ypid'];
            // Use potion logic
            $result = $this->itemRepo->usePotion($sid, $ypid);
            if ($result) {
                $actionMessage .= "Sử dụng dược phẩm thành công.<br/>";
                // Refresh player stats
                $player = $this->playerRepo->findBySid($sid);
                $this->player = $player;
            } else {
                $actionMessage .= "Sử dụng dược phẩm thất bại.<br/>";
            }
        }

        // Handle Skill Use (canshu=usejn)
        $skillDamageBonus = 0;
        if ($canshu == 'usejn' && isset($_GET['jnid'])) {
            $jnid = $_GET['jnid'];
            $skill = $this->skillRepo->useConsumableSkill($sid, $jnid);
            if ($skill) { 
                $skillDamageBonus = $skill->jngj; 
                $actionMessage .= "Sử dụng kỹ năng {$skill->jnname}!<br/>"; 
            } else {
                $actionMessage .= "Sử dụng kỹ năng thất bại.<br/>";
            }
        }

        // Handle Attack (pvegj)
        if ($cmd == 'pvegj') {
            // Player attacks Monster
            $baseDamage = max(1, $player->ugj - $monster->gfy);
            $finalDamage = floor(($baseDamage + $skillDamageBonus) * (mt_rand(90, 110) / 100));
            
            // Critical Hit (Baoji) logic could go here
            
            $monster->ghp -= $finalDamage;
            $combatLog .= "Bạn tấn công {$monster->gname} gây $finalDamage sát thương.<br>";

            if ($monster->ghp <= 0) {
                // Monster Death
                $monster->ghp = 0;
                $this->monsterRepo->updateMonster($monster);
                
                // Rewards
                $expGain = $monster->gexp;
                $this->playerRepo->addExp($sid, $expGain);
                $combatLog .= "Bạn đã đánh bại {$monster->gname}!<br>Nhận được $expGain kinh nghiệm.<br>";
                
                // Task Update Logic (if any task requires killing this monster)
                // $this->taskRepo->updateKillTask($sid, $monster->gyid);
                
                // Drop Items Logic
                // ...
                
                // Reset Monster (Respawn or Delete)
                // Usually we set sid='' and ghp=maxhp after some time, or delete instance.
                // For now, let's just clear attacker so it can be fought again (or respawn logic handles it)
                $this->monsterRepo->setAttacker($gid, '');
                // Restore HP for next fight? Or leave dead until respawn script runs?
                // Legacy code usually has a respawn mechanism.
                // Let's just leave it dead/reset for now.
                
                $this->render('pve_win', [
                    'monster' => $monster,
                    'combatLog' => $combatLog,
                    'player' => $player
                ]);
                return;
            } else {
                // Monster attacks Player
                $mdamage = max(1, $monster->ggj - $player->ufy);
                $mdamage = floor($mdamage * (mt_rand(90, 110) / 100));
                
                $player->uhp -= $mdamage;
                $this->playerRepo->updateHp($sid, $player->uhp);
                $combatLog .= "{$monster->gname} tấn công bạn gây $mdamage sát thương.<br>";
                
                if ($player->uhp <= 0) {
                    // Player Death
                    $combatLog .= "Bạn đã bị đánh bại!<br>";
                    $this->playerRepo->updateHp($sid, 1); // Revive with 1 HP at town?
                    // Redirect to town or show death screen
                    $this->render('pve_lose', [
                        'monster' => $monster,
                        'combatLog' => $combatLog,
                        'player' => $player
                    ]);
                    return;
                }
                
                $this->monsterRepo->updateMonster($monster);
            }
        }

        $this->render('pve', [
            'monster' => $monster,
            'combatLog' => $combatLog,
            'actionMessage' => $actionMessage,
            'player' => $player,
            'potions' => $this->itemRepo->getPlayerPotions($sid),
            'skills' => $this->skillRepo->getPlayerConsumableSkills($sid)
        ]);
    }
}
