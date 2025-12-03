<?php
$gonowmid = $encode->encode("cmd=gomid&newmid=$player->nowmid&sid=$sid");
$backCmd = $encode->encode("cmd=getbagyd&sid=$sid");
$useCmd = $encode->encode("cmd=usepill&ydid={$item->ydid}&sid=$sid");
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $item->ydname; ?></title>
    <link rel="stylesheet" href="css/gamecss.css">
</head>
<body>
    <div class="container">
        <h3><?php echo $item->ydname; ?></h3>
        
        <?php if (isset($message)): ?>
            <div style="color: green; margin-bottom: 10px;"><?php echo $message; ?></div>
        <?php endif; ?>

        <div class="item-detail">
            <p>Số lượng: <?php echo $playerItem ? $playerItem->ydsum : 0; ?></p>
            <p>Hiệu quả:</p>
            <ul>
                <?php if ($item->ydhp > 0) echo "<li>HP +{$item->ydhp}</li>"; ?>
                <?php if ($item->ydgj > 0) echo "<li>Công kích +{$item->ydgj}</li>"; ?>
                <?php if ($item->ydfy > 0) echo "<li>Phòng thủ +{$item->ydfy}</li>"; ?>
                <?php if ($item->ydbj > 0) echo "<li>Bạo kích +{$item->ydbj}</li>"; ?>
                <?php if ($item->ydxx > 0) echo "<li>Hút máu +{$item->ydxx}</li>"; ?>
            </ul>
            <p>Giá bán: <?php echo $item->jiage ?? 0; ?></p>
        </div>

        <div class="actions">
            <?php if ($playerItem && $playerItem->ydsum > 0): ?>
                <a href="?cmd=<?php echo $useCmd; ?>" class="btn btn-primary">Sử dụng</a>
            <?php endif; ?>
        </div>

        <hr>
        <a href="?cmd=<?php echo $backCmd; ?>" class="btn">Quay lại túi</a>
        <a href="game.php?cmd=<?php echo $gonowmid; ?>" class="btn">Trở về trò chơi</a>
    </div>
</body>
</html>
