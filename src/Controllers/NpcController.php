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

    public function interact()
    {
        $nid = $_GET['nid'] ?? 0;
        $sid = $this->sid;
        $canshu = $_GET['canshu'] ?? '';

        $npc = $this->npcRepo->findById($nid);
        if (!$npc) {
            echo "NPC not found";
            return;
        }

        // Check tasks
        $tasks = $this->taskRepo->getNpcTasks($nid, $sid);
        
        // Pass DB connection for legacy templates
        $db = \XXJ\Core\Database::getInstance()->getConnection();
        // Legacy templates expect $dblj
        $dblj = $db;

        $this->render('npc', [
            'npc' => $npc,
            'tasks' => $tasks,
            'canshu' => $canshu,
            'dblj' => $dblj
        ]);
    }
}
