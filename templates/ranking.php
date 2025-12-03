<?php
/**
 * @var array $rankings
 * @var string $type
 * @var string $title
 * @var \XXJ\Models\Player $player
 */
$encoder = new \XXJ\Utils\Encoder();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <link rel="stylesheet" href="css/gamecss.css">
</head>
<body>
<div class="main">
    <div class="header">
        <?= $title ?>
    </div>
    
    <div class="content">
        <div align="center">
            <a href="?cmd=<?= $encoder->encode("cmd=paihang&type=level") ?>" <?= $type == 'level' ? 'style="color:red"' : '' ?>>Đẳng cấp</a> |
            <a href="?cmd=<?= $encoder->encode("cmd=paihang&type=attack") ?>" <?= $type == 'attack' ? 'style="color:red"' : '' ?>>Công kích</a> |
            <a href="?cmd=<?= $encoder->encode("cmd=paihang&type=defense") ?>" <?= $type == 'defense' ? 'style="color:red"' : '' ?>>Phòng ngự</a> |
            <a href="?cmd=<?= $encoder->encode("cmd=paihang&type=wealth") ?>" <?= $type == 'wealth' ? 'style="color:red"' : '' ?>>Tài phú</a>
        </div>
        <hr>

        <?php if (!empty($rankings)): ?>
            <?php foreach ($rankings as $index => $rank): ?>
                <div>
                    <?= $index + 1 ?>. 
                    <?php if (isset($rank->clubname) && $rank->clubname): ?>
                        [<?= $rank->clubname ?>]
                    <?php endif; ?>
                    <a href="?cmd=<?= $encoder->encode("cmd=getplayerinfo&uid={$rank->uid}") ?>"><?= $rank->uname ?></a>
                    
                    <?php if ($type == 'level'): ?>
                        (Lv.<?= $rank->ulv ?>)
                    <?php elseif ($type == 'attack'): ?>
                        (Công: <?= $rank->ugj ?>)
                    <?php elseif ($type == 'defense'): ?>
                        (Thủ: <?= $rank->ufy ?>)
                    <?php elseif ($type == 'wealth'): ?>
                        (Linh thạch: <?= $rank->uyxb ?>)
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Chưa có dữ liệu xếp hạng.</p>
        <?php endif; ?>
        
        <br>
        <a href="?cmd=<?= $encoder->encode("cmd=gomid&newmid={$player->nowmid}") ?>">Trở về bản đồ</a>
    </div>
</div>
</body>
</html>
