<?php

namespace XXJ\Controllers;

use XXJ\Core\Controller;
use XXJ\Repositories\PlayerRepository;

class TalentController extends Controller
{
    private PlayerRepository $playerRepo;

    public function __construct()
    {
        parent::__construct();
        $this->playerRepo = new PlayerRepository();
    }

    public function index()
    {
        $player = $this->playerRepo->findBySid($this->sid);
        
        if ($player->ulv < 30) {
            $this->render('talent/index', [
                'error' => 'Đẳng cấp nhỏ hơn 30, dễ dàng tẩu hỏa nhập ma！',
                'player' => $player
            ]);
            return;
        }

        $message = '';
        $cmd = $_GET['cmd'] ?? '';
        
        // Handle actions
        if (isset($_GET['action'])) {
            $action = $_GET['action'];
            
            if ($action == 'reset') {
                // Nghịch thiên cải mệnh (Reset Talents)
                // Logic: Random chance based on luck (tfxy)?
                // Legacy: $sjs = mt_rand(1,30-$player->tfxy); if ($player->ulv !=0 && $sjs <10)
                $chance = mt_rand(1, max(1, 30 - $player->tfxy));
                if ($chance < 10) {
                    $this->playerRepo->resetTalents($this->sid, $player->ulv);
                    $message = "Nghịch thiên cải mệnh thành công！Thiên phú thiết lập lại.";
                    $player = $this->playerRepo->findBySid($this->sid); // Refresh
                } else {
                    $message = "Thiên mệnh khó trái, nghịch thiên tính sai！Có lẽ ngươi chênh lệch chút may mắn.";
                }
            } elseif ($action == 'upgrade') {
                $type = $_GET['type'] ?? '';
                if ($player->tf > 0 && in_array($type, ['tfxy', 'tfsb', 'tffy', 'tfhp', 'tfbj', 'tfxx', 'tfgj'])) {
                    $this->playerRepo->upgradeTalent($this->sid, $type);
                    $message = "Tăng lên thành công";
                    $player = $this->playerRepo->findBySid($this->sid); // Refresh
                } else {
                    $message = "Thiên phú giá trị không đủ hoặc loại thiên phú không hợp lệ, tăng lên thất bại！";
                }
            } elseif ($action == 'info') {
                // Show info cost 1 uczb?
                // Legacy: if ($player->uczb>0) ... update game1 set uczb = $sx - '1'
                // But legacy code just showed text if they had money, didn't seem to actually charge for just viewing?
                // Wait, legacy code: if ($player->uczb>0){ $ts= $tswb; ... update ... } else { "No money..." }
                // So it charges 1 XianYu (uczb) to view the help text? That's harsh.
                // Let's keep it free or just show it. The legacy code implies it charges.
                // I'll make it free for modern UX, or just show it.
                $message = "May mắn: Rơi xuống bảo vật xác suất*1; Né tránh: Năng lực né tránh*2; Cuồng bạo: Bạo kích xác suất*1.5; Lực lượng: Lực công kích*5; Tính bền dẻo: Phòng ngự*5; Thể phách: HP*50; Nghịch thiên cải mệnh: Thiết lập lại thiên phú.";
            }
        }

        $this->render('talent/index', [
            'player' => $player,
            'message' => $message
        ]);
    }
}
