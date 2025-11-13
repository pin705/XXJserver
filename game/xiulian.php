<?php
require_once __DIR__ . '/../src/Helpers/NguoiChoiHelper.php';
require_once __DIR__ . '/../src/Helpers/TrangBiHelper.php';
require_once __DIR__ . '/../src/Helpers/DaoCuHelper.php';
require_once __DIR__ . '/../src/Helpers/DuocPhamHelper.php';
require_once __DIR__ . '/../src/Helpers/SungVatHelper.php';
require_once __DIR__ . '/../src/Helpers/NhiemVuHelper.php';
use TuTaTuTien\Helpers as Helpers;

$player = \Helpers\layThongTinNguoiChoi($sid,$dblj);
$gonowmid = $encode->encode("cmd=gomid&newmid=$player->idBanDoHienTai&sid=$sid");
$strxl = $encode->encode("cmd=startxiulian&canshu=1&sid=$sid");
$strxl1 = $encode->encode("cmd=startxiulian&canshu=2&sid=$sid");
$endxl = $encode->encode("cmd=endxiulian&sid=$sid");
$nowdate = date('Y-m-d H:i:s');
$xlsjc='Chưa bắt đầu tu luyện';
$tishi = '';
$xlexp = 0;
$xiaohao = 32 * $player->capDo;
$jpxiaohao = round(($player->capDo+1)/2);


if ($cmd == 'startxiulian'){
    if ($player->sfxl == 1){
        $tishi = 'Ngươi đã tại Trong tu luyện<br/>';
    }else{
        if ($canshu == 1){
            $ret = Helpers\thayDoiTienTroChoi(2,$xiaohao,$sid,$dblj);
        }else{
            $ret = Helpers\thayDoiMaThach(2,$jpxiaohao,$sid,$dblj);
        }
        if ($ret){
            Helpers\thayDoiThuocTinhNguoiChoi('xiuliantime',$nowdate,$sid,$dblj);
            Helpers\thayDoiThuocTinhNguoiChoi('sfxl',1,$sid,$dblj);
            $tishi = 'Bắt đầu tu luyện...<br/>';
            $xlsjc = 0;
            $player = \Helpers\layThongTinNguoiChoi($sid,$dblj);
        }else{
            $tishi='Linh thạch không đủ';
        }

    }
}
		$one = strtotime($nowdate) ;
        $tow = strtotime($player->xiuliantime);
        $xlsjc=floor(($one-$tow)/60);
		$xlexp = round($xlsjc * $player->capDo*1);
     if ($xlsjc > 1440){
        $xlsjc = 1440;
        $xlexp = round($xlsjc * $player->capDo*1);//Thu hoạch tu vi tính toán
	 }
if ($cmd == 'endxiulian'){//Kết thúc tu tiên
    if ($player->sfxl == 1){
		Helpers\themKinhNghiem($sid,$dblj,$xlexp);//Cái này cần đột phá, tràn ra không cách nào gia tăng tu luyện giá trị
       // Helpers\themThuocTinhNguoiChoi('uexp',$xlexp,$sid,$dblj);Cái này trực tiếp số cộng dữ liệu, không cần đột phá
        Helpers\thayDoiThuocTinhNguoiChoi('sfxl',0,$sid,$dblj);
		//$player = \Helpers\layThongTinNguoiChoi($sid,$dblj);	
        $xlsjc = 'Kết thúc tu luyện...<br/>Thời gian tu luyện：'.$xlsjc;
        $tishi = 'nhận được  tu vi:'.$xlexp.'<br/>';   
        $player = \Helpers\layThongTinNguoiChoi($sid,$dblj);	
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
    // $xlexp = round($xlsjc * $player->capDo*1000);//Thu hoạch tu vi tính toán
	// $sl = $xlexp;
    //Helpers\themKinhNghiem($sid,$dblj,$xlexp);
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
// $cxwg = Helpers\layThongTinVoCong($wgid,$sid,$dblj);

$xlhtml = <<<HTML
<IMG width='280' height='140' src='./images/xiulian.jpg' style="border-radius: 8px;">
<a href="?cmd=$xiuliancmd" >Ngồi thiền tu luyện</a><a href="?cmd=$wgxl" >Võ công tu hành</a><a href="?cmd=$wgxx" >Bí tịch</a><br>
Tu luyện người chơi：$player->tenNhanVat<br/>
Người chơi trạng thái：$player->canhGioi($player->capDo)<br/>
===============<br/>
Thời gian tu luyện:$xlsjc Phút<br/>
Tu luyện ích lợi:$xlexp Tu vi<br/>
Trước mắt tu vi:$player->kinhNghiem <br/>
===============<br/>
Ngồi thiền trạng thái:$tishi 
===============<br/>
Chú：Nhiều nhất tu luyện 24 Giờ, 1440 Phút<br/>
<br/>
Tu luyện cần linh thạch：$xiaohao/$player->tienTroChoi<br/>
Tu luyện cần ma thạch：$jpxiaohao/$player->tienNap<br/>
$xlcz
		<a href="#" onClick="javascript:history.back(-1);">Trở lại</a>
        <a href="game.php?cmd=$gonowmid" style="float:right;" >Trở về trò chơi</a>
HTML;
echo $xlhtml;
?>