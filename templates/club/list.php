<?php
/**
 * @var \XXJ\Models\Club[] $clubs
 * @var \XXJ\Models\Player $player
 */
$encoder = new \XXJ\Utils\Encoder();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Danh sách môn phái</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <link rel="stylesheet" href="css/gamecss.css">
</head>
<body>
<div class="main">
    <div class="header">
        Thiên Bảng (Danh sách môn phái)
    </div>
    
    <div class="content">
        <div align="center">
            <img src="./images/menpai.png" width="280" height="140" style="border-radius: 8px;">
        </div>
        <br>
        
        <div align="center">
            <a href="?cmd=<?= $encoder->encode("cmd=club&action=create") ?>">Tạo môn phái mới</a>
        </div>
        <hr>

        <?php if (!empty($clubs)): ?>
            <?php foreach ($clubs as $index => $club): ?>
                <div>
                    [<?= $index + 1 ?>] <a href="?cmd=<?= $encoder->encode("cmd=club&clubid={$club->clubid}") ?>"><?= $club->clubname ?></a> (Lv.<?= $club->clublv ?>)
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Chưa có môn phái nào được thành lập.</p>
        <?php endif; ?>
        
        <br>
        <a href="?cmd=<?= $encoder->encode("cmd=gomid&newmid={$player->nowmid}") ?>">Trở về bản đồ</a>
    </div>
</div>
</body>
</html>
