<?php
/**
 * @var \XXJ\Models\Player $player
 * @var string|null $error
 */
$encoder = new \XXJ\Utils\Encoder();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Tạo môn phái</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <link rel="stylesheet" href="css/gamecss.css">
</head>
<body>
<div class="main">
    <div class="header">
        Tạo môn phái
    </div>
    
    <div class="content">
        <div align="center">
            <p>Thiên địa bất nhân, tu đạo tức tu đạo.</p>
            <p>Đại đạo bất chỉ, đại đạo lộ bất chỉ.</p>
            <p>Muốn trộm ra tiên lộ, một người.. quá khó..</p>
        </div>
        <hr>
        
        <?php if (isset($error)): ?>
            <p style="color: red; text-align: center;"><?= $error ?></p>
        <?php endif; ?>

        <form action="?cmd=<?= $encoder->encode("cmd=club&action=create") ?>" method="post">
            <div align="center">
                <p>Phí tạo lập: 100 Ma thạch (Hiện có: <?= $player->uczb ?>)</p>
                <input type="text" name="clubname" placeholder="Tên môn phái (6-12 ký tự)" required><br><br>
                <textarea name="clubinfo" style="height: 80px; width: 80%;" placeholder="Tuyên ngôn môn phái"></textarea>
                <br><br>
                <input type="submit" value="Tạo môn phái" style="background-color: #ab4d0e; color: white; padding: 5px 15px; border: none; border-radius: 3px;">
            </div>
        </form>
        
        <br>
        <a href="?cmd=<?= $encoder->encode("cmd=club") ?>">Quay lại</a>
    </div>
</div>
</body>
</html>
