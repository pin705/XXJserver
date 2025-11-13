<?php
/**
 * Bootstrap File - Tự Động Tải Các Class và Helper
 * 
 * File này tự động tải tất cả các class và helper functions cần thiết
 * để tránh phải require_once nhiều lần trong mỗi file game.
 * 
 * Sử dụng:
 * require_once __DIR__ . '/bootstrap.php';
 * 
 * @package TuTaTuTien
 */

// Định nghĩa đường dẫn gốc của dự án
define('ROOT_PATH', __DIR__);
define('SRC_PATH', ROOT_PATH . '/src');
define('CLASS_PATH', ROOT_PATH . '/class');
define('CONFIG_PATH', ROOT_PATH . '/config');
define('GAME_PATH', ROOT_PATH . '/game');

// Tự động tải các file config
require_once CONFIG_PATH . '/CauHinhGame.php';

// Tự động tải tất cả Helper files
$helperFiles = [
    'NguoiChoiHelper.php',
    'TrangBiHelper.php',
    'DaoCuHelper.php',
    'DuocPhamHelper.php',
    'QuaiVatHelper.php',
    'TruongLaoHelper.php',
    'NhiemVuHelper.php',
    'BanDoHelper.php',
    'SungVatHelper.php',
    'KyNangHelper.php',
    'ClubHelper.php',
];

foreach ($helperFiles as $helperFile) {
    $filePath = SRC_PATH . '/Helpers/' . $helperFile;
    if (file_exists($filePath)) {
        require_once $filePath;
    }
}

// Tự động tải tất cả Class files
$classFiles = [
    'NguoiChoi.php',
    'QuaiVat.php',
    'TrangBi.php',
    'BanDo.php',
    'DaoCu.php',
    'DuocPham.php',
    'NhiemVu.php',
    'TruongLao.php',
    'KyNang.php',
    'SungVat.php',
];

foreach ($classFiles as $classFile) {
    $filePath = SRC_PATH . '/Classes/' . $classFile;
    if (file_exists($filePath)) {
        require_once $filePath;
    }
}

// Tự động tải Core classes
$coreFiles = [
    'GameHandler.php',
];

foreach ($coreFiles as $coreFile) {
    $filePath = SRC_PATH . '/Core/' . $coreFile;
    if (file_exists($filePath)) {
        require_once $filePath;
    }
}

// Import namespace để sử dụng dễ dàng hơn
use TuTaTuTien\Helpers as Helpers;
use TuTaTuTien\Classes\NguoiChoi;
use TuTaTuTien\Classes\QuaiVat;
use TuTaTuTien\Classes\TrangBi;
use TuTaTuTien\Classes\BanDo;
use TuTaTuTien\Classes\DaoCu;
use TuTaTuTien\Classes\DuocPham;
use TuTaTuTien\Classes\NhiemVu;
use TuTaTuTien\Classes\TruongLao;
use TuTaTuTien\Classes\KyNang;
use TuTaTuTien\Classes\SungVat;
use TuTaTuTien\Core\GameHandler;

// Helper function để debug (có thể tắt trong production)
if (!function_exists('debug_log')) {
    /**
     * Ghi log debug vào file
     * 
     * @param mixed $data Dữ liệu cần log
     * @param string $label Nhãn cho log entry
     */
    function debug_log($data, $label = 'DEBUG') {
        if (defined('DEBUG_MODE') && DEBUG_MODE) {
            $logFile = ROOT_PATH . '/debug.log';
            $timestamp = date('Y-m-d H:i:s');
            $message = "[$timestamp] [$label] " . print_r($data, true) . PHP_EOL;
            file_put_contents($logFile, $message, FILE_APPEND);
        }
    }
}

// Thiết lập error reporting (có thể điều chỉnh theo môi trường)
if (!defined('PRODUCTION_MODE')) {
    define('PRODUCTION_MODE', false);
}

if (!PRODUCTION_MODE) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}
