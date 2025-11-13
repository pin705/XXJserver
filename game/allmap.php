<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2021/6/17
 * Time: 10:18
 */
require_once __DIR__ . '/../src/Helpers/NguoiChoiHelper.php';
require_once __DIR__ . '/../src/Helpers/BanDoHelper.php';
use TuTaTuTien\Helpers as Helpers;

//$sql = "select * from mid order by mid ASC";//Thu hoạch trước mắt địa đồ
//$cxjg = $dblj->query($sql);

$nguoiChoi = Helpers\layThongTinNguoiChoi($sid, $dblj);
$map = '';

$cxallmap = Helpers\layTatCaKhuVuc($dblj);
$br = 0;
for ($i=0;$i<count($cxallmap);$i++){

    $qyame = $cxallmap[$i]['qyname'];
    $mid = $cxallmap[$i]['mid'];
    if ($mid>0){
        $banDo = Helpers\layThongTinBanDo($mid, $dblj);
        $mname = $banDo->tenBanDo;
        $br++;
        $gomid = $encode->encode("cmd=gomid&newmid=$mid&sid=$sid");
        $map .=<<<HTML
        <a href="?cmd=$gomid" >[$qyame]$mname</a>
HTML;
    }
    if ($br >= 3){
        $br = 0;
        $map.="<br/>"  ;
    }
}


$gonowmid = $encode->encode("cmd=gomid&newmid=$nguoiChoi->idBanDoHienTai&sid=$sid");
$allmap = <<<HTML
<IMG width='280' height='140' src='./images/rw.png'src="./images/rw.png" style="border-radius: 8px;">
<!--<IMG width='280' height='50' src='./images/dt.jpg'>--><hr>
$map<hr>
<a href="#" onClick="javascript:history.back(-1);"  background-color: #ecf7ed;">Trở lại</a>
            <a href="game.php?cmd=$gonowmid" style="float:right;background-color:#cdefea57;" >Trở về trò chơi</a>
HTML;
echo $allmap;
?>