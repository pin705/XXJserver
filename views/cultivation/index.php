<?php
$gonowmid = $encode->encode("cmd=gomid&newmid=$player->nowmid&sid=$sid");
$startLinhThach = $encode->encode("cmd=cultivation_start&type=1&sid=$sid");
$startMaThach = $encode->encode("cmd=cultivation_start&type=2&sid=$sid");
$endCmd = $encode->encode("cmd=cultivation_end&sid=$sid");
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tu Luyện (Ngồi Thiền)</title>
    <link rel="stylesheet" href="css/gamecss.css">
    <style>
        .cultivation-container {
            text-align: center;
            padding: 20px;
        }
        .btn {
            display: inline-block;
            padding: 8px 15px;
            background-color: #eee;
            border: 1px solid #ccc;
            text-decoration: none;
            color: #333;
            border-radius: 3px;
            margin: 5px;
        }
        .btn-primary {
            background-color: #007bff;
            color: white;
            border-color: #007bff;
        }
        .btn-warning {
            background-color: #ffc107;
            color: black;
            border-color: #ffc107;
        }
        .btn-success {
            background-color: #28a745;
            color: white;
            border-color: #28a745;
        }
    </style>
</head>
<body>
    <div class="container cultivation-container">
        <h3>Tu Luyện (Ngồi Thiền)</h3>
        
        <img src="images/xiulian.jpg" style="width: 280px; border-radius: 8px; margin-bottom: 15px;">
        
        <?php if (isset($error)): ?>
            <div style="color: red; margin-bottom: 10px;"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <?php if (isset($success)): ?>
            <div style="color: green; margin-bottom: 10px;"><?php echo $success; ?></div>
        <?php endif; ?>

        <div style="text-align: left; margin: 0 auto; max-width: 300px; border: 1px solid #ddd; padding: 10px; border-radius: 5px;">
            <p>Người tu luyện: <strong><?php echo $player->uname; ?></strong></p>
            <p>Cảnh giới: <?php echo $player->jingjie; ?></p>
            <p>Tu vi hiện tại: <?php echo $player->uexp; ?></p>
            <p>Linh thạch: <?php echo $player->uyxb; ?></p>
            <p>Ma thạch: <?php echo $player->uczb; ?></p>
        </div>

        <hr>

        <?php if ($player->sfxl == 1): ?>
            <div style="background-color: #e8f5e9; padding: 15px; border-radius: 5px; margin-bottom: 15px;">
                <h4 style="color: green;">Đang trong trạng thái Ngồi Thiền...</h4>
                <p>Thời gian đã tu luyện: <strong><?php echo $trainingTime; ?></strong> phút</p>
                <p>Dự kiến nhận: <strong><?php echo $expGain; ?></strong> tu vi</p>
                <p>(Tối đa 1440 phút)</p>
                <a href="?cmd=<?php echo $endCmd; ?>" class="btn btn-success">Kết Thúc Tu Luyện</a>
            </div>
        <?php else: ?>
            <div style="margin-bottom: 15px;">
                <p>Ngồi thiền giúp tăng tu vi bản thân.</p>
                <p>Tiêu hao: <strong><?php echo $spiritStoneCost; ?></strong> Linh thạch hoặc <strong><?php echo $magicStoneCost; ?></strong> Ma thạch.</p>
                
                <a href="?cmd=<?php echo $startLinhThach; ?>" class="btn btn-primary">Dùng Linh Thạch</a>
                <a href="?cmd=<?php echo $startMaThach; ?>" class="btn btn-warning">Dùng Ma Thạch</a>
            </div>
        <?php endif; ?>

        <hr>
        <a href="game.php?cmd=<?php echo $gonowmid; ?>" class="btn">Trở về trò chơi</a>
    </div>
</body>
</html>
