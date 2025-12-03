<?php
$gonowmid = $encode->encode("cmd=gomid&newmid=$player->nowmid&sid=$sid");
$backCmd = $encode->encode("cmd=skill&sid=$sid");
$startCmd = $encode->encode("cmd=skill_start_train&sid=$sid");
$endCmd = $encode->encode("cmd=skill_end_train&sid=$sid");
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tu Luyện Võ Công</title>
    <link rel="stylesheet" href="css/gamecss.css">
    <style>
        .train-container {
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
        .btn-success {
            background-color: #28a745;
            color: white;
            border-color: #28a745;
        }
    </style>
</head>
<body>
    <div class="container train-container">
        <h3>Tu Luyện: <span style="color: <?php echo $skill->wgys; ?>"><?php echo $skill->wgname; ?></span></h3>
        
        <img src="images/wugong/<?php echo $skill->wgid; ?>.png" style="width: 150px; border-radius: 10px; margin-bottom: 15px;">
        
        <?php if (isset($error)): ?>
            <div style="color: red; margin-bottom: 10px;"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <?php if (isset($success)): ?>
            <div style="color: green; margin-bottom: 10px;"><?php echo $success; ?></div>
        <?php endif; ?>

        <div style="text-align: left; margin: 0 auto; max-width: 300px; border: 1px solid #ddd; padding: 10px; border-radius: 5px;">
            <p>Người tu luyện: <strong><?php echo $player->uname; ?></strong></p>
            <p>Cấp độ võ công: <?php echo $skill->wgdj; ?></p>
            <p>Kinh nghiệm: <?php echo $skill->wgxl; ?> / <?php echo $skill->wgxlmax; ?></p>
            <p>Số lượng bí tịch: <?php echo $skill->wgsum; ?> quyển</p>
            <p>Tiêu hao bắt đầu: <?php echo $currencyCost; ?> Linh thạch/Ma thạch</p>
            <p>Tiêu hao kết thúc: 1 quyển bí tịch</p>
            <p>Giới thiệu: <?php echo $skill->wginfo; ?></p>
        </div>

        <hr>

        <?php if ($skill->xlzt == 1): ?>
            <div style="background-color: #e8f5e9; padding: 15px; border-radius: 5px; margin-bottom: 15px;">
                <h4 style="color: green;">Đang trong trạng thái tu luyện...</h4>
                <p>Thời gian đã tu luyện: <strong><?php echo $trainingTime; ?></strong> phút</p>
                <p>Dự kiến nhận: <strong><?php echo $expGain; ?></strong> kinh nghiệm</p>
                <p>(Tối đa 1440 phút)</p>
                <a href="?cmd=<?php echo $endCmd; ?>" class="btn btn-success">Kết Thúc Tu Luyện (Tốn 1 Bí tịch)</a>
            </div>
        <?php else: ?>
            <div style="margin-bottom: 15px;">
                <p>Bắt đầu tu luyện sẽ tiêu hao <strong><?php echo $currencyCost; ?></strong> Linh thạch hoặc Ma thạch.</p>
                <?php 
                    $startLinhThach = $encode->encode("cmd=skill_start_train&type=1&sid=$sid");
                    $startMaThach = $encode->encode("cmd=skill_start_train&type=2&sid=$sid");
                ?>
                <a href="?cmd=<?php echo $startLinhThach; ?>" class="btn btn-primary">Dùng Linh Thạch</a>
                <a href="?cmd=<?php echo $startMaThach; ?>" class="btn btn-warning">Dùng Ma Thạch</a>
            </div>
        <?php endif; ?>

        <hr>
        <a href="?cmd=<?php echo $backCmd; ?>" class="btn">Quay lại</a>
        <a href="game.php?cmd=<?php echo $gonowmid; ?>" class="btn">Trở về trò chơi</a>
    </div>
</body>
</html>
