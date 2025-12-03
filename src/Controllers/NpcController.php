<?php

namespace XXJ\Controllers;

use XXJ\Core\Controller;
use XXJ\Repositories\NpcRepository;
use XXJ\Repositories\TaskRepository;
use XXJ\Repositories\PlayerRepository;

class NpcController extends Controller
{
    private NpcRepository $npcRepo;
    private TaskRepository $taskRepo;
    private PlayerRepository $playerRepo;

    public function __construct()
    {
        parent::__construct();
        $this->npcRepo = new NpcRepository();
        $this->taskRepo = new TaskRepository();
        $this->playerRepo = new PlayerRepository();
    }

    public function index()
    {
        $nid = $_GET['nid'] ?? 0;
        $cmd = $_GET['cmd'] ?? '';
        $canshu = $_GET['canshu'] ?? '';
        $sid = $this->sid;
        $dblj = $this->db; // Expose PDO for templates
        $player = $this->player;
        $encode = $this->encoder;
        
        $npc = $this->npcRepo->findById($nid);
        
        if (!$npc) {
            echo "Không tìm thấy NPC.";
            return;
        }
        
        // Task Logic

        $taskHtml = $this->generateTaskHtml($npc, $player);
        
        // Template Logic
        $templateOutput = '';
        $npchtml = ''; // Templates often populate this variable
        $gonowmid = $encode->encode("cmd=gomid&newmid=$player->nowmid&sid=$sid"); // Templates use this
        
        if ($npc->muban) {
            $mubanFile = dirname(__DIR__, 2) . "/npc/muban/{$npc->muban}.php";
            if (file_exists($mubanFile)) {
                ob_start();
                include $mubanFile;
                $templateOutput = ob_get_clean();
                
                // If template set $npchtml, append it
                if (!empty($npchtml)) {
                    $templateOutput .= $npchtml;
                }
            }
        }
        
        $this->render('npc/index', [
            'npc' => $npc,
            'taskHtml' => $taskHtml,
            'templateOutput' => $templateOutput,
            'gonowmid' => $gonowmid
        ]);
    }

    private function generateTaskHtml($npc, $player)
    {
        if (empty($npc->taskid)) return '';
        
        $html = '<div class="npc-tasks">';
        $taskIds = explode(',', $npc->taskid);
        
        foreach ($taskIds as $tid) {
            $task = $this->taskRepo->findById($tid);
            if (!$task) continue;
            
            $playerTask = $this->taskRepo->getPlayerTask($player->sid, $tid);
            $status = $this->determineTaskStatus($task, $playerTask, $npc->id);
            
            // Icon logic
            $icon = '';
            if ($status == 'available') $icon = '<img src="images/wen.gif" />'; // Yellow ?
            if ($status == 'active') $icon = '<img src="images/wen.gif" style="filter: grayscale(100%);" />'; // Grey ?
            if ($status == 'completed') $icon = '<img src="images/tan.gif" />'; // Yellow !
            
            if ($icon) {
                $link = $this->encoder->encode("cmd=task&rwid=$tid&sid={$player->sid}");
                $html .= "<a href='?cmd=$link'>$icon {$task->rwname}</a><br>";
            }
        }
        
        $html .= '</div>';
        return $html;
    }

    private function determineTaskStatus($task, $playerTask, $npcId)
    {
        // 1. Completed (rwzt=3) -> Don't show (unless repeatable?)
        if ($playerTask && $playerTask->rwzt == 3) return 'finished';
        
        // 2. Active (rwzt=1 or 2)
        if ($playerTask) {
            if ($playerTask->rwzt == 2) return 'completed'; // Ready to submit
            return 'active'; // In progress
        }
        
        // 3. Available (Not accepted)
        // Check requirements (Level, Pre-req task)
        // Simplified for now: Always available if not taken
        return 'available';
    }

    public function rename()
    {
        $sid = $this->sid;
        $player = $this->player;
        $canshu = $_GET['canshu'] ?? '';
        $nid = $_GET['nid'] ?? 0;
        
        $message = '';
        
        if ($canshu == 'process') {
            $newName = $_GET['newname'] ?? '';
            $newName = htmlspecialchars($newName);
            
            if ($player->uczb < 200) {
                $message = "Tiên thạch không đủ 200, không thể đổi tên!";
            } elseif (strlen($newName) < 6 || strlen($newName) > 12) {
                $message = "Tên quá dài hoặc quá ngắn (6-12 ký tự)!";
            } else {
                // Deduct currency using SID
                $this->playerRepo->updateCurrency($sid, 'uczb', -200);
                
                // Update name using UID
                $this->playerRepo->updateName($player->uid, $newName);
                
                $message = "Đổi tên thành công: $newName";
                $player->uname = $newName; // Update local object
            }
        }
        
        $this->render('npc/rename', [
            'player' => $player,
            'sid' => $sid,
            'nid' => $nid,
            'message' => $message
        ]);
    }

    public function vipRename()
    {
        $sid = $this->sid;
        $player = $this->player;
        $canshu = $_GET['canshu2'] ?? ''; // Legacy uses canshu2
        
        $message = '';
        
        if ($player->vip < 1) { 
             $message = "Cấp VIP chưa đủ (Yêu cầu VIP 1)!";
             $this->render('npc/rename', [
                'player' => $player,
                'sid' => $sid,
                'nid' => 0,
                'message' => $message
            ]);
            return;
        }

        if ($canshu == 'gm') {
            $newName = $_GET['gaibian'] ?? '';
            $newName = htmlspecialchars($newName);
            
            if ($player->uczb < 200) {
                $message = "Tiên thạch không đủ 200!";
            } elseif (strlen($newName) < 6 || strlen($newName) > 12) {
                $message = "Tên quá dài hoặc quá ngắn (6-12 ký tự)!";
            } else {
                $this->playerRepo->updateCurrency($sid, 'uczb', -200);
                $this->playerRepo->updateName($player->uid, $newName);
                $message = "VIP Đổi tên thành công: $newName";
                $player->uname = $newName;
            }
        }
        
        $this->render('npc/rename', [
            'player' => $player,
            'sid' => $sid,
            'nid' => 0,
            'message' => $message,
            'isVip' => true
        ]);
    }
}
