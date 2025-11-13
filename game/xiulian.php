<?php
$player = \player\getplayer($sid,$dblj);
$gonowmid = $encode->encode("cmd=gomid&newmid=$player->nowmid&sid=$sid");
$strxl = $encode->encode("cmd=startxiulian&canshu=1&sid=$sid");
$strxl1 = $encode->encode("cmd=startxiulian&canshu=2&sid=$sid");
$endxl = $encode->encode("cmd=endxiulian&sid=$sid");
$nowdate = date('Y-m-d H:i:s');
$xlsjc='Chưa bắt đầu tu luyện';
$tishi = '';
$xlexp = 0;
$xiaohao = 32 * $player->ulv;
$jpxiaohao = round(($player->ulv+1)/2);


if ($cmd == 'startxiulian'){
    if ($player->sfxl == 1){
        $tishi = 'Ngươi đã tại Trong tu luyện<br/>';
    }else{
        if ($canshu == 1){
            $ret = \player\changeyxb(2,$xiaohao,$sid,$dblj);
        }else{
            $ret = \player\changeczb(2,$jpxiaohao,$sid,$dblj);
        }
        if ($ret){
            \player\changeplayersx('xiuliantime',$nowdate,$sid,$dblj);
            \player\changeplayersx('sfxl',1,$sid,$dblj);
            $tishi = 'Bắt đầu tu luyện...<br/>';
            $xlsjc = 0;
            $player = \player\getplayer($sid,$dblj);
        }else{
            $tishi='Linh thạch không đủ';
        }

    }
}
		$one = strtotime($nowdate) ;
        $tow = strtotime($player->xiuliantime);
        $xlsjc=floor(($one-$tow)/60);
		$xlexp = round($xlsjc * $player->ulv*1);
     if ($xlsjc > 1440){
        $xlsjc = 1440;
        $xlexp = round($xlsjc * $player->ulv*1);//Thu hoạch tu vi tính toán
	 }
if ($cmd == 'endxiulian'){//Kết thúc tu tiên
    if ($player->sfxl == 1){
		\player\changeexp($sid,$dblj,$xlexp);//Cái này cần đột phá, tràn ra không cách nào gia tăng tu luyện giá trị
       // \player\addplayersx('uexp',$xlexp,$sid,$dblj);Cái này trực tiếp số cộng dữ liệu, không cần đột phá
        \player\changeplayersx('sfxl',0,$sid,$dblj);
		//$player = \player\getplayer($sid,$dblj);	
        $xlsjc = 'Kết thúc tu luyện...<br/>Thời gian tu luyện：'.$xlsjc;
        $tishi = 'nhận được  tu vi:'.$xlexp.'<br/>';   
        $player = \player\getplayer($sid,$dblj);	
    }
	else{
        $tishi = 'Ngươi còn chưa có bắt đầu tu luyện...<br/>';
    }
}

if ($player->sfxl == 1){
    // $one = strtotime($nowdate) ;
    // $tow = strtotime($player->xiuliantime);
    // $xlsjc=floor(($one-$tow)/60);
    // if ($xlsjc > 1440){
        // $xlsjc = 1440;
    // }
    // $xlexp = round($xlsjc * $player->ulv*1000);//Thu hoạch tu vi tính toán
	// $sl = $xlexp;
    //\player\changeexp($sid,$dblj,$xlexp);
    $tishi = '<font color="#A0A000">Tu</font><font color="#F5A000">Luyện</font><font color="#FFA000">Bên trong</font><br/>';
    $xlcz = "<a href=?cmd=$endxl>Kết thúc tu luyện</a><br/><br/>";
}else{
	$tishi = 'Ngươi còn chưa có bắt đầu tu luyện...<br/>';
    $xlcz = "<a href=?cmd=$strxl>Sử dụng linh thạch tu luyện</a><a href=?cmd=$strxl1>Sử dụng ma thạch tu luyện</a><br/><br/>";
}
$xiuliancmd = $encode->encode("cmd=goxiulian&sid=$sid");
$wgxl = $encode->encode("cmd=wgxl&sid=$sid");
$wgxx = $encode->encode("cmd=xxwg&sid=$sid");
// $wgid = $player->wugong;
// $cxwg = \player\wgcx($wgid,$sid,$dblj);

$xlhtml = <<<HTML
<IMG width='280' height='140' src='./images/xiulian.jpg' style="border-radius: 8px;">
<a href="?cmd=$xiuliancmd" >Ngồi thiền tu luyện</a><a href="?cmd=$wgxl" >Võ công tu hành</a><a href="?cmd=$wgxx" >Bí tịch</a><br>
Tu luyện người chơi：$player->uname<br/>
Người chơi trạng thái：$player->jingjie($player->ulv)<br/>
===============<br/>
Thời gian tu luyện:$xlsjc Phút<br/>
Tu luyện ích lợi:$xlexp Tu vi<br/>
Trước mắt tu vi:$player->uexp <br/>
===============<br/>
Ngồi thiền trạng thái:$tishi 
===============<br/>
Chú：Nhiều nhất tu luyện 24 Giờ, 1440 Phút<br/>
<br/>
Tu luyện cần linh thạch：$xiaohao/$player->uyxb<br/>
Tu luyện cần ma thạch：$jpxiaohao/$player->uczb<br/>
$xlcz
		<a href="#" onClick="javascript:history.back(-1);">Trở lại</a>
        <a href="game.php?cmd=$gonowmid" style="float:right;" >Trở về trò chơi</a>
HTML;
echo $xlhtml;
?>