<?php
// Template for liaotian (Chat)
// Variables: $player, $messages, $ltlx, $encoder, $sid
?>
<div class="title">Trò chuyện</div>
<br>
<?php 
$allCmd = $encoder->encode("cmd=liaotian&ltlx=all&sid=$sid");
$imCmd = $encoder->encode("cmd=liaotian&ltlx=im&sid=$sid");
?>
【<a href="?cmd=<?= $allCmd ?>">Công cộng</a> | <a href="?cmd=<?= $imCmd ?>">Riêng</a>】
<div style='border: #dcd4a1; border-style: dashed; border-width: 1px; padding: 5px;'>
    <?php foreach ($messages as $msg): ?>
        <?php $uCmd = $encoder->encode("cmd=getplayerinfo&uid={$msg['uid']}&sid=$sid"); ?>
        <a href="?cmd=<?= $uCmd ?>"><?= $msg['name'] ?></a>: <?= $msg['msg'] ?><br>
    <?php endforeach; ?>
</div>

<form action="game.php" method="get">
    <input type="hidden" name="cmd" value="sendliaotian">
    <input type="hidden" name="ltlx" value="<?= $ltlx ?>">
    <input type="hidden" name="sid" value="<?= $sid ?>">
    <input type="text" name="ltmsg" maxlength="50">
    <input type="submit" value="Gửi đi">
    <a href="?cmd=<?= $allCmd ?>">Làm mới</a>
</form>

<br>
<?php $backCmd = $encoder->encode("cmd=gomid&newmid=$player->nowmid&sid=$sid"); ?>
<a href="?cmd=<?= $backCmd ?>">Trở về trò chơi</a>
