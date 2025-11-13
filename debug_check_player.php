<?php
/**
 * Debug tool: Check player in database
 * Usage: debug_check_player.php?sid=xxx
 * Or: debug_check_player.php?token=xxx
 */

require_once 'pdo.php';

echo '<meta charset="utf-8">';
echo '<h2>Debug: Check Player in Database</h2>';

$sid = isset($_GET['sid']) ? $_GET['sid'] : '';
$token = isset($_GET['token']) ? $_GET['token'] : '';

if ($sid) {
    echo "<h3>Tìm kiếm theo SID: $sid</h3>";
    $sql = "SELECT * FROM game1 WHERE sid = ?";
    $stmt = $dblj->prepare($sql);
    $stmt->execute([$sid]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($result) {
        echo "<pre>";
        print_r($result);
        echo "</pre>";
    } else {
        echo "<p style='color:red;'>KHÔNG TÌM THẤY player với SID này!</p>";
        
        // Tìm tất cả players
        echo "<h3>Tất cả players trong database:</h3>";
        $sql = "SELECT sid, uname, token, ulv, nowmid FROM game1 ORDER BY uid DESC LIMIT 10";
        $stmt = $dblj->query($sql);
        $all = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo "<pre>";
        print_r($all);
        echo "</pre>";
    }
}

if ($token) {
    echo "<h3>Tìm kiếm theo Token: $token</h3>";
    $sql = "SELECT * FROM game1 WHERE token = ?";
    $stmt = $dblj->prepare($sql);
    $stmt->execute([$token]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($result) {
        echo "<pre>";
        print_r($result);
        echo "</pre>";
    } else {
        echo "<p style='color:red;'>KHÔNG TÌM THẤY player với token này!</p>";
    }
}

if (!$sid && !$token) {
    echo "<p>Usage:</p>";
    echo "<ul>";
    echo "<li>?sid=xxx - Tìm theo SID</li>";
    echo "<li>?token=xxx - Tìm theo Token</li>";
    echo "</ul>";
    
    echo "<h3>10 players gần nhất:</h3>";
    $sql = "SELECT sid, uname, token, ulv, nowmid, endtime FROM game1 ORDER BY uid DESC LIMIT 10";
    $stmt = $dblj->query($sql);
    $all = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo "<table border='1' style='border-collapse:collapse;'>";
    echo "<tr><th>SID</th><th>Username</th><th>Token</th><th>Level</th><th>Map</th><th>Last Active</th></tr>";
    foreach ($all as $row) {
        echo "<tr>";
        echo "<td>" . substr($row['sid'], 0, 10) . "...</td>";
        echo "<td>{$row['uname']}</td>";
        echo "<td>" . substr($row['token'], 0, 10) . "...</td>";
        echo "<td>{$row['ulv']}</td>";
        echo "<td>{$row['nowmid']}</td>";
        echo "<td>{$row['endtime']}</td>";
        echo "</tr>";
    }
    echo "</table>";
}

echo "<hr>";
echo "<h3>Test SID Generation:</h3>";
echo "<form method='get'>";
echo "Username: <input name='test_username' value='testuser'><br>";
echo "Token: <input name='test_token' value='testtoken123'><br>";
echo "<input type='submit' value='Generate SID'>";
echo "</form>";

if (isset($_GET['test_username']) && isset($_GET['test_token'])) {
    $test_sid = md5($_GET['test_username'] . $_GET['test_token'] . '229');
    echo "<p>Generated SID: <strong>$test_sid</strong></p>";
}
?>
