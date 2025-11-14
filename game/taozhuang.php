<?php

//Khảo thí sáo trang
$player = player\getplayer($sid,$dblj);
$gonowmid = $encode->encode("cmd=gomid&newmid=$player->nowmid&sid=$sid");

$zb1 = player\getzb($player->tool1,$dblj);
$zb2 = player\getzb($player->tool2,$dblj);
$zb3 = player\getzb($player->tool3,$dblj);
$zb4 = player\getzb($player->tool4,$dblj);
$zb5 = player\getzb($player->tool5,$dblj);
$zb6 = player\getzb($player->tool6,$dblj);
$zb7 = player\getzb($player->tool7,$dblj);

$zhuangbei1 = $zb1->taozhuang;
$zhuangbei2 = $zb2->taozhuang;
$zhuangbei3 = $zb3->taozhuang ;
$zhuangbei4 = $zb4->taozhuang ;
$zhuangbei5 = $zb5->taozhuang ;
$zhuangbei6 = $zb6->taozhuang ;
$zhuangbei7 = $zb7->taozhuang ;

$zbmz1 = $zb1->zbname;
$zbmz2 = $zb2->zbname;
$zbmz3 = $zb3->zbname ;
$zbmz4 = $zb4->zbname ;
$zbmz5 = $zb5->zbname ;
$zbmz6 = $zb6->zbname ;
$zbmz7 = $zb7->zbname ;

if($zbmz1==''){
	$zbmz1 = "Vũ khí vì không！" ;
}
if($zbmz2==''){
	$zbmz2 = "Đồ phòng ngự vì không！" ;
}
if($zbmz3==''){
	$zbmz3 = "Đồ trang sức vì không！" ;
}
if($zbmz4==''){
	$zbmz4 = "Thư tịch vì không！" ;
}
if($zbmz5==''){
	$zbmz5 = "Tọa kỵ vì không！" ;
}
if($zbmz6==''){
	$zbmz6 = "Lệnh bài vì không！" ;
}
if($zbmz7==''){
	$zbmz7 = "Ám khí vì không！" ;
}








// if($zhuangbei1==$zhuangbei2){$taozhuang=1;
// }else{
// if($zhuangbei1==$zhuangbei3){$taozhuang=1;
// }else{
// if($zhuangbei1==$zhuangbei4){$taozhuang=1;
// }else{
// if($zhuangbei1==$zhuangbei5){$taozhuang=1;
// }else{
// if($zhuangbei1==$zhuangbei6){$taozhuang=1;
// }else{
// if($zhuangbei1==$zhuangbei7){$taozhuang=1;
// }else{
// if($zhuangbei2==$zhuangbei3){$taozhuang=1;
// }else{
// if($zhuangbei2==$zhuangbei4){$taozhuang=1;
// }else{
// if($zhuangbei2==$zhuangbei5){$taozhuang=1;
// }else{
// if($zhuangbei2==$zhuangbei6){$taozhuang=1;
// }else{
// if($zhuangbei2==$zhuangbei7){$taozhuang=1;
// }else{
// if($zhuangbei3==$zhuangbei4){$taozhuang=1;
// }else{
// if($zhuangbei3==$zhuangbei5){$taozhuang=1;
// }else{
// if($zhuangbei3==$zhuangbei6){$taozhuang=1;
// }else{
// if($zhuangbei3==$zhuangbei7){$taozhuang=1;
// }else{
// if($zhuangbei4==$zhuangbei5){$taozhuang=1;
// }else{
// if($zhuangbei4==$zhuangbei6){$taozhuang=1;
// }else{
// if($zhuangbei4==$zhuangbei7){$taozhuang=1;
// }else{
// if($zhuangbei5==$zhuangbei6){$taozhuang=1;
// }else{
// if($zhuangbei5==$zhuangbei7){$taozhuang=1;
// }else{
// if($zhuangbei6==$zhuangbei7){$taozhuang=1;
// }}}}}}}}}}}}}}}}}}}}}


// if($zhuangbei1==$zhuangbei2&&$zhuangbei1==$zhuangbei3){$taozhuang=2;
// }else{
// if($zhuangbei1==$zhuangbei2&&$zhuangbei1==$zhuangbei4){$taozhuang=2;
// }else{
// if($zhuangbei1==$zhuangbei2&&$zhuangbei1==$zhuangbei5){$taozhuang=2;
// }else{
// if($zhuangbei1==$zhuangbei2&&$zhuangbei1==$zhuangbei6){$taozhuang=2;
// }else{
// if($zhuangbei1==$zhuangbei2&&$zhuangbei1==$zhuangbei7){$taozhuang=2;
// }else{
// if($zhuangbei1==$zhuangbei3&&$zhuangbei1==$zhuangbei4){$taozhuang=2;
// }else{
// if($zhuangbei1==$zhuangbei3&&$zhuangbei1==$zhuangbei5){$taozhuang=2;
// }else{
// if($zhuangbei1==$zhuangbei3&&$zhuangbei1==$zhuangbei6){$taozhuang=2;
// }else{
// if($zhuangbei1==$zhuangbei3&&$zhuangbei1==$zhuangbei7){$taozhuang=2;
// }else{
// if($zhuangbei1==$zhuangbei4&&$zhuangbei1==$zhuangbei5){$taozhuang=2;
// }else{
// if($zhuangbei1==$zhuangbei4&&$zhuangbei1==$zhuangbei6){$taozhuang=2;
// }else{
// if($zhuangbei1==$zhuangbei4&&$zhuangbei1==$zhuangbei7){$taozhuang=2;
// }else{
// if($zhuangbei1==$zhuangbei5&&$zhuangbei1==$zhuangbei7){$taozhuang=2;
// }else{
// if($zhuangbei1==$zhuangbei5&&$zhuangbei1==$zhuangbei6){$taozhuang=2;
// }else{
// if($zhuangbei1==$zhuangbei6&&$zhuangbei1==$zhuangbei7){$taozhuang=2;
// }else{
// if($zhuangbei2==$zhuangbei3&&$zhuangbei2==$zhuangbei4){$taozhuang=2;
// }else{
// if($zhuangbei2==$zhuangbei3&&$zhuangbei2==$zhuangbei5){$taozhuang=2;
// }else{
// if($zhuangbei2==$zhuangbei3&&$zhuangbei2==$zhuangbei7){$taozhuang=2;
// }else{
// if($zhuangbei2==$zhuangbei3&&$zhuangbei2==$zhuangbei6){$taozhuang=2;
// }else{
// if($zhuangbei2==$zhuangbei4&&$zhuangbei2==$zhuangbei5){$taozhuang=2;
// }else{
// if($zhuangbei2==$zhuangbei4&&$zhuangbei2==$zhuangbei7){$taozhuang=2;
// }else{
// if($zhuangbei2==$zhuangbei4&&$zhuangbei2==$zhuangbei6){$taozhuang=2;
// }else{
// if($zhuangbei2==$zhuangbei5&&$zhuangbei2==$zhuangbei7){$taozhuang=2;
// }else{
// if($zhuangbei2==$zhuangbei5&&$zhuangbei2==$zhuangbei6){$taozhuang=2;
// }else{
// if($zhuangbei2==$zhuangbei6&&$zhuangbei2==$zhuangbei7){$taozhuang=2;
// }
// }}}}}}}}}}}}}}}}}}}}}}}}



// if($zhuangbei1==$zhuangbei2&&$zhuangbei1==$zhuangbei3&&$zhuangbei1==$zhuangbei4){$taozhuang=3;
// }else{
// if($zhuangbei1==$zhuangbei2&&$zhuangbei1==$zhuangbei3&&$zhuangbei1==$zhuangbei5){$taozhuang=3;
// }else{
// if($zhuangbei1==$zhuangbei2&&$zhuangbei1==$zhuangbei3&&$zhuangbei1==$zhuangbei6){$taozhuang=3;
// }else{
// if($zhuangbei1==$zhuangbei2&&$zhuangbei1==$zhuangbei3&&$zhuangbei1==$zhuangbei7){$taozhuang=3;
// }else{
// if($zhuangbei1==$zhuangbei2&&$zhuangbei1==$zhuangbei4&&$zhuangbei1==$zhuangbei5){$taozhuang=3;
// }else{
// if($zhuangbei1==$zhuangbei2&&$zhuangbei1==$zhuangbei4&&$zhuangbei1==$zhuangbei6){$taozhuang=3;
// }else{
// if($zhuangbei1==$zhuangbei2&&$zhuangbei1==$zhuangbei4&&$zhuangbei1==$zhuangbei7){$taozhuang=3;
// }else{
// if($zhuangbei1==$zhuangbei2&&$zhuangbei1==$zhuangbei5&&$zhuangbei1==$zhuangbei6){$taozhuang=3;
// }else{
// if($zhuangbei1==$zhuangbei2&&$zhuangbei1==$zhuangbei5&&$zhuangbei1==$zhuangbei7){$taozhuang=3;
// }else{
// if($zhuangbei1==$zhuangbei2&&$zhuangbei1==$zhuangbei6&&$zhuangbei1==$zhuangbei7){$taozhuang=3;
// }else{
// if($zhuangbei1==$zhuangbei3&&$zhuangbei1==$zhuangbei4&&$zhuangbei1==$zhuangbei5){$taozhuang=3;
// }else{
// if($zhuangbei1==$zhuangbei3&&$zhuangbei1==$zhuangbei4&&$zhuangbei1==$zhuangbei6){$taozhuang=3;
// }else{
// if($zhuangbei1==$zhuangbei3&&$zhuangbei1==$zhuangbei4&&$zhuangbei1==$zhuangbei7){$taozhuang=3;
// }else{
// if($zhuangbei1==$zhuangbei3&&$zhuangbei1==$zhuangbei5&&$zhuangbei1==$zhuangbei6){$taozhuang=3;
// }else{
// if($zhuangbei1==$zhuangbei3&&$zhuangbei1==$zhuangbei5&&$zhuangbei1==$zhuangbei7){$taozhuang=3;
// }else{
// if($zhuangbei1==$zhuangbei3&&$zhuangbei1==$zhuangbei6&&$zhuangbei1==$zhuangbei7){$taozhuang=3;
// }else{
// if($zhuangbei1==$zhuangbei4&&$zhuangbei1==$zhuangbei5&&$zhuangbei1==$zhuangbei6){$taozhuang=3;
// }else{
// if($zhuangbei1==$zhuangbei4&&$zhuangbei1==$zhuangbei5&&$zhuangbei1==$zhuangbei7){$taozhuang=3;
// }else{
// if($zhuangbei1==$zhuangbei4&&$zhuangbei1==$zhuangbei6&&$zhuangbei1==$zhuangbei7){$taozhuang=3;
// }else{
// if($zhuangbei1==$zhuangbei5&&$zhuangbei1==$zhuangbei6&&$zhuangbei1==$zhuangbei7){$taozhuang=3;
// }}}}}}}}}}}}}}}}}}}}


// if($zhuangbei1==$zhuangbei2&&$zhuangbei1==$zhuangbei3&&$zhuangbei1==$zhuangbei4&&$zhuangbei1==$zhuangbei5){$taozhuang=4;
// }else{
// if($zhuangbei1==$zhuangbei2&&$zhuangbei1==$zhuangbei3&&$zhuangbei1==$zhuangbei4&&$zhuangbei1==$zhuangbei6){$taozhuang=4;
// }else{
// if($zhuangbei1==$zhuangbei2&&$zhuangbei1==$zhuangbei3&&$zhuangbei1==$zhuangbei4&&$zhuangbei1==$zhuangbei7){$taozhuang=4;
// }}}


// if($zhuangbei1==$zhuangbei2&&$zhuangbei1==$zhuangbei4&&$zhuangbei1==$zhuangbei5&&$zhuangbei1==$zhuangbei6){$taozhuang=4;
// }else{
// if($zhuangbei1==$zhuangbei2&&$zhuangbei1==$zhuangbei4&&$zhuangbei1==$zhuangbei5&&$zhuangbei1==$zhuangbei7){$taozhuang=4;
// }}

// if($zhuangbei1==$zhuangbei2&&$zhuangbei1==$zhuangbei5&&$zhuangbei1==$zhuangbei6&&$zhuangbei1==$zhuangbei7){$taozhuang=4;
// }

// if($zhuangbei1==$zhuangbei2&&$zhuangbei1==$zhuangbei4&&$zhuangbei1==$zhuangbei6&&$zhuangbei1==$zhuangbei7){$taozhuang=4;
// }

// if($zhuangbei1==$zhuangbei2&&$zhuangbei1==$zhuangbei3&&$zhuangbei1==$zhuangbei5&&$zhuangbei1==$zhuangbei6){$taozhuang=4;
// }else{
// if($zhuangbei1==$zhuangbei2&&$zhuangbei1==$zhuangbei3&&$zhuangbei1==$zhuangbei5&&$zhuangbei1==$zhuangbei7){$taozhuang=4;
// }}

// if($zhuangbei1==$zhuangbei2&&$zhuangbei1==$zhuangbei3&&$zhuangbei1==$zhuangbei6&&$zhuangbei1==$zhuangbei7){$taozhuang=4;
// }


// if($zhuangbei1==$zhuangbei2&&$zhuangbei1==$zhuangbei3&&$zhuangbei1==$zhuangbei4&&$zhuangbei1==$zhuangbei5&&$zhuangbei1==$zhuangbei6){$taozhuang=5;
// }else{
// if($zhuangbei1==$zhuangbei2&&$zhuangbei1==$zhuangbei3&&$zhuangbei1==$zhuangbei4&&$zhuangbei1==$zhuangbei5&&$zhuangbei1==$zhuangbei7){$taozhuang=5;
// }}


// if($zhuangbei1==$zhuangbei2&&$zhuangbei1==$zhuangbei3&&$zhuangbei1==$zhuangbei4&&$zhuangbei1==$zhuangbei6&&$zhuangbei1==$zhuangbei7){$taozhuang=5;
// }else{

// if($zhuangbei1==$zhuangbei2&&$zhuangbei1==$zhuangbei3&&$zhuangbei1==$zhuangbei5&&$zhuangbei1==$zhuangbei6&&$zhuangbei1==$zhuangbei7){$taozhuang=5;
// }else{

// if($zhuangbei1==$zhuangbei2&&$zhuangbei1==$zhuangbei4&&$zhuangbei1==$zhuangbei5&&$zhuangbei1==$zhuangbei6&&$zhuangbei1==$zhuangbei7){$taozhuang=5;
// }else{

// if($zhuangbei1==$zhuangbei3&&$zhuangbei1==$zhuangbei4&&$zhuangbei1==$zhuangbei5&&$zhuangbei1==$zhuangbei6&&$zhuangbei1==$zhuangbei7){$taozhuang=5;
// }}}}

$czb1 = $zb1->taozhuang;
$czb2 = $zb2->taozhuang;
$czb3 = $zb3->taozhuang ;
$czb4 = $zb4->taozhuang ;
$czb5 = $zb5->taozhuang ;
$czb6 = $zb6->taozhuang ;
$czb7 = $zb7->taozhuang ;

if($czb1*$czb2*$czb3*$czb4*$czb5*$czb6*$czb7 != 0){
        if($zhuangbei1==$zhuangbei2&&$zhuangbei1==$zhuangbei3&&$zhuangbei1==$zhuangbei4&&$zhuangbei1==$zhuangbei5&&$zhuangbei1==$zhuangbei6&&$zhuangbei1==     $zhuangbei7){$taozhuang="Trước mắt thần trang ngay tại chuẩn bị giai đoạn, có thể trông thấy đoạn văn này, ngươi căn bản cũng không phải là người chơi bình thường！！！";
        }else{
        $taozhuang="Kích hoạt nhắc nhở：Cần mặc sắc thái cùng kiểu dáng giống nhau trang bị mới có thể kích hoạt, trước mắt trang bị chưa đạt tới mở ra điều kiện！<br><br>";
         }
}else{
	$taozhuang = "Đủ mọi màu sắc trang bị không cách nào tiến hành kích hoạt, cần mặc sắc thái cùng kiểu dáng đồng dạng！<br><br>" ;
}

$ztcmd = $encode->encode("cmd=zhuangtai&sid=$sid");
$cwinfo = $encode->encode("cmd=chongwu&cwid=$player->cw&canshu=cwinfo&sid=$sid");
$gm =  $encode->encode("cmd=czbgm&canshu2=gaiming2&sid=$sid");
$sz =  $encode->encode("cmd=taozhuang&sid=$sid");
//Khảo thí sáo trang

$tzhtml =<<<HTML
<div class="menu"><a href="?cmd=$ztcmd">Nhân vật</a><a href="?cmd=$cwinfo"><font color="#9c27b0">Sủng vật</font></a><a href="?cmd=$sz">Thần trang</a><a href="?cmd=$gm">Đổi tên</a></div>
<hr>
Trang bị tình huống：<br>
<font style="color: $zb1->zbys;">$zbmz1</font> Kiểu dáng：$zhuangbei1<br>
<font style="color: $zb2->zbys;">$zbmz2</font> Kiểu dáng：$zhuangbei2<br>
<font style="color: $zb3->zbys;">$zbmz3</font> Kiểu dáng：$zhuangbei3<br>
<font style="color: $zb4->zbys;">$zbmz4</font> Kiểu dáng：$zhuangbei4<br>
<font style="color: $zb5->zbys;">$zbmz5</font> Kiểu dáng：$zhuangbei5<br>
<font style="color: $zb6->zbys;">$zbmz6</font> Kiểu dáng：$zhuangbei6<br>
<font style="color: $zb7->zbys;">$zbmz7</font> Kiểu dáng：$zhuangbei7<br><br>
$taozhuang
<a href="#" onClick="javascript:history.back(-1);">Trở lại</a>
<a href="game.php?cmd=$gonowmid" style="float:right;" >Trở về trò chơi</a>
HTML;
echo $tzhtml;

?>