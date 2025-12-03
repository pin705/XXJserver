<?php

namespace XXJ\Controllers;

use XXJ\Core\Controller;
use XXJ\Repositories\PlayerRepository;
use XXJ\Repositories\TaskRepository;
use XXJ\Repositories\ItemRepository;

class TaskController extends Controller
{
    private PlayerRepository $playerRepo;
    private TaskRepository $taskRepo;
    private ItemRepository $itemRepo;

    public function __construct()
    {
        parent::__construct();
        $this->playerRepo = new PlayerRepository();
        $this->taskRepo = new TaskRepository();
        $this->itemRepo = new ItemRepository();
    }

    public function index()
    {
        $sid = $this->player->sid;
        $tasks = $this->taskRepo->getPlayerTasks($sid);
        
        $this->render('task/list', [
            'tasks' => $tasks,
            'player' => $this->player
        ]);
    }

    public function myTasks()
    {
        $this->index();
    }

    public function taskInfo()
    {
        $sid = $this->player->sid;
        $rwid = $_GET['rwid'] ?? 0;
        
        $playerTask = $this->taskRepo->getPlayerTask($sid, $rwid);
        if (!$playerTask) {
            $this->redirect('task');
            return;
        }
        
        $task = $this->taskRepo->findById($rwid);
        
        // Resolve names for requirements
        $targetName = '';
        if ($task->rwzl == 1) { // Collect
            $item = $this->itemRepo->getItemTemplate($task->rwyq);
            $targetName = $item ? $item->djname : 'Vật phẩm';
        } elseif ($task->rwzl == 2) { // Kill
            // Need MonsterRepository? Or just query
            // Legacy uses getyguaiwu
            // I'll assume I can get name from DB or just show ID for now if Repo missing
            // Let's use a quick query or add MonsterRepo later.
            // For now, let's try to get it via direct DB query in Controller or Repo?
            // Better to add getMonsterName to TaskRepo or similar.
            // I'll skip name resolution for now or use a placeholder.
            $targetName = "Quái vật ($task->rwyq)";
        } elseif ($task->rwzl == 3) { // Talk
            // NPC Name
             $targetName = "NPC ($task->rwcount)";
        }

        $this->render('task/my_info', [
            'playerTask' => $playerTask,
            'task' => $task,
            'targetName' => $targetName,
            'player' => $this->player
        ]);
    }
    
    public function npcTask()
    {
        // This replaces the legacy game/task.php view when clicking a task on NPC
        $sid = $this->player->sid;
        $rwid = $_GET['rwid'] ?? 0;
        $nid = $_GET['nid'] ?? 0;
        
        $task = $this->taskRepo->findById($rwid);
        if (!$task) {
            echo "Nhiệm vụ không tồn tại.";
            return;
        }
        
        $playerTask = $this->taskRepo->getPlayerTask($sid, $rwid);
        
        $message = '';
        $action = $_GET['canshu'] ?? '';
        
        if ($action == 'jieshou') {
            if ($playerTask) {
                $message = 'Bạn đã nhận nhiệm vụ này rồi.';
            } else {
                if ($this->taskRepo->acceptTask($sid, $task)) {
                    $message = 'Tiếp nhận thành công!';
                    $playerTask = $this->taskRepo->getPlayerTask($sid, $rwid);
                } else {
                    $message = 'Không thể tiếp nhận nhiệm vụ.';
                }
            }
        } elseif ($action == 'tijiao') {
            $result = $this->taskRepo->submitTask($sid, $rwid);
            $message = $result;
            $playerTask = $this->taskRepo->getPlayerTask($sid, $rwid); // Refresh state
        }
        
        // Resolve rewards names
        $rewards = [];
        if ($task->rwdj) {
            $items = explode(',', $task->rwdj);
            foreach ($items as $itemStr) {
                $parts = explode('|', $itemStr);
                if (count($parts) == 2) {
                    $item = $this->itemRepo->getItemTemplate($parts[0]);
                    if ($item) $rewards[] = "{$item->djname} x{$parts[1]}";
                }
            }
        }
        if ($task->rwyp) {
            $potions = explode(',', $task->rwyp);
            foreach ($potions as $pStr) {
                $parts = explode('|', $pStr);
                if (count($parts) == 2) {
                    $potion = $this->itemRepo->getPotionTemplate($parts[0]);
                    if ($potion) $rewards[] = "{$potion->ypname} x{$parts[1]}";
                }
            }
        }
        if ($task->rwzb) {
            $zbs = explode(',', $task->rwzb);
            foreach ($zbs as $zbid) {
                $zb = $this->itemRepo->getEquipmentTemplate($zbid);
                if ($zb) $rewards[] = $zb->zbname;
            }
        }
        if ($task->rwexp) $rewards[] = "Kinh nghiệm: {$task->rwexp}";
        if ($task->rwyxb) $rewards[] = "Linh thạch: {$task->rwyxb}";

        $this->render('task/npc_view', [
            'task' => $task,
            'playerTask' => $playerTask,
            'message' => $message,
            'rewards' => $rewards,
            'nid' => $nid,
            'player' => $this->player
        ]);
    }
    
    public function teleport()
    {
        $sid = $this->player->sid;
        $rwid = $_GET['rwid'] ?? 0;
        $task = $this->taskRepo->findById($rwid);
        
        if ($task && $task->rwqy) {
            $cost = round($this->player->ulv * 12 + 500);
            if ($this->player->uyxb >= $cost) {
                $this->playerRepo->updateCurrency($sid, 'uyxb', -$cost);
                $this->playerRepo->updateMap($sid, $task->rwqy);
                $this->redirect('gomid', ['newmid' => $task->rwqy]); // Redirect to map logic
            } else {
                // Error: Not enough money
                $this->redirect('mytaskinfo', ['rwid' => $rwid, 'error' => 'not_enough_money']);
            }
        } else {
            $this->redirect('task');
        }
    }
}
