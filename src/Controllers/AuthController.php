<?php

namespace XXJ\Controllers;

use XXJ\Core\View;
use XXJ\Utils\Encoder;
use XXJ\Repositories\PlayerRepository;
use XXJ\Repositories\GameConfigRepository;
use XXJ\Core\Database;

class AuthController
{
    private PlayerRepository $playerRepo;
    private GameConfigRepository $configRepo;
    private Encoder $encoder;
    private $db;

    public function __construct()
    {
        $this->playerRepo = new PlayerRepository();
        $this->configRepo = new GameConfigRepository();
        $this->encoder = new Encoder();
        $this->db = Database::getInstance()->getConnection();
    }

    public function showCreatePlayer($params)
    {
        $token = $params['token'] ?? '';
        $tishi = $params['tishi'] ?? '';
        View::render('cj', ['token' => $token, 'tishi' => $tishi]);
    }

    public function createPlayer($params)
    {
        $token = $params['token'] ?? '';
        $username = $params['username'] ?? '';
        $sex = $params['sex'] ?? '';
        $shenfen = $params['shenfen'] ?? '';

        if (empty($token) || empty($username) || empty($sex)) {
            $this->showCreatePlayer(['token' => $token, 'tishi' => 'Thiếu thông tin<br>']);
            return;
        }

        // Check duplicate name
        $stmt = $this->db->prepare("SELECT uname FROM game1 WHERE uname = ?");
        $stmt->execute([$username]);
        if ($stmt->fetch()) {
            $this->showCreatePlayer(['token' => $token, 'tishi' => "Người chơi:【{$username}】Đã tồn tại<br><br>"]);
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

            $sql = "INSERT INTO game1(token, sid, uname, ulv, uyxb, uczb, uexp, uhp, umaxhp, ugj, ufy, uwx, usex, vip, nowmid, endtime, sfzx, shenfen) 
                    VALUES (?, ?, ?, '1', '2000', '100', '0', '35', '35', '12', '5', '0', ?, '0', ?, ?, ?, ?)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$token, $sid, $username, $sex, $firstmid, $nowdate, $shenfen, $shenfen]);

            // Global chat announcement
            $sqlChat = "INSERT INTO ggliaotian(name, msg, uid) VALUES (?, ?, '0')";
            $stmtChat = $this->db->prepare($sqlChat);
            $stmtChat->execute(['【Hệ thống】', "Vạn người không được một{$username}Bước lên tiên đồ"]);

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
             $stmt = $this->db->prepare("UPDATE game1 SET endtime=?, sfzx=1 WHERE sid=?");
             $stmt->execute([$nowdate, $sid]);
             header("refresh:1;url=?cmd=$gonowmid");
             exit();
        }
    }
}
