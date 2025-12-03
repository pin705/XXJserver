<?php
$boss = $data['boss'];
$sid = $_GET['sid'];
$backLink = $encoder->encode("cmd=gomid&newmid={$player->nowmid}&sid=$sid");
?>
<div class="boss-escaped">
    <h3>Boss đã bỏ chạy!</h3>
    <p><?= $boss->bossname ?> đã bị đánh bại hoặc bỏ chạy.</p>
    <p>Nó đã trở nên mạnh mẽ hơn và đang chờ đợi thử thách tiếp theo.</p>
    
    <a href="?cmd=<?= $backLink ?>">Quay lại bản đồ</a>
</div>

