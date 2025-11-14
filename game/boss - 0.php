
<?php
$boss = \player\getboss($bossid,$dblj);
$player = \player\getplayer($sid,$dblj);
$nowmid=$player->nowmid;
$pgjcmd = $encode->encode("cmd=pvb&canshu=ptgj&bossid=$bossid&sid=$sid");
$gonowmid = $encode->encode("cmd=gomid&newmid=$player->nowmid&sid=$player->sid");

$useyp1 = $encode->encode("cmd=pve&canshu=useyp&ypid=$player->yp1&sid=$sid&gid=$bossid&nowmid=$nowmid");
$useyp2 = $encode->encode("cmd=pve&canshu=useyp&ypid=$player->yp2&sid=$sid&gid=$bossid&nowmid=$nowmid");
$useyp3 = $encode->encode("cmd=pve&canshu=useyp&ypid=$player->yp3&sid=$sid&gid=$bossid&nowmid=$nowmid");
$ypname1 = 'Dược phẩm 1';
$ypname2 = 'Dược phẩm 2';
$ypname3 = 'Dược phẩm 3';
if ($player->yp1!=0){
    $yaopin = \player\getplayeryaopin($player->yp1,$sid,$dblj);
    $ypname1 = $yaopin->ypname.'('.$yaopin->ypsum.')';
}
if ($player->yp2!=0){
    $yaopin = \player\getplayeryaopin($player->yp2,$sid,$dblj);
    $ypname2 = $yaopin->ypname.'('.$yaopin->ypsum.')';
}
if ($player->yp3!=0){
    $yaopin = \player\getplayeryaopin($player->yp3,$sid,$dblj);
    $ypname3 = $yaopin->ypname.'('.$yaopin->ypsum.')';
}


$bosshtml=<<<HTML
==BOOS Chiến đấu==<br/>
<IMG width="50" height="50" src="./images/cqgs.png"><BR>
$boss->bossname[lv:$boss->bosslv]<br/>
Khí huyết:($boss->bosshp)<br/>
Khí huyết:(<div class="hpys" style="display: inline">$boss->bosshp</div>/<div class="hpys" style="display: inline">$boss->bossmaxhp</div>)$pvebj$ghurt<br/>
Công kích:($boss->bossgj)<br/>
Phòng ngự:($boss->bossfy)<br/>
Trước mắt công kích nhân số:<br/>
===================<br/>
$player->uname [lv:$player->ulv]<br/>
Khí huyết:(<div class="hpys" style="display: inline">$player->uhp</div>/<div class="hpys" style="display: inline">$player->umaxhp</div>)$phurt$pvexx<br/>
Công kích:($player->ugj)<br/>
Phòng ngự:($player->ufy)<br/>
$tishihtml
<br/>
<ul>
<li><a href="?cmd=$gonowmid">Chạy trốn</a></li><br/>
<li><a href="?cmd=$pgjcmd">Công kích</a></li>
</ul>

<a href="?cmd=$useyp1">$ypname1</a>.<a href="?cmd=$useyp2">$ypname2</a>.<a href="?cmd=$useyp3">$ypname3</a><br/>
<br/>
HTML;

echo $bosshtml
?>
