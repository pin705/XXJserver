<?php
/**
 * File ví dụ sử dụng code refactored
 * 
 * File này minh họa cách sử dụng các class và function mới
 * 
 * @package TuTaTuTien\Examples
 */

// Cách 1: Sử dụng trực tiếp code mới
require_once __DIR__ . '/src/Classes/NguoiChoi.php';
require_once __DIR__ . '/src/Classes/QuaiVat.php';
require_once __DIR__ . '/src/Classes/TrangBi.php';
require_once __DIR__ . '/src/Helpers/NguoiChoiHelper.php';
require_once __DIR__ . '/config/CauHinhGame.php';

use TuTaTuTien\Classes\NguoiChoi;
use TuTaTuTien\Classes\QuaiVat;
use TuTaTuTien\Classes\TrangBi;
use TuTaTuTien\Config\CauHinhGame;
use TuTaTuTien\Helpers;

// --- VÍ DỤ 1: Lấy thông tin người chơi ---
function viDu1LayThongTinNguoiChoi($sid, $pdo)
{
    echo "=== VÍ DỤ 1: Lấy thông tin người chơi ===\n";
    
    $nguoiChoi = Helpers\layThongTinNguoiChoi($sid, $pdo);
    
    if ($nguoiChoi) {
        echo "Tên nhân vật: " . $nguoiChoi->tenNhanVat . "\n";
        echo "Cấp độ: " . $nguoiChoi->capDo . "\n";
        echo "Cảnh giới: " . $nguoiChoi->layTenCanhGioiDayDu() . "\n";
        echo "Sinh mệnh: " . $nguoiChoi->sinhMenh . "/" . $nguoiChoi->sinhMenhToiDa . "\n";
        echo "Công kích: " . $nguoiChoi->tinhTongCongKich() . "\n";
        echo "Phòng ngự: " . $nguoiChoi->tinhTongPhongNgu() . "\n";
        
        if ($nguoiChoi->coTheLenCap()) {
            echo "✓ Có thể lên cấp!\n";
        } else {
            echo "Cần thêm " . ($nguoiChoi->kinhNghiemToiDa - $nguoiChoi->kinhNghiem) . " kinh nghiệm\n";
        }
    }
    
    echo "\n";
}

// --- VÍ DỤ 2: Thêm kinh nghiệm và tự động lên cấp ---
function viDu2ThemKinhNghiem($sid, $pdo)
{
    echo "=== VÍ DỤ 2: Thêm kinh nghiệm ===\n";
    
    $nguoiChoi = Helpers\layThongTinNguoiChoi($sid, $pdo);
    echo "Kinh nghiệm trước: " . $nguoiChoi->kinhNghiem . "/" . $nguoiChoi->kinhNghiemToiDa . "\n";
    
    // Thêm 1000 kinh nghiệm
    $ketQua = Helpers\themKinhNghiem($sid, 1000, $pdo);
    
    if ($ketQua) {
        echo "✓ Đã thêm 1000 kinh nghiệm\n";
        
        $nguoiChoi = Helpers\layThongTinNguoiChoi($sid, $pdo);
        echo "Kinh nghiệm sau: " . $nguoiChoi->kinhNghiem . "/" . $nguoiChoi->kinhNghiemToiDa . "\n";
        
        if ($nguoiChoi->capDo > 1) {
            echo "✓ Đã tự động lên cấp!\n";
        }
    }
    
    echo "\n";
}

// --- VÍ DỤ 3: Chiến đấu với quái vật ---
function viDu3ChienDau($sid, $pdo)
{
    echo "=== VÍ DỤ 3: Chiến đấu với quái vật ===\n";
    
    $nguoiChoi = Helpers\layThongTinNguoiChoi($sid, $pdo);
    
    // Tạo một quái vật mẫu
    $quaiVat = new QuaiVat();
    $quaiVat->tenQuai = "Yêu Hổ";
    $quaiVat->capDo = 5;
    $quaiVat->sinhMenh = 500;
    $quaiVat->sinhMenhToiDa = 500;
    $quaiVat->congKich = 50;
    $quaiVat->phongNgu = 20;
    $quaiVat->baoKich = 10;
    $quaiVat->canhGioi = "Luyện Khí Một Giai";
    
    echo "Gặp " . $quaiVat->layTenDayDu() . "\n";
    echo "Sinh mệnh quái: " . $quaiVat->sinhMenh . "/" . $quaiVat->sinhMenhToiDa . "\n";
    
    $vongDau = 1;
    while ($nguoiChoi->conSong() && $quaiVat->conSong() && $vongDau <= 10) {
        echo "\n--- Vòng $vongDau ---\n";
        
        // Người chơi tấn công
        $satThuongNguoiChoi = rand($nguoiChoi->congKich - 10, $nguoiChoi->congKich + 10);
        $satThuongThucTe = $quaiVat->nhanSatThuong($satThuongNguoiChoi);
        echo "Bạn gây " . $satThuongThucTe . " sát thương\n";
        echo "Sinh mệnh quái: " . $quaiVat->sinhMenh . "/" . $quaiVat->sinhMenhToiDa . "\n";
        
        if (!$quaiVat->conSong()) {
            echo "\n✓ Đã tiêu diệt " . $quaiVat->tenQuai . "!\n";
            break;
        }
        
        // Quái vật phản công
        $satThuongQuai = $quaiVat->tanCong($nguoiChoi);
        echo $quaiVat->tenQuai . " gây " . $satThuongQuai . " sát thương\n";
        
        $vongDau++;
    }
    
    echo "\n";
}

// --- VÍ DỤ 4: Quản lý trang bị ---
function viDu4TrangBi()
{
    echo "=== VÍ DỤ 4: Quản lý trang bị ===\n";
    
    $trangBi = new TrangBi();
    $trangBi->tenTrangBi = "Kiếm Trường Huyền Thiết";
    $trangBi->congKich = 50;
    $trangBi->phongNgu = 10;
    $trangBi->baoKich = 5;
    $trangBi->sinhMenh = 100;
    $trangBi->capCuongHoa = 0;
    $trangBi->phamChat = 'tim';
    $trangBi->capDoYeuCau = 10;
    
    echo "Trang bị: " . $trangBi->layTenDayDu() . "\n";
    echo "Màu sắc: " . $trangBi->layMauPhamChat() . "\n";
    echo "Công kích: " . $trangBi->tinhTongCongKich() . "\n";
    echo "Phòng ngự: " . $trangBi->tinhTongPhongNgu() . "\n";
    
    // Thử cường hóa
    echo "\nThử cường hóa...\n";
    for ($i = 0; $i < 5; $i++) {
        if ($trangBi->coTheCuongHoa()) {
            $tyLe = $trangBi->tinhTyLeCuongHoa();
            echo "Lần " . ($i + 1) . " (Tỷ lệ: $tyLe%): ";
            
            if ($trangBi->cuongHoa()) {
                echo "✓ Thành công! Cấp cường hóa: " . $trangBi->capCuongHoa . "\n";
                echo "Tên mới: " . $trangBi->layTenDayDu() . "\n";
                echo "Công kích mới: " . $trangBi->tinhTongCongKich() . "\n";
            } else {
                echo "✗ Thất bại\n";
            }
        }
    }
    
    echo "\n";
}

// --- VÍ DỤ 5: Sử dụng hằng số cấu hình ---
function viDu5CauHinhGame()
{
    echo "=== VÍ DỤ 5: Sử dụng hằng số cấu hình ===\n";
    
    echo "Cấp độ tối đa: " . CauHinhGame::CAP_DO_TOI_DA . "\n";
    echo "Cấp mở khóa thiên phú: " . CauHinhGame::CAP_DO_MO_KHOA_THIEN_PHU . "\n";
    echo "Thời gian offline tối đa: " . CauHinhGame::THOI_GIAN_OFFLINE_TOI_DA . " giây\n";
    
    echo "\nCác cảnh giới:\n";
    $soLuongCanhGioi = count(CauHinhGame::TEN_CANH_GIOI);
    for ($index = 0; $index < $soLuongCanhGioi; $index++) {
        $ten = CauHinhGame::TEN_CANH_GIOI[$index];
        $nguong = CauHinhGame::NGUONG_CAP_DO_CANH_GIOI[$index];
        $hesoExp = isset(CauHinhGame::HE_SO_KINH_NGHIEM[$index]) ? CauHinhGame::HE_SO_KINH_NGHIEM[$index] : '-';
        echo "- $ten (Cấp $nguong+, hệ số KN: $hesoExp)\n";
    }
    
    echo "\n";
}

// --- VÍ DỤ 6: So sánh code cũ và mới ---
function viDu6SoSanh()
{
    echo "=== VÍ DỤ 6: So sánh code cũ và mới ===\n";
    
    echo "CODE CŨ:\n";
    echo "  \$player->uname\n";
    echo "  \$player->ulv\n";
    echo "  \$player->uexp\n";
    echo "  getplayer(\$sid, \$dblj)\n";
    echo "  changeexp(\$sid, \$dblj, \$exp)\n";
    
    echo "\nCODE MỚI:\n";
    echo "  \$nguoiChoi->tenNhanVat\n";
    echo "  \$nguoiChoi->capDo\n";
    echo "  \$nguoiChoi->kinhNghiem\n";
    echo "  layThongTinNguoiChoi(\$idPhien, \$ketNoiDB)\n";
    echo "  themKinhNghiem(\$idPhien, \$soKinhNghiem, \$ketNoiDB)\n";
    
    echo "\n✓ Tên rõ ràng hơn, dễ hiểu hơn\n";
    echo "✓ Tuân thủ chuẩn PSR-1/PSR-12\n";
    echo "✓ PHPDoc đầy đủ bằng tiếng Việt\n";
    
    echo "\n";
}

// --- MAIN: Chạy tất cả ví dụ (nếu có kết nối database) ---
/*
if (isset($pdo) && isset($sid)) {
    viDu1LayThongTinNguoiChoi($sid, $pdo);
    viDu2ThemKinhNghiem($sid, $pdo);
    viDu3ChienDau($sid, $pdo);
}
*/

// Chạy các ví dụ không cần database
viDu4TrangBi();
viDu5CauHinhGame();
viDu6SoSanh();

echo "=== Hoàn thành tất cả ví dụ ===\n";
