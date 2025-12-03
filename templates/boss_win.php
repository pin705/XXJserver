<?php
$gonowmid = $encode->encode("cmd=gomid&newmid=$nowmid&sid=$sid");
?>
<IMG width='280' height='140' src='./images/boss.png' style="border-radius: 8px;">
<br/>
Bạn đã đánh bại <?php echo $boss->bossname; ?>!<br/>
<br/>
Nhận được:<br/>
<?php foreach ($drops as $drop): ?>
    <?php echo $drop; ?><br/>
<?php endforeach; ?>
<br/>
<a href="?cmd=<?php echo $gonowmid; ?>">Trở về trò chơi</a>
