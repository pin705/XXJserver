<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2021/6/17
 * Time: 10:18
 */
//$sql = "select * from mid order by mid ASC";//Thu hoạch trước mắt địa đồ
//$cxjg = $dblj->query($sql);

$player = player\getplayer($sid,$dblj);
$map = '';

$cxallmap = \player\getqy_all($dblj);
$br = 0;
for ($i=0;$i<count($cxallmap);$i++){

    $qyame = $cxallmap[$i]['qyname'];
    $mid = $cxallmap[$i]['mid'];
    if ($mid>0){
        $cxmid = \player\getmid($mid,$dblj);
        $mname = $cxmid->mname;
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


$gonowmid = $encode->encode("cmd=gomid&newmid=$player->nowmid&sid=$sid");
$allmap = <<<HTML
<IMG width='280' height='140' src='./images/rw.png'src="./images/rw.png" style="border-radius: 8px;">
<!--<IMG width='280' height='50' src='./images/dt.jpg'>--><hr>
$map<hr>
<a href="#" onClick="javascript:history.back(-1);"  background-color: #ecf7ed;">Trở lại</a>
            <a href="game.php?cmd=$gonowmid" style="float:right;background-color:#cdefea57;" >Trở về trò chơi</a>
HTML;
echo $allmap;
?>