<?php
require_once __DIR__ . '/../src/Helpers/NguoiChoiHelper.php';
use TuTaTuTien\Helpers as Helpers;

$nguoiChoi = Helpers\layThongTinNguoiChoi($sid, $dblj);
$gonowmid = $encode->encode("cmd=gomid&newmid=$nguoiChoi->idBanDoHienTai&sid=$sid");
$getbagzbcmd = $encode->encode("cmd=getbagzb&sid=$sid");
$getbagdjcmd = $encode->encode("cmd=getbagdj&sid=$sid");
$getbagjncmd = $encode->encode("cmd=getbagjn&sid=$sid");
$yaopin = player\getplayeryaopinall($sid,$dblj);
$allyp= '';
$suoyin = 0;
if ($yaopin){
    foreach ($yaopin as $yp){
        $ypsum = $yp['ypsum'];
        if ($ypsum > 0){
            $suoyin += 1;
            $ypid = $yp['ypid'];
            $ypname = $yp['ypname'];
            $ypcmd = $encode->encode("cmd=ypinfo&ypid=$ypid&sid=$sid");
            $allyp .= <<<HTML
            [$suoyin].<a href="?cmd=$ypcmd">{$ypname}x$ypsum</a><br/>
HTML;
        }
    }
}
$getbagydcmd = $encode->encode("cmd=getbagyd&sid=$sid");
$bagyphtml =<<<HTML

<font size="2"><div class="menu"><a href="?cmd=$getbagzbcmd">Trang bị</a><a href="?cmd=$getbagdjcmd">Đạo cụ</a><a href="#" style="background-color: gray;">Dược phẩm</a><a href="?cmd=$getbagjncmd">Kỹ năng</a><a href="?cmd=$getbagydcmd">Đan dược</a></div></font><br>
<br/>
$allyp
<br/>

<a href="#" onClick="javascript:history.back(-1);">Trở lại</a>
        <a href="game.php?cmd=$gonowmid" style="float:right;background-color:#cff3d2;color: #755d5d;" >Trở về trò chơi</a>
HTML;
echo $bagyphtml;

?>