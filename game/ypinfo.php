<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2021 /6/26
 * Time: 15:57
 */
require_once __DIR__ . '/../src/Helpers/NguoiChoiHelper.php';
require_once __DIR__ . '/../src/Helpers/DuocPhamHelper.php';
use TuTaTuTien\Helpers as Helpers;

$nguoiChoi = Helpers\layThongTinNguoiChoi($sid, $dblj);
$yphp = '';
$ypgj = '';
$ypfy = '';
$ypbj = '';
$ypxx = '';
$gonowmid = $encode->encode("cmd=gomid&newmid=$nguoiChoi->idBanDoHienTai&sid=$sid");
$yaopin = Helpers\layThongTinDuocPham($ypid, $dblj);
$playeryp = Helpers\layDuocPhamCuaNguoiChoi($ypid, $sid, $dblj);
$setyp = '';
$tishi='';
if (isset($canshu)){
    switch ($canshu){
        case 'setyp1':
            Helpers\thayDoiThuocTinhNguoiChoi('yp1', $ypid, $sid, $dblj);
            $tishi = "Thiết trí dược phẩm 1 Thành công<br/>";
            break;
        case 'setyp2':
            Helpers\thayDoiThuocTinhNguoiChoi('yp2', $ypid, $sid, $dblj);
            $tishi = "Thiết trí dược phẩm 2 Thành công<br/>";
            break;
        case 'setyp3':
            Helpers\thayDoiThuocTinhNguoiChoi('yp3', $ypid, $sid, $dblj);
            $tishi = "Thiết trí dược phẩm 3 Thành công<br/>";
            break;
        case 'useyp':
            $userypret = Helpers\suDungDuocPham($ypid, 1, $sid, $dblj);
            if ($userypret){
                $tishi = "Sử dụng thành công<br/>";
            }else{
                $tishi = "Sử dụng thất bại<br/>";
            }
            break;
    }
}
if ($playeryp){
    $setyp1 = $encode->encode("cmd=ypinfo&canshu=setyp1&ypid=$ypid&sid=$sid");
    $setyp2 = $encode->encode("cmd=ypinfo&canshu=setyp2&ypid=$ypid&sid=$sid");
    $setyp3 = $encode->encode("cmd=ypinfo&canshu=setyp3&ypid=$ypid&sid=$sid");
    $useyp = $encode->encode("cmd=ypinfo&canshu=useyp&ypid=$ypid&sid=$sid");
    $setyp = <<<HTML
    <br/><font size="2">Dược phẩm vị trí：
    <a href="?cmd=$setyp1">Vị trí 1</a>
    <a href="?cmd=$setyp2">Vị trí 2</a>
    <a href="?cmd=$setyp3">Vị trí 3</a>
	</font><hr>
    <a href="?cmd=$useyp">Sử dụng dược phẩm</a><hr>
HTML;
}
if($yaopin->sinhMenh!=0){
    $yphp = "Khôi phục khí huyết：".$yaopin->sinhMenh."<br/>";
}
if ($yaopin->congKich!=0){
    $ypgj = "Công kích".$yaopin->congKich."<br/>";
}
if ($yaopin->phongNgu!=0){
    $ypfy = "Phòng ngự".$yaopin->phongNgu."<br/>";
}
if ($yaopin->baoKich!=0){
    $ypbj = "Bạo kích".$yaopin->baoKich."<br/>";
}
if ($yaopin->hutMau!=0){
    $ypxx = "Hút máu".$yaopin->hutMau."<br/>";
}
$ypsx = "<br/>".$yphp.$ypgj.$ypfy.$ypbj.$ypxx;
$ypinfo = <<<HTML
<IMG width='280' height='140' src='./images/yaopin.png'src="./images/rw.png" style="border-radius: 8px;">

[{$yaopin->tenDuocPham}]$tishi
$ypsx
$setyp
<br/>
	<a href="#" onClick="javascript:history.back(-1);">Trở lại</a>
    <a href="game.php?cmd=$gonowmid" style="float:right;" >Trở về trò chơi</a> 
HTML;
echo $ypinfo;