<font size="2">
<div class="menu">
    <a href="#" style="background-color: gray;">Trang bị</a>
    <a href="?cmd=getbagdj&sid=<?php echo $player->sid; ?>">Đạo cụ</a>
    <a href="?cmd=getbagyp&sid=<?php echo $player->sid; ?>">Dược phẩm</a>
    <a href="?cmd=getbagjn&sid=<?php echo $player->sid; ?>">Kỹ năng</a>
    <a href="?cmd=getbagyd&sid=<?php echo $player->sid; ?>">Đan dược</a>
</div>
</font><br>
<br/>
<?php foreach ($items as $item): ?>
    <a href="?cmd=zbinfo&zbid=<?php echo $item->zbnowid; ?>&sid=<?php echo $player->sid; ?>">
        <font color="<?php echo $item->zbys ?? ''; ?>"><?php echo $item->zbname; ?></font>
    </a><br/>
<?php endforeach; ?>
<br/>
<?php if ($totalPages > 1): ?>
    <?php if ($page > 1): ?>
        <a href="?cmd=getbagzb&page=<?php echo $page - 1; ?>&sid=<?php echo $player->sid; ?>">Trang trước</a>
    <?php endif; ?>
    <?php echo $page; ?>/<?php echo $totalPages; ?>
    <?php if ($page < $totalPages): ?>
        <a href="?cmd=getbagzb&page=<?php echo $page + 1; ?>&sid=<?php echo $player->sid; ?>">Trang sau</a>
    <?php endif; ?>
    <br/>
<?php endif; ?>
<br/>
<a href="#" onClick="javascript:history.back(-1);">Trở lại</a>
<a href="?cmd=gomid&newmid=<?php echo $player->nowmid; ?>&sid=<?php echo $player->sid; ?>" style="float:right;background-color:#cff3d2;color: #755d5d;" >Trở về trò chơi</a>
