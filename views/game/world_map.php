<div class="main">
    <h3>Bản đồ thế giới</h3>
    <hr>
    <?php foreach ($regions as $region): ?>
        <a href="?cmd=<?= $encoder->encode("cmd=qydt&qyid={$region->qyid}&sid={$sid}") ?>"><?= $region->qyname ?></a><br/>
    <?php endforeach; ?>
    <hr>
    <a href="?cmd=<?= $encoder->encode("cmd=gomid&newmid={$player->nowmid}&sid={$sid}") ?>">Trở về</a>
</div>
