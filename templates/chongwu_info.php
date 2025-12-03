<?php
/**
 * @var \XXJ\Models\Pet $pet
 * @var \XXJ\Models\Player $player
 */
$encoder = new \XXJ\Utils\Encoder();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thông tin sủng vật</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <link rel="stylesheet" href="css/gamecss.css">
</head>
<body>
<div class="main">
    <div class="header">
        Thông tin sủng vật
    </div>
    
    <div class="content">
        <div style="border: 1px solid #ccc; padding: 10px;">
            <h3 style="color: <?= $pet->getQualityColor() ?>"><?= $pet->cwname ?></h3>
            <p>Cấp độ: <?= $pet->cwlv ?></p>
            <p>Phẩm chất: <span style="color: <?= $pet->getQualityColor() ?>"><?= $pet->getQualityName() ?></span></p>
            <p>HP: <?= $pet->cwhp ?> / <?= $pet->total_hp ?></p>
            <p>Công kích: <?= $pet->total_gj ?></p>
            <p>Phòng thủ: <?= $pet->total_fy ?></p>
            <p>Bạo kích: <?= $pet->total_bj ?>%</p>
            <p>Hút huyết: <?= $pet->total_xx ?>%</p>
            <p>Kinh nghiệm: <?= $pet->cwexp ?> / <?= $pet->cwmaxexp ?></p>
            
            <hr>
            <p>Tăng trưởng HP: <?= $pet->uphp ?></p>
            <p>Tăng trưởng Công: <?= $pet->upgj ?></p>
            <p>Tăng trưởng Thủ: <?= $pet->upfy ?></p>
            
            <hr>
            <form action="?cmd=<?= $encoder->encode("cmd=chongwu&action=rename&cwid={$pet->cwid}") ?>" method="post">
                Đổi tên: <input type="text" name="newname" value="<?= $pet->cwname ?>" maxlength="20">
                <input type="submit" value="Xác nhận">
            </form>
        </div>
        
        <br>
        <a href="?cmd=<?= $encoder->encode("cmd=chongwu") ?>">Quay lại danh sách sủng vật</a>
        <br>
        <a href="?cmd=<?= $encoder->encode("cmd=gomid&newmid={$player->nowmid}") ?>">Trở về bản đồ</a>
    </div>
</div>
</body>
</html>
