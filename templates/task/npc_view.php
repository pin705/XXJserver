<?php
/**
 * @var \XXJ\Models\Task $task
 * @var object|null $playerTask
 * @var string $message
 * @var array $rewards
 * @var int $nid
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
        <?php if ($message): ?>
            <div style="color: red; border: 1px solid red; padding: 5px; margin-bottom: 10px;">
                <?= $message ?>
            </div>
        <?php endif; ?>

        <p><?= $task->rwinfo ?></p>
        
        <p><strong>Phần thưởng:</strong></p>
        <ul>
            <?php foreach ($rewards as $reward): ?>
                <li><?= $reward ?></li>
            <?php endforeach; ?>
        </ul>

        <hr/>
        
        <?php if (!$playerTask): ?>
            <!-- Not accepted yet -->
            <?php $acceptLink = $encoder->encode("cmd=npctask&rwid={$task->rwid}&nid={$nid}&canshu=jieshou"); ?>
            <a href="?cmd=<?= $acceptLink ?>">Tiếp nhận nhiệm vụ</a>
        <?php elseif ($playerTask->rwzt == 1): ?>
            <!-- In progress -->
            <p>Đang thực hiện: <?= $playerTask->rwnowcount ?> / <?= $task->rwcount ?></p>
            <p>Hãy hoàn thành yêu cầu rồi quay lại đây.</p>
        <?php elseif ($playerTask->rwzt == 2): ?>
            <!-- Ready to submit -->
            <?php $submitLink = $encoder->encode("cmd=npctask&rwid={$task->rwid}&nid={$nid}&canshu=tijiao"); ?>
            <a href="?cmd=<?= $submitLink ?>">Hoàn thành nhiệm vụ</a>
        <?php elseif ($playerTask->rwzt == 3): ?>
             <p>Bạn đã hoàn thành nhiệm vụ này.</p>
        <?php endif; ?>

        <br/><br/>
        <a href="?cmd=<?= $encoder->encode("cmd=npc&nid={$nid}") ?>">Quay lại NPC</a><br/>
        <a href="?cmd=<?= $encoder->encode("cmd=gomid&newmid={$player->nowmid}") ?>">Trở về bản đồ</a>
    </div>
</div>
</body>
</html>
