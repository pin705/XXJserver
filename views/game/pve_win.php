<?php
$encode = new \XXJ\Classes\Encode();
$gonowmid = $encode->encode("cmd=gomid&newmid={$player->nowmid}&sid={$player->sid}");
?>

<h3>Chiến thắng!</h3>

<div style="color: green;">
    Bạn đã đánh bại <b><?php echo $monster->gname; ?></b>!
</div>
<br/>

<div style="border: 1px dashed #999; padding: 5px; background: #f9f9f9;">
    <?php echo $combatLog; ?>
</div>
<br/>

<a href="?cmd=<?php echo $gonowmid; ?>">Trở về bản đồ</a>
