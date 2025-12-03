<?php
$pets = $data['pets'];
$currentPetId = $data['currentPetId'];
$popup = $data['popup'] ?? null;
$showConfirm = $data['showConfirm'] ?? false;
$player = $data['player'];
$sid = $data['sid'];

$qualities = [
    0 => ['name' => 'Phổ thông', 'color' => '#00C000'],
    1 => ['name' => 'Ưu tú', 'color' => '#1a80da'],
    2 => ['name' => 'Trác tuyệt', 'color' => '#a08f0a'],
    3 => ['name' => 'Phi phàm', 'color' => '#14b8b9'],
    4 => ['name' => 'Hoàn mỹ', 'color' => '#f16613'],
    5 => ['name' => 'Nghịch thiên', 'color' => '#ec0909']
];
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sủng Vật - Tu Tiên Giới</title>
    <link rel="stylesheet" href="/css/gamecss.css">
    <style>
        .pet-container {
            padding: 10px;
        }
        .pet-list {
            margin-bottom: 20px;
        }
        .pet-item {
            margin-bottom: 5px;
            padding: 5px;
            border-bottom: 1px dashed #ccc;
        }
        .pet-actions a {
            margin-left: 5px;
            font-size: 12px;
            text-decoration: none;
            padding: 2px 5px;
            border: 1px solid #ccc;
            border-radius: 3px;
            background: #f9f9f9;
        }
        .pet-active {
            background-color: #ef0a0a;
            color: #ecf3ea;
            border-radius: 10px;
            padding: 2px 5px;
            font-size: 12px;
        }
        .draw-section {
            text-align: center;
            margin-top: 20px;
            border-top: 1px solid #ccc;
            padding-top: 10px;
        }
        .draw-btn {
            color: #18a558;
            font-weight: bold;
            text-decoration: none;
        }
        .confirm-box {
            text-align: center;
            margin: 10px 0;
            padding: 10px;
            border: 1px solid #f00;
            background: #fff0f0;
        }
        .message {
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 4px;
            text-align: center;
        }
        .msg-success {
            background-color: #dff0d8;
            color: #3c763d;
        }
        .msg-fail {
            background-color: #f2dede;
            color: #a94442;
        }
    </style>
</head>
<body>
    <div class="pet-container">
        <div style="text-align: center;">
            <img src="/images/cw.png" width="280" height="140" style="border-radius: 8px;">
        </div>

        <?php if ($popup === 'success'): ?>
            <div class="message msg-success">Thao tác thành công!</div>
        <?php elseif ($popup === 'fail'): ?>
            <div class="message msg-fail">Thao tác thất bại (Không đủ Tiên thạch)!</div>
        <?php endif; ?>

        <div class="pet-list">
            <?php if (empty($pets)): ?>
                <div style="text-align: center; margin: 20px;">Ngươi chưa có sủng vật nào.</div>
            <?php else: ?>
                <?php foreach ($pets as $pet): ?>
                    <?php 
                        $q = $qualities[$pet->cwpz] ?? $qualities[0];
                        $isActive = ($pet->cwid == $currentPetId);
                    ?>
                    <div class="pet-item">
                        [<span style="color: <?php echo $q['color']; ?>"><?php echo $q['name']; ?></span>]
                        <a href="?cmd=chongwu&action=info&cwid=<?php echo $pet->cwid; ?>&sid=<?php echo $sid; ?>" style="color: <?php echo $q['color']; ?>; font-weight: bold;">
                            <?php echo htmlspecialchars($pet->cwname); ?>
                        </a>
                        
                        <span class="pet-actions">
                            <?php if ($isActive): ?>
                                <span class="pet-active">(Đã xuất chiến)</span>
                                <a href="?cmd=chongwu&action=recall&sid=<?php echo $sid; ?>">Thu hồi</a>
                            <?php else: ?>
                                <a href="?cmd=chongwu&action=deploy&cwid=<?php echo $pet->cwid; ?>&sid=<?php echo $sid; ?>">Xuất chiến</a>
                                <a href="?cmd=chongwu&action=release&cwid=<?php echo $pet->cwid; ?>&sid=<?php echo $sid; ?>" onclick="return confirm('Ngươi chắc chắn muốn phóng sinh sủng vật này?');">Phóng sinh</a>
                            <?php endif; ?>
                        </span>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <div class="draw-section">
            <?php if ($showConfirm): ?>
                <div class="confirm-box">
                    <p>Xác nhận rút sủng vật (Tiêu hao 50 Tiên thạch)?</p>
                    <a href="?cmd=chongwu&action=draw&sid=<?php echo $sid; ?>" style="color: red; font-weight: bold; margin-right: 10px;">Xác nhận</a>
                    <a href="?cmd=chongwu&sid=<?php echo $sid; ?>">Hủy bỏ</a>
                </div>
            <?php else: ?>
                <a href="?cmd=chongwu&action=confirm_draw&sid=<?php echo $sid; ?>" class="draw-btn">Rút sủng vật [50 Tiên thạch]</a>
            <?php endif; ?>
        </div>

        <div style="margin-top: 20px;">
            <a href="game.php">Trở về trò chơi</a>
        </div>
    </div>
</body>
</html>