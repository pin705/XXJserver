<?php
$encode = new \XXJ\Classes\Encode();
// Revive at town or same map? Usually town.
// For now, just go back to map (assuming revived)
$gonowmid = $encode->encode("cmd=gomid&newmid={$player->nowmid}&sid={$player->sid}");
?>

<h3>Thất bại...</h3>

<div style="color: red;">
    Bạn đã bị <b><?php echo $monster->gname; ?></b> đánh bại!
</div>
<br/>

<div style="border: 1px dashed #999; padding: 5px; background: #f9f9f9;">
    <?php echo $combatLog; ?>
</div>
<br/>

<a href="?cmd=<?php echo $gonowmid; ?>">Hồi sinh về thành</a>
