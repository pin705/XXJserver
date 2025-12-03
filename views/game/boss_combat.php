<?php
$boss = $data['boss'];
$player = $data['player'];
$combatLog = $data['combatLog'];
$msg = $data['msg'];
$potions = $data['potions'];
$skills = $data['skills'];

$sid = $_GET['sid'];
$attackLink = $encoder->encode("cmd=pvbgj&bossid={$boss->bossid}&sid=$sid");
$backLink = $encoder->encode("cmd=gomid&newmid={$player->nowmid}&sid=$sid");
?>
<div class="boss-combat">
    <h3>Fighting: <?= $boss->bossname ?> (Lv. <?= $boss->bosslv ?>)</h3>
    
    <div class="status-bars">
        <div class="boss-status">
            <p>Boss HP: <?= $boss->bosshp ?> / <?= $boss->bossmaxhp ?></p>
            <div class="hp-bar" style="width: 200px; background: #ccc; border: 1px solid #000;">
                <div style="width: <?= ($boss->bosshp / $boss->bossmaxhp) * 100 ?>%; background: red; height: 10px;"></div>
            </div>
        </div>
        
        <div class="player-status">
            <p><?= $player->uname ?> HP: <?= $player->uhp ?> / <?= $player->umaxhp ?></p>
            <div class="hp-bar" style="width: 200px; background: #ccc; border: 1px solid #000;">
                <div style="width: <?= ($player->uhp / $player->umaxhp) * 100 ?>%; background: green; height: 10px;"></div>
            </div>
        </div>
    </div>

    <?php if ($msg): ?>
        <div class="message" style="color: blue;"><?= $msg ?></div>
    <?php endif; ?>

    <div class="combat-log" style="border: 1px solid #eee; padding: 10px; margin: 10px 0; max-height: 200px; overflow-y: auto;">
        <?php foreach ($combatLog as $log): ?>
            <p><?= $log ?></p>
        <?php endforeach; ?>
    </div>

    <div class="actions">
        <a href="?cmd=<?= $attackLink ?>" class="btn-attack">Attack</a>
        
        <div class="potions">
            <h4>Potions:</h4>
            <?php foreach ($potions as $slot => $potion): ?>
                <?php 
                    $useLink = $encoder->encode("cmd=pvbgj&bossid={$boss->bossid}&sid=$sid&canshu=useyp&ypid={$potion['ypid']}");
                ?>
                <a href="?cmd=<?= $useLink ?>"><?= $potion['ypname'] ?> (<?= $potion['ypsum'] ?>)</a> 
            <?php endforeach; ?>
        </div>
        
        <div class="skills">
            <h4>Skills:</h4>
            <?php foreach ($skills as $skill): ?>
                <?php 
                    // Assuming skills can be used in boss fight similarly
                    $useLink = $encoder->encode("cmd=pvbgj&bossid={$boss->bossid}&sid=$sid&canshu=usejn&jnid={$skill['jnid']}");
                ?>
                <a href="?cmd=<?= $useLink ?>"><?= $skill['jnname'] ?></a> 
            <?php endforeach; ?>
        </div>
        
        <br>
        <a href="?cmd=<?= $backLink ?>">Run Away</a>
    </div>
</div>
