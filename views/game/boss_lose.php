<?php
$boss = $data['boss'];
$sid = $_GET['sid'];
$backLink = $encoder->encode("cmd=gomid&newmid={$player->nowmid}&sid=$sid");
?>
<div class="boss-lose">
    <h3>Defeat!</h3>
    <p>You were defeated by <?= $boss->bossname ?>.</p>
    <p>You need to heal before you can fight again.</p>
    
    <a href="?cmd=<?= $backLink ?>">Return to Map</a>
</div>
