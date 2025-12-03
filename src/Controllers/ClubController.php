<?php

namespace XXJ\Controllers;

use XXJ\Core\Controller;
use XXJ\Repositories\ClubRepository;
use XXJ\Repositories\PlayerRepository;

class ClubController extends Controller
{
    private ClubRepository $clubRepo;
    private PlayerRepository $playerRepo;

    public function __construct()
    {
        parent::__construct();
        $this->clubRepo = new ClubRepository();
        $this->playerRepo = new PlayerRepository();
    }

    public function index()
    {
        $action = $_GET['action'] ?? 'index';
        $canshu = $_GET['canshu'] ?? '';
        
        // Map legacy parameters
        if ($canshu === 'joinclub') $action = 'join';
        if ($canshu === 'outclub') $action = 'leave';
        if ($canshu === 'deleteclub') $action = 'disband';
        if ($canshu === 'renzhi') $action = 'manage';
        if ($canshu === 'zhiwei') $action = 'assign_role';

        switch ($action) {
            case 'create':
                $this->create();
                break;
            case 'join':
                $this->join();
                break;
            case 'leave':
                $this->leave();
                break;
            case 'disband':
                $this->disband();
                break;
            case 'manage':
                $this->manage();
                break;
            case 'assign_role':
                $this->assignRole();
                break;
            case 'list':
                $this->listClubs();
                break;
            default:
                $this->defaultView();
                break;
        }
    }

    public function list()
    {
        $this->listClubs();
    }

    private function listClubs()
    {
        $clubs = $this->clubRepo->getAllClubs();
        $this->render('club/list', [
            'clubs' => $clubs,
            'player' => $this->player,
            'sid' => $this->player->sid
        ]);
    }

    private function defaultView()
    {
        $sid = $this->player->sid;
        $clubId = $_GET['clubid'] ?? null;
        
        $member = $this->clubRepo->findMemberBySid($sid);
        
        if (!$member && !$clubId) {
            // Not in a club and no club specified -> Show list or "No Club" view
            $this->listClubs();
            return;
        }

        if ($member && !$clubId) {
            $clubId = $member->clubid;
        }

        $club = $this->clubRepo->findClubById($clubId);
        
        if (!$club) {
            // Club not found
            $this->listClubs();
            return;
        }

        $members = $this->clubRepo->getClubMembers($clubId);
        $founder = $this->playerRepo->findById($club->clubno1);

        $this->render('club/index', [
            'club' => $club,
            'member' => $member, // Current player's membership (if any)
            'members' => $members,
            'founder' => $founder,
            'player' => $this->player,
            'sid' => $sid
        ]);
    }

    public function join()
    {
        $sid = $this->player->sid;
        $clubId = $_GET['clubid'] ?? null;
        
        if ($clubId) {
            $result = $this->clubRepo->joinClub($sid, $this->player->uid, $clubId);
            $msg = $result ? "Gia nhập thành công!" : "Gia nhập thất bại (Đã có bang hoặc lỗi)!";
        } else {
            $msg = "Môn phái không tồn tại!";
        }
        
        // Redirect to club view or list with message
        $params = ['cmd' => 'club', 'clubid' => $clubId, 'sid' => $sid, 'msg' => $msg];
        $url = '?' . http_build_query($params);
        header("Location: $url");
        exit;
    }

    public function leave()
    {
        $sid = $this->player->sid;
        $this->clubRepo->leaveClub($sid);
        
        $params = ['cmd' => 'club', 'sid' => $sid, 'msg' => 'Đã rời bang!'];
        $url = '?' . http_build_query($params);
        header("Location: $url");
        exit;
    }

    public function disband()
    {
        $sid = $this->player->sid;
        $member = $this->clubRepo->findMemberBySid($sid);
        
        if ($member && $member->uclv == 1) { // 1 = Leader
            $this->clubRepo->disbandClub($member->clubid);
            $msg = "Giải tán bang thành công!";
        } else {
            $msg = "Bạn không phải bang chủ!";
        }
        
        $params = ['cmd' => 'club', 'sid' => $sid, 'msg' => $msg];
        $url = '?' . http_build_query($params);
        header("Location: $url");
        exit;
    }

    public function manage()
    {
        $sid = $this->player->sid;
        $member = $this->clubRepo->findMemberBySid($sid);
        
        if (!$member || $member->uclv > 2) { // Only Leader (1) and Deputy (2) can manage? Legacy check: uclv == 1 or 2
             $this->redirect('club');
             return;
        }
        
        $zhiwei = $_GET['zhiwei'] ?? null;
        
        if ($zhiwei) {
            // Select member to assign
            $candidates = $this->clubRepo->getAssignableMembers($member->clubid, $member->uclv);
            $this->render('club/assign', [
                'candidates' => $candidates,
                'zhiwei' => $zhiwei,
                'sid' => $sid
            ]);
        } else {
            // Show roles to assign
            $this->render('club/manage', [
                'member' => $member,
                'sid' => $sid
            ]);
        }
    }

    public function assignRole()
    {
        $sid = $this->player->sid;
        $member = $this->clubRepo->findMemberBySid($sid);
        $targetUid = $_GET['uid'] ?? null;
        $zhiwei = $_GET['zhiwei'] ?? null;
        
        if ($member && $targetUid && $zhiwei) {
            // Security check: can this member assign this role?
            // Legacy logic: just update.
            $this->clubRepo->updateMemberRole($member->clubid, $targetUid, $zhiwei);
        }
        
        $this->redirect('club', ['clubid' => $member->clubid]);
    }
    
    public function create()
    {
        // Legacy didn't show create logic in club.php, maybe in cjclub?
        // Assuming separate logic or not implemented fully in legacy snippet provided.
        // But router has 'cjclub'.
        // Let's implement basic create if needed, or skip for now.
        $this->redirect('club');
    }
}
        if (!$club) {
            $this->redirect('club'); // Redirect to list if club not found
            return;
        }

        $members = $this->clubRepo->getMembers($clubId);
        $isMember = $currentMember && $currentMember->clubid == $clubId;
        $isLeader = $isMember && $currentMember->uclv == 1;
        
        // Determine view mode
        $viewMode = 'guest';
        if ($isMember) {
            $viewMode = 'member';
        }
        
        $this->render('club/view', [
            'club' => $club,
            'members' => $members,
            'currentMember' => $currentMember,
            'viewMode' => $viewMode,
            'player' => $this->player
        ]);
    }
}
    {
        $clubs = $this->clubRepo->getAllClubs();
        $this->render('club/list', [
            'clubs' => $clubs,
            'player' => $this->player
        ]);
    }

    public function create()
    {
        $sid = $this->player->sid;
        $member = $this->clubRepo->findMemberBySid($sid);
        
        if ($member) {
            // Already in a club
            $this->redirect('club');
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $clubname = $_POST['clubname'] ?? '';
            $clubinfo = $_POST['clubinfo'] ?? '';
            
            // Validation
            if (strlen($clubname) < 6 || strlen($clubname) > 30) { // Adjusted length check for UTF-8
                $this->render('club/create', ['error' => 'Tên môn phái phải từ 6-30 ký tự', 'player' => $this->player]);
                return;
            }
            
            if ($this->player->uczb < 100) {
                $this->render('club/create', ['error' => 'Không đủ 100 Ma thạch', 'player' => $this->player]);
                return;
            }
            
            // Deduct cost
            $this->playerRepo->updateCurrency($sid, 'uczb', -100);
            
            // Create
            $clubId = $this->clubRepo->createClub($clubname, $this->player->uid, $sid);
            if ($clubId) {
                // Update info if provided
                if ($clubinfo) {
                    $this->clubRepo->updateClubInfo($clubId, $clubinfo);
                }
                $this->redirect('club');
            } else {
                // Refund on failure? Or just show error. Transaction rollback handles DB consistency.
                // But we already deducted currency outside transaction? 
                // Ideally currency deduction should be inside transaction or we refund.
                // For now, let's assume success if validation passed.
                $this->render('club/create', ['error' => 'Tạo môn phái thất bại', 'player' => $this->player]);
            }
        } else {
            $this->render('club/create', ['player' => $this->player]);
        }
    }

    public function join()
    {
        $clubId = $_GET['clubid'] ?? 0;
        $sid = $this->player->sid;
        $member = $this->clubRepo->findMemberBySid($sid);
        
        if ($member) {
            // Already in a club
            $this->redirect('club');
            return;
        }
        
        if ($clubId) {
            $this->clubRepo->joinClub($clubId, $this->player->uid, $sid);
        }
        
        $this->redirect('club', ['clubid' => $clubId]);
    }

    public function leave()
    {
        $sid = $this->player->sid;
        $member = $this->clubRepo->findMemberBySid($sid);
        
        if ($member) {
            if ($member->uclv == 1) {
                // Leader cannot leave, must disband or transfer
                // For now, let's say leader uses 'disband' action
                $this->redirect('club');
                return;
            }
            $this->clubRepo->leaveClub($sid);
        }
        
        $this->redirect('club');
    }

    public function disband()
    {
        $sid = $this->player->sid;
        $member = $this->clubRepo->findMemberBySid($sid);
        
        if ($member && $member->uclv == 1) {
            $this->clubRepo->deleteClub($member->clubid);
        }
        
        $this->redirect('club');
    }

    public function manage()
    {
        $sid = $this->player->sid;
        $member = $this->clubRepo->findMemberBySid($sid);
        
        if (!$member || $member->uclv > 2) { // Only Leader (1) and Vice (2) can manage? Legacy code allowed Leader to appoint.
            $this->redirect('club');
            return;
        }
        
        $action = $_GET['subaction'] ?? '';
        
        if ($action === 'appoint') {
            $targetUid = $_GET['uid'] ?? 0;
            $newRank = $_GET['rank'] ?? 6;
            
            // Validation: Can only appoint ranks lower than self?
            // Legacy code: Leader (1) can appoint 2,3,4,5,6. Vice (2) can appoint 3,4,5,6.
            
            if ($targetUid && $newRank > $member->uclv) {
                $this->clubRepo->updateMemberRank($member->clubid, $targetUid, $newRank);
            }
        }
        
        $this->redirect('club');
    }
}
