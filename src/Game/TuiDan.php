<?php
$gonowmid = $encode->encode("cmd=goto_map&newmid=$player->nowmid&sid=$sid");
$getbagzbcmd = $encode->encode("cmd=get_equipment_bag&sid=$sid");
$getbagdjcmd = $encode->encode("cmd=get_item_bag&sid=$sid");
$getbagjncmd = $encode->encode("cmd=get_skill_bag&sid=$sid");
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
            $ypcmd = $encode->encode("cmd=pill_info&ypid=$ypid&sid=$sid");
            $allyp .= <<<HTML
            [$suoyin].<a href="?cmd=$ypcmd">{$ypname}x$ypsum</a><br/>
HTML;
        }
    }
}
$getbagydcmd = $encode->encode("cmd=get_medicine_bag&sid=$sid");
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