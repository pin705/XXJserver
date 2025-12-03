<?php

namespace XXJ\Controllers;

use XXJ\Core\Controller;
use XXJ\Repositories\PetRepository;
use XXJ\Repositories\PlayerRepository;

class PetController extends Controller
{
    private PetRepository $petRepo;
    private PlayerRepository $playerRepo;

    public function __construct()
    {
        parent::__construct();
        $this->petRepo = new PetRepository();
        $this->playerRepo = new PlayerRepository();
    }

    public function index()
    {
        $action = $_GET['action'] ?? 'index';
        
        switch ($action) {
            case 'draw':
                $this->draw();
                break;
            case 'deploy':
                $this->deploy();
                break;
            case 'recall':
                $this->recall();
                break;
            case 'release':
                $this->release();
                break;
            case 'info':
                $this->info();
                break;
            case 'rename':
                $this->rename();
                break;
            default:
                $this->listPets();
                break;
        }
    }

    private function listPets()
    {
        $sid = $this->player->sid;
        $pets = $this->petRepo->findBySid($sid);
        $currentPetId = $this->player->cw;
        
        $popup = null;
        if (isset($_GET['result'])) {
            if ($_GET['result'] === 'success') {
                $popup = 'success';
            } elseif ($_GET['result'] === 'fail') {
                $popup = 'fail';
            }
        }

        $this->render('chongwu', [
            'pets' => $pets,
            'currentPetId' => $currentPetId,
            'popup' => $popup,
            'player' => $this->player
        ]);
    }

    public function draw()
    {
        $sid = $this->player->sid;
        
        // Check currency (50 Ma thạch - uczb)
        // Note: Legacy code uses changeczb(2, 50, ...) which deducts 50 uczb.
        // uczb is Premium Currency? Let's check player.php
        // Yes, changeczb affects uczb.
        
        if ($this->player->uczb >= 50) {
            // Deduct currency
            $this->playerRepo->updateCurrency($sid, 'uczb', -50);
            
            // Create pet
            $this->petRepo->create($sid);
            
            $this->redirect('chongwu', ['result' => 'success']);
        } else {
            $this->redirect('chongwu', ['result' => 'fail']);
        }
    }

    public function deploy()
    {
        $cwid = $_GET['cwid'] ?? 0;
        $sid = $this->player->sid;
        
        if ($cwid) {
            $this->petRepo->deploy($sid, $cwid);
        }
        
        $this->redirect('chongwu');
    }

    public function recall()
    {
        $sid = $this->player->sid;
        $this->petRepo->recall($sid);
        $this->redirect('chongwu');
    }

    public function release()
    {
        $cwid = $_GET['cwid'] ?? 0;
        $sid = $this->player->sid;
        
        if ($cwid) {
            // If deployed, recall first
            if ($this->player->cw == $cwid) {
                $this->petRepo->recall($sid);
            }
            $this->petRepo->delete($cwid, $sid);
        }
        
        $this->redirect('chongwu');
    }
    
    public function info()
    {
        $cwid = $_GET['cwid'] ?? 0;
        $pet = $this->petRepo->findById($cwid);
        
        if (!$pet || $pet->sid != $this->player->sid) {
            $this->redirect('chongwu');
            return;
        }
        
        $this->render('chongwu_info', [
            'pet' => $pet,
            'player' => $this->player
        ]);
    }
    
    public function rename()
    {
        $cwid = $_GET['cwid'] ?? 0;
        $newName = $_POST['newname'] ?? '';
        $sid = $this->player->sid;
        
        if ($cwid && $newName) {
            // Basic validation
            $newName = trim($newName);
            if (strlen($newName) > 0 && strlen($newName) <= 20) {
                $this->petRepo->updateName($cwid, $sid, $newName);
            }
        }
        
        $this->redirect('chongwu_info', ['cwid' => $cwid]);
    }
}
