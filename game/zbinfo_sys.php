<?php
$player = \player\getplayer($sid,$dblj);
$gonowmid = $encode->encode("cmd=gomid&newmid=$player->nowmid&sid=$sid");
$zhuangbei = new \player\zhuangbei();
$zhuangbei = player\getzbkzb($zbid,$dblj);
$tools = array("Không hạn","Vũ khí","Đồ phòng ngự","Đồ trang sức","Thư tịch","Tọa kỵ","Lệnh bài","Ám khí");
$tool = $tools[$zhuangbei->tool];
//Chủng loại：$tool<br/>==========<br/>
$html = <<<HTML
Trang bị tên:<font color='$zhuangbei->zbys'>【 $zhuangbei->zbname 】</font><br/>
Trang bị công kích:$zhuangbei->zbgj<br/>
Trang bị phòng ngự:$zhuangbei->zbfy<br/>
Gia tăng khí huyết:$zhuangbei->zbhp<br/>
Trang bị bạo kích:$zhuangbei->zbbj%<br/>
Trang bị hút máu:$zhuangbei->zbxx%<br/>
==========<br/>
Chủng loại：$tool<br/>==========<br/>
Trang bị tin tức:$zhuangbei->zbinfo<br/>

<br/>
	<a href="#" onClick="javascript:history.back(-1);">Trở lại</a>
    <a href="game.php?cmd=$gonowmid" style="float:right;" >Trở về trò chơi</a> 
HTML;
echo $html;
?>