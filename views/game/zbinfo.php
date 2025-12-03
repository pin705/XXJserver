<?php if (!$item): ?>
    Trang bị không tồn tại.<br/>
    <a href="#" onClick="javascript:history.back(-1);">Trở lại</a>
<?php else: ?>
    <font color="<?php echo $item->zbys ?? ''; ?>"><?php echo $item->zbname; ?></font><br/>
    Cấp bậc yêu cầu: <?php echo $item->zblv; ?><br/>
    Công kích: <?php echo $item->zbgj; ?><br/>
    Phòng ngự: <?php echo $item->zbfy; ?><br/>
    Bạo kích: <?php echo $item->zbbj; ?>%<br/>
    Hút máu: <?php echo $item->zbxx; ?>%<br/>
    HP: <?php echo $item->zbhp; ?><br/>
    Giới thiệu: <?php echo $item->zbinfo; ?><br/>
    <br/>
    <a href="?cmd=setzbwz&zbid=<?php echo $item->zbnowid; ?>&sid=<?php echo $player->sid; ?>">Trang bị</a><br/>
    <a href="?cmd=upzb&zbid=<?php echo $item->zbnowid; ?>&sid=<?php echo $player->sid; ?>">Cường hóa</a><br/>
    <a href="?cmd=delezb&zbid=<?php echo $item->zbnowid; ?>&sid=<?php echo $player->sid; ?>">Vứt bỏ</a><br/>
    <br/>
    <a href="#" onClick="javascript:history.back(-1);">Trở lại</a>
    <a href="?cmd=gomid&newmid=<?php echo $player->nowmid; ?>&sid=<?php echo $player->sid; ?>" style="float:right;background-color:#cff3d2;color: #755d5d;" >Trở về trò chơi</a>
<?php endif; ?>
