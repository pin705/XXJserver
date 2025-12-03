<?php
$task = $data['task'];
$playerTask = $data['playerTask'];
$msg = $data['msg'];
$sid = $_GET['sid'];
$backLink = $encoder->encode("cmd=gomid&newmid={$player->nowmid}&sid=$sid");

// Determine actions
$acceptLink = $encoder->encode("cmd=task&rwid={$task->rwid}&sid=$sid&canshu=jieshou");
$submitLink = $encoder->encode("cmd=task&rwid={$task->rwid}&sid=$sid&canshu=tijiao");
?>
<div class="task-detail">
    <h3><?= $task->rwname ?></h3>
    <p><?= $task->rwinfo ?? 'Không có mô tả.' ?></p>
    
    <?php if ($msg): ?>
        <p style="color: blue;"><?= $msg ?></p>
    <?php endif; ?>

    <div class="rewards">
        <h4>Phần thưởng:</h4>
        <p>Kinh nghiệm: <?= $task->rwexp ?></p>
        <p>Linh thạch: <?= $task->rwyxb ?></p>
    </div>

    <div class="actions">
        <?php if (!$playerTask): ?>
            <a href="?cmd=<?= $acceptLink ?>">Nhận nhiệm vụ</a>
        <?php elseif ($playerTask->rwzt == 1): ?>
            <p>Trạng thái: Đang thực hiện (<?= $playerTask->rwnowcount ?>/<?= $task->rwcount ?>)</p>
        <?php elseif ($playerTask->rwzt == 2): ?>
            <p>Trạng thái: Hoàn thành!</p>
            <a href="?cmd=<?= $submitLink ?>">Trả nhiệm vụ</a>
        <?php elseif ($playerTask->rwzt == 3): ?>
            <p>Trạng thái: Đã xong</p>
        <?php endif; ?>
        
        <br><br>
        <a href="?cmd=<?= $backLink ?>">Quay lại</a>
    </div>
</div>

