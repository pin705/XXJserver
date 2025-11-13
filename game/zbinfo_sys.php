<?php
require_once __DIR__ . '/../src/Helpers/NguoiChoiHelper.php';
require_once __DIR__ . '/../src/Helpers/TrangBiHelper.php';
use TuTaTuTien\Helpers as Helpers;

$nguoiChoi = Helpers\layThongTinNguoiChoi($sid, $dblj);
$gonowmid = $encode->encode("cmd=gomid&newmid=$nguoiChoi->idBanDoHienTai&sid=$sid");
$trangBi = Helpers\layThongTinTrangBi($zbid, $dblj);
$tools = array("Không hạn","Vũ khí","Đồ phòng ngự","Đồ trang sức","Thư tịch","Tọa kỵ","Lệnh bài","Ám khí");
$tool = $tools[$trangBi->viTri];
//Chủng loại：$tool<br/>==========<br/>
$html = <<<HTML
Trang bị tên:<font color='$trangBi->phamChat'>【 $trangBi->tenTrangBi 】</font><br/>
Trang bị công kích:$trangBi->congKich<br/>
Trang bị phòng ngự:$trangBi->phongNgu<br/>
Gia tăng khí huyết:$trangBi->sinhMenh<br/>
Trang bị bạo kích:$trangBi->baoKich%<br/>
Trang bị hút máu:$trangBi->hutMau%<br/>
==========<br/>
Chủng loại：$tool<br/>==========<br/>
Trang bị tin tức:$trangBi->moTa<br/>

<br/>
	<a href="#" onClick="javascript:history.back(-1);">Trở lại</a>
    <a href="game.php?cmd=$gonowmid" style="float:right;" >Trở về trò chơi</a> 
HTML;
echo $html;
?>