<?php

namespace XXJ\Controllers;

use XXJ\Core\Controller;
use XXJ\Repositories\GameConfigRepository;
use XXJ\Repositories\ChatRepository;

class AuthController extends Controller
{
    private GameConfigRepository $configRepo;
    private ChatRepository $chatRepo;

    public function __construct()
    {
        parent::__construct();
        $this->configRepo = new GameConfigRepository();
        $this->chatRepo = new ChatRepository();
    }

    public function showCreatePlayer()
    {
        $token = $_GET['token'] ?? '';
        $tishi = $_GET['tishi'] ?? '';
        $this->render('game/cj', ['token' => $token, 'tishi' => $tishi]);
    }

    public function createPlayer()
    {
        $token = $_GET['token'] ?? '';
        $username = $_POST['username'] ?? ($_GET['username'] ?? '');
        $sex = $_POST['sex'] ?? ($_GET['sex'] ?? '');
        $shenfen = $_POST['shenfen'] ?? ($_GET['shenfen'] ?? '');

        if (empty($token) || empty($username) || empty($sex)) {
            $this->redirect('cj', ['token' => $token, 'tishi' => 'Thiếu thông tin']);
            return;
        }

        // Check duplicate name (This should ideally be in Repo too, but keeping it simple for now or moving to Repo)
        // Let's use a quick check via Repo if possible, or just add a method.
        // Actually, let's add checkNameExists to PlayerRepo.
        if ($this->playerRepo->checkNameExists($username)) {
             $this->redirect('cj', ['token' => $token, 'tishi' => "Người chơi:【{$username}】Đã tồn tại"]);
             return;
        }

        // Check name length
        $len = strlen($username);
        if ($len < 6 || $len > 12) {
            $this->showCreatePlayer(['token' => $token, 'tishi' => "Người sử dụng tên không thể quá ngắn hoặc là quá dài<br><br>"]);
            return;
        }

        $username = htmlspecialchars($username);
        $sid = md5($username . $token . '229');

        // Check if token already has a player
        $existingPlayer = $this->playerRepo->findByToken($token);
        if (!$existingPlayer) {
            $config = $this->configRepo->getConfig();
            $firstmid = $config->firstmid;
            $nowdate = date('Y-m-d H:i:s');

            $this->playerRepo->create([
                'token' => $token,
                'sid' => $sid,
                'uname' => $username,
                'sex' => $sex,
                'nowmid' => $firstmid,
                'endtime' => $nowdate,
                'shenfen' => $shenfen
            ]);

            // Global chat announcement
            $this->chatRepo->addMessage('0', '【Hệ thống】', "Vạn người không được một{$username}Bước lên tiên đồ");

            $gonowmid = $this->encoder->encode("cmd=gomid&newmid=$firstmid&sid=$sid");
            
            echo '<meta charset="utf-8" content="width=device-width,user-scalable=no" name="viewport">';
            echo $username . "<font color=#8EBE67>Hoan</font><font color=#9FB85B>Nghênh</font><font color=#B0B24F>Đến</font><font color=#C1AC43>Đến</font><font color=#D2A637>Tìm</font><font color=#E3A02B>Tiên</font><font color=#F49A1F>Kỷ, now loading……</font>";
            
            header("refresh:2;url=?cmd=$gonowmid");
            exit();
        }
        exit();
    }
    
    public function login($params) {
        $sid = $params['sid'];
        $player = $this->playerRepo->findBySid($sid);
        if ($player) {
             $gonowmid = $this->encoder->encode("cmd=gomid&newmid=$player->nowmid&sid=$sid");
             $nowdate = date('Y-m-d H:i:s');
             $this->playerRepo->updateLoginStatus($sid, $nowdate);
             header("refresh:1;url=?cmd=$gonowmid");
             exit();
        }
    }
}
