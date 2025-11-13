<?php
require_once __DIR__ . '/../src/Helpers/NguoiChoiHelper.php';
require_once __DIR__ . '/../src/Helpers/TrangBiHelper.php';
require_once __DIR__ . '/../src/Helpers/DaoCuHelper.php';
require_once __DIR__ . '/../src/Helpers/DuocPhamHelper.php';
require_once __DIR__ . '/../src/Helpers/ClubHelper.php';
use TuTaTuTien\Helpers as Helpers;

$nguoiChoi = Helpers\layThongTinNguoiChoi($sid,$dblj);
$player1 = Helpers\layThongTinNguoiChoiTheoUid($uid,$dblj);
$immenu='';

$gonowmid = $encode->encode("cmd=gomid&newmid=$nguoiChoi->idBanDoHienTai&sid=$sid");
$pkcmd = $encode->encode("cmd=pvp&uid=$uid&sid=$sid");
$clubplayer = Helpers\layThongTinClubPlayer($player1->sid,$dblj);
if (isset($canshu)){
    if ($canshu == "addim"){
        Helpers\themBanBe($uid,$sid,$dblj);
    }
}

if ($clubplayer){
    $club = Helpers\layThongTinClub($clubplayer->clubid,$dblj);
    $clubcmd = $encode->encode("cmd=club&clubid=$club->clubid&sid=$sid");
    $clubname ="<a href='?cmd=$clubcmd'>$club->clubname</a>";
}else{
    $clubname = "Không môn không phái";
}
if ($nguoiChoi->sid != $player1->sid){
    $immenu = "<a href='?cmd=$pkcmd' style='color:#ff0000'>Công kích</a>";
    $ret = Helpers\kiemTraLaBanBe($uid,$sid,$dblj);
    if (!$ret){
        $addim=  $encode->encode("cmd=getplayerinfo&canshu=addim&uid=$uid&sid=$sid");
        $immenu.="<a href='?cmd=$addim' style='
    color: #009688;'>Kết giao</a><hr>";
    }else{
        $chat=  $encode->encode("cmd=getplayerinfo&canshu=addim&uid=$uid&sid=$sid");
        $deim=  $encode->encode("cmd=im&canshu=deim&uid=$uid&sid=$sid");
        $immenu.=<<<HTML
        </a><a href='?cmd=$deim'>Xóa bỏ hảo hữu</a>
<form>
<input type="hidden" name="cmd" value="sendliaotian">
<input type="hidden" name="ltlx" value="im">
<input type="hidden" name="sid" value="$sid">
<input type="hidden" name="imuid" value="$uid">
<input name="ltmsg">
<input type="submit" value="Gửi đi nói chuyện riêng">
</form>

HTML;
    }
    $immenu .= "<br/>";
}

$tool1 = '';
$tool2 = '';
$tool3 = '';
$tool4 = '';
$tool5 = '';
$tool6 = '';
$tool7 = '';

if ($player1->viTriTrangBi1!=0){
    $zhuangbei = Helpers\layThongTinTrangBiTheoId($player1->viTriTrangBi1,$dblj);
    $qhs = '';
    if ($zhuangbei->capCuongHoa>0){
        $qhs = '+'.$zhuangbei->capCuongHoa;
    }
    $zbcmd = $encode->encode("cmd=chakanzb&zbnowid=$player1->viTriTrangBi1&uid=$player1->idNguoiDung&sid=$sid");
	
$tool1 = "Vũ khí:<a href='?cmd=$zbcmd'><font color='$zhuangbei->phamChat'>{$zhuangbei->tenTrangBi}</font>{$qhs}</a><br/>";//Hai cái điểm trong dấu ngoặc cao cấp không cần'.#FFF.'Trực tiếp'#FF'

}
if ($player1->viTriTrangBi2!=0){
    $zhuangbei = Helpers\layThongTinTrangBiTheoId($player1->viTriTrangBi2,$dblj);
    $qhs = '';
    if ($zhuangbei->capCuongHoa>0){
        $qhs = '+'.$zhuangbei->capCuongHoa;
    }
    $zbcmd = $encode->encode("cmd=chakanzb&zbnowid=$player1->viTriTrangBi2&uid=$player1->idNguoiDung&sid=$sid");
    $tool2 = "Đồ phòng ngự:<a href='?cmd=$zbcmd'><font color='$zhuangbei->phamChat'>{$zhuangbei->tenTrangBi}</font>{$qhs}</a><br/>";
}
if ($player1->viTriTrangBi3!=0){
    $zhuangbei = Helpers\layThongTinTrangBiTheoId($player1->viTriTrangBi3,$dblj);
    $qhs = '';
    if ($zhuangbei->capCuongHoa>0){
        $qhs = '+'.$zhuangbei->capCuongHoa;
    }
    $zbcmd = $encode->encode("cmd=chakanzb&zbnowid=$player1->viTriTrangBi3&uid=$player1->idNguoiDung&sid=$sid");
    $tool3 = "Đồ trang sức:<a href='?cmd=$zbcmd'><font color='$zhuangbei->phamChat'>{$zhuangbei->tenTrangBi}</font>{$qhs}</a><br/>";
}
if ($player1->viTriTrangBi4!=0){
    $zhuangbei = Helpers\layThongTinTrangBiTheoId($player1->viTriTrangBi4,$dblj);
    $qhs = '';
    if ($zhuangbei->capCuongHoa>0){
        $qhs = '+'.$zhuangbei->capCuongHoa;
    }
    $zbcmd = $encode->encode("cmd=chakanzb&zbnowid=$player1->viTriTrangBi4&uid=$player1->idNguoiDung&sid=$sid");
    $tool4 = "Thư tịch:<a href='?cmd=$zbcmd'><font color='$zhuangbei->phamChat'>{$zhuangbei->tenTrangBi}</font>{$qhs}</a><br/>";
}
if ($player1->viTriTrangBi5!=0){
    $zhuangbei = Helpers\layThongTinTrangBiTheoId($player1->viTriTrangBi5,$dblj);
    $qhs = '';
    if ($zhuangbei->capCuongHoa>0){
        $qhs = '+'.$zhuangbei->capCuongHoa;
    }
    $zbcmd = $encode->encode("cmd=chakanzb&zbnowid=$player1->viTriTrangBi5&uid=$player1->idNguoiDung&sid=$sid");
    $tool5 = "Tọa kỵ:<a href='?cmd=$zbcmd'><font color='$zhuangbei->phamChat'>{$zhuangbei->tenTrangBi}</font>{$qhs}</a><br/>";;
}
if ($player1->viTriTrangBi6!=0){
    $zhuangbei = Helpers\layThongTinTrangBiTheoId($player1->viTriTrangBi6,$dblj);
    $qhs = '';
    if ($zhuangbei->capCuongHoa>0){
        $qhs = '+'.$zhuangbei->capCuongHoa;
    }
    $zbcmd = $encode->encode("cmd=chakanzb&zbnowid=$player1->viTriTrangBi6&uid=$player1->idNguoiDung&sid=$sid");
    $tool6 = "Lệnh bài:<a href='?cmd=$zbcmd'><font color='$zhuangbei->phamChat'>{$zhuangbei->tenTrangBi}</font>{$qhs}</a><br/>";;
}
if ($player1->viTriTrangBi7!=0){
    $zhuangbei = Helpers\layThongTinTrangBiTheoId($player1->viTriTrangBi7,$dblj);
    $qhs = '';
    if ($zhuangbei->capCuongHoa>0){
        $qhs = '+'.$zhuangbei->capCuongHoa;
    }
    $zbcmd = $encode->encode("cmd=chakanzb&zbnowid=$player1->viTriTrangBi7&uid=$player1->idNguoiDung&sid=$sid");
    $tool7 = "Ám khí:<a href='?cmd=$zbcmd'><font color='$zhuangbei->phamChat'>{$zhuangbei->tenTrangBi}</font>{$qhs}</a><br/>";;
}
//Dẫn vào võ công, mượn gió bẻ măng
$wgid = $nguoiChoi->wugong;
$cxwg = Helpers\layThongTinVoCong($wgid,$sid,$dblj);
$wglx = $cxwg->wglx;
$wgys = $cxwg->wgys;
if ($nguoiChoi->wugong!=0&&$wglx==0){
	$tishi = "<a href='?cmd=$gonowmid' style='color:$wgys'>$cxwg->wgname</a>";
}

$ztcmd = $encode->encode("cmd=otherzhuangtai&sid=$sid");//Thông tin cá nhân
$cwinfo = $encode->encode("cmd=chongwu&cwid=$player1->cw&canshu=cwinfo&sid=$sid");//Sủng vật kết nối
$html = <<<HTML
【<a>Thông tin cá nhân</a><a href="?cmd=$cwinfo"><font color="#e28e0c">Sủng vật tin tức</font></a>】<br/>
Biệt danh:$player1->tenNhanVat<br/>
Môn phái:$clubname<br/>
Cảnh giới:$player1->canhGioi $player1->tangCanhGioi<br/>
Đẳng cấp:$player1->capDo<br/>
Tu vi:$player1->kinhNghiem/$player1->kinhNghiemToiDa<br/>
Linh thạch:$player1->tienTroChoi$tishi<br/>
Ma thạch:$player1->tienNap<br/>
Khí huyết:$player1->sinhMenh/$player1->sinhMenhToiDa<br/>
Công kích:$player1->congKich<br/>
Phòng ngự:$player1->phongNgu<br/>
Bạo kích:$player1->baoKich<br/>
Hút máu:$player1->hutMau<br/>
<hr>
$tool1
$tool2
$tool3
$tool4
$tool5
$tool6
$tool7
<hr>
$immenu
<a href="#" onClick="javascript:history.back(-1);" style=" background-color: #ecf7ed;">Trở lại</a><!--Cư trái-float:left;-->
<a href="game.php?cmd=$gonowmid" style="float:right;background-color:#ecf7ed;" >Trở về trò chơi</a>
HTML;
echo $html;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/ 12/01
 * Time: 18:10
 */?>