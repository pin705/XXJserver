<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/8/11
 * Time: 18:54
 */
require_once __DIR__ . '/../Helpers/NguoiChoiHelper.php';
require_once __DIR__ . '/../Helpers/KyNangHelper.php';
require_once __DIR__ . '/../Helpers/DaoCuHelper.php';
use TuTaTuTien\Helpers as Helpers;

$nguoiChoi = Helpers\layThongTinNguoiChoi($sid, $dblj);
$jineng = Helpers\layThongTinKyNang($jnid, $dblj);
$duihuan = $encode->encode("cmd=skill_info&canshu=duihuan&jnid=$jnid&sid=$sid");
$gonowmid = $encode->encode("cmd=goto_map&newmid=$nguoiChoi->idBanDoHienTai&sid=$sid");
$htmltishi = '';
$playerjn = Helpers\layKyNangCuaNguoiChoi($jnid, $sid, $dblj);

$daoju = Helpers\layDaoCuCuaNguoiChoi($sid, $jineng->idDaoCuCanThiet, $dblj);
$dhdaoju = Helpers\layThongTinDaoCu($jineng->idDaoCuCanThiet, $dblj);
if (!$daoju){
    $daoju = Helpers\layThongTinDaoCu($jineng->idDaoCuCanThiet, $dblj);
    $daoju->soLuong = 0;
}

if (isset($canshu)){
    switch ($canshu){
        case 'duihuan':
            $ret = Helpers\xoaDaoCuCuaNguoiChoi($jineng->idDaoCuCanThiet, $jineng->soLuongDaoCuCanThiet, $sid, $dblj);
            if ($ret){
                Helpers\themKyNangChoNguoiChoi($jnid, 1, $sid, $dblj);
                $htmltishi = "Hối đoái thành công<br/>";
                $playerjn = Helpers\layKyNangCuaNguoiChoi($jnid, $sid, $dblj);
                $daoju = Helpers\layDaoCuCuaNguoiChoi($sid, $jineng->idDaoCuCanThiet, $dblj);
            }else{
                $htmltishi = "Đạo cụ số lượng không đủ<br/>";
            }

            break;
        case 'setjn1':
            Helpers\thayDoiThuocTinhNguoiChoi('jn1', $jnid, $sid, $dblj);
            $htmltishi = "Thiết trí phù lục 1 Thành công<br/>";
            break;
        case 'setjn2':
            Helpers\thayDoiThuocTinhNguoiChoi('jn2', $jnid, $sid, $dblj);
            $htmltishi = "Thiết trí phù lục 2 Thành công<br/>";
            break;
        case 'setjn3':
            Helpers\thayDoiThuocTinhNguoiChoi('jn3', $jnid, $sid, $dblj);
            $htmltishi = "Thiết trí phù lục 3 Thành công<br/>";
            break;
    }


}

$dhhtml = "Hối đoái cần：$dhdaoju->tenDaoCu($daoju->soLuong/$jineng->soLuongDaoCuCanThiet)<a href='?cmd=$duihuan'>Hối đoái</a><br/><br/>";
if ($playerjn){
    $setjn1 = $encode->encode("cmd=skill_info&canshu=setjn1&jnid=$jnid&sid=$sid");
    $setjn2 = $encode->encode("cmd=skill_info&canshu=setjn2&jnid=$jnid&sid=$sid");
    $setjn3 = $encode->encode("cmd=skill_info&canshu=setjn3&jnid=$jnid&sid=$sid");
    $dhhtml .=
        '<a href="?cmd='.$setjn1.'">Trang bị phù lục 1</a>'.
        '<a href="?cmd='.$setjn2.'">Trang bị phù lục 2</a>'.
        '<a href="?cmd='.$setjn3.'">Trang bị phù lục 3</a><br/>';
}

?>
Kỹ năng tên：<?php echo $jineng->tenKyNang; ?><br/>
Công kích tăng thêm：<?php echo $jineng->congKich; ?>%<br/>
Phòng ngự tăng thêm：<?php echo $jineng->phongNgu; ?>%<br/>
Bạo kích tăng thêm：<?php echo $jineng->baoKich; ?>%<br/>
Hút máu tăng thêm：<?php echo $jineng->hutMau; ?>%<br/>
<?php echo $htmltishi; ?>
<?php echo $dhhtml; ?>
<br/>
<a href="#" onClick="javascript:history.back(-1);">Trở lại</a><br/>
<a href="?cmd=<?php echo $gonowmid; ?>">Trở về trò chơi</a><br/>
