<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2021 /6/26
 * Time: 15:57
 */
$yphp = '';
$ypgj = '';
$ypfy = '';
$ypbj = '';
$ypxx = '';
$gonowmid = $encode->encode("cmd=gomid&newmid=$player->nowmid&sid=$sid");
$yaopin = \player\getyaopinonce($ypid,$dblj);
$playeryp = \player\getplayeryaopin($ypid,$sid,$dblj);
$setyp = '';
$tishi='';
if (isset($canshu)){
    switch ($canshu){
        case 'setyp1':
            \player\changeplayersx('yp1',$ypid,$sid,$dblj);
            $tishi = "Thiết trí dược phẩm 1 Thành công<br/>";
            break;
        case 'setyp2':
            \player\changeplayersx('yp2',$ypid,$sid,$dblj);
            $tishi = "Thiết trí dược phẩm 2 Thành công<br/>";
            break;
        case 'setyp3':
            \player\changeplayersx('yp3',$ypid,$sid,$dblj);
            $tishi = "Thiết trí dược phẩm 3 Thành công<br/>";
            break;
        case 'useyp':
            $userypret = \player\useyaopin($ypid,1,$sid,$dblj);
            if ($userypret){
                $tishi = "Sử dụng thành công<br/>";
            }else{
                $tishi = "Sử dụng thất bại<br/>";
            }
            break;
    }
}
if ($playeryp){
    $setyp1 = $encode->encode("cmd=ypinfo&canshu=setyp1&ypid=$ypid&sid=$sid");
    $setyp2 = $encode->encode("cmd=ypinfo&canshu=setyp2&ypid=$ypid&sid=$sid");
    $setyp3 = $encode->encode("cmd=ypinfo&canshu=setyp3&ypid=$ypid&sid=$sid");
    $useyp = $encode->encode("cmd=ypinfo&canshu=useyp&ypid=$ypid&sid=$sid");
    $setyp = <<<HTML
    <br/><font size="2">Dược phẩm vị trí：
    <a href="?cmd=$setyp1">Vị trí 1</a>
    <a href="?cmd=$setyp2">Vị trí 2</a>
    <a href="?cmd=$setyp3">Vị trí 3</a>
	</font><hr>
    <a href="?cmd=$useyp">Sử dụng dược phẩm</a><hr>
HTML;
}
if($yaopin->yphp!=0){
    $yphp = "Khôi phục khí huyết：".$yaopin->yphp."<br/>";
}
if ($yaopin->ypgj!=0){
    $ypgj = "Công kích".$yaopin->ypgj."<br/>";
}
if ($yaopin->ypfy!=0){
    $ypfy = "Phòng ngự".$yaopin->ypfy."<br/>";
}
if ($yaopin->ypbj!=0){
    $ypbj = "Bạo kích".$yaopin->ypbj."<br/>";
}
if ($yaopin->ypxx!=0){
    $ypxx = "Hút máu".$yaopin->ypxx."<br/>";
}
$ypsx = "<br/>".$yphp.$ypgj.$ypfy.$ypbj.$ypxx;
$ypinfo = <<<HTML
<IMG width='280' height='140' src='./images/yaopin.png'src="./images/rw.png" style="border-radius: 8px;">

[{$yaopin->ypname}]$tishi
$ypsx
$setyp
<br/>
	<a href="#" onClick="javascript:history.back(-1);">Trở lại</a>
    <a href="game.php?cmd=$gonowmid" style="float:right;" >Trở về trò chơi</a> 
HTML;
echo $ypinfo;