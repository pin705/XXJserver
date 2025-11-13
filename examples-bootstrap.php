<?php
/**
 * Example - Ví dụ sử dụng Bootstrap và GameHandler
 * 
 * File này minh họa cách sử dụng bootstrap.php và GameHandler
 * để giảm code lặp và tăng khả năng mở rộng
 * 
 * @package TuTaTuTien\Examples
 */

// Chỉ cần require bootstrap một lần - tất cả helpers và classes sẽ được load tự động
require_once __DIR__ . '/bootstrap.php';

use TuTaTuTien\Helpers as Helpers;
use TuTaTuTien\Core\GameHandler;

echo "=== Ví Dụ Sử Dụng Bootstrap và GameHandler ===\n\n";

// ============================================
// PHẦN 1: Sử dụng Helpers (Cách cũ vẫn hoạt động)
// ============================================

echo "1. SỬ DỤNG HELPERS TRỰC TIẾP:\n";
echo str_repeat("-", 50) . "\n";

// Giả lập database connection (trong thực tế sử dụng pdo.php)
try {
    $dblj = new PDO('mysql:host=localhost;dbname=test', 'user', 'pass');
    echo "✓ Database connected (example)\n";
} catch (PDOException $e) {
    echo "✗ Database connection failed (this is just an example)\n";
    $dblj = null;
}

// Ví dụ sử dụng helpers (không cần require từng file)
if ($dblj) {
    echo "\nSử dụng Helpers (đã được load tự động):\n";
    echo "- Helpers\layThongTinNguoiChoi()\n";
    echo "- Helpers\layThongTinBanDo()\n";
    echo "- Helpers\layThongTinQuaiVat()\n";
    echo "- ... và 8 helpers khác\n";
}

echo "\n";

// ============================================
// PHẦN 2: Sử dụng GameHandler (Cách mới - khuyến nghị)
// ============================================

echo "\n2. SỬ DỤNG GAMEHANDLER (CÁCH MỚI):\n";
echo str_repeat("-", 50) . "\n";

// Giả lập encode object
class MockEncode {
    public function encode($str) {
        return base64_encode($str);
    }
}

$encode = new MockEncode();
$sid = 'example_session_id';

// Tạo GameHandler instance
echo "\nKhởi tạo GameHandler:\n";
echo "  \$game = new GameHandler(\$dblj, \$encode, \$sid);\n";

if ($dblj) {
    // Trong thực tế:
    // $game = new GameHandler($dblj, $encode, $sid);
    echo "✓ GameHandler được khởi tạo thành công\n";
    
    echo "\nCác phương thức có sẵn:\n";
    echo "  • getNguoiChoi() - Lấy thông tin người chơi\n";
    echo "  • reloadNguoiChoi() - Tải lại thông tin\n";
    echo "  • createLink(\$cmd, \$params) - Tạo link encode\n";
    echo "  • getLinkQuayVeBanDo() - Link về bản đồ\n";
    echo "  • getLinkQuayVeKhuVuc() - Link về khu vực\n";
    echo "  • nguoiChoiConSong() - Kiểm tra còn sống\n";
    echo "  • validateBanDo(\$nowmid) - Validate bản đồ\n";
    echo "  • validatePVP(\$targetUid) - Validate PVP\n";
    echo "  • createErrorMessage(\$msg) - Tạo thông báo lỗi\n";
    echo "  • getThongTinDuocPhamTrangBi() - Lấy info dược phẩm\n";
    echo "  • getThongTinKyNangTrangBi() - Lấy info kỹ năng\n";
}

echo "\n";

// ============================================
// PHẦN 3: So Sánh Code Cũ vs Code Mới
// ============================================

echo "\n3. SO SÁNH CODE CŨ VS CODE MỚI:\n";
echo str_repeat("-", 50) . "\n";

echo "\n📝 CODE CŨ (Nhiều require, lặp code):\n";
echo <<<'CODE'
<?php
require_once __DIR__ . '/../src/Helpers/NguoiChoiHelper.php';
require_once __DIR__ . '/../src/Helpers/TrangBiHelper.php';
require_once __DIR__ . '/../src/Helpers/DaoCuHelper.php';
require_once __DIR__ . '/../src/Helpers/DuocPhamHelper.php';
require_once __DIR__ . '/../src/Helpers/QuaiVatHelper.php';
require_once __DIR__ . '/../src/Helpers/TruongLaoHelper.php';
require_once __DIR__ . '/../src/Helpers/NhiemVuHelper.php';
require_once __DIR__ . '/../src/Helpers/BanDoHelper.php';
require_once __DIR__ . '/../src/Helpers/SungVatHelper.php';
require_once __DIR__ . '/../src/Helpers/KyNangHelper.php';
require_once __DIR__ . '/../src/Helpers/ClubHelper.php';
use TuTaTuTien\Helpers as Helpers;

$player = Helpers\layThongTinNguoiChoi($sid, $dblj);
$gonowmid = $encode->encode("cmd=gomid&newmid=$player->idBanDoHienTai&sid=$player->sid");

if ($nowmid != $player->idBanDoHienTai) {
    echo 'Mời bình thường chơi đùa!<br/>';
    echo '<a href="?cmd='.$gonowmid.'">Trở về</a>';
    exit;
}
CODE;

echo "\n\n✨ CODE MỚI (Ngắn gọn, dễ maintain):\n";
echo <<<'CODE'
<?php
require_once __DIR__ . '/bootstrap.php';  // Chỉ 1 dòng!

use TuTaTuTien\Core\GameHandler;

$game = new GameHandler($dblj, $encode, $sid);
$validation = $game->validateBanDo($nowmid);

if (!$validation['valid']) {
    exit($validation['message']);
}
CODE;

echo "\n\n📊 THỐNG KÊ:\n";
echo "  Cũ: 11 dòng require + 7 dòng logic = 18 dòng\n";
echo "  Mới: 1 dòng require + 4 dòng logic = 5 dòng\n";
echo "  ➜ Giảm 72% code!\n";

echo "\n";

// ============================================
// PHẦN 4: Ví Dụ Thực Tế - PVP Validation
// ============================================

echo "\n4. VÍ DỤ THỰC TẾ - PVP VALIDATION:\n";
echo str_repeat("-", 50) . "\n";

echo "\n📝 CODE CŨ:\n";
echo <<<'CODE'
<?php
$cxmid = Helpers\layThongTinBanDo($player->idBanDoHienTai, $dblj);
$pvper = Helpers\layThongTinNguoiChoiTheoUid($uid, $dblj);

if ($cxmid->ispvp == 0) {
    Helpers\thayDoiThuocTinhNguoiChoi("ispvp", 0, $sid, $dblj);
    $tishihtml = 'Trước mắt địa đồ không cho phép PK<br/><br/>';
    $tishihtml .= '<a href="?cmd='.$gonowmid.'">Trở về trò chơi</a>';
    exit($tishihtml);
}

if ($pvper->sfzx == 0) {
    Helpers\thayDoiThuocTinhNguoiChoi("ispvp", 0, $sid, $dblj);
    $tishihtml = 'Nên người chơi không có online<br/><br/>';
    $tishihtml .= '<a href="?cmd='.$gonowmid.'">Trở về trò chơi</a>';
    exit($tishihtml);
}

if ($pvper->idBanDoHienTai != $player->idBanDoHienTai) {
    Helpers\thayDoiThuocTinhNguoiChoi("ispvp", 0, $sid, $dblj);
    $tishihtml = 'Nên người chơi không có ở nơi đó đồ<br/><br/>';
    $tishihtml .= '<a href="?cmd='.$gonowmid.'">Trở về trò chơi</a>';
    exit($tishihtml);
}
// ... và còn nhiều checks khác
CODE;

echo "\n\n✨ CODE MỚI:\n";
echo <<<'CODE'
<?php
$game = new GameHandler($dblj, $encode, $sid);
$pvpValidation = $game->validatePVP($uid);

if (!$pvpValidation['valid']) {
    exit($pvpValidation['message']);
}

// Lấy thông tin đối thủ
$target = $pvpValidation['target'];
CODE;

echo "\n\n📊 THỐNG KÊ:\n";
echo "  Cũ: ~25 dòng code lặp lại\n";
echo "  Mới: 5 dòng code\n";
echo "  ➜ Giảm 80% code!\n";

echo "\n";

// ============================================
// PHẦN 5: Lợi Ích Của Cách Tiếp Cận Mới
// ============================================

echo "\n5. LỢI ÍCH CỦA CÁCH TIẾP CẬN MỚI:\n";
echo str_repeat("-", 50) . "\n";

$benefits = [
    "✓ Giảm code lặp: Không cần require 11 files trong mỗi file game",
    "✓ Dễ maintain: Logic tập trung trong GameHandler",
    "✓ Dễ mở rộng: Thêm methods mới vào GameHandler dễ dàng",
    "✓ Tái sử dụng: Methods trong GameHandler dùng chung cho toàn bộ game",
    "✓ Ít bug: Logic xử lý tập trung, sửa 1 chỗ áp dụng toàn bộ",
    "✓ Performance: Chỉ load files cần thiết một lần",
    "✓ Chuẩn PSR: Tuân thủ chuẩn lập trình PHP hiện đại",
    "✓ Type safety: Có PHPDoc đầy đủ cho IDE autocomplete",
];

foreach ($benefits as $benefit) {
    echo "  $benefit\n";
}

echo "\n";

// ============================================
// PHẦN 6: Migration Guide
// ============================================

echo "\n6. HƯỚNG DẪN CHUYỂN ĐỔI:\n";
echo str_repeat("-", 50) . "\n";

echo "\nBước 1: Thay thế requires\n";
echo "  Từ: require_once __DIR__ . '/../src/Helpers/...'\n";
echo "  Sang: require_once __DIR__ . '/bootstrap.php'\n";

echo "\nBước 2: Sử dụng GameHandler\n";
echo "  \$game = new GameHandler(\$dblj, \$encode, \$sid);\n";

echo "\nBước 3: Thay thế logic validation\n";
echo "  - validateBanDo() thay cho manual checks\n";
echo "  - validatePVP() thay cho PVP checks\n";
echo "  - createErrorMessage() thay cho manual HTML\n";

echo "\nBước 4: Sử dụng helper methods\n";
echo "  - getLinkQuayVeBanDo() thay cho manual encode\n";
echo "  - getThongTinDuocPhamTrangBi() cho dược phẩm\n";
echo "  - getThongTinKyNangTrangBi() cho kỹ năng\n";

echo "\n";

// ============================================
// KẾT LUẬN
// ============================================

echo "\n" . str_repeat("=", 50) . "\n";
echo "KẾT LUẬN:\n";
echo str_repeat("=", 50) . "\n\n";

echo "Bootstrap và GameHandler giúp:\n";
echo "  • Code ngắn gọn hơn 70-80%\n";
echo "  • Dễ đọc và maintain hơn\n";
echo "  • Ít bug hơn\n";
echo "  • Mở rộng dễ dàng hơn\n";
echo "  • Tuân thủ chuẩn PSR\n\n";

echo "Xem thêm:\n";
echo "  - SETUP.md: Hướng dẫn cài đặt chi tiết\n";
echo "  - REFACTORING.md: Tài liệu refactoring\n";
echo "  - bootstrap.php: Source code bootstrap\n";
echo "  - src/Core/GameHandler.php: Source code GameHandler\n\n";

echo "Happy Coding! 🚀\n";
