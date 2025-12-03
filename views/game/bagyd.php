<?php
$gonowmid = $encode->encode("cmd=gomid&newmid=$player->nowmid&sid=$sid");
$getbagzbcmd = $encode->encode("cmd=getbagzb&sid=$sid");
$getbagdjcmd = $encode->encode("cmd=getbagdj&sid=$sid");
$getbagjncmd = $encode->encode("cmd=getbagjn&sid=$sid");
$getbagypcmd = $encode->encode("cmd=getbagyp&sid=$sid");
$getbagydcmd = $encode->encode("cmd=getbagyd&sid=$sid");
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Túi Đan Dược</title>
    <link rel="stylesheet" href="css/gamecss.css">
</head>
<body>
    <div class="container">
        <h3>Túi Đan Dược</h3>
        
        <div class="nav-tabs">
            <a href="?cmd=<?php echo $getbagzbcmd; ?>">Trang bị</a>
            <a href="?cmd=<?php echo $getbagypcmd; ?>">Dược phẩm</a>
            <a href="?cmd=<?php echo $getbagdjcmd; ?>">Đạo cụ</a>
            <a href="?cmd=<?php echo $getbagjncmd; ?>">Kỹ năng</a>
            <a href="?cmd=<?php echo $getbagydcmd; ?>" class="active">Đan dược</a>
        </div>

        <hr>

        <?php if (empty($items)): ?>
            <p>Không có đan dược nào.</p>
        <?php else: ?>
            <ul class="item-list">
                <?php foreach ($items as $item): ?>
                    <?php 
                        $detailCmd = $encode->encode("cmd=ydinfo&id={$item->ydid}&type=pill&sid=$sid");
                    ?>
                    <li>
                        <a href="?cmd=<?php echo $detailCmd; ?>">
                            <?php echo $item->ydname; ?> (x<?php echo $item->ydsum; ?>)
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <hr>
        <a href="game.php?cmd=<?php echo $gonowmid; ?>" class="btn">Trở về trò chơi</a>
    </div>
</body>
</html>
