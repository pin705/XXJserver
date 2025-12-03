<?php
// Template for task
// Variables: $player, $task, $playerTask, $message, $encoder, $sid, $nid
?>
<div class="title">Nhiệm vụ: <?= $task->rwname ?></div>
<br>
<?php if ($message): ?>
    <div style="color: blue;"><?= $message ?></div>
    <hr>
<?php endif; ?>

Nội dung: <?= $task->rwinfo ?><br>
<br>
Phần thưởng:<br>
Kinh nghiệm: <?= $task->rwexp ?><br>
Linh thạch: <?= $task->rwyxb ?><br>
<hr>

<?php if (!$playerTask): ?>
    <?php $acceptCmd = $encoder->encode("cmd=task&nid=$nid&canshu=jieshou&rwid=$task->id&sid=$sid"); ?>
    <a href="?cmd=<?= $acceptCmd ?>">Tiếp nhận nhiệm vụ</a>
<?php elseif ($playerTask->rwzt == 1): ?>
    Trạng thái: Đang thực hiện (<?= $playerTask->rwcount ?>/<?= $task->rwcount ?>)<br>
<?php elseif ($playerTask->rwzt == 2): ?>
    <?php $submitCmd = $encoder->encode("cmd=task&nid=$nid&canshu=tijiao&rwid=$task->id&sid=$sid"); ?>
    <a href="?cmd=<?= $submitCmd ?>">Trả nhiệm vụ</a>
<?php elseif ($playerTask->rwzt == 3): ?>
    Đã hoàn thành.
<?php endif; ?>

<br><br>
<?php $backCmd = $encoder->encode("cmd=gomid&newmid=$player->nowmid&sid=$sid"); ?>
<a href="?cmd=<?= $backCmd ?>">Trở về trò chơi</a>
