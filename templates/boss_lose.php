<?php
$gonowmid = $encode->encode("cmd=gomid&newmid=$nowmid&sid=$sid");
$bagyd = $encode->encode("cmd=getbagyd&sid=$sid");
?>
<IMG width='280' height='140' src='./images/boss.png' style="border-radius: 8px;">
<br/>
Bạn đã bị <?php echo $boss->bossname; ?> đánh bại!<br/>
<br/>
<a href="?cmd=<?php echo $bagyd; ?>">Sử dụng thuốc</a><br/>
<a href="?cmd=<?php echo $gonowmid; ?>">Trở về trò chơi</a>
