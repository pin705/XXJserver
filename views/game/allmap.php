<?php foreach ($maps as $map): ?>
    <a href="?cmd=gomid&newmid=<?php echo $map->mid; ?>&sid=<?php echo $player->sid; ?>"><?php echo $map->mname; ?></a><br/>
<?php endforeach; ?>
<br/>
<a href="#" onClick="javascript:history.back(-1);">Trở lại</a>
<a href="?cmd=gomid&newmid=<?php echo $player->nowmid; ?>&sid=<?php echo $player->sid; ?>" style="float:right;background-color:#cff3d2;color: #755d5d;" >Trở về trò chơi</a>
