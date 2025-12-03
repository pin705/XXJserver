<?php
$encode = new \XXJ\Classes\Encode();
$gonowmid = $encode->encode("cmd=gomid&newmid={$player->nowmid}&sid={$player->sid}");

// Interaction Links
$acceptLink = $encode->encode("cmd=task&nid=$nid&canshu=jieshou&rwid={$task->rwid}&sid={$player->sid}");
$submitLink = $encode->encode("cmd=task&nid=$nid&canshu=tijiao&rwid={$task->rwid}&sid={$player->sid}");
?>

<?php if ($message): ?>
    <div style="color: red;"><?php echo $message; ?></div>
<?php endif; ?>

【<?php echo $task->rwname; ?>】:<br/>
<?php echo $task->rwinfo; ?><br/>

<?php
// Task Requirement Description
$reqHtml = '';
switch ($task->rwzl) {
    case 1: // Collect
        $reqHtml = "Thu thập {$task->rwcount} {$targetName}"; 
        break;
    case 2: // Kill
        $reqHtml = "Đánh giết {$task->rwcount} {$targetName}";
        break;
    case 3: // Talk
        $reqHtml = "Đi tìm {$targetName}";
        break;
}
echo $reqHtml . "<br/>";
?>

Nhiệm vụ ban thưởng：<br/>
<?php foreach ($rewards as $reward): ?>
    <?php echo $reward; ?><br/>
<?php endforeach; ?>

<?php
// Status / Actions
if ($playerTask) {
    if ($playerTask->rwzl != 3) {
        echo "Tiến độ: {$playerTask->rwnowcount}/{$playerTask->rwcount}<br/>";
        if ($playerTask->rwnowcount >= $playerTask->rwcount) {
             echo "<a href='?cmd={$submitLink}'>Đưa ra (Hoàn thành)</a>";
        } else {
             echo "Đang thực hiện...";
        }
    } elseif ($playerTask->rwcount == $nid) {
        // Dialogue task, target NPC matches current NPC
        echo "<a href='?cmd={$submitLink}'>Đưa ra (Hoàn thành)</a>";
    } else {
        echo "Đang thực hiện...";
    }
} else {
    echo "<a href='?cmd={$acceptLink}'>Tiếp nhận</a>";
}
?>

<br/>
<a href="?cmd=<?php echo $gonowmid; ?>" style="float:right;">Rời đi</a>
