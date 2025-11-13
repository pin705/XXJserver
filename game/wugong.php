<?php
$player = \player\getplayer($sid,$dblj);
$wgid = $player->wugong;
$wgid = $player->wugong;
$cxwg = \player\wgcx($wgid,$sid,$dblj);

$gonowmid = $encode->encode("cmd=gomid&newmid=$player->nowmid&sid=$sid");
$strxl = $encode->encode("cmd=wgxiulian&canshu=1&wgid=$wgid&sid=$sid");
$endxl = $encode->encode("cmd=jswg&wgid=$wgid&sid=$sid");//Kết thúc tu tiên
$nowdate = date('Y-m-d H:i:s');
$xlsjc='Chưa bắt đầu tu luyện';
$tishi = '';
$xlexp = 0;
$xiaohao = 0 + $cxwg->wgdj ;
$xhms = $cxwg->wgdj*3;


if ($cmd == 'wgxiulian'){
    if ($cxwg->xlzt == 1){
        $tishi = 'Đã trong tu luyện<br/>';
    }else{
        if ($canshu == 1){
            $ret = \player\changeyxb(2,$xhms,$sid,$dblj);
        }else{
            $ret = \player\changeczb(2,$xhms,$sid,$dblj);
        }
        if ($ret){
            \player\gaibianwg('xlsj',$nowdate,$wgid,$sid,$dblj);
            \player\gaibianwg('xlzt',1,$wgid,$sid,$dblj);
            $tishi = 'Hắc hưu hắc hưu, thao luyện...<br/>';
            $xlsjc = 0;
            $player = \player\getplayer($sid,$dblj);
        }else{
            $tishi='Thất bại thất bại thất bại 404';
        }

    }
}
		$one = strtotime($nowdate) ;
        $tow = strtotime($cxwg->xlsj);
        $xlsjc=floor(($one-$tow)/60);
		$xlexp = round($xlsjc*0.8);
		$fanbei = round(10 + $xlexp*1.2);
     if ($xlsjc > 1440){
        $xlsjc = 1440;
        $xlexp = round($xlsjc * 1.2);//Thu hoạch công lực
		$fanbei = round(10 + $xlexp*1.6);
	 }
if ($cmd == 'jswg'){//Kết thúc tu tiên
    if ($cxwg->xlzt == 1){
		$zzz =$xlexp+$cxwg->wgxl;
		if($zzz > $cxwg->wgxlmax){
			$zj = $zzz - $cxwg->wgxlmax;
			\player\gaibianwg('xlzt',0,$wgid,$sid,$dblj);
			$ret = $dblj->exec($sql);
			$sql = "update playerwugong set wgxl =  $zj where wgid = '$wgid' and sid='$sid'";
			$ret = $dblj->exec($sql);
			$sql = "update playerwugong set wgdj = wgdj + 1 where wgid = '$wgid' and sid='$sid'";
			$ret = $dblj->exec($sql);
			$sql = "update playerwugong set wgxlmax = wgxlmax + $fanbei where wgid = '$wgid' and sid='$sid'";
			$ret = $dblj->exec($sql);
			$sql = "update playerwugong set wgsum = wgsum - 1 where wgid = '$wgid' and sid='$sid'";
		    $ret = $dblj->exec($sql);
		}
        else{
		\player\gaibianwg('xlzt',0,$wgid,$sid,$dblj);
        $xlsjc = 'Kết thúc tu luyện...<br/>Thời gian tu luyện：'.$xlsjc;
        $tishi = 'nhận được  tu vi:'.$xlexp.''.$zj.'<br/>';
		$wgsum = $cxwg->wgsum - 1 ;
		$sql = "update playerwugong set wgsum = wgsum - 1 where wgid = '$wgid' and sid='$sid'";
		$ret = $dblj->exec($sql);
	    $sql = "update playerwugong set wgxl = wgxl + $xlexp where wgid = '$wgid' and sid='$sid'";
        $ret = $dblj->exec($sql);//Tính toán võ công đẳng cấp
		}
    }
	else{
        $tishi = 'Ngươi còn chưa có bắt đầu tu luyện...<br/>';
    }
}

$cxwg = \player\wgcx($wgid,$sid,$dblj);
if ($cxwg->xlzt == 1){
    $tishi = '<font color="#A0A000">Luyện</font><font color="#F5A000">Võ</font><font color="#FFA000">Bên trong</font><br/>';
    $xlcz = "<a href=?cmd=$endxl>Kết thúc tu luyện</a><br/><br/>";
}else{
	$tishi = 'Lười biếng bên trong...<br>';
	if($cxwg->wgsum>=1){
    $xlcz = "<a href=?cmd=$strxl style='color: #f36c09;'>Bắt đầu tu hành</a><br/><br/>";
	}else{
		$xlcz = "<a style='color: #f50808;'>Thiếu khuyết bí tịch, không cách nào tu hành</a><br><br>";
	}
}
$xiuliancmd = $encode->encode("cmd=goxiulian&sid=$sid");
$wgxl = $encode->encode("cmd=wgxl&sid=$sid");
$wgxx = $encode->encode("cmd=xxwg&sid=$sid");
$cxwg = \player\wgcx($wgid,$sid,$dblj);
$wgys = $cxwg->wgys;
$wu = $player->wugong;
if ($wu==0){
	$wuwugong = "Không có võ công！！";
	$wumiji = "0 Bí tịch";
	$jieshao = "Mời thu thập bí tịch tiến hành học tập võ công";
	$gongli = "0.000001";
	
}
$xlhtml = <<<HTML
<IMG width='280' height='140' src='./images/wugong/$wgid.png' style="border-radius: 8px;">
<a href="?cmd=$xiuliancmd" >Ngồi thiền tu luyện</a><a href="?cmd=$wgxl" >Võ công tu hành</a><a href="?cmd=$wgxx" >Bí tịch</a><br>
Tu hành người chơi：$player->uname<br/>
Người chơi đẳng cấp：$player->jingjie($player->ulv)<br/>
===============<br/>
Tu hành võ công:$wuwugong<font color="$wgys">$cxwg->wgname</font><br>
Trước mắt công lực:$gongli $cxwg->wgdj<br>
Bí tịch số lượng:$wumiji $cxwg->wgsum Quyển<br/>
Tu hành tiêu hao:$xiaohao Quyển<br/>
Võ công giới thiệu:$jieshao $cxwg->wginfo<br>
===============<br/>
Trạng thái tu luyện:$tishi 
===============<br/>
Chú：Võ công đẳng cấp càng cao, thời gian tu hành càng dài,<br>Tối cao 1440 Phút, tiêu hao bí tịch cũng nhiều。<br/>
$xlcz<a href="#" onClick="javascript:history.back(-1);">
Trở lại</a><a href="game.php?cmd=$gonowmid" style="float:right;" >
Trở về trò chơi</a>
HTML;
echo $xlhtml;
?>