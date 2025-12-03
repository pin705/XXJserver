<?php

namespace XXJ\Controllers;

use XXJ\Core\View;
use XXJ\Utils\Encoder;
use XXJ\Repositories\PlayerRepository;
use XXJ\Repositories\TaskRepository;
use XXJ\Core\Database;

class TaskController
{
    private PlayerRepository $playerRepo;
    private TaskRepository $taskRepo;
    private Encoder $encoder;

    public function __construct()
    {
        $this->playerRepo = new PlayerRepository();
        $this->taskRepo = new TaskRepository();
        $this->encoder = new Encoder();
    }

    public function showTask($params)
    {
        $sid = $params['sid'];
        $rwid = $params['rwid'];
        $nid = $params['nid'] ?? 0;
        
        $player = $this->playerRepo->findBySid($sid);
        $task = $this->taskRepo->findById($rwid);
        $playerTask = $this->taskRepo->getPlayerTask($sid, $rwid);

        $message = '';

        if (isset($params['canshu'])) {
            if ($params['canshu'] == 'jieshou') {
                if ($playerTask) {
                    $message = 'Xin đừng nên lặp lại xác nhận nhiệm vụ';
                } else {
                    $this->taskRepo->acceptTask($sid, $task);
                    $message = 'Tiếp nhận thành công';
                    $playerTask = $this->taskRepo->getPlayerTask($sid, $rwid); // Refresh
                }
            } elseif ($params['canshu'] == 'tijiao') {
                // Submit logic (simplified)
                if ($playerTask && $playerTask->rwzt == 2) { // Assuming 2 is completed
                     $this->taskRepo->updateTaskStatus($sid, $rwid, 3); // 3 is finished
                     $message = 'Nhiệm vụ hoàn thành!';
                     // Give rewards logic here
                } else {
                    $message = 'Nhiệm vụ chưa hoàn thành';
                }
            }
        }

        View::render('task', [
            'player' => $player,
            'task' => $task,
            'playerTask' => $playerTask,
            'message' => $message,
            'encoder' => $this->encoder,
            'sid' => $sid,
            'nid' => $nid
        ]);
    }
}
