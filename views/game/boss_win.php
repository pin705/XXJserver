<?php
$boss = $data['boss'];
$drops = $data['drops'];
$sid = $_GET['sid'];
$backLink = $encoder->encode("cmd=gomid&newmid={$player->nowmid}&sid=$sid");
?>
<div class="boss-win">
    <h3>Victory!</h3>
    <p>You have defeated <?= $boss->bossname ?>!</p>
    
    <div class="rewards">
        <h4>Rewards:</h4>
        <ul>
            <?php foreach ($drops as $drop): ?>
                <li><?= $drop ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
    
    <p>The boss has grown stronger...</p>
    
    <a href="?cmd=<?= $backLink ?>">Return to Map</a>
</div>
