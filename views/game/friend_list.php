=======Hảo hữu=======<br/>
<?php foreach ($friends as $friend): ?>
    <a href="?cmd=<?php echo $friend['cmd']; ?>"><?php echo $friend['name']; ?></a><br/>
<?php endforeach; ?>
<br/>
<a href="#" onClick="javascript:history.back(-1);">Trở lại</a>
<a href="?cmd=<?php echo $back_cmd; ?>" style="float:right;" >Trở về trò chơi</a>
