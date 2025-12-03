<?php
$club = $data['club'];
$member = $data['member'];
$members = $data['members'];
$founder = $data['founder'];
$player = $data['player'];
$sid = $data['sid'];
$msg = $_GET['msg'] ?? '';

$roleNames = [
    1 => 'Chưởng môn',
    2 => 'Phó chưởng môn',
    3 => 'Trưởng lão',
    4 => 'Chấp sự',
    5 => 'Tinh anh',
    6 => 'Đệ tử'
];

$myRank = $member ? $member->uclv : 999;
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($club->clubname); ?> - Tu Tiên Giới</title>
    <link rel="stylesheet" href="/css/gamecss.css">
    <style>
        .club-container {
            padding: 10px;
        }
        .club-info {
            border: 1px solid #ccc;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 10px;
        }
        .member-list {
            margin-top: 10px;
        }
        .member-item {
            margin-bottom: 3px;
        }
        .role-tag {
            font-weight: bold;
            color: #555;
        }
        .actions {
            margin: 10px 0;
            padding: 5px;
            background: #f9f9f9;
            border: 1px dashed #ccc;
        }
        .actions a {
            margin-right: 10px;
            text-decoration: none;
            font-weight: bold;
            color: #0000FF;
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
    <div class="club-container">
        <h3>Môn phái: <?php echo htmlspecialchars($club->clubname); ?></h3>
        
        <?php if ($msg): ?>
            <div class="message"><?php echo htmlspecialchars($msg); ?></div>
        <?php endif; ?>

        <div class="club-info">
            Người thành lập: <a href="?cmd=getplayerinfo&uid=<?php echo $club->clubno1; ?>&sid=<?php echo $sid; ?>"><?php echo htmlspecialchars($founder->uname ?? 'Unknown'); ?></a><br>
            Tài chính: Linh thạch [<?php echo number_format($club->clubyxb); ?>] - Cực phẩm [<?php echo number_format($club->clubczb); ?>]<br>
            Kiến thiết độ: <?php echo number_format($club->clubexp); ?><br>
            Giới thiệu: <br>
            <?php echo nl2br(htmlspecialchars($club->clubinfo)); ?>
        </div>

        <div class="actions">
            <?php if ($member && $member->clubid == $club->clubid): ?>
                <?php if ($myRank == 1): ?>
                    <a href="?cmd=club&action=manage&sid=<?php echo $sid; ?>">Quản lý</a>
                    <a href="?cmd=club&action=disband&sid=<?php echo $sid; ?>" onclick="return confirm('Bạn chắc chắn muốn giải tán bang?');" style="color: red;">Giải tán</a>
                <?php elseif ($myRank == 2): ?>
                    <a href="?cmd=club&action=manage&sid=<?php echo $sid; ?>">Quản lý</a>
                    <a href="?cmd=club&action=leave&sid=<?php echo $sid; ?>" onclick="return confirm('Bạn chắc chắn muốn rời bang?');">Rời Bang</a>
                <?php else: ?>
                    <a href="?cmd=club&action=leave&sid=<?php echo $sid; ?>" onclick="return confirm('Bạn chắc chắn muốn rời bang?');">Rời Bang</a>
                <?php endif; ?>
            <?php else: ?>
                <?php if (!$member): ?>
                    <a href="?cmd=club&action=join&clubid=<?php echo $club->clubid; ?>&sid=<?php echo $sid; ?>">Xin gia nhập</a>
                <?php endif; ?>
            <?php endif; ?>
            <a href="?cmd=club&action=list&sid=<?php echo $sid; ?>">Danh sách môn phái</a>
        </div>

        <div class="member-list">
            <strong>Thành viên môn phái:</strong><br>
            <?php foreach ($members as $m): ?>
                <div class="member-item">
                    <span class="role-tag">[<?php echo $roleNames[$m['uclv']] ?? 'Đệ tử'; ?>]</span>
                    <a href="?cmd=getplayerinfo&uid=<?php echo $m['uid']; ?>&sid=<?php echo $sid; ?>">
                        <?php echo htmlspecialchars($m['uname']); ?>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>

        <div style="margin-top: 20px;">
            <a href="game.php" style="background-color: #cff3d2; padding: 5px; border-radius: 3px; text-decoration: none;">Trở về trò chơi</a>
        </div>
    </div>
</body>
</html>