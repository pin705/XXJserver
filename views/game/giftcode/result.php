<?php
$player = $data['player'];
$sid = $data['sid'];
$message = $data['message'];
$gonowmid = "gomid&newmid=$player->nowmid&sid=$sid";
?>
<p>Kết quả đổi mã</p>
<p><?php echo $message; ?></p>
<p>
    <a href="?cmd=duihuan&sid=<?php echo $sid; ?>">Tiếp tục đổi</a><br/>
    <a href="?cmd=<?php echo $gonowmid; ?>">Trở về trò chơi</a>
</p>
