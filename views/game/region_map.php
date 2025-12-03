<div class="main">
    <h3>Bản đồ khu vực</h3>
    <hr>
    <?php if (empty($maps)): ?>
        <p>Không có bản đồ nào trong khu vực này.</p>
    <?php else: ?>
        <?php foreach ($maps as $map): ?>
            <?php 
                $style = ($map->mid == $currentMap->mid) ? 'style="color:red;font-weight:bold;"' : '';
                $link = $encoder->encode("cmd=gomid&newmid={$map->mid}&sid={$sid}");
            ?>
            <a href="?cmd=<?= $link ?>" <?= $style ?>><?= $map->mname ?></a>
            <?php if ($map->mid == $currentMap->mid): ?> (Hiện tại) <?php endif; ?>
            <br/>
        <?php endforeach; ?>
    <?php endif; ?>
    <hr>
    <a href="?cmd=<?= $encoder->encode("cmd=gomid&newmid={$player->nowmid}&sid={$sid}") ?>">Trở về</a>
</div>
