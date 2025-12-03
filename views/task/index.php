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
    <p><?= $task->rwinfo ?? 'No description.' ?></p>
    
    <?php if ($msg): ?>
        <p style="color: blue;"><?= $msg ?></p>
    <?php endif; ?>

    <div class="rewards">
        <h4>Rewards:</h4>
        <p>Exp: <?= $task->rwexp ?></p>
        <p>Spirit Stones: <?= $task->rwyxb ?></p>
    </div>

    <div class="actions">
        <?php if (!$playerTask): ?>
            <a href="?cmd=<?= $acceptLink ?>">Accept Task</a>
        <?php elseif ($playerTask->rwzt == 1): ?>
            <p>Status: In Progress (<?= $playerTask->rwnowcount ?>/<?= $task->rwcount ?>)</p>
        <?php elseif ($playerTask->rwzt == 2): ?>
            <p>Status: Completed!</p>
            <a href="?cmd=<?= $submitLink ?>">Submit Task</a>
        <?php elseif ($playerTask->rwzt == 3): ?>
            <p>Status: Finished</p>
        <?php endif; ?>
        
        <br><br>
        <a href="?cmd=<?= $backLink ?>">Return</a>
    </div>
</div>
