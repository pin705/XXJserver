<?php if (isset($_GET['msg'])): ?>
    <?php echo $_GET['msg']; ?><br/>
<?php endif; ?>

<?php if ($player->sfxl == 1): ?>
    Đang tu luyện...<br/>
    Thời gian: <?php echo $minutes; ?> phút<br/>
    Kinh nghiệm dự kiến: <?php echo $exp; ?><br/>
    <br/>
    <a href="?cmd=endxiulian&sid=<?php echo $player->sid; ?>">Kết thúc tu luyện</a><br/>
<?php else: ?>
    Chưa bắt đầu tu luyện.<br/>
    <br/>
    <a href="?cmd=startxiulian&type=1&sid=<?php echo $player->sid; ?>">Tu luyện thường (<?php echo $cost_yxb; ?> Linh thạch)</a><br/>
    <a href="?cmd=startxiulian&type=2&sid=<?php echo $player->sid; ?>">Tu luyện cao cấp (<?php echo $cost_czb; ?> Tiên ngọc)</a><br/>
<?php endif; ?>
<br/>
<a href="#" onClick="javascript:history.back(-1);">Trở lại</a>
<a href="?cmd=gomid&newmid=<?php echo $player->nowmid; ?>&sid=<?php echo $player->sid; ?>" style="float:right;background-color:#cff3d2;color: #755d5d;" >Trở về trò chơi</a>
