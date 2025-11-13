<?php
$player = player\getplayer($sid,$dblj);
$gonowmid = $encode->encode("cmd=gomid&newmid=$player->nowmid&sid=$sid");
$tfxy =  $encode->encode("cmd=tianfu&canshuxy=xy&sid=$sid");
$tfsb =  $encode->encode("cmd=tianfu&canshusb=xy&sid=$sid");
$tffy =  $encode->encode("cmd=tianfu&canshufy=xy&sid=$sid");
$tfhp =  $encode->encode("cmd=tianfu&canshuhp=xy&sid=$sid");
$tfbj =  $encode->encode("cmd=tianfu&canshubj=xy&sid=$sid");
$tfxx =  $encode->encode("cmd=tianfu&canshuxx=xy&sid=$sid");
$tfgj =  $encode->encode("cmd=tianfu&canshugj=xy&sid=$sid");
$ntgm =  $encode->encode("cmd=tianfu&nt=xy&sid=$sid");//Nghịch thiên cải mệnh
$wbts =  $encode->encode("cmd=tianfu&wbts1=xy&sid=$sid");//Văn bản nhắc nhở

//Nhỏ hơn 30 Cấp không cách nào tiến vào
$jzjr = <<<HTML
	<a href="#" onClick="javascript:history.back(-1);">Trở lại</a>
    <a href="game.php?cmd=$gonowmid" style="float:right;" >Trở về trò chơi</a>
HTML;
            if ($player->ulv<30){
				echo "<hr>Đẳng cấp nhỏ hơn 30, dễ dàng tẩu hỏa nhập ma！<hr>$jzjr";
			}
			//Nơi này biểu hiện không cách nào gián đoạn, không để ý tới, dù sao có thể trông thấy đoạn này đều là không bình thường người chơi

$tswb = <<<HTML
  <div class="inner">
  <p>May mắn：Rơi xuống bảo vật xác suất*1;Né tránh：Năng lực né tránh*2;Cuồng bạo：Bạo kích xác suất*1.5;Lực lượng：Lực công kích*5;Tính bền dẻo：Phòng ngự*5;Thể phách：HP*50;Nghịch thiên cải mệnh：Thiết lập lại thiên phú, cần nhất định may mắn, trước mắt không thu phí, không hạn chế。
  </p>
  </div>
HTML;
//Văn bản nhắc nhở
if (isset($wbts1)){
    switch ($wbts1){
        case "xy":
            if ($player->uczb>0){
                $ts= $tswb;
				    $sx = $player->uczb;
				    $sql = "update game1 set uczb = $sx - '1' WHERE sid='$sid'";//Người chơi thuộc tính--Giảm bớt ma thạch-1
                    $ret = $dblj->exec($sql);
                }
			 else{
				$ts = "<hr>Không có tiền ta liền không nói cho ngươi！<hr>";
			 }
	}
}

//Nghịch thiên cải mệnh
if (isset($nt)){
    switch ($nt){
        case "xy":
		$sjs = mt_rand(1,30-$player->tfxy);
            if ($player->ulv !=0 && $sjs <10){
				$ts = "<hr>Nghịch thiên cải mệnh thành công！Thiên phú thiết lập lại.<hr>";
				
				     $sx = $player->ulv*5;
				     $sql = "update game1 set tf = '$sx' WHERE sid='$sid'";//Cải biến người chơi thuộc tính---Ban đầu hóa thiên phú
                     $ret = $dblj->exec($sql);
					 $sql = "update game1 set tfbj =  '0' WHERE sid='$sid'";//Thiên phú ban đầu hóa
                     $ret = $dblj->exec($sql);
					 $sql = "update game1 set tfgj =  '0' WHERE sid='$sid'";//Thiên phú ban đầu hóa
                     $ret = $dblj->exec($sql);
					 $sql = "update game1 set tfhp =  '0' WHERE sid='$sid'";//Thiên phú ban đầu hóa
                     $ret = $dblj->exec($sql);
					 $sql = "update game1 set tfxy =  '0' WHERE sid='$sid'";//Thiên phú ban đầu hóa
                     $ret = $dblj->exec($sql);
					 $sql = "update game1 set tffy =  '0' WHERE sid='$sid'";//Thiên phú ban đầu hóa
                     $ret = $dblj->exec($sql);
					 $sql = "update game1 set tfsb =  '0' WHERE sid='$sid'";//Thiên phú ban đầu hóa
                     $ret = $dblj->exec($sql);
					 $sql = "update game1 set tfxx =  '0' WHERE sid='$sid'";//Thiên phú ban đầu hóa
                     $ret = $dblj->exec($sql);
					 
                }
			 else{
				$ts = "<hr>Thiên mệnh khó trái, nghịch thiên tính sai！Có lẽ ngươi chênh lệch chút may mắn.<hr>";
			 }
	}
}

if (isset($canshuxy)){
    switch ($canshuxy){
        case "xy":
            if ($player->tf>0){
                $ts= "<hr>Tăng lên thành công<hr>";
				    $sx = $player->tfxy;
				    $sql = "update game1 set tfxy = $sx + '1' WHERE sid='$sid'";//Gia tăng người chơi thuộc tính
                    $ret = $dblj->exec($sql);
					$sql = "update game1 set tf = $player->tf - '1' WHERE sid='$sid'";//Thiên phú tổng giảm
                    $ret = $dblj->exec($sql);
                }
			 else{
				$ts = "<hr>Thiên phú giá trị không đủ, tăng lên thất bại！<hr>";
			 }
	}
}
if (isset($canshusb)){
    switch ($canshusb){
        case "xy":
            if ($player->tf>0){
                $ts= "<hr>Tăng lên thành công<hr>";
				    $sx = $player->tfsb;
				    $sql = "update game1 set tfsb = $sx + '1' WHERE sid='$sid'";//Gia tăng người chơi thuộc tính
                    $ret = $dblj->exec($sql);
					$sql = "update game1 set tf = $player->tf - '1' WHERE sid='$sid'";//Thiên phú tổng giảm
                    $ret = $dblj->exec($sql);
                }
			 else{
				$ts = "<hr>Thiên phú giá trị không đủ, tăng lên thất bại！<hr>";
			 }
	}
}
if (isset($canshugj)){
    switch ($canshugj){
        case "xy":
            if ($player->tf>0){
                $ts= "<hr>Tăng lên thành công<hr>";
				    $sx = $player->tfgj;
				    $sql = "update game1 set tfgj = $sx + '1' WHERE sid='$sid'";//Gia tăng người chơi thuộc tính
                    $ret = $dblj->exec($sql);
					$sql = "update game1 set tf = $player->tf - '1' WHERE sid='$sid'";//Thiên phú tổng giảm
                    $ret = $dblj->exec($sql);
                }
			 else{
				$ts = "<hr>Thiên phú giá trị không đủ, tăng lên thất bại！<hr>";
			 }
	}
}
if (isset($canshufy)){
    switch ($canshufy){
        case "xy":
            if ($player->tf>0){
                $ts= "<hr>Tăng lên thành công<hr>";
				    $sx = $player->tffy;
				    $sql = "update game1 set tffy = $sx + '1' WHERE sid='$sid'";//Gia tăng người chơi thuộc tính
                    $ret = $dblj->exec($sql);
					$sql = "update game1 set tf = $player->tf - '1' WHERE sid='$sid'";//Thiên phú tổng giảm
                    $ret = $dblj->exec($sql);
                }
			 else{
				$ts = "<hr>Thiên phú giá trị không đủ, tăng lên thất bại！<hr>";
			 }
	}
}
if (isset($canshubj)){
    switch ($canshubj){
        case "xy":
            if ($player->tf>0){
                $ts= "<hr>Tăng lên thành công<hr>";
				    $sx = $player->tfbj;
				    $sql = "update game1 set tfbj = $sx + '1' WHERE sid='$sid'";//Gia tăng người chơi thuộc tính
                    $ret = $dblj->exec($sql);
					$sql = "update game1 set tf = $player->tf - '1' WHERE sid='$sid'";//Thiên phú tổng giảm
                    $ret = $dblj->exec($sql);
                }
			 else{
				$ts = "<hr>Thiên phú giá trị không đủ, tăng lên thất bại！<hr>";
			 }
	}
}
if (isset($canshuhp)){
    switch ($canshuhp){
        case "xy":
            if ($player->tf>0){
                $ts= "<hr>Tăng lên thành công<hr>";
				    $sx = $player->tfhp;
				    $sql = "update game1 set tfhp = $sx + '1' WHERE sid='$sid'";//Gia tăng người chơi thuộc tính
                    $ret = $dblj->exec($sql);
					$sql = "update game1 set tf = $player->tf - '1' WHERE sid='$sid'";//Thiên phú tổng giảm
                    $ret = $dblj->exec($sql);
                }
			 else{
				$ts = "<hr>Thiên phú giá trị không đủ, tăng lên thất bại！<hr>";
			 }
	}
}
if (isset($canshuxx)){
    switch ($canshuxx){
        case "xy":
            if ($player->tf>0){
                $ts= "<hr>Tăng lên thành công<hr>";
				    $sx = $player->tfxx;
				    $sql = "update game1 set tfxx = $sx + '1' WHERE sid='$sid'";//Gia tăng người chơi thuộc tính
                    $ret = $dblj->exec($sql);
					$sql = "update game1 set tf = $player->tf - '1' WHERE sid='$sid'";//Thiên phú tổng giảm
                    $ret = $dblj->exec($sql);
                }
			 else{
				$ts = "<hr>Thiên phú giá trị không đủ, tăng lên thất bại！<hr>";
			 }
	}
}
$ztcmd = $encode->encode("cmd=zhuangtai&sid=$sid");
$cwinfo = $encode->encode("cmd=chongwu&cwid=$player->cw&canshu=cwinfo&sid=$sid");
$cwid = $cw['cwid'];
$gm =  $encode->encode("cmd=czbgm&canshu2=gaiming2&sid=$sid");
$player = player\getplayer($sid,$dblj);
$html = <<<HTML
<link rel="stylesheet" href="./chajian/tishiwenben/css/style.css">
<div class="menu"><a href="?cmd=$ztcmd">Thông tin cá nhân</a><a href="?cmd=$cwinfo"><font color="#9c27b0">Sủng vật tin tức</font></a><a href="?cmd=$gm">Đổi tên</a></div><br><br>
Thiên phú còn thừa:$player->tf<br>
Khí huyết:$player->uhp/$player->umaxhp<br/>
Công kích:$player->ugj<br/>
Phòng ngự:$player->ufy<br/>
Bạo kích:$player->ubj<br/>
Hút máu:$player->uxx<br/>
May mắn:$player->tfxy<br>
Né tránh:$player->tfsb<br>
$ts
<a href="?cmd=$tfxy">Tăng lên may mắn</a><a href="?cmd=$tfsb">Tăng lên né tránh</a><a href="?cmd=$tfxx">Tăng lên khôi phục</a><br>
<a href="?cmd=$tfgj">Tăng lên lực lượng</a><a href="?cmd=$tfbj">Tăng lên cuồng bạo</a><a href="?cmd=$tfhp">Tăng lên thể phách</a><br>
<a href="?cmd=$tffy">Tăng lên tính bền dẻo</a><a href="?cmd=$ntgm"><font color=#FB4A0E>Nghịch thiên cải mệnh</font></a><a href="?cmd=$wbts">Nhắc nhở văn bản</a>
<br>
<hr>
<br/>
<a href="#" onClick="javascript:history.back(-1);" >Trở lại</a><!--Cư trái-float:left;-->
<a href="game.php?cmd=$gonowmid" style="float:right;" >Trở về trò chơi</a>
HTML;
echo $html;
?>