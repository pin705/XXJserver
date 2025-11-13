<?php
require_once __DIR__ . '/../src/Helpers/NguoiChoiHelper.php';
require_once __DIR__ . '/../src/Helpers/TrangBiHelper.php';
require_once __DIR__ . '/../src/Helpers/DaoCuHelper.php';
require_once __DIR__ . '/../src/Helpers/DuocPhamHelper.php';
require_once __DIR__ . '/../src/Helpers/QuaiVatHelper.php';
require_once __DIR__ . '/../src/Helpers/TruongLaoHelper.php';
require_once __DIR__ . '/../src/Helpers/NhiemVuHelper.php';
require_once __DIR__ . '/../src/Helpers/BanDoHelper.php';
require_once __DIR__ . '/../src/Helpers/SungVatHelper.php';
require_once __DIR__ . '/../src/Helpers/KyNangHelper.php';
require_once __DIR__ . '/../src/Helpers/ClubHelper.php';
use TuTaTuTien\Helpers as Helpers;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2021 /12/19 Chuẩn bị sửa chữa sủng vật xuất trạm Cùng thuộc tính trưởng thành
 * Time: 22:22
 */
//if (!isset($uid)){
//
//}
$cxmid = Helpers\layThongTinBanDo($player->idBanDoHienTai,$dblj);
$cxqy = Helpers\layThongTinKhuVuc($cxmid->mqy,$dblj);
$gorehpmid = $encode->encode("cmd=gomid&newmid=$cxqy->mid&sid=$player->sid");
$player = \Helpers\layThongTinNguoiChoi($sid,$dblj);
$pvper = \Helpers\layThongTinNguoiChoiTheoUid($uid,$dblj);
$gonowmid = $encode->encode("cmd=gomid&newmid=$player->idBanDoHienTai&sid=$player->sid");
if ($cxmid->ispvp == 0){
    Helpers\thayDoiThuocTinhNguoiChoi("ispvp",0,$sid,$dblj);
    $tishihtml = 'Trước mắt địa đồ không cho phép PK<br/><br/>'.
        '<a href="?cmd='.$gonowmid.'">Trở về trò chơi</a>';
    exit($tishihtml);;
}

if ($pvper->sfzx == 0){
    Helpers\thayDoiThuocTinhNguoiChoi("ispvp",0,$sid,$dblj);
    $tishihtml = 'Nên người chơi không có online<br/><br/>'.
        '<a href="?cmd='.$gonowmid.'">Trở về trò chơi</a>';
    exit($tishihtml);;
}
if ($pvper->idBanDoHienTai != $player->idBanDoHienTai){
    Helpers\thayDoiThuocTinhNguoiChoi("ispvp",0,$sid,$dblj);
    $tishihtml = 'Nên người chơi không có ở nơi đó đồ<br/><br/>'.
        '<a href="?cmd='.$gonowmid.'">Trở về trò chơi</a>';
    exit($tishihtml);
}
if ($player->sinhMenh<=0){
    Helpers\thayDoiThuocTinhNguoiChoi("ispvp",0,$sid,$dblj);
    $tishihtml = 'Ngươi là thân bị trọng thương, không cách nào tiến hành chiến đấu<br/><br/>'.
        '<a href="?cmd='.$gorehpmid.'">Trở về trò chơi</a>';
    exit($tishihtml);
}
if ($pvper->sinhMenh<=0){
    Helpers\thayDoiThuocTinhNguoiChoi("ispvp",0,$sid,$dblj);
	 Helpers\thayDoiThuocTinhNguoiChoi("ispvp",0,$pvper->sid,$dblj);
	 
    $tishihtml = '<FONT color="#ff7888" size="3.5&sid">Nên người chơi đã nhận bạo lực một kích, trước mắt chính vùng vẫy giãy chết, còn xin đại hiệp giơ cao đánh khẽ。</FONT><br/><br/>'.

        '<a href="?cmd='.$gonowmid.'">Trở về trò chơi</a>';
    exit($tishihtml);
}
//Helpers\thayDoiThuocTinhNguoiChoi("ispvp",$pvper->idNguoiDung,$sid,$dblj);
Helpers\thayDoiThuocTinhNguoiChoi("ispvp",$player->idNguoiDung,$pvper->sid,$dblj);
$pvperhurt = '';
$tishihtml = '';
$pvpbj = '';
if (isset($canshu)){
    switch ($canshu){
        case 'gj':
            $jineng = Helpers\taoMoiKyNang();
            if (isset($jnid)){
                $ret = Helpers\giamKyNang($jnid,1,$sid,$dblj);
                if ($ret){
                    $jineng = Helpers\layThongTinKyNangCuaNguoiChoi($jnid,$sid,$dblj);
                    $tishihtml = "Sử dụng kỹ năng：$jineng->jnname<br/>";
                }else{
                    $tishihtml = "Kỹ năng số lượng không đủ<br/>";
                }
            }
            $player->congKich +=$jineng->jngj;
            $player->phongNgu +=$jineng->jnfy;
            $player->baoKich +=$jineng->jnbj;
            $player->hutMau +=$jineng->jnxx;

            $ran = mt_rand(1,100);
            if ($player->baoKich >= $ran){
                $player->congKich = round($player->congKich * 1.82);
                $pvpbj = 'Bạo kích';
            }

            $pvperhurt = round($player->congKich - $pvper->phongNgu * 0.75,0);
            if ($pvperhurt < $player->congKich * 0.05){
                $pvperhurt = round($player->congKich*0.05);
            }

            $pvpxx = round($pvperhurt*($player->hutMau/100));

            $sql = "update game1 set uhp = uhp - $pvperhurt  WHERE sid = '$pvper->sid'";
            $dblj->exec($sql);


            Helpers\themThuocTinhNguoiChoi("uhp",$pvpxx,$sid,$dblj);

            $player =  Helpers\layThongTinNguoiChoi($sid,$dblj);
			
            if ($player->sinhMenh > $player->sinhMenhToiDa){
                Helpers\thayDoiThuocTinhNguoiChoi("uhp",$player->sinhMenhToiDa,$sid,$dblj);
                $player =  Helpers\layThongTinNguoiChoi($sid,$dblj);
            }
            $pvper = \Helpers\layThongTinNguoiChoiTheoUid($uid,$dblj);
            $pvperhurt = '-'.$pvperhurt;
            if ($pvper->sinhMenh<=0){
                Helpers\thayDoiThuocTinhNguoiChoi("ispvp",0,$sid,$dblj);
                Helpers\thayDoiThuocTinhNguoiChoi("ispvp",0,$pvper->sid,$dblj);
				
				
                $dieinfo = ["Nghe nói$player->tenNhanVat Đánh chết$pvper->tenNhanVat","$pvper->tenNhanVat Bị$player->tenNhanVat Đánh cho hoa rơi nước chảy"," $player->tenNhanVat Đem$pvper->tenNhanVat Đánh cho sinh hoạt không thể tự gánh vác"];
				
				
                $randdie = mt_rand(0,count($dieinfo)-1);
                $msg = $dieinfo[$randdie];
                $sql = "insert into ggliaotian(name,msg,uid) values('【Nghe đồn】','$msg','0')";
                $cxjg = $dblj->exec($sql);
                $html = '
                    Chiến đấu kết quả:<br/>
                    Ngươi đánh chết'.$pvper->tenNhanVat.'<br/>
                    Chiến đấu thắng lợi！<br/>
                    <a href="?cmd='.$gonowmid.'">Trở về trò chơi</a>';
                exit($html);
            }
            break;
    }
}

if ($player->sinhMenh<=0){
    $cxmid = Helpers\layThongTinBanDo($player->idBanDoHienTai,$dblj);
    $cxqy = Helpers\layThongTinKhuVuc($cxmid->mqy,$dblj);
    Helpers\thayDoiThuocTinhNguoiChoi("ispvp",0,$sid,$dblj);
    Helpers\thayDoiThuocTinhNguoiChoi("ispvp",0,$pvper->sid,$dblj);
    $html = <<<HTML
            Chiến đấu kết quả:<br/>
            Ngươi bị$guaiwu->tenQuaiVat Đánh chết<br/>
            Chiến đấu thất bại！<br/>
            Mời thiếu hiệp lại đến<br/>
            <br/>
            <a href="?cmd=$gorehpmid">Trở về trò chơi</a>
HTML;
    exit($html);
}

$pgjcmd = $encode->encode("cmd=pvp&canshu=gj&uid=$uid&sid=$player->sid");

$usejn1 = $encode->encode("cmd=pvp&canshu=usejn&jnid=$player->jn1&sid=$sid&uid=$uid");
$usejn2 = $encode->encode("cmd=pvp&canshu=usejn&jnid=$player->jn2&sid=$sid&uid=$uid");
$usejn3 = $encode->encode("cmd=pvp&canshu=usejn&jnid=$player->jn3&sid=$sid&uid=$uid");

$jnname1 = 'Phù lục 1';
$jnname2 = 'Phù lục 2';
$jnname3 = 'Phù lục 3';


if ($player->jn1!=0){
    $jineng = Helpers\layThongTinKyNangCuaNguoiChoi($player->jn1,$sid,$dblj);
    if ($jineng){
        $jnname1 = $jineng->jnname.'('.$jineng->jncount.')';
    }
}
if ($player->jn2!=0){
    $jineng = Helpers\layThongTinKyNangCuaNguoiChoi($player->jn2,$sid,$dblj);
    if ($jineng){
        $jnname2 = $jineng->jnname.'('.$jineng->jncount.')';
    }
}
if ($player->jn3!=0){
    $jineng = Helpers\layThongTinKyNangCuaNguoiChoi($player->jn3,$sid,$dblj);;
    if ($jineng){
        $jnname3 = $jineng->jnname.'('.$jineng->jncount.')';
    }
}

$html = <<<HTML
==Chiến đấu==<br/>
$pvper->tenNhanVat [lv:$pvper->capDo]<br/>

Khí huyết:(<div class="hpys" style="display: inline">$pvper->sinhMenh</div>/<div class="hpys" style="display: inline">$pvper->sinhMenhToiDa</div>)$pvpbj $pvperhurt<br/>
Công kích:($pvper->congKich)<br/>
Phòng ngự:($pvper->phongNgu)<br/>
===================<br/>
$player->tenNhanVat [lv:$player->capDo]<br/>
Khí huyết:(<div class="hpys" style="display: inline">$player->sinhMenh</div>/<div class="hpys" style="display: inline">$player->sinhMenhToiDa</div>)<br/>
Công kích:($player->congKich)<br/>
Phòng ngự:($player->phongNgu)<br/>
$tishihtml
<ul>
<li><a href="?cmd=$pgjcmd">Công kích</a></li><br/>
<li><a href="?cmd=$gonowmid">Chạy trốn</a></li>
</ul>
<a href="?cmd=$usejn1">$jnname1</a>.<a href="?cmd=$usejn2">$jnname2</a>.<a href="?cmd=$usejn3">$jnname3</a><br/>
<br/>
HTML;
echo $html;
