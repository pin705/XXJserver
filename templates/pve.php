<?php
// Template for pve (Combat)
// Variables: $player, $monster, $combatLog, $encoder, $sid
?>
<div class="title">Chiến đấu: <?= $monster->gname ?></div>
<br>
<?php if ($combatLog): ?>
    <div class="log" style="color: red;"><?= $combatLog ?></div>
    <hr>
<?php endif; ?>

<?php if ($monster->ghp <= 0): ?>
    <font color="red">Chiến thắng!</font><br>
    <?php $backCmd = $encoder->encode("cmd=gomid&newmid=$player->nowmid&sid=$sid"); ?>
    <a href="?cmd=<?= $backCmd ?>">Trở về</a>
<?php else: ?>
    <!-- Monster Status -->
    Quái vật: <?= $monster->gname ?><br>
    HP: <?= $monster->ghp ?>/<?= $monster->gmaxhp ?><br>
    Level: <?= $monster->glv ?><br>
    <hr>
    
    <!-- Player Status -->
    Nhân vật: <?= $player->uname ?><br>
    HP: <?= $player->uhp ?>/<?= $player->umaxhp ?><br>
    <hr>

    <!-- Actions -->
    <?php $attackCmd = $encoder->encode("cmd=pvegj&gid=$monster->id&sid=$sid"); ?>
    <a href="?cmd=<?= $attackCmd ?>">Tấn công thường</a><br>
    
    <!-- Skills (Placeholder) -->
    <!-- <a href="#">Kỹ năng 1</a><br> -->

    <!-- Items (Placeholder) -->
    <!-- <a href="#">Dùng thuốc</a><br> -->

    <br>
    <?php $runCmd = $encoder->encode("cmd=gomid&newmid=$player->nowmid&sid=$sid"); ?>
    <a href="?cmd=<?= $runCmd ?>">Chạy trốn</a>
<?php endif; ?>
