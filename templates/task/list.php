<?php
/**
 * @var array $tasks
 * @var \XXJ\Models\Player $player
 */
$encoder = new \XXJ\Utils\Encoder();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Nhiệm vụ</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <link rel="stylesheet" href="css/gamecss.css">
</head>
<body>
<div class="main">
    <div class="header">
        Nhiệm vụ của bạn
    </div>
    
    <div class="content">
        <?php if (empty($tasks)): ?>
            <p>Hiện không có nhiệm vụ nào đang thực hiện.</p>
        <?php else: ?>
            <?php foreach ($tasks as $pt): ?>
                <div class="task-item">
                    <?php 
                        $status = '';
                        if ($pt->rwzt == 1) $status = '(Đang làm)';
                        elseif ($pt->rwzt == 2) $status = '(Hoàn thành)';
                        
                        $link = $encoder->encode("cmd=mytaskinfo&rwid={$pt->rwid}");
                    ?>
                    <a href="?cmd=<?= $link ?>"><?= $pt->rwname ?> <?= $status ?></a><br/>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
        
        <br/>
        <a href="?cmd=<?= $encoder->encode("cmd=gomid&newmid={$player->nowmid}") ?>">Trở về</a>
    </div>
</div>
</body>
</html>
