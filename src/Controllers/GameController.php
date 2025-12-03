<?php

namespace XXJ\Controllers;

use XXJ\Core\Controller;
use XXJ\Repositories\MapRepository;
use XXJ\Repositories\BossRepository;
use XXJ\Repositories\NpcRepository;
use XXJ\Repositories\MonsterRepository;
use XXJ\Repositories\ChatRepository;

class GameController extends Controller
{
    private MapRepository $mapRepo;
    private BossRepository $bossRepo;
    private NpcRepository $npcRepo;
    private MonsterRepository $monsterRepo;
    private ChatRepository $chatRepo;

    public function __construct()
    {
        parent::__construct();
        $this->mapRepo = new MapRepository();
        $this->bossRepo = new BossRepository();
        $this->npcRepo = new NpcRepository();
        $this->monsterRepo = new MonsterRepository();
        $this->chatRepo = new ChatRepository();
    }

    public function moveToMap()
    {
        $sid = $this->sid;
        $player = $this->player;
        $newmid = $_GET['newmid'] ?? null;

        if (!$player) {
            echo "Player not found";
            return;
        }

        if ($newmid && $player->nowmid != $newmid) {
            $clmid = $this->mapRepo->findById($newmid);
            $playerinfo = $player->uname . "Hướng" . $clmid->mname . ".Đi đến";
            
            if ($playerinfo != $clmid->playerinfo) {
                $this->mapRepo->updatePlayerInfo($player->nowmid, $playerinfo);
            }

            if ($player->uhp <= 0) {
                $retmid = $this->mapRepo->findById($player->nowmid);
                $retqy = $this->mapRepo->getRegion($retmid->mqy);
                $gonowmid = $this->encoder->encode("cmd=gomid&newmid=$retqy->mid&sid=$sid");
                if ($newmid != $retqy->mid) {
                    exit("Ngươi đã trọng thương mời trị liệu<br/>" . '<a href="?cmd=' . $gonowmid . '">Trở về trò chơi</a>');
                }
            }

            $this->playerRepo->updateMap($sid, $newmid);
            $player->nowmid = $newmid;
        }

        $this->showMap();
    }

    public function showMap()
    {
        $sid = $this->sid;
        $player = $this->player;
        
        if (!$player) return;

        if (empty($player->nowmid) || $player->nowmid == 0) {
            // Fallback to firstmid logic if needed, but assuming valid map for now
        }

        $clmid = $this->mapRepo->findById($player->nowmid);
        
        // Boss Logic
        $boss = null;
        $bossHtml = '';
        $djs = '';
        if ($clmid->midboss != 0) {
            $boss = $this->bossRepo->findById($clmid->midboss);
            $nowdate = date('Y-m-d H:i:s');
            $second = floor((strtotime($nowdate) - strtotime($clmid->mgtime)) % 86400);
            
            if ($boss->bosshp < 0 && $second > $clmid->ms) {
                $this->bossRepo->respawn($clmid->midboss);
                $boss = $this->bossRepo->findById($clmid->midboss);
            }
            
            if ($boss->bosshp > 0) {
                $bossinfo = $this->encoder->encode("cmd=boss&bossid=$boss->bossid&sid=$sid");
                $bossHtml = "<a style=\"color: #f80a0a;border-radius: 10px;\" href=\"?cmd=$bossinfo\">$boss->bossname</a>";
            } else {
                 // Countdown logic
                 $sj = $clmid->ms - $second;
                 if ($sj > 0) {
                     $djs = $sj; // Pass to view to render JS countdown
                 }
            }
        }

        // NPCs
        $npcs = $this->npcRepo->getNpcsByMap($player->nowmid);
        
        // Monsters
        $monsters = $this->monsterRepo->getMonstersByMap($player->nowmid);

        // Chat
        $chats = $this->chatRepo->getGlobalMessages(2);

        // Links
        $links = [
            'up' => $this->encoder->encode("cmd=gomid&newmid=$clmid->upmid&sid=$sid"),
            'down' => $this->encoder->encode("cmd=gomid&newmid=$clmid->downmid&sid=$sid"),
            'left' => $this->encoder->encode("cmd=gomid&newmid=$clmid->leftmid&sid=$sid"),
            'right' => $this->encoder->encode("cmd=gomid&newmid=$clmid->rightmid&sid=$sid"),
            'refresh' => $this->encoder->encode("cmd=gomid&newmid=$clmid->mid&sid=$sid"),
            'map' => $this->encoder->encode("cmd=allmap&sid=$sid"),
            'task' => $this->encoder->encode("cmd=mytask&sid=$sid"),
            'status' => $this->encoder->encode("cmd=zhuangtai&sid=$sid"),
            'bag' => $this->encoder->encode("cmd=getbagzb&sid=$sid"),
            'chat' => $this->encoder->encode("cmd=liaotian&ltlx=all&sid=$sid"),
            'pet' => $this->encoder->encode("cmd=chongwu&sid=$sid"),
            'shop' => $this->encoder->encode("cmd=shangdian&canshu=gogoumai&sid=$sid"),
            'rank' => $this->encoder->encode("cmd=paihang&sid=$sid"),
            'cultivate' => $this->encoder->encode("cmd=goxiulian&sid=$sid"),
            'trade' => $this->encoder->encode("cmd=fangshi&fangshi=daoju&sid=$sid"),
            'club' => $this->encoder->encode("cmd=club&sid=$sid"),
            'friend' => $this->encoder->encode("cmd=im&sid=$sid"),
            'gift' => $this->encoder->encode("cmd=duihuan&sid=$sid"),
            'mystery_shop' => $this->encoder->encode("cmd=getbagyd&sid=$sid"),
        ];

        $this->render('game/nowmid', [
            'clmid' => $clmid,
            'boss' => $boss,
            'bossHtml' => $bossHtml,
            'djs' => $djs,
            'npcs' => $npcs,
            'monsters' => $monsters,
            'chats' => $chats,
            'links' => $links
        ]);
    }

    public function listMaps()
    {
        $maps = $this->mapRepo->getAllMaps();
        $this->render('game/allmap', ['maps' => $maps]);
    }

    public function showRegionMap()
    {
        $sid = $this->sid;
        $player = $this->player;
        $currentMap = $this->mapRepo->findById($player->nowmid);
        
        $qyid = $_GET['qyid'] ?? $currentMap->mqy;
        
        // Get all maps in the region
        $maps = $this->mapRepo->findByRegion($qyid);
        
        $this->render('game/region_map', [
            'maps' => $maps,
            'currentMap' => $currentMap,
            'player' => $player,
            'sid' => $sid
        ]);
    }

    public function showWorldMap()
    {
        $regions = $this->mapRepo->getAllRegions();
        $this->render('game/world_map', ['regions' => $regions]);
    }
}
