<?php
$clubs = $data['clubs'];
$player = $data['player'];
$sid = $data['sid'];
$msg = $_GET['msg'] ?? '';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh Sách Môn Phái - Tu Tiên Giới</title>
    <link rel="stylesheet" href="/css/gamecss.css">
    <style>
        .club-list-container {
            padding: 10px;
        }
        .club-item {
            margin-bottom: 5px;
            padding: 5px;
            border-bottom: 1px dashed #ccc;
        }
        .club-name {
            font-weight: bold;
            color: #0000FF;
            text-decoration: none;
        }
        .message {
            padding: 10px;
            margin-bottom: 10px;
            background-color: #dff0d8;
            border: 1px solid #d6e9c6;
            color: #3c763d;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div class="club-list-container">
        <div style="text-align: center;">
            <img src="/images/menpai.png" width="280" height="140" style="border-radius: 8px;">
        </div>
        
        <h3 style="text-align: center;">===========Thiên Bảng===========</h3>

        <?php if ($msg): ?>
            <div class="message"><?php echo htmlspecialchars($msg); ?></div>
        <?php endif; ?>

        <?php if (empty($clubs)): ?>
            <div style="text-align: center;">Hiện chưa có môn phái nào.</div>
        <?php else: ?>
            <?php foreach ($clubs as $index => $club): ?>
                <div class="club-item">
                    [<?php echo $index + 1; ?>] 
                    <a href="?cmd=club&clubid=<?php echo $club->clubid; ?>&sid=<?php echo $sid; ?>" class="club-name">
                        <?php echo htmlspecialchars($club->clubname); ?>
                    </a>
                    (Lv.<?php echo $club->clublv; ?>)
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <div style="margin-top: 20px;">
            <a href="game.php" style="background-color: #cff3d2; padding: 5px; border-radius: 3px; text-decoration: none;">Trở về trò chơi</a>
        </div>
    </div>
</body>
</html>