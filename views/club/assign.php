<?php
$candidates = $data['candidates'];
$zhiwei = $data['zhiwei'];
$sid = $data['sid'];

$roleNames = [
    2 => 'Phó chưởng môn',
    3 => 'Trưởng lão',
    4 => 'Chấp sự',
    5 => 'Tinh anh',
    6 => 'Đệ tử'
];
$targetRoleName = $roleNames[$zhiwei] ?? 'Chức vụ';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bổ Nhiệm <?php echo $targetRoleName; ?> - Tu Tiên Giới</title>
    <link rel="stylesheet" href="/css/gamecss.css">
    <style>
        .assign-container {
            padding: 10px;
        }
        .candidate-item {
            margin-bottom: 5px;
            padding: 5px;
            border-bottom: 1px dashed #ccc;
        }
    </style>
</head>
<body>
    <div class="assign-container">
        <h3>Chọn người nhậm chức: <?php echo $targetRoleName; ?></h3>
        
        <?php if (empty($candidates)): ?>
            <div>Không có thành viên nào phù hợp để bổ nhiệm.</div>
        <?php else: ?>
            <?php foreach ($candidates as $c): ?>
                <div class="candidate-item">
                    <a href="?cmd=club&action=assign_role&uid=<?php echo $c['uid']; ?>&zhiwei=<?php echo $zhiwei; ?>&sid=<?php echo $sid; ?>">
                        <?php echo htmlspecialchars($c['uname']); ?>
                    </a>
                    (Hiện tại: <?php echo $roleNames[$c['uclv']] ?? 'Đệ tử'; ?>)
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <div style="margin-top: 20px;">
            <a href="?cmd=club&action=manage&sid=<?php echo $sid; ?>" style="background-color: #cff3d2; padding: 5px; border-radius: 3px; text-decoration: none;">Trở lại</a>
        </div>
    </div>
</body>
</html>