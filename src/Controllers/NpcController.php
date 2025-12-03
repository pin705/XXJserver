<?php

namespace XXJ\Controllers;

use XXJ\Core\Controller;
use XXJ\Repositories\NpcRepository;
use XXJ\Repositories\TaskRepository;

class NpcController extends Controller
{
    private NpcRepository $npcRepo;
    private TaskRepository $taskRepo;

    public function __construct()
    {
        parent::__construct();
        $this->npcRepo = new NpcRepository();
        $this->taskRepo = new TaskRepository();
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
            echo "NPC not found.";
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

}
