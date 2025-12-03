<?php
$boss = $data['boss'];
$drops = $data['drops'];
$sid = $_GET['sid'];
$fightLink = $encoder->encode("cmd=pvbgj&bossid={$boss->bossid}&sid=$sid");
$backLink = $encoder->encode("cmd=gomid&newmid={$player->nowmid}&sid=$sid");
?>
<div class="boss-info">
    <h3><?= $boss->bossname ?> (Lv. <?= $boss->bosslv ?>)</h3>
    <p><?= $boss->bossinfo ?></p>
    
    <div class="stats">
        <p>HP: <?= $boss->bosshp ?> / <?= $boss->bossmaxhp ?></p>
        <p>Attack: <?= $boss->bossgj ?></p>
        <p>Defense: <?= $boss->bossfy ?></p>
    </div>

    <div class="drops">
        <h4>Possible Drops:</h4>
        <ul>
            <?php foreach ($drops as $drop): ?>
                <li>
                    <?php if ($drop['type'] == 'zb'): ?>
                        <span style="color: <?= $drop['item']->zbys ?? 'black' ?>"><?= $drop['item']->zbname ?></span>
                    <?php elseif ($drop['type'] == 'dj'): ?>
                        <?= $drop['item']->djname ?>
                    <?php elseif ($drop['type'] == 'yp'): ?>
                        <?= $drop['item']->ypname ?>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <div class="actions">
        <a href="?cmd=<?= $fightLink ?>">Fight!</a><br>
        <a href="?cmd=<?= $backLink ?>">Return</a>
    </div>
</div>
