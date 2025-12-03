<?php
// error_reporting(0);
include_once 'pdo.php';
require_once __DIR__ . '/vendor/autoload.php';

use XXJ\Core\Database;
use XXJ\Core\Router;
use XXJ\Utils\Encoder;

// Initialize Database
try {
    Database::getInstance([
        'host' => $dbhost,
        'dbname' => $dbname,
        'username' => $sqlname,
        'password' => $sqlpass
    ]);
} catch (Exception $e) {
    error_log("DB Init failed: " . $e->getMessage());
}

// Headers
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");

$encode = new Encoder();
$Dcmd = $_SERVER['QUERY_STRING'];
session_start();

// Rate Limiting
$allow_sep = "220";
function getMillisecond() {
    list($t1, $t2) = explode(' ', microtime());
    return (float)sprintf('%.0f',(floatval($t1) + floatval($t2)) * 1000);
}

function shouldReencode($cmd) {
    $list = ['cjplayer','djinfo','zbinfo','npc','duihuan','shangdian','sendliaotian'];
    return in_array($cmd, $list, true);
}

function reencodeAndRedirect($encode, $Dcmd) {
    $Dcmd = $encode->encode($Dcmd);
    header("refresh:1;url=?cmd=$Dcmd");
    exit();
}

if (isset($_SESSION["post_sep"])) {
    if (getMillisecond() - $_SESSION["post_sep"] < $allow_sep) {
        $msg = '<meta charset="utf-8" content="width=device-width,user-scalable=no" name="viewport">Ngươi điểm kích quá nhanh^_^!<br/><a href="?'.$Dcmd.'">Tiếp tục</a>';
        exit($msg);
    } else {
        $_SESSION["post_sep"] = getMillisecond();
    }
} else {
    $_SESSION["post_sep"] = getMillisecond();
}

// Router Logic
parse_str($Dcmd);
if (isset($cmd)) {
    if (shouldReencode($cmd)) {
        reencodeAndRedirect($encode, $Dcmd);
    }

    $Dcmd = $encode->decode($cmd);
    parse_str($Dcmd, $params);
    $_GET = array_merge($_GET, $params);

    $router = new Router();
    
    // Auth
    $router->add('cj', [\XXJ\Controllers\AuthController::class, 'showCreatePlayer']);
    $router->add('cjplayer', [\XXJ\Controllers\AuthController::class, 'createPlayer']);
    $router->add('login', [\XXJ\Controllers\AuthController::class, 'login']);
    
    // Game
    $router->add('gomid', [\XXJ\Controllers\GameController::class, 'moveToMap']);
    $router->add('allmap', [\XXJ\Controllers\GameController::class, 'listMaps']);
    $router->add('qydt', [\XXJ\Controllers\GameController::class, 'showRegionMap']);
    $router->add('ditu', [\XXJ\Controllers\GameController::class, 'showWorldMap']);

    // Player
    $router->add('zhuangtai', [\XXJ\Controllers\PlayerController::class, 'showStatus']);
    $router->add('xxzb', [\XXJ\Controllers\PlayerController::class, 'showStatus']);
    $router->add('setzbwz', [\XXJ\Controllers\PlayerController::class, 'showStatus']);
    $router->add('getplayerinfo', [\XXJ\Controllers\PlayerController::class, 'viewOtherPlayer']);

    // Inventory
    $router->add('getbagzb', [\XXJ\Controllers\InventoryController::class, 'showBag']);
    $router->add('getbagyp', [\XXJ\Controllers\InventoryController::class, 'showBag']);
    $router->add('getbagdj', [\XXJ\Controllers\InventoryController::class, 'showBag']);
    $router->add('getbagyd', [\XXJ\Controllers\InventoryController::class, 'showPillBag']);
    $router->add('zbinfo', [\XXJ\Controllers\InventoryController::class, 'showDetail']);
    $router->add('zbinfo_sys', [\XXJ\Controllers\InventoryController::class, 'showTemplateDetail']);
    $router->add('chakanzb', [\XXJ\Controllers\InventoryController::class, 'showDetail']);
    $router->add('ypinfo', [\XXJ\Controllers\InventoryController::class, 'showDetail']);
    $router->add('djinfo', [\XXJ\Controllers\InventoryController::class, 'showDetail']);
    $router->add('ydinfo', [\XXJ\Controllers\InventoryController::class, 'showDetail']);
    $router->add('setyp', [\XXJ\Controllers\InventoryController::class, 'setPotionSlot']);
    $router->add('useyp', [\XXJ\Controllers\InventoryController::class, 'usePotion']);
    $router->add('usepill', [\XXJ\Controllers\InventoryController::class, 'usePill']);
    $router->add('upzb', [\XXJ\Controllers\InventoryController::class, 'upgradeEquipment']);
    $router->add('delezb', [\XXJ\Controllers\InventoryController::class, 'deleteEquipment']);

    // Combat
    $router->add('pve', [\XXJ\Controllers\CombatController::class, 'pve']);
    $router->add('pvegj', [\XXJ\Controllers\CombatController::class, 'pve']);
    $router->add('pvp', [\XXJ\Controllers\PvpController::class, 'combat']);

    // Boss
    $router->add('pvb', [\XXJ\Controllers\BossController::class, 'fight']);
    $router->add('pvbgj', [\XXJ\Controllers\BossController::class, 'fight']);
    $router->add('bossinfo', [\XXJ\Controllers\BossController::class, 'info']);

    // NPC
    $router->add('npc', [\XXJ\Controllers\NpcController::class, 'index']);
    $router->add('gaiming', [\XXJ\Controllers\NpcController::class, 'rename']);
    $router->add('czbgm', [\XXJ\Controllers\NpcController::class, 'vipRename']);

    // Task
    $router->add('task', [\XXJ\Controllers\TaskController::class, 'index']);
    $router->add('mytask', [\XXJ\Controllers\TaskController::class, 'myTasks']);
    $router->add('mytaskinfo', [\XXJ\Controllers\TaskController::class, 'taskInfo']);
    $router->add('taskteleport', [\XXJ\Controllers\TaskController::class, 'teleport']);

    // Chat
    $router->add('liaotian', [\XXJ\Controllers\ChatController::class, 'index']);
    $router->add('sendliaotian', [\XXJ\Controllers\ChatController::class, 'send']);
    $router->add('im', [\XXJ\Controllers\ChatController::class, 'index']); // Alias

    // Shop & Market
    $router->add('shangdian', [\XXJ\Controllers\ShopController::class, 'index']);
    $router->add('fangshi', [\XXJ\Controllers\MarketController::class, 'index']);
    $router->add('fangshi_buy', [\XXJ\Controllers\MarketController::class, 'buy']);

    // Gift Code
    $router->add('duihuan', function() {
        $controller = new \XXJ\Controllers\GiftCodeController();
        if ($_SERVER['REQUEST_METHOD'] === 'POST' || isset($_GET['dhm'])) {
            $controller->redeem();
        } else {
            $controller->index();
        }
    });

    // Systems
    $router->add('tianfu', [\XXJ\Controllers\TalentController::class, 'index']);
    $router->add('tupo', [\XXJ\Controllers\BreakthroughController::class, 'index']);
    $router->add('taozhuang', [\XXJ\Controllers\SuitController::class, 'index']);
    $router->add('paihang', [\XXJ\Controllers\RankingController::class, 'index']);
    $router->add('chongwu', [\XXJ\Controllers\PetController::class, 'index']);
    $router->add('getginfo', [\XXJ\Controllers\MonsterController::class, 'info']);

    // Club
    $router->add('club', [\XXJ\Controllers\ClubController::class, 'index']);
    $router->add('clublist', [\XXJ\Controllers\ClubController::class, 'list']);
    $router->add('cjclub', [\XXJ\Controllers\ClubController::class, 'create']);
    $router->add('clubinfo', [\XXJ\Controllers\ClubController::class, 'info']);
    $router->add('joinclub', [\XXJ\Controllers\ClubController::class, 'join']);
    $router->add('outclub', [\XXJ\Controllers\ClubController::class, 'leave']);

    // Friend
    $router->add('friend', [\XXJ\Controllers\FriendController::class, 'index']);
    $router->add('addim', [\XXJ\Controllers\FriendController::class, 'add']);
    $router->add('deim', [\XXJ\Controllers\FriendController::class, 'remove']);

    // Skills
    $router->add('wgxiulian', [\XXJ\Controllers\SkillController::class, 'train']);
    $router->add('wgxl', [\XXJ\Controllers\SkillController::class, 'train']);
    $router->add('jswg', [\XXJ\Controllers\SkillController::class, 'endTraining']);
    $router->add('xxwg', [\XXJ\Controllers\SkillController::class, 'index']);
    $router->add('getbagjn', [\XXJ\Controllers\SkillController::class, 'index']);
    $router->add('jninfo', [\XXJ\Controllers\SkillController::class, 'train']);
    $router->add('skill', [\XXJ\Controllers\SkillController::class, 'index']);
    $router->add('skill_draw', [\XXJ\Controllers\SkillController::class, 'draw']);
    $router->add('skill_learn', [\XXJ\Controllers\SkillController::class, 'learn']);
    $router->add('skill_unlearn', [\XXJ\Controllers\SkillController::class, 'unlearn']);
    $router->add('skill_discard', [\XXJ\Controllers\SkillController::class, 'discard']);
    $router->add('skill_train', [\XXJ\Controllers\SkillController::class, 'train']);
    $router->add('skill_start_train', [\XXJ\Controllers\SkillController::class, 'startTraining']);
    $router->add('skill_end_train', [\XXJ\Controllers\SkillController::class, 'endTraining']);

    // Cultivation
    $router->add('xiulian', [\XXJ\Controllers\CultivationController::class, 'index']);
    $router->add('goxiulian', [\XXJ\Controllers\CultivationController::class, 'start']);
    $router->add('endxiulian', [\XXJ\Controllers\CultivationController::class, 'end']);
    $router->add('cultivation', [\XXJ\Controllers\CultivationController::class, 'index']);
    $router->add('cultivation_start', [\XXJ\Controllers\CultivationController::class, 'start']);
    $router->add('cultivation_end', [\XXJ\Controllers\CultivationController::class, 'end']);

    try {
        $router->dispatch($params['cmd'] ?? '', $params);
    } catch (Exception $e) {
        echo "Lỗi: " . $e->getMessage();
        echo "<br><a href='index.php'>Về trang chủ</a>";
    }

} else {
    header("refresh:1;url=index.php");
    exit();
}
?>
