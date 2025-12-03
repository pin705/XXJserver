<?php
$tasks = $data['tasks'];
$player = $data['player'];
$sid = $_GET['sid'];
$backLink = $encoder->encode("cmd=gomid&newmid={$player->nowmid}&sid=$sid");
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nhiệm vụ của tôi</title>
    <link rel="stylesheet" href="css/gamecss.css">
</head>
<body>
    <div class="container">
        <h3>Nhiệm vụ của tôi</h3>
        
        <?php if (empty($tasks)): ?>
            <p>Hiện không có nhiệm vụ nào.</p>
        <?php else: ?>
            <ul class="task-list">
                <?php foreach ($tasks as $pt): ?>
                    <?php 
                        $detailLink = $encoder->encode("cmd=task&rwid={$pt->rwid}&sid=$sid");
                        $status = '';
                        if ($pt->rwzt == 1) $status = '(Đang làm)';
                        elseif ($pt->rwzt == 2) $status = '(Hoàn thành)';
                        elseif ($pt->rwzt == 3) $status = '(Đã xong)';
                    ?>
                    <li>
                        <a href="?cmd=<?= $detailLink ?>">
                            <?= $pt->rwname ?> <?= $status ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <hr>
        <a href="?cmd=<?= $backLink ?>" class="btn">Trở về trò chơi</a>
    </div>
</body>
</html>
