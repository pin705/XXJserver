<?php
$boss = $data['boss'];
$sid = $_GET['sid'];
$backLink = $encoder->encode("cmd=gomid&newmid={$player->nowmid}&sid=$sid");
?>
<div class="boss-lose">
    <h3>Thất bại!</h3>
    <p>Bạn đã bị đánh bại bởi <?= $boss->bossname ?>.</p>
    <p>Bạn cần hồi phục trước khi có thể chiến đấu lại.</p>
    
    <a href="?cmd=<?= $backLink ?>">Quay lại bản đồ</a>
</div>

