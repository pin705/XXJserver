<?php
require_once __DIR__ . '/../Helpers/NguoiChoiHelper.php';
require_once __DIR__ . '/../Helpers/TrangBiHelper.php';
require_once __DIR__ . '/../Helpers/DaoCuHelper.php';
require_once __DIR__ . '/../Helpers/DuocPhamHelper.php';
require_once __DIR__ . '/../Helpers/ClubHelper.php';
use TuTaTuTien\Helpers as Helpers;

$player = Helpers\layThongTinNguoiChoi($sid,$dblj);//Thu hoạch ngươi ID
$gonowmid = $encode->encode("cmd=gomid&newmid=$player->idBanDoHienTai&sid=$sid");//【Trở về trò chơi kết nối】
$qysd = $encode->encode("cmd=shangdian&canshu=gogoumai&sid=$sid");//【Cửa hàng kết nối】  PHP ，Lựa chọn văn bản , tăng thêm dấu hiệu , thân phận của ngươi
$clmid = Helpers\layThongTinBanDo($player->idBanDoHienTai,$dblj); //Thu hoạch địa đồ tin tức
if ($clmid->playerinfo != ''){
    $clmid->playerinfo .='<br/>';
}
//$ydlist = $encode->encode("cmd=shangdian&nid&canshu=ydlist&sid=$sid");//Đây là không có viết xong, cũng không biết muốn viết cái gì

//Bắt đầu từ nơi này cái thứ nhất web page
// $npchtml = <<<HTML


// $npchtml = '';

// $cxallnpchtml = \player\getqy_all($dblj);
// $br = 0;
// for ($i=0;$i<count($cxallnpchtml);$i++){

    // $qyame = $cxallnpchtml[$i]['qyname'];
    // $mid = $cxallnpchtml[$i]['mid'];
    // if ($mid>0){
        // $cxmid = Helpers\layThongTinBanDo($mid,$dblj);
        // $mname = $cxmid->mname;
        // $br++;
        // $gomid = $encode->encode("cmd=gomid&newmid=$mid&sid=$sid");
        // $npchtml .=<<<HTML
        // <a href="?cmd=$gomid" >[$qyame]$mname</a>
// HTML;
    // }
    // if ($br >= 3){
        // $br = 0;
        // $npchtml.="<br/>"  ;
    // }
// }



// <br/><a href="?cmd=$shangdian">Cái thứ nhất đoạn</a><br/>
//HTML;
//Kết thúc cái thứ nhất web page


$yrdthtml = '';
$yrdt = Helpers\layThongTinBanDo($mid,$dblj);
$cxallnpchtml = Helpers\layDanhSachKhuVuc($dblj);

$br = 0;
for ($i=0;$i<count($cxallnpchtml);$i++){
     $qyame = $cxallnpchtml[$i]['qyname'];
    $yrdt = Helpers\layThongTinBanDo($qyid,$dblj);
    $mid = $cxallnpchtml[$i]['mid'];
	
    if ($mid>0){
        $cxmid = Helpers\layThongTinBanDo($mid,$dblj);
        $mname = $cxmid->mname;
		
        $br++;
        $gomid = $encode->encode("cmd=gomid&newmid=$mid&sid=$sid");
        $yrdthtml .=<<<HTML
        <a href="?cmd=$gomid" >【$qyame $mname 】</a>
HTML;
    }
    if ($br >= 1){
        $br = 0;
        $yrdthtml.="<br/>"  ;
    }
}
$yrdthtml = <<<HTML

<hr>
$yrdthtml
<hr>
HTML;
$ztcmd = $encode->encode("cmd=zhuangtai&sid=$sid");
$goliaotian = $encode->encode("cmd=liaotian&ltlx=all&sid=$sid");
$gonowmid = $encode->encode("cmd=gomid&newmid=$clmid->mid&sid=$sid");
$phcmd = $encode->encode("cmd=paihang&sid=$sid");
$getbagcmd = $encode->encode("cmd=getbagzb&sid=$sid");
$cwcmd = $encode->encode("cmd=chongwu&sid=$sid");
$cxall = '';

$upmidlj = $encode->encode("cmd=gomid&newmid=$clmid->upmid&sid=$sid");//Bên trên địa đồ
$downmidlj = $encode->encode("cmd=gomid&newmid=$clmid->downmid&sid=$sid");
$leftmidlj = $encode->encode("cmd=gomid&newmid=$clmid->leftmid&sid=$sid");
$rightmidlj = $encode->encode("cmd=gomid&newmid=$clmid->rightmid&sid=$sid");
$upmid = Helpers\layThongTinBanDo($clmid->upmid,$dblj);
$downmid = Helpers\layThongTinBanDo($clmid->downmid,$dblj);
$leftmid = Helpers\layThongTinBanDo($clmid->leftmid,$dblj);
$rightmid = Helpers\layThongTinBanDo($clmid->rightmid,$dblj);
$sx = ($clmid->leftmid)+4;
$dt = $encode->encode("cmd=gomid&newmid=$sx&sid=$sid");//Bên trên địa đồ
$dd = Helpers\layThongTinBanDo($sx,$dblj);
$lukouhtml ='';
if ($upmid->mname!=''){
    $lukouhtml .= <<<HTML
    Bắc:<a href="?cmd=$upmidlj">$upmid->mname ↑</a><br/>
HTML;
}

if ($leftmid->mname!=''){
    $lukouhtml .= <<<HTML
    Tây:<a href="?cmd=$leftmidlj">$leftmid->mname ←</a><br/>
HTML;
}

if ($rightmid->mname!=''){
    $lukouhtml .= <<<HTML
    <a href="?cmd=$rightmidlj">$rightmid->mname →</a><br/>
HTML;
}

if ($downmid->mname!=''){
    $lukouhtml .= <<<HTML
    <a href="?cmd=$downmidlj">$downmid->mname ↓</a><br/>
HTML;
}



$dthtml =<<<HTML

        <div width:100%>
          <div width:100%">
		  <div align="center">
		  <font size="2">
            <div id="playScene" class="" style="height: 50% !important; opacity: 1;">
			<center>Vị trí của ta:$clmid->mname<br><hr>
			<center><span id="gtBtn0" data-tp="b"><IMG width='280' height='150' src='./dt/ditu/{$clmid->mqy}.png' style="border-radius: 10px;"></a></span>
			
			</font>
			
          </div>
		</div>
		</div>
		</div>	
		<br><br>		

		<a href="#" onClick="javascript:history.back(-1);" style="float:left; background-color: #ecf7ed;">Trở lại</a>
            <a href="game.php?cmd=$gonowmid" style="float:right;background-color:#ecf7ed;" >Trở về trò chơi</a>
		<br>
		
</body>
HTML;



$djshtml = <<<HTML
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Máy bấm giờ</title>

<script type="text/javascript" src="./chajian/djs/js/jquery.js"></script>
<script type="text/javascript" src="./chajian/djs/js/time_js.js"></script>

<link type="text/css" rel="stylesheet" href="./chajian/djs/css/time_css.css" />

</head>

<body>

<div class="game_time">

	<div class="hold">
		<div class="pie pie1"></div>
	</div>

	<div class="hold">
		<div class="pie pie2"></div>
	</div>

	<div class="bg"> </div>
	
	<div class="time"></div>
	
</div>

<script type="text/javascript">
countDown();
</script>

</body>

HTML;
//Phía trên là đếm ngược một đoạn










//Phía dưới là một cái tham số cất giữ, sau đó mở ra cái thứ hai web page
//$player = Helpers\layThongTinNguoiChoi($sid,$dblj);//Thu hoạch ngươi ID
// $bb = $encode->encode("cmd=getbagyd&sid=$sid");
// $sd = $encode->encode("cmd=shangdian&canshu=gogoumai&sid=$sid");
$qydt = $encode->encode("cmd=qydt&sid=$sid");
$qydthtml =<<<HTML
         <div align="center">
         【<a href="?cmd=$qydt">Quái vật</a>|<a href="?cmd=$qydt">NPC</a>|<a href="?cmd=$qydt" style="
    background-color: #dbf9d5;
">Địa đồ】</a><br/>
    
        
        
		<div align="center">
		【Khu vực địa đồ】<br>
		$dthtml<br>
		$yrdthtml<br>
		</div>
		
		<a href="#" onClick="javascript:history.back(-1);">Trở lại</a>
        <a href="?cmd=$gonowmid">Trở về trò chơi</a>
		
		</div>
HTML;
echo $qydthtml
?> 










