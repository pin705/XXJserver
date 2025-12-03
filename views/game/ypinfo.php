<?php if (!$item): ?>
    Dược phẩm không tồn tại.<br/>
    <a href="#" onClick="javascript:history.back(-1);">Trở lại</a>
<?php else: ?>
    <?php echo $item->ypname; ?><br/>
    Giới thiệu: <?php echo $item->ypinfo; ?><br/>
    Hồi phục HP: <?php echo $item->yphp; ?><br/>
    Công kích: <?php echo $item->ypgj; ?><br/>
    Phòng ngự: <?php echo $item->ypfy; ?><br/>
    <br/>
    <?php if ($playerPotion && $playerPotion->ypsum > 0): ?>
        Số lượng: <?php echo $playerPotion->ypsum; ?><br/>
        <br/>
        <font size="2">Dược phẩm vị trí：
        <a href="?cmd=setyp&slot=1&ypid=<?php echo $item->ypid; ?>&sid=<?php echo $player->sid; ?>">Vị trí 1</a>
        <a href="?cmd=setyp&slot=2&ypid=<?php echo $item->ypid; ?>&sid=<?php echo $player->sid; ?>">Vị trí 2</a>
        <a href="?cmd=setyp&slot=3&ypid=<?php echo $item->ypid; ?>&sid=<?php echo $player->sid; ?>">Vị trí 3</a>
        </font><br/>
        <br/>
        <a href="?cmd=useyp&ypid=<?php echo $item->ypid; ?>&sid=<?php echo $player->sid; ?>">Sử dụng</a><br/>
    <?php else: ?>
        Bạn không có dược phẩm này.<br/>
    <?php endif; ?>
    <br/>
    <a href="#" onClick="javascript:history.back(-1);">Trở lại</a>
    <a href="?cmd=gomid&newmid=<?php echo $player->nowmid; ?>&sid=<?php echo $player->sid; ?>" style="float:right;background-color:#cff3d2;color: #755d5d;" >Trở về trò chơi</a>
<?php endif; ?>
