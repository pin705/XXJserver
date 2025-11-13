

<?php
/*
Nơi này ta bố trí ba lô, chủ yếu là cửa hàng công năng cất giữ
*/
require_once __DIR__ . '/../Helpers/NguoiChoiHelper.php';
require_once __DIR__ . '/../Helpers/DuocPhamHelper.php';
use TuTaTuTien\Helpers as Helpers;

$nguoiChoi = Helpers\layThongTinNguoiChoi($sid, $dblj);

$gonowmid = $encode->encode("cmd=goto_map&newmid=$nguoiChoi->idBanDoHienTai&sid=$sid");
$getbagzbcmd = $encode->encode("cmd=get_equipment_bag&sid=$sid");
$getbagdjcmd = $encode->encode("cmd=get_item_bag&sid=$sid");
$getbagjncmd = $encode->encode("cmd=get_skill_bag&sid=$sid");
$getbagydcmd = $encode->encode("cmd=get_medicine_bag&sid=$sid");
$yaodan = Helpers\layTatCaDuocDanCuaNguoiChoi($sid, $dblj);

$allyd= '';
$suoyin = 0;
if ($yaodan){
    foreach ($yaodan as $yd){
        $ydsum = $yd['ydsum'];
        if ($ydsum > 0){
            $suoyin += 1;
            $ydid = $yd['ydid'];
            $ydname = $yd['ydname'];
            $ydcmd = $encode->encode("cmd=medicine_info&ydid=$ydid&sid=$sid");
			
			$playeryd = Helpers\layDuocDanCuaNguoiChoi($ydid, $sid, $dblj);
			
            $useyd = $encode->encode("cmd=medicine_info&canshu=useyd&ydid=$ydid&sid=$sid");
			
			$yaodan1 = Helpers\layThongTinDuocDan($ydid, $dblj);//Dẫn vào nhan sắc văn kiện
			
            $allyd .= <<<HTML
            [$suoyin].<a href="?cmd=$ydcmd"><font color='{$yaodan1->ydys}'>{$ydname}</font>x$ydsum</a><a href="?cmd=$useyd">Sử dụng</a>
			<br/>
HTML;
        }
    }
}
        $shangdian = $encode->encode("cmd=shop&canshu=gogoumai&sid=$sid");
		$shangdian1 = $encode->encode("cmd=shop&canshu1=gogoumai1&sid=$sid");
		$beibaocmd = $encode->encode("cmd=get_medicine_bag&sid=$sid");
		$getbagydcmd = $encode->encode("cmd=get_medicine_bag&sid=$sid");

$bagydhtml =<<<HTML
 <IMG width='280' height='140' src='./images/miji.png'src="./images/rw.png" style="border-radius: 8px;">
 
<!--【<a href="?cmd=$getbagzbcmd">Trang bị</a>|<a href="?cmd=$getbagdjcmd">Đạo cụ</a>|Dược phẩm|<a href="?cmd=$getbagjncmd">Phù lục</a>】<br/>-->
        <div class="menu">
            <a href="?cmd=$shangdian">Linh thạch đan dược</a></a>
            <a href="?cmd=$shangdian1"><font color="#9c27b0">Ma thạch đan dược</font></a>
			<a href="?cmd=$beibaocmd">Hiệu thuốc</a>
        </div>
            <br/>
<br/>
$allyd
<br/>

<a href="#" onClick="javascript:history.back(-1);">Trở lại</a>
        <a href="game.php?cmd=$gonowmid" style="float:right;background-color:#cff3d2;color: #755d5d;" >Trở về trò chơi</a>
HTML;
echo $bagydhtml;

?>