<?php
// Variables: $player, $boss, $sid, $encode, $combatLog, $nowmid, $potions
$pvbgj = $encode->encode("cmd=pvbgj&bossid={$boss->bossid}&sid=$sid&nowmid=$nowmid");
$gonowmid = $encode->encode("cmd=gomid&newmid=$nowmid&sid=$sid");
?>
<IMG width='280' height='140' src='./images/boss.png' style="border-radius: 8px;">
<br/>
<?php echo $combatLog; ?>
<br/>
Boss: <?php echo $boss->bossname; ?> (Lv <?php echo $boss->bosslv; ?>)<br/>
HP: <?php echo $boss->bosshp; ?> / <?php echo $boss->bossmaxhp; ?><br/>
<br/>
Player: <?php echo $player->uname; ?> (Lv <?php echo $player->ulv; ?>)<br/>
HP: <?php echo $player->uhp; ?> / <?php echo $player->umaxhp; ?><br/>
<br/>
<a href="?cmd=<?php echo $pvbgj; ?>">Tấn công</a><br/>

<?php foreach (['yp1', 'yp2', 'yp3'] as $slot): ?>
    <?php if (isset($potions[$slot])): ?>
        <?php 
            $p = $potions[$slot];
            $useyp = $encode->encode("cmd=pvb&bossid={$boss->bossid}&sid=$sid&nowmid=$nowmid&canshu=useyp&ypid={$player->$slot}");
        ?>
        <a href="?cmd=<?php echo $useyp; ?>"><?php echo $p->ypname; ?>(<?php echo $p->ypsum; ?>)</a>
    <?php else: ?>
        Dược phẩm <?php echo substr($slot, -1); ?>
    <?php endif; ?>
<?php endforeach; ?>
<br/>
<a href="?cmd=<?php echo $gonowmid; ?>">Chạy trốn</a>
