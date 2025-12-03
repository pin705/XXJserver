<?php
$boss = $data['boss'];
$drops = $data['drops'];
$sid = $_GET['sid'];
$backLink = $encoder->encode("cmd=gomid&newmid={$player->nowmid}&sid=$sid");
?>
<div class="boss-win">
    <h3>Chiến thắng!</h3>
    <p>Bạn đã đánh bại <?= $boss->bossname ?>!</p>
    
    <div class="rewards">
        <h4>Phần thưởng:</h4>
        <ul>
            <?php foreach ($drops as $drop): ?>
                <li><?= $drop ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
    
    <p>Boss đã trở nên mạnh mẽ hơn...</p>
    
    <a href="?cmd=<?= $backLink ?>">Quay lại bản đồ</a>
</div>

