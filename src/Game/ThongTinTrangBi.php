<?php
require_once __DIR__ . '/../Helpers/NguoiChoiHelper.php';
require_once __DIR__ . '/../Helpers/TrangBiHelper.php';
require_once __DIR__ . '/../Helpers/DaoCuHelper.php';
use TuTaTuTien\Helpers as Helpers;
use TuTaTuTien\Classes\TrangBi;

$player = Helpers\layThongTinNguoiChoi($sid, $dblj);
$gonowmid = $encode->encode("cmd=goto_map&newmid=$player->idBanDoHienTai&sid=$sid");
$zhuangbei = new TrangBi();
if ($zbnowid!=0){
    $zhuangbei = Helpers\layThongTinTrangBiTheoId($zbnowid, $dblj);
}

$arr = array($player->tool1,$player->tool2,$player->tool3,$player->tool4,$player->tool5,$player->tool6,$player->tool7);
$setzbwz='';
$upgj = '';
$upfy = '';
$uphp = '';
$upbj = '';
$upxx = '';
$upts = '';
$qhssum = '';
$upls = round($zhuangbei->capCuongHoa/2) * round($zhuangbei->capCuongHoa/3) * 2 * (round($zhuangbei->capCuongHoa / 4) )+ 1;

if (isset($canshu)){
    if ($canshu == "chushou" && !in_array($zhuangbei->idTrangBi,$arr) && isset($pay) && $pay > 0){
        try {

            $dblj->setAttribute(PDO::ATTR_AUTOCOMMIT, 0);
            $dblj->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $dblj->beginTransaction();

            $sql = "insert into `fangshi_zb`(zbname, zbinfo, zbgj, zbfy, zbbj, zbxx, zbid, uid, zbnowid, sid, zbhp, qianghua, zblv, pay,zbys) VALUES ('$zhuangbei->tenTrangBi','$zhuangbei->moTa','$zhuangbei->congKich','$zhuangbei->phongNgu','$zhuangbei->baoKich','$zhuangbei->hutMau','$zhuangbei->idMauTrangBi','$player->idNguoiDung','$zbnowid','$sid','$zhuangbei->sinhMenh','$zhuangbei->capCuongHoa','$zhuangbei->capDoYeuCau','$pay','$zhuangbei->phamChat')";
            $affected_rows = $dblj->exec($sql);
            if (!$affected_rows){
                throw new PDOException("Trang bị treo bán thất bại<br/>");//Cái kia sai lầm ném ra ngoài dị thường
            }
            $sql="UPDATE `playerzhuangbei` SET uid=0,sid='' WHERE zbnowid = $zbnowid";
            $affected_rows=$dblj->exec($sql);
            if (!$affected_rows){
                throw new PDOException("Trang bị truyền tống thất bại<br/>");//Cái kia sai lầm ném ra ngoài dị thường
            }
            echo "Treo bán thành công！<br/>";
            $dblj->commit();//Giao dịch thành công liền đưa ra
        }catch(PDOException $e){
            echo $e->getMessage();
            $dblj->rollBack();
        }
        $dblj->setAttribute(PDO::ATTR_AUTOCOMMIT, 1);//Quan bế
        $zhuangbei = Helpers\layThongTinTrangBiTheoId($zbnowid, $dblj);
    }
}


if ($player->uid == $zhuangbei->uid){
    $uyxb = '/'.$player->uyxb;
    if ($cmd=='upzb'){
        if ($player->uyxb >=$upls){
            $ret = Helpers\nangCapThuocTinhTrangBi($zbnowid,$upsx,$sid,$dblj);
            if ($ret != -1){
                $retyxb = Helpers\thayDoiTienTroChoi(2,$upls,$sid,$dblj);
                if ($ret==1){
                    $upts = "Chúc mừng cường hóa thành công<br/>";
                }elseif ($ret==0){
                    $upts = "Cường hóa thất bại, mời tích lũy tích nhân phẩm<br/>";
                }
                $zhuangbei = Helpers\layThongTinTrangBiTheoId($zbnowid,$dblj);

            }else{
                $upts = "Cường hóa thất bại, cường hóa thạch không đủ<br/>";
            }
        }else{
            $upts = "Cường hóa thất bại, linh thạch không đủ<br/>";
        }
    }
    $upgj = $encode->encode("cmd=upgrade_equipment&upsx=zbgj&zbnowid=$zhuangbei->zbnowid&sid=$sid");
    $upfy = $encode->encode("cmd=upgrade_equipment&upsx=zbfy&zbnowid=$zhuangbei->zbnowid&sid=$sid");
    $uphp = $encode->encode("cmd=upgrade_equipment&upsx=zbhp&zbnowid=$zhuangbei->zbnowid&sid=$sid");
    $upbj = $encode->encode("cmd=upgrade_equipment&upsx=zbbj&zbnowid=$zhuangbei->zbnowid&sid=$sid");
    $upxx = $encode->encode("cmd=upgrade_equipment&upsx=zbxx&zbnowid=$zhuangbei->zbnowid&sid=$sid");
    $daoju = player\getplayerdaoju($sid,1,$dblj);
    $qhssum = '/0';
    if ($daoju){
        $qhssum = '/'.$daoju->djsum;
    }

    $upgj =<<<HTML
    <a href="?cmd=$upgj">Cường hóa công kích</a>
HTML;
    $upfy =<<<HTML
    <a href="?cmd=$upfy">Cường hóa phòng ngự</a>
HTML;
    $uphp =<<<HTML
    <a href="?cmd=$uphp">Cường hóa khí huyết</a>
HTML;
    $upbj =<<<HTML
    <a href="?cmd=$upbj">Cường hóa bạo kích</a>
HTML;
    $upxx =<<<HTML
    <a href="?cmd=$upxx">Cường hóa hút máu</a>
HTML;
}else{
    $uyxb='';
}

if ($player->idNguoiDung == $zhuangbei->idNguoiDung && !in_array($zhuangbei->idTrangBi,$arr)){

    $player = Helpers\layThongTinNguoiChoi($sid, $dblj);
    $delezb = $encode->encode("cmd=delete_equipment&zbnowid=$zhuangbei->idTrangBi&sid=$sid");
    $self = $_SERVER['PHP_SELF'];
    $setzbwz = $encode->encode("cmd=set_equipment_position&zbwz={$zhuangbei->viTriTrangBi}&zbnowid=$zhuangbei->idTrangBi&sid=$sid");
    $setzbwz = "<a href='?cmd=$setzbwz'>Mặc trang bị</a>";

    if ($zhuangbei->viTriTrangBi == 0){
        $setzbwz1 = $encode->encode("cmd=set_equipment_position&zbwz=1&zbnowid=$zhuangbei->idTrangBi&sid=$sid");
        $setzbwz2 = $encode->encode("cmd=set_equipment_position&zbwz=2&zbnowid=$zhuangbei->idTrangBi&sid=$sid");
        $setzbwz3 = $encode->encode("cmd=set_equipment_position&zbwz=3&zbnowid=$zhuangbei->idTrangBi&sid=$sid");
        $setzbwz4 = $encode->encode("cmd=set_equipment_position&zbwz=4&zbnowid=$zhuangbei->idTrangBi&sid=$sid");
        $setzbwz5 = $encode->encode("cmd=set_equipment_position&zbwz=5&zbnowid=$zhuangbei->idTrangBi&sid=$sid");
        $setzbwz6 = $encode->encode("cmd=set_equipment_position&zbwz=6&zbnowid=$zhuangbei->idTrangBi&sid=$sid");
        $setzbwz7 = $encode->encode("cmd=set_equipment_position&zbwz=7&zbnowid=$zhuangbei->idTrangBi&sid=$sid");

        $setzbwz = "
    <a href='?cmd=$setzbwz1'>Trang bị tại【Vũ khí】Vị trí</a>
    <a href='?cmd=$setzbwz2'>Trang bị tại【Đồ phòng ngự】Vị trí</a><br/>
    <a href='?cmd=$setzbwz3'>Trang bị tại【Đồ trang sức】Vị trí</a>
    <a href='?cmd=$setzbwz4'>Trang bị tại【Thư tịch】Vị trí</a><br/>
    <a href='?cmd=$setzbwz5'>Trang bị tại【Tọa kỵ】Vị trí</a>
    <a href='?cmd=$setzbwz6'>Trang bị tại【Lệnh bài】Vị trí</a><br/>
    <a href='?cmd=$setzbwz7'>Trang bị tại【Ám khí】Vị trí</a>";
    }

    $setzbwz .=<<<HTML
    <a href="?cmd=$delezb" style="float:right;">Phân giải trang bị</a>
    <br/>
    <form action="$self">
    <input type="hidden" name="cmd" value="chakanzb">
    <input type="hidden" name="canshu" value="chushou">
    <input type="hidden" name="sid" value='$sid'>
    <input type="hidden" name="zbnowid" value="$zhuangbei->idTrangBi">
	<div align="center">
    Đấu giá đơn giá：<br/>
    <input type="number" name="pay"> 
    <input type="submit" value="Đấu giá">
	</div>
    </form>
HTML;
}
$updjsl = $zhuangbei->capCuongHoa * 3 + 1;
$upls = round($zhuangbei->capCuongHoa/2) * round($zhuangbei->capCuongHoa/3) * 2 * (round($zhuangbei->capCuongHoa / 4) )+ 1;
$fjls = $zhuangbei->capCuongHoa * 20 + 20;
$qianghua = '';
if ($zhuangbei->capCuongHoa>0){
    $qianghua="+".$zhuangbei->capCuongHoa;
}

$qhcgl = round((30-$zhuangbei->capCuongHoa)/30,2) * 100;//Trang bị cường hóa xác suất thành công tính toán
$qhcgl .='%';
$tools = array("Không hạn định","Vũ khí","Đồ phòng ngự","Đồ trang sức","Thư tịch","Tọa kỵ","Lệnh bài","Ám khí");
$tool = $tools[$zhuangbei->viTriTrangBi];


$html = <<<HTML
Trang bị tên:<font color='$zhuangbei->phamChat'>【 $zhuangbei->tenTrangBi 】</font>$qianghua<br/>
Trang bị đẳng cấp:$zhuangbei->capDoYeuCau<br/>
Trang bị công kích:$zhuangbei->congKich$upgj<br/>
Trang bị phòng ngự:$zhuangbei->phongNgu$upfy<br/>
Gia tăng khí huyết:$zhuangbei->sinhMenh$uphp<br/>
Trang bị bạo kích:$zhuangbei->baoKich%<br/>
Trang bị hút máu:$zhuangbei->hutMau%<br/>
<!--
Gia tăng khí huyết:$zhuangbei->sinhMenh$uphp<br/>
Trang bị hút máu:$zhuangbei->hutMau$upxx<br/>Mở ra hút máu cường hóa
-->

=======<br>
Chủng loại:<font style="color: #f90909;">$tool</font><br>
=======<br>
Trang bị tin tức:$zhuangbei->moTa<br/>
Cường hóa xác suất thành công：$qhcgl<br/>
Cường hóa cần cường hóa thạch：$updjsl$qhssum<br/>
Cường hóa cần linh thạch：$upls$uyxb<br/>
Phân giải cần linh thạch：$fjls$uyxb<br/>
$upts
$setzbwz
<br/>
	<a href="#" onClick="javascript:history.back(-1);">Trở lại</a>
    <a href="game.php?cmd=$gonowmid" style="float:right;" >Trở về trò chơi</a> 
HTML;
echo $html;
?>