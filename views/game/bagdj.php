<font size="2">
<div class="menu">
    <a href="?cmd=getbagzb&sid=<?php echo $player->sid; ?>">Trang bị</a>
    <a href="#" style="background-color: gray;">Đạo cụ</a>
    <a href="?cmd=getbagyp&sid=<?php echo $player->sid; ?>">Dược phẩm</a>
    <a href="?cmd=getbagjn&sid=<?php echo $player->sid; ?>">Kỹ năng</a>
    <a href="?cmd=getbagyd&sid=<?php echo $player->sid; ?>">Đan dược</a>
</div>
</font><br>
<br/>
<?php $i = 0; ?>
<?php foreach ($items as $item): ?>
    <?php $i++; ?>
    [<?php echo $i; ?>].<a href="?cmd=djinfo&djid=<?php echo $item->djid; ?>&sid=<?php echo $player->sid; ?>"><?php echo $item->djname; ?>x<?php echo $item->djsum; ?></a><br/>
<?php endforeach; ?>
<br/>
<a href="#" onClick="javascript:history.back(-1);">Trở lại</a>
<a href="?cmd=gomid&newmid=<?php echo $player->nowmid; ?>&sid=<?php echo $player->sid; ?>" style="float:right;background-color:#cff3d2;color: #755d5d;" >Trở về trò chơi</a>
