<?php
require_once __DIR__ . '/../Helpers/KyNangHelper.php';
use TuTaTuTien\Helpers as Helpers;

$gonowmid = $encode->encode("cmd=goto_map&newmid=$player->nowmid&sid=$sid");
$getbagzbcmd = $encode->encode("cmd=get_equipment_bag&sid=$sid");
$getbagdjcmd = $encode->encode("cmd=get_item_bag&sid=$sid");
$getbagypcmd = $encode->encode("cmd=get_pill_bag&sid=$sid");
$jineng = Helpers\layTatCaKyNangCuaNguoiChoi($sid, $dblj);

$alljn= '';
$suoyin = 0;
if ($jineng){
    foreach ($jineng as $jn){
        $jnsum = $jn['jncount'];
        if ($jnsum > 0){
            $suoyin += 1;
            $jnid = $jn['jnid'];
            $jnname = $jn['jnname'];
            $jncmd = $encode->encode("cmd=skill_info&jnid=$jnid&sid=$sid");
            $alljn .= <<<HTML
            [$suoyin].<a href="?cmd=$jncmd">$jnname x$jnsum</a><br/>
HTML;
        }
    }
}
$getbagydcmd = $encode->encode("cmd=get_medicine_bag&sid=$sid");
$bagyphtml =<<<HTML

<font size="2"><div class="menu"><a href="?cmd=$getbagzbcmd">Trang bị</a><a href="?cmd=$getbagdjcmd">Đạo cụ</a><a href="?cmd=$getbagypcmd">Dược phẩm</a><a href="#" style="background-color: gray;">Kỹ năng</a><a href="?cmd=$getbagydcmd">Dược đan</a></div></font><br>
<br/>
$alljn
<br/>

<a href="#" onClick="javascript:history.back(-1);">Trở lại</a>
        <a href="game.php?cmd=$gonowmid" style="float:right;background-color:#cff3d2;color: #755d5d;" >Trở về trò chơi</a>
HTML;
echo $bagyphtml;

?>