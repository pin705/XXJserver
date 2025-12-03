<?php
$gonowmid = $encode->encode("cmd=gomid&newmid=$player->nowmid&sid=$sid");
$tools = array("Không hạn","Vũ khí","Đồ phòng ngự","Đồ trang sức","Thư tịch","Tọa kỵ","Lệnh bài","Ám khí");
$tool = isset($tools[$item->tool]) ? $tools[$item->tool] : "Khác";
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $item->zbname; ?></title>
    <link rel="stylesheet" href="css/gamecss.css">
</head>
<body>
    <div class="container">
        <h3><?php echo $item->zbname; ?></h3>
        
        <div class="item-detail">
            <p>Loại: <?php echo $tool; ?></p>
            <p>Công kích: <?php echo $item->zbgj; ?></p>
            <p>Phòng ngự: <?php echo $item->zbfy; ?></p>
            <p>HP: <?php echo $item->zbhp; ?></p>
            <p>Bạo kích: <?php echo $item->zbbj; ?>%</p>
            <p>Hút máu: <?php echo $item->zbxx; ?>%</p>
            <p>Mô tả: <?php echo $item->zbinfo; ?></p>
        </div>

        <hr>
        <a href="game.php?cmd=<?php echo $gonowmid; ?>" class="btn">Trở về trò chơi</a>
    </div>
</body>
</html>
