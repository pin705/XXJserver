<?php
$member = $data['member'];
$sid = $data['sid'];

$myRank = $member->uclv;
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Môn Phái - Tu Tiên Giới</title>
    <link rel="stylesheet" href="/css/gamecss.css">
    <style>
        .manage-container {
            padding: 10px;
        }
        .role-link {
            display: block;
            margin-bottom: 5px;
            padding: 5px;
            background: #f0f0f0;
            text-decoration: none;
            color: #333;
            border: 1px solid #ccc;
        }
    </style>
</head>
<body>
    <div class="manage-container">
        <h3>Bổ nhiệm chức vụ</h3>
        
        <?php if ($myRank == 1): ?>
            <a href="?cmd=club&action=manage&zhiwei=2&sid=<?php echo $sid; ?>" class="role-link">Nhậm chức Phó chưởng môn</a>
        <?php endif; ?>
        
        <?php if ($myRank <= 2): ?>
            <a href="?cmd=club&action=manage&zhiwei=3&sid=<?php echo $sid; ?>" class="role-link">Nhậm chức Trưởng lão</a>
            <a href="?cmd=club&action=manage&zhiwei=4&sid=<?php echo $sid; ?>" class="role-link">Nhậm chức Chấp sự</a>
            <a href="?cmd=club&action=manage&zhiwei=5&sid=<?php echo $sid; ?>" class="role-link">Nhậm chức Tinh anh</a>
            <a href="?cmd=club&action=manage&zhiwei=6&sid=<?php echo $sid; ?>" class="role-link">Nhậm chức Đệ tử</a>
        <?php endif; ?>

        <div style="margin-top: 20px;">
            <a href="?cmd=club&sid=<?php echo $sid; ?>" style="background-color: #cff3d2; padding: 5px; border-radius: 3px; text-decoration: none;">Trở lại</a>
        </div>
    </div>
</body>
</html>