<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2026/8/30 0030
 * Time: 19:32
 */
require_once __DIR__ . '/../src/Helpers/NguoiChoiHelper.php';
use TuTaTuTien\Helpers as Helpers;

if (isset($canshu)){
    if ($canshu=="deim"){
        $sql="delete from im WHERE imuid = $uid AND sid='$sid'";
        $dblj->exec($sql);
    }
}
$sql="select * from im WHERE sid='$sid'";
$ret = $dblj->query($sql);
$imitem = $ret->fetchAll(PDO::FETCH_ASSOC);
$gonowmid = $encode->encode("cmd=gomid&newmid=$player->nowmid&sid=$sid");
$imlist = '';
foreach ($imitem as $im){
    $imuid = $im['imuid'];
    $implayer = Helpers\layThongTinNguoiChoiTheoUid($imuid, $dblj);
    $playercmd = $encode->encode("cmd=getplayerinfo&uid=$imuid&sid=$sid");
    $imlist .="<a href='?cmd=$playercmd'>$implayer->tenNhanVat</a><br/>";
}



$imhtml =<<<HTML
=======Hảo hữu=======<br/>
$imlist
<br/>
$zhuangbei1<br>
$zhuangbei2<br>
$zhuangbei3<br>
$zhuangbei4<br>
$zhuangbei5<br>
$zhuangbei6<br>
$zhuangbei7<br>
$taozhuang
<a href="#" onClick="javascript:history.back(-1);">Trở lại</a>
<a href="game.php?cmd=$gonowmid" style="float:right;" >Trở về trò chơi</a>
HTML;
echo $imhtml;