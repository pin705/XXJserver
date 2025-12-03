<font size="2">
<div class="menu">
    <a href="?cmd=getbagzb&sid=<?php echo $player->sid; ?>">Trang bị</a>
    <a href="?cmd=getbagdj&sid=<?php echo $player->sid; ?>">Đạo cụ</a>
    <a href="#" style="background-color: gray;">Dược phẩm</a>
    <a href="?cmd=getbagjn&sid=<?php echo $player->sid; ?>">Kỹ năng</a>
    <a href="?cmd=getbagyd&sid=<?php echo $player->sid; ?>">Đan dược</a>
</div>
</font><br>
<br/>
<?php $i = 0; ?>
<?php foreach ($items as $item): ?>
    <?php $i++; ?>
    [<?php echo $i; ?>].<a href="?cmd=ypinfo&ypid=<?php echo $item->ypid; ?>&sid=<?php echo $player->sid; ?>"><?php echo $item->ypname; ?>x<?php echo $item->ypsum; ?></a><br/>
<?php endforeach; ?>
<br/>
<a href="#" onClick="javascript:history.back(-1);">Trở lại</a>
<a href="?cmd=gomid&newmid=<?php echo $player->nowmid; ?>&sid=<?php echo $player->sid; ?>" style="float:right;background-color:#cff3d2;color: #755d5d;" >Trở về trò chơi</a>
