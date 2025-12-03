<?php
$encode = new \XXJ\Classes\Encode();
$gonowmid = $encode->encode("cmd=gomid&newmid={$player->nowmid}&sid={$player->sid}");
$createAction = $encode->encode("cmd=cjclub&sid={$player->sid}");
?>

<h3>Tạo Môn Phái</h3>

<?php if (isset($error)): ?>
    <div style="color:red;"><?php echo $error; ?></div>
<?php endif; ?>

<form action="?cmd=<?php echo $createAction; ?>" method="post">
    Tên môn phái (6-30 ký tự):<br/>
    <input type="text" name="clubname" maxlength="30"><br/>
    
    Giới thiệu:<br/>
    <textarea name="clubinfo" rows="3" cols="20"></textarea><br/>
    
    Chi phí: 100 Ma thạch<br/>
    <input type="submit" value="Tạo môn phái">
</form>

<br/>
<div class="menu">
    <a href="#" onClick="javascript:history.back(-1);">Trở lại</a>
    <a href="?cmd=<?php echo $gonowmid; ?>" style="float:right;">Trở về trò chơi</a>
</div>
