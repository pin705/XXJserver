<?php
$encode = new \XXJ\Classes\Encode();
$gonowmid = $encode->encode("cmd=gomid&newmid={$player->nowmid}&sid={$player->sid}");
?>

<?php echo $task->rwname; ?>:<br/>

<?php
// Task Progress
$progressHtml = '';
switch ($task->rwzl) {
    case 1: // Collect
        $progressHtml = "Thu thập {$task->rwcount} {$targetName}<br/>Tiến độ: {$playerTask->rwnowcount}/{$task->rwcount}";
        break;
    case 2: // Kill
        $progressHtml = "Đánh giết {$task->rwcount} {$targetName}<br/>Tiến độ: {$playerTask->rwnowcount}/{$task->rwcount}";
        break;
    case 3: // Talk
        $progressHtml = "Đi tìm {$targetName}";
        break;
}
echo $progressHtml . "<br/>";
?>

Nhiệm vụ ban thưởng：<br/>
<?php foreach ($rewards as $reward): ?>
    <?php if ($reward['type'] == 'item'): ?>
        <?php $link = $encode->encode("cmd=djinfo&djid={$reward['id']}&sid={$player->sid}"); ?>
        <div class='djys'><a href='?cmd=<?php echo $link; ?>'><?php echo $reward['name']; ?></a> x<?php echo $reward['count']; ?></div>
    <?php elseif ($reward['type'] == 'potion'): ?>
        <?php $link = $encode->encode("cmd=ypinfo&ypid={$reward['id']}&sid={$player->sid}"); ?>
        <div class='ypys'><a href='?cmd=<?php echo $link; ?>'><?php echo $reward['name']; ?></a> x<?php echo $reward['count']; ?></div>
    <?php elseif ($reward['type'] == 'equip'): ?>
        <?php $link = $encode->encode("cmd=zbinfo_sys&zbid={$reward['id']}&sid={$player->sid}"); ?>
        <div class='zbys'><a href='?cmd=<?php echo $link; ?>'><?php echo $reward['name']; ?></a></div>
    <?php elseif ($reward['type'] == 'exp'): ?>
        Kinh nghiệm: <?php echo $reward['value']; ?><br/>
    <?php elseif ($reward['type'] == 'yxb'): ?>
        Linh thạch: <?php echo $reward['value']; ?><br/>
    <?php endif; ?>
<?php endforeach; ?>

<?php
// Teleport Link
if ($player->uyxb >= $teleportCost) {
    $teleportLink = $encode->encode("cmd=taskteleport&rwid={$task->rwid}&sid={$player->sid}");
    echo "<a href='?cmd={$teleportLink}'>Truyền tống [{$teleportCost}]</a><br>";
} else {
    echo "<font color='#12e271'>【Truyền tống quan bế】</font>Nghĩ bạch chơi? Không đủ: {$teleportCost}<hr>";
}
?>

<br/>
<a href="#" onClick="javascript:history.back(-1);">Trở lại</a><br/>
<a href="?cmd=<?php echo $gonowmid; ?>">Trở về trò chơi</a>
