<?php
$boss = $data['boss'];
$sid = $_GET['sid'];
$backLink = $encoder->encode("cmd=gomid&newmid={$player->nowmid}&sid=$sid");
?>
<div class="boss-escaped">
    <h3>Boss Escaped!</h3>
    <p><?= $boss->bossname ?> has already been defeated or escaped.</p>
    <p>It has grown stronger and is waiting for the next challenge.</p>
    
    <a href="?cmd=<?= $backLink ?>">Return to Map</a>
</div>
