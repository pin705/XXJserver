<?php
$pet = $data['pet'];
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

$q = $qualities[$pet->cwpz] ?? $qualities[0];
$qualityBonus = $pet->cwpz * 10;
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông Tin Sủng Vật - Tu Tiên Giới</title>
    <link rel="stylesheet" href="/css/gamecss.css">
    <style>
        .pet-info-container {
            padding: 10px;
        }
        .menu-links {
            margin-bottom: 10px;
            padding: 5px;
            background: #f0f0f0;
            border-radius: 5px;
        }
        .menu-links a {
            margin-right: 10px;
            text-decoration: none;
            font-weight: bold;
        }
        .stat-box {
            border: 1px solid #ccc;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 10px;
        }
        .stat-row {
            margin-bottom: 5px;
        }
        .rename-form {
            margin-top: 10px;
            padding-top: 10px;
            border-top: 1px dashed #ccc;
        }
    </style>
</head>
<body>
    <div class="pet-info-container">
        <div class="menu-links">
            <a href="?cmd=zhuangtai&sid=<?php echo $sid; ?>">Nhân vật</a>
            <a href="?cmd=chongwu&sid=<?php echo $sid; ?>" style="color: #9c27b0;">Sủng vật</a>
            <a href="?cmd=taozhuang&sid=<?php echo $sid; ?>">Thần trang</a>
        </div>

        <div class="stat-box">
            <div class="stat-row">Tên: <strong>[<?php echo htmlspecialchars($pet->cwname); ?>]</strong></div>
            <div class="stat-row">Đẳng cấp: <?php echo $pet->cwlv; ?></div>
            <div class="stat-row">Phẩm chất: <span style="color: <?php echo $q['color']; ?>"><?php echo $q['name']; ?></span></div>
            <div class="stat-row">Kinh nghiệm: <?php echo $pet->cwexp; ?>/<?php echo $pet->cwmaxexp; ?></div>
            <div class="stat-row">Khí huyết: <?php echo $pet->cwhp; ?>/<?php echo $pet->cwmaxhp; ?></div>
            <div class="stat-row">Công kích: <?php echo $pet->cwgj; ?></div>
            <div class="stat-row">Phòng ngự: <?php echo $pet->cwfy; ?></div>
            <div class="stat-row">Bạo kích: <?php echo $pet->cwbj; ?>%</div>
            <div class="stat-row">Hút máu: <?php echo $pet->cwxx; ?>%</div>
            <hr>
            <div class="stat-row">Khí huyết trưởng thành: <?php echo $pet->uphp; ?></div>
            <div class="stat-row">Công kích trưởng thành: <?php echo $pet->upgj; ?></div>
            <div class="stat-row">Phòng ngự trưởng thành: <?php echo $pet->upfy; ?></div>
            <div class="stat-row">
                Phẩm chất [<?php echo $q['name']; ?>] khi thăng cấp tăng thêm <?php echo $qualityBonus; ?>% chỉ số.
            </div>

            <div class="rename-form">
                <form action="?cmd=chongwu&action=rename&cwid=<?php echo $pet->cwid; ?>&sid=<?php echo $sid; ?>" method="POST">
                    <input type="text" name="newname" placeholder="Tên mới" maxlength="20" required>
                    <button type="submit">Đổi tên</button>
                </form>
            </div>
        </div>

        <div>
            <a href="?cmd=chongwu&sid=<?php echo $sid; ?>" style="background-color: #cff3d2; padding: 5px; border-radius: 3px; text-decoration: none;">Trở lại</a>
            <a href="game.php" style="float:right; background-color:#cff3d2; color: #755d5d; padding: 5px; border-radius: 3px; text-decoration: none;">Trở về trò chơi</a>
        </div>
    </div>
</body>
</html>