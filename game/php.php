<?php
$player = player\getplayer($sid,$dblj);//Thu hoạch ngươi ID
$gonowmid = $encode->encode("cmd=gomid&newmid=$player->nowmid&sid=$sid");//【Trở về trò chơi kết nối】
$shangdian = $encode->encode("cmd=shangdian&canshu=gogoumai&sid=$sid");//【Cửa hàng kết nối】  PHP ，Lựa chọn văn bản , tăng thêm dấu hiệu , thân phận của ngươi
$fangshi = $encode->encode("cmd=fangshi&fangshi=daoju&sid=$sid");
$zhuangbei = $encode->encode("cmd=fangshi&fangshi=zhuangbei&sid=$sid");
//$ydlist = $encode->encode("cmd=shangdian&nid&canshu=ydlist&sid=$sid");//Đây là không có viết xong, cũng không biết muốn viết cái gì

//Bắt đầu từ nơi này cái thứ nhất web page
// $qydthtml = <<<HTML
// <br/><a href="?cmd=$shangdian">Cái thứ nhất đoạn</a><br/>
// HTML;
//Kết thúc cái thứ nhất web page




//Phía dưới là một cái tham số cất giữ, sau đó mở ra cái thứ hai web page
//$player = player\getplayer($sid,$dblj);//Thu hoạch ngươi ID

$qydthtml =<<<HTML
         <div align="center">
         【<a href="?cmd=$shangdian">Quái vật</a>|<a href="?cmd=$zhuangbei">NPC</a>|<a href="?cmd=$zhuangbei">Địa đồ】</a><br/></div>
    

        $qydthtml<br/>
		<div align="center">
		<a href="#" onClick="javascript:history.back(-1);">Trở lại</a>
        <a href="?cmd=$gonowmid">Trở về trò chơi</a>
		</div>
HTML;
echo $qydthtml
?> 


 <?php
// $player = player\getplayer($sid,$dblj);
// $map = '';

// $cxallmap = \player\getqy_all($dblj);
// $br = 0;
// for ($i=0;$i<count($cxallmap);$i++){

    // $qyame = $cxallmap[$i]['qyname'];
    // $mid = $cxallmap[$i]['mid'];
    // if ($mid>0){
        // $cxmid = \player\getmid($mid,$dblj);
        // $mname = $cxmid->mname;
        // $br++;
        // $gomid = $encode->encode("cmd=gomid&newmid=$mid&sid=$sid");
        // $map .=<<<HTML
        // <a href="?cmd=$gomid" >[$qyame]$mname</a>
// HTML;
    // }
    // if ($br >= 3){
        // $br = 0;
        // $map.="<br/>"  ;
    // }
// }


// $gonowmid = $encode->encode("cmd=gomid&newmid=$player->nowmid&sid=$sid");
// $allmap = <<<HTML
// <!--<IMG width='280' height='50' src='./images/dt.jpg'>-->Thế giới địa đồ：<br/>
// $map<br>
// <br>
// <a href="#" onClick="javascript:history.back(-1);">Trở lại</a><br/>
// <a href="game.php?cmd=$gonowmid">Trở về trò chơi</a>
// HTML;
// echo $allmap;
// ?>