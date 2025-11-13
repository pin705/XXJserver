<?php
$player = \player\getplayer($sid,$dblj);
$gonowmid = $encode->encode("cmd=goto_map&newmid=$player->nowmid&sid=$sid");
$gm =  $encode->encode("cmd=recharge_gm&canshu2=gaiming2&sid=$sid");
$czb = $player->uczb;
$vip =$player->vip;
$fh=<<<HTML
	<a href="#" onClick="javascript:history.back(-1);">Quay lại</a>
    <a href="game.php?cmd=$gonowmid" style="float:right;" >Trở lại trò chơi</a> 
HTML;
if (isset($canshu2)){
    switch ($canshu2){
        case "gaiming2":
            if ($vip<1){
                $czbhtml= "<hr/>大虾的VIP[$vip]有点辣眼睛.<br/>需要vip8才能修改名字,大虾加油吧.<hr>";
                break;}
$czbhtml=<<<HTML
<div align="center">
==vip改名系统==<br/>
隐姓埋名<br/>
不问世事<br/>
又或者...<br/>
大杀四方<br>
</div>
<form>
<input type="hidden" name="cmd" value="czbgm">
<input type="hidden" name="uid" value="$uid">
<input type="hidden" name="sid" value="$sid">
<input type="hidden" name="canshu2" value="gm">
<div align="center">
<input name="gaibian" placeholder="新大名:">
<br><br>
<input type="submit" value="更改" style="background-color: #49bb7c;color: white;border-radius: 4px;">
</div>
</form>
HTML;
break;
            case "gm":
            if ($czb<200){
                $czbhtml= "<hr>魔石不足200，无法修改<hr>";
                break;
            }

           $gaibian = htmlspecialchars($gaibian);

            if (strlen($gaibian)<6 || strlen($gaibian)>12){
                $czbhtml = "<hr/>名称过长或过短<hr/>";
                break;
            }
			if ($player->uczb>200){
			     $ret1 = \player\changeczb(2,200,$sid,$dblj);//魔石扣除200
			
			     $sql = "update game1 set uname = '$gaibian' WHERE sid='$sid'";//改变玩家属性
                 $ret = $dblj->exec($sql);

            $czbhtml.= "<hr/>成功<hr/>";}
			else {
				$czbhtml = "<hr/>魔石不足200，无法创建<hr/>";
			}
            break;
			
    }

}

$html = <<<HTML
<IMG width='280' height='140' src='./images/gaiming.png'src="./images/rw.png" style="border-radius: 8px;">
$czbhtml<br>
$fh
HTML;
 echo $html;

?>