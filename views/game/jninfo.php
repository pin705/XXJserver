<?php if (!$skill): ?>
    Kỹ năng không tồn tại.<br/>
    <a href="#" onClick="javascript:history.back(-1);">Trở lại</a>
<?php else: ?>
    <?php echo $skill->wgname; ?><br/>
    Cấp bậc: <?php echo $skill->wgdj; ?><br/>
    Giới thiệu: <?php echo $skill->wginfo ?? 'Không có giới thiệu'; ?><br/>
    <br/>
    <a href="?cmd=wgxiulian&wgid=<?php echo $skill->wgid; ?>&sid=<?php echo $player->sid; ?>">Tu luyện</a><br/>
    <br/>
    <a href="#" onClick="javascript:history.back(-1);">Trở lại</a>
    <a href="?cmd=gomid&newmid=<?php echo $player->nowmid; ?>&sid=<?php echo $player->sid; ?>" style="float:right;background-color:#cff3d2;color: #755d5d;" >Trở về trò chơi</a>
<?php endif; ?>
