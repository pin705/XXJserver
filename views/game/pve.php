<?php
$encode = new \XXJ\Classes\Encode();
$gonowmid = $encode->encode("cmd=gomid&newmid={$player->nowmid}&sid={$player->sid}");
$attackLink = $encode->encode("cmd=pvegj&gid={$monster->id}&sid={$player->sid}");

// Calculate HP percentages
$monsterHpPercent = ($monster->gmaxhp > 0) ? round(($monster->ghp / $monster->gmaxhp) * 100) : 0;
$playerHpPercent = ($player->umaxhp > 0) ? round(($player->uhp / $player->umaxhp) * 100) : 0;
?>

<h3>Chiến đấu</h3>

<!-- Monster Status -->
<div>
    <b><?php echo $monster->gname; ?></b> (Lv<?php echo $monster->glv; ?>)<br/>
    HP: <?php echo $monster->ghp; ?> / <?php echo $monster->gmaxhp; ?>
    <div style="width: 200px; height: 10px; border: 1px solid #ccc; background: #eee;">
        <div style="width: <?php echo $monsterHpPercent; ?>%; height: 100%; background: red;"></div>
    </div>
</div>
<br/>

<!-- Player Status -->
<div>
    <b><?php echo $player->uname; ?></b> (Lv<?php echo $player->ulv; ?>)<br/>
    HP: <?php echo $player->uhp; ?> / <?php echo $player->umaxhp; ?>
    <div style="width: 200px; height: 10px; border: 1px solid #ccc; background: #eee;">
        <div style="width: <?php echo $playerHpPercent; ?>%; height: 100%; background: green;"></div>
    </div>
</div>
<br/>

<!-- Combat Log -->
<?php if (!empty($actionMessage)): ?>
    <div style="color: blue;"><?php echo $actionMessage; ?></div>
<?php endif; ?>

<?php if (!empty($combatLog)): ?>
    <div style="border: 1px dashed #999; padding: 5px; background: #f9f9f9;">
        <?php echo $combatLog; ?>
    </div>
    <br/>
<?php endif; ?>

<!-- Actions -->
<a href="?cmd=<?php echo $attackLink; ?>"><b>Công kích</b></a><br/>
<br/>

<!-- Quick Items (Potions) -->
Dược phẩm:<br/>
<?php if (!empty($potions)): ?>
    <?php foreach ($potions as $potion): ?>
        <?php 
        // Assuming potion object has id, name, count
        // Need to check structure of getPlayerPotions result
        // If it returns item objects:
        $useLink = $encode->encode("cmd=pve&canshu=useyp&ypid={$potion->ypid}&gid={$monster->id}&sid={$player->sid}");
        ?>
        <a href="?cmd=<?php echo $useLink; ?>"><?php echo $potion->ypname; ?> (<?php echo $potion->djsum; ?>)</a> 
    <?php endforeach; ?>
<?php else: ?>
    Không có dược phẩm.
<?php endif; ?>
<br/><br/>

<!-- Quick Skills -->
Kỹ năng:<br/>
<?php if (!empty($skills)): ?>
    <?php foreach ($skills as $skill): ?>
        <?php 
        $useSkillLink = $encode->encode("cmd=pvegj&canshu=usejn&jnid={$skill->jnid}&gid={$monster->id}&sid={$player->sid}");
        ?>
        <a href="?cmd=<?php echo $useSkillLink; ?>"><?php echo $skill->jnname; ?></a> 
    <?php endforeach; ?>
<?php else: ?>
    Chưa học kỹ năng.
<?php endif; ?>
<br/><br/>

<a href="?cmd=<?php echo $gonowmid; ?>">Chạy trốn</a>
