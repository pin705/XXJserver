<?php

namespace XXJ\Controllers;

use XXJ\Core\Controller;
use XXJ\Repositories\MonsterRepository;
use XXJ\Repositories\MapRepository;

class CombatController extends Controller
{
    private MonsterRepository $monsterRepo;
    private MapRepository $mapRepo;

    public function __construct()
    {
        parent::__construct();
        $this->monsterRepo = new MonsterRepository();
        $this->mapRepo = new MapRepository();
    }

    public function pve()
    {
        $sid = $this->sid;
        $player = $this->player;
        $gid = $_GET['gid'] ?? 0;
        $cmd = $_GET['cmd'] ?? '';
        
        $monster = $this->monsterRepo->findById($gid);

        if (!$player || !$monster) {
            echo "Error: Player or Monster not found.";
            return;
        }

        // Check Map
        if ($player->nowmid != $monster->mid && $monster->mid) {
             // Logic from pve.php: if ($nowmid!=$player->nowmid)
             // But here we trust player->nowmid is correct context usually. 
             // Let's just check if monster is in same map if monster has mid property
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
            // Pet logic would go here (simplified for now)
        }

        // Handle Item Use (canshu=useyp)
        if (isset($_GET['canshu']) && $_GET['canshu'] == 'useyp' && isset($_GET['ypid'])) {
            // Implement use item logic
            // $this->playerRepo->useItem($sid, $_GET['ypid']);
        }

        // Handle Attack (pvegj)
        $combatLog = "";
        if ($cmd == 'pvegj') {
            // Player attacks Monster
            $damage = max(1, $player->ugj - $monster->gfy); // Simplified formula
            // Random factor
            $damage = floor($damage * (mt_rand(90, 110) / 100));
            
            $monster->ghp -= $damage;
            $combatLog .= "Bạn tấn công {$monster->gname} gây $damage sát thương.<br>";

            if ($monster->ghp <= 0) {
                // Monster Death
                $monster->ghp = 0;
                $this->monsterRepo->updateMonster($monster);
                // Rewards logic (Exp, Items)
                // For now just show victory
                $combatLog .= "Bạn đã đánh bại {$monster->gname}!<br>";
                // Reset monster (respawn logic usually handled elsewhere or here)
                // In original code, it might delete or reset.
            } else {
                // Monster attacks Player
                $mdamage = max(1, $monster->ggj - $player->ufy);
                $mdamage = floor($mdamage * (mt_rand(90, 110) / 100));
                $player->uhp -= $mdamage;
                $this->playerRepo->updateHp($sid, $player->uhp);
                $combatLog .= "{$monster->gname} tấn công bạn gây $mdamage sát thương.<br>";
                
                $this->monsterRepo->updateMonster($monster);
            }
        }

        $this->render('pve', [
            'monster' => $monster,
            'combatLog' => $combatLog
        ]);
    }
}
