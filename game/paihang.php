<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 20 21 /6/15
 * Time: 20:36
 */
$gonowmid = $encode->encode("cmd=gomid&newmid=$player->nowmid&sid=$sid");
$sql = 'SELECT * FROM game1 ORDER BY ulv DESC,uexp ASC LIMIT 10';//danh sách thu hoạch
$player = player\getplayer($sid,$dblj);
$phcxjg = $dblj->query($sql);
$phhtml='';
$phlshtml='';
$backcmd=$encode->encode("cmd=gomid&newmid=$player->nowmid&sid=$sid");
if ($phcxjg){
    $ret = $phcxjg->fetchAll(PDO::FETCH_ASSOC);
    for ($i=0;$i < count($ret);$i++){
        $uname = $ret[$i]['uname'];
        $ulv = $ret[$i]['ulv'];
        $uid = $ret[$i]['uid'];
        $cxsid = $ret[$i]['sid'];
        $clubp = \player\getclubplayer_once($cxsid,$dblj);
        if ($clubp){
            $club = \player\getclub($clubp->clubid,$dblj);
            $club->clubname ="[$club->clubname]";
        }else{
            $club = new \player\club();
            $club->clubname ="";
        }
        $ucmd = $encode->encode("cmd=getplayerinfo&uid=$uid&sid=$player->sid");
        $xuhao = $i+1;
        $phlshtml .="$xuhao.[$ulv]<a href='?cmd=$ucmd'>{$club->clubname}$uname</a><br/>";
    }
    $phhtml.=<<<HTML
    Đẳng cấp| Công kích| Phòng ngự| Đánh giết| Ma thạch| <hr/>
    $phlshtml
    <br/>
	<div class="menu"><a href="#" onClick="javascript:history.back(-1);">Trở lại</a>
    <a href="game.php?cmd=$gonowmid" style="float:right;" >Trở về trò chơi</a> </div>
HTML;
    echo $phhtml;
}
?>