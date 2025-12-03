<?php
$player = $data['player'];
$sid = $data['sid'];
$gonowmid = "gomid&newmid=$player->nowmid&sid=$sid";
?>
<p>Đổi Mã Quà Tặng</p>
<form action="?cmd=duihuan&sid=<?php echo $sid; ?>" method="post">
    Mã quà tặng: <input type="text" name="dhm" value="">
    <input type="submit" value="Đổi">
</form>
<p>
    <a href="#" onClick="javascript:history.back(-1);">Trở lại</a>
    <a href="?cmd=<?php echo $gonowmid; ?>" style="float:right;">Trở về trò chơi</a>
</p>
