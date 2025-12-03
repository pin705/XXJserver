<?php
/**
 * @var object $playerTask
 * @var \XXJ\Models\Task $task
 * @var string $targetName
 * @var \XXJ\Models\Player $player
 */
$encoder = new \XXJ\Utils\Encoder();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title><?= $task->rwname ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <link rel="stylesheet" href="css/gamecss.css">
</head>
<body>
<div class="main">
    <div class="header">
        <?= $task->rwname ?>
    </div>
    
    <div class="content">
        <p><?= $task->rwinfo ?></p>
        
        <p>Yêu cầu: <?= $targetName ?></p>
        <p>Tiến độ: <?= $playerTask->rwnowcount ?> / <?= $task->rwcount ?></p>
        
        <?php if ($task->rwqy): ?>
            <?php $teleLink = $encoder->encode("cmd=taskteleport&rwid={$task->rwid}"); ?>
            <a href="?cmd=<?= $teleLink ?>">Dịch chuyển tới mục tiêu (Phí: <?= round($player->ulv * 12 + 500) ?> linh thạch)</a><br/>
        <?php endif; ?>

        <br/>
        <?php if ($playerTask->rwzt == 2): ?>
            <p style="color: green">Đã hoàn thành! Hãy đến gặp NPC để trả nhiệm vụ.</p>
        <?php else: ?>
            <p style="color: yellow">Đang thực hiện...</p>
        <?php endif; ?>
        
        <br/>
        <a href="?cmd=<?= $encoder->encode("cmd=mytask") ?>">Danh sách nhiệm vụ</a><br/>
        <a href="?cmd=<?= $encoder->encode("cmd=gomid&newmid={$player->nowmid}") ?>">Trở về</a>
    </div>
</div>
</body>
</html>
