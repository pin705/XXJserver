<?php
require_once __DIR__ . '/../src/Helpers/NguoiChoiHelper.php';
require_once __DIR__ . '/../src/Helpers/TrangBiHelper.php';
require_once __DIR__ . '/../src/Helpers/DaoCuHelper.php';
require_once __DIR__ . '/../src/Helpers/DuocPhamHelper.php';
require_once __DIR__ . '/../src/Helpers/QuaiVatHelper.php';
require_once __DIR__ . '/../src/Helpers/TruongLaoHelper.php';
require_once __DIR__ . '/../src/Helpers/NhiemVuHelper.php';
require_once __DIR__ . '/../src/Helpers/BanDoHelper.php';
require_once __DIR__ . '/../src/Helpers/SungVatHelper.php';
require_once __DIR__ . '/../src/Helpers/KyNangHelper.php';
require_once __DIR__ . '/../src/Helpers/ClubHelper.php';
use TuTaTuTien\Helpers as Helpers;


$player = Helpers\layThongTinNguoiChoi($sid,$dblj);//Thu hoạch người chơi tin tức
$lastmid = $player->idBanDoHienTai;

if (isset($newmid)){
    if ($player->idBanDoHienTai!=$newmid){
        $clmid = Helpers\layThongTinBanDo($newmid,$dblj); //Thu hoạch sắp đi địa đồ tin tức
	$playerinfo = $player->tenNhanVat."Hướng$clmid->mname.Đi đến";
        if ($playerinfo != $clmid->playerinfo){
            $sql = "update mid set playerinfo='$playerinfo' WHERE mid='$lastmid'";
            $dblj->exec($sql);
        }
        if ($player->sinhMenh<=0){
            $retmid = Helpers\layThongTinBanDo($player->idBanDoHienTai,$dblj);
            $retqy = Helpers\layThongTinKhuVuc($retmid->mqy,$dblj);
            $gonowmid = $encode->encode("cmd=gomid&newmid=$retqy->mid&sid=$sid");
            if ($newmid != $retqy->mid){
                exit("Ngươi đã trọng thương mời trị liệu<br/>".'<a href="?cmd='.$gonowmid.'">Trở về trò chơi</a>');
            }

        }
		//Nghĩ tại cái này tăng thêm quái vật dây dưa, hoặc là ngẫu nhiên sự kiện
		// if ($player->sinhMenh<=0){
            // $retmid = Helpers\layThongTinBanDo($player->idBanDoHienTai,$dblj);
            // $retqy = Helpers\layThongTinKhuVuc($retmid->mqy,$dblj);
            // $gonowmid = $encode->encode("cmd=gomid&newmid=$retqy->mid&sid=$sid");
            // if ($newmid != $retqy->mid){
                // exit("Gặp được quái vật dây dưa, không cách nào thoát thân。<br/>".'<a href="?cmd='.$gonowmid.'">Trở về trò chơi</a>');
            // }

        // }
        Helpers\thayDoiThuocTinhNguoiChoi('nowmid',$newmid,$sid,$dblj);
        $player = Helpers\layThongTinNguoiChoi($sid,$dblj);//Thu hoạch người chơi tin tức
    }

}

if ($player->idBanDoHienTai=='' || $player->idBanDoHienTai==0){//Phán đoán nhân vật phải chăng xuất hiện tại phi pháp địa đồ
    $gameconfig = Helpers\layCauHinhTroChoi($dblj);
    $sql = "update game1 set nowmid='$gameconfig->firstmid' WHERE sid='$sid'";
    $dblj->exec($sql);
    $player->idBanDoHienTai=$gameconfig->firstmid;
}
$clmid = Helpers\layThongTinBanDo($player->idBanDoHienTai,$dblj); //Thu hoạch địa đồ tin tức
if ($clmid->playerinfo != ''){
    $clmid->playerinfo .='<br/>';
}
$pvphtml = "[Khu vực an toàn]";
if ($clmid->ispvp){
    $pvphtml = "<font color='#FF0000'>[PVP]</font>";
}


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

$lukouhtml ='';
$bosshtml = '';//boss Địa chỉ dẫn vào
if ($clmid->midinfo == ''){
    $clmid->midinfo = $clmid->mname;
}
$clmid = Helpers\layThongTinBanDo($newmid,$dblj); //Thu hoạch sắp đi địa đồ tin tức
$boss = Helpers\layThongTinBoss($clmid->midboss,$dblj);
$bossxl = $boss->bosshp;
$second=floor((strtotime($nowdate) - strtotime($clmid->mgtime))%86400);
if ($bossxl<0 && $clmid->midboss != 0 && $second > $clmid->ms){
	// $sql = "update mid set mgtime='$nowdate' WHERE mid='$player->idBanDoHienTai'";//Gia tăng thời gian, tính toán
    // $dblj->exec($sql);
	$sql = "update boss set bosshp = bossmaxhp  WHERE bossid='$clmid->midboss'";//Cho boss Tăng máu, phía trên phán đoán làm mới thời gian
	$dblj->exec($sql);
	$boss = Helpers\layThongTinBoss($clmid->midboss,$dblj);
    $bossinfo = $encode->encode("cmd=boss&bossid=$boss->bossid&sid=$sid");
    $bosshtml = <<<HTML
	<a style="color: #f80a0a;border-radius: 10px;" href="?cmd=$bossinfo">
	$boss->tenBoss</a>
HTML;
}
    if($bossxl>0 && $clmid->midboss != 0){
    $boss = Helpers\layThongTinBoss($clmid->midboss,$dblj);
    $bossinfo = $encode->encode("cmd=boss&bossid=$boss->bossid&sid=$sid");
    $bosshtml = <<<HTML
	<a style="color: #f80a0a;border-radius: 10px;" href="?cmd=$bossinfo">
	$boss->tenBoss</a>
HTML;
    }

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
    Đông:<a href="?cmd=$rightmidlj">$rightmid->mname →</a><br/>
HTML;
}

if ($downmid->mname!=''){
    $lukouhtml .= <<<HTML
    Nam:<a href="?cmd=$downmidlj">$downmid->mname ↓</a><br/>
HTML;
}

$sql = "select * from midguaiwu where mid='$player->idBanDoHienTai' AND sid = ''";//Thu hoạch trước mắt địa đồ quái vật
$cxjg = $dblj->query($sql);
$cxallguaiwu = $cxjg->rowCount();
$nowdate = date('Y-m-d H:i:s');
$second=floor((strtotime($nowdate)-strtotime($clmid->mgtime))%86400);//Thu hoạch làm mới khoảng cách 86400
if ($second > $clmid->ms  && $cxallguaiwu<= 0 && $clmid->mgid!=''){//làm mới quái vật, còn thừa nhiều ít quái vật làm mới, có thể tại sửa chữa sửa chữa, đổi thành quái vật tử vong cái gì đang cày mới cái gì
    $sql = "update mid set mgtime='$nowdate' WHERE mid='$player->idBanDoHienTai'";
    $dblj->exec($sql);
    $retgw = explode(",",$clmid->mgid);
    foreach ($retgw as $itemgw){
        $gwinfo = explode("|",$itemgw);
        $guaiwu = Helpers\layThongTinMauQuaiVat($gwinfo[0],$dblj);
        $guaiwu->gyid = $gwinfo[0];
        $sjexp = mt_rand(6,8) + 100;//Vốn có tăng thêm 0.5，Ta đổi thành 100..
        $guaiwu->gexp = round($guaiwu->capDo * $sjexp,0);
        for ($n=0;$n<$gwinfo[1];$n++){
            $sql = "insert into midguaiwu(mid,gname,glv,ghp,ggj,gfy,gbj,gxx,gexp,gyid,gmaxhp) 
                    values('$player->idBanDoHienTai',
                    '$guaiwu->tenQuaiVat',
                    '$guaiwu->capDo',
                    '$guaiwu->ghp',
                    '$guaiwu->congKich',
                    '$guaiwu->phongNgu',
                    '$guaiwu->gbj',
                    '$guaiwu->gxx',
                    '$guaiwu->gexp',
                    '$guaiwu->gyid',
                    '$guaiwu->ghp')";
            $cxjg = $dblj->exec($sql);
        }

    }
}
//Đếm ngược, đã vứt bỏ
// if ($clmid->ms == 600){
// $djshtml = <<<HTML
// <head>
// <script type="text/javascript" src="./chajian/djs/js/jquery.js"></script>
// <script type="text/javascript" src="./chajian/djs/js/time_js.js"></script>
// <link type="text/css" rel="stylesheet" href="./chajian/djs/css/time_css.css" />
// </head>
// <body>	
// <div class="time"></div>
// <script type="text/javascript">
// countDown();
// </script>
// </body>

// HTML;
// }else{
        // ;
    // }
	
	// if ($clmid->ms > 0){
        // $djshtml;
    // }else{
        // $djshtml ;
    // }
//Phía trên là đếm ngược một đoạn




$sql = "select * from midguaiwu where mid='$player->idBanDoHienTai' AND sid = ''";//Thu hoạch trước mắt địa đồ quái vật
$cxjg = $dblj->query($sql);
$cxallguaiwu = $cxjg->fetchAll(PDO::FETCH_ASSOC);
$gwhtml = '';
for ($i = 0;$i<count($cxallguaiwu);$i++){
    $gwcmd = $encode->encode("cmd=getginfo&gid=".$cxallguaiwu[$i]['id']."&gyid=".$cxallguaiwu[$i]['gyid']."&sid=$sid&nowmid=$player->idBanDoHienTai");
    $gwhtml .="<a href='?cmd=$gwcmd'>".$cxallguaiwu[$i]['gname']."</a>";
}

$sql = "select * from game1 where nowmid='$player->idBanDoHienTai' AND sfzx = 1";//Thu hoạch trước mắt địa đồ người chơi
$cxjg = $dblj->query($sql);
$playerhtml = '';
if ($cxjg){
    $cxallplayer = $cxjg->fetchAll(PDO::FETCH_ASSOC);
    $nowdate = date('Y-m-d H:i:s');
    for ($i = 0;$i<count($cxallplayer);$i++){
        if ($cxallplayer[$i]['uname']!=""){
            $cxtime = $cxallplayer[$i]['endtime'];
            $cxuid = $cxallplayer[$i]['uid'];
            $cxsid = $cxallplayer[$i]['sid'];
            $cxuname = $cxallplayer[$i]['uname'];
            $cxuname = $cxallplayer[$i]['uname'];
            $second=floor((strtotime($nowdate)-strtotime($cxtime))%86400);//Thu hoạch làm mới khoảng cách
            if ($second > 3000){
                $sql = "update game1 set sfzx=0 WHERE sid='$cxsid'";
                $dblj->exec($sql);
            }else{
                $clubp = Helpers\layThongTinClubPlayer($cxsid,$dblj);
                if ($clubp){
                    $club = Helpers\layThongTinClub($clubp->clubid,$dblj);
                    $club->clubname ="[$club->clubname]";
                }else{
                    $club = new Helpers\layThongTinClub();
                    $club->clubname ="";
                }
                $playercmd = $encode->encode("cmd=getplayerinfo&uid=$cxuid&sid=$sid");
                $playerhtml .="<a href='?cmd=$playercmd'>{$club->clubname}$cxuname</a>";
            }

        }
    }
}


$npchtml='';
$task = Helpers\layDanhSachNhiemVuNguoiChoi($sid,$dblj);//Người chơi nhiệm vụ mấy tổ

$sql = "select * from playerrenwu WHERE sid='$sid' AND rwlx = 2";
$cxjg = $dblj->query($sql);
$mrrw = $cxjg->fetchAll(PDO::FETCH_ASSOC);
for ($n=0;$n<count($mrrw);$n++){
    if ($mrrw[$n]['data']!=date('d') ){
        $rwid = $mrrw[$n]['rwid'];
        $sql="delete from playerrenwu WHERE rwid=$rwid AND sid='$sid'";
        $dblj->exec($sql);
    }
}

$sql = "select * from playerrenwu WHERE sid='$sid' AND rwzt!=3";
$cxjg = $dblj->query($sql);
$wtjrw = $cxjg->fetchAll(PDO::FETCH_ASSOC);
$taskcount = count($wtjrw);

if ($clmid->mnpc !=""){
    $sql = "select * from npc where id in ($clmid->mnpc)";//Thu hoạch npc
    $cxjg = $dblj->query($sql);
    $cxnpcall = $cxjg->fetchAll(PDO::FETCH_ASSOC);

    for ($i=0;$i < count($cxnpcall);$i++){
        $nname = $cxnpcall[$i]['nname'];
        $nid = $cxnpcall[$i]['id'];
        $taskid = $cxnpcall[$i]['taskid'];
        $taskarr = explode(',',$taskid);
        $yrw = false;
        if ($taskid!=''){
            for ($l=0;$l<count($taskarr);$l++){
                $nowrw = Helpers\layThongTinNhiemVu($taskarr[$l],$dblj);
                $rwret = Helpers\layThongTinNhiemVuCuaNguoiChoi($sid,$taskarr[$l],$dblj);
                $lastrwid = $nowrw->lastrwid;

                if ($nowrw->rwlx == 1 || $nowrw->rwlx == 2){
                    if (!$rwret){
                        if ($nowrw->rwzl != 3){
                            $npchtml .='<img src="images/wen.gif" />';
                        }elseif($nowrw->rwyq == $nid){
                            $npchtml .='<img src="images/wen.gif" />';
                        }else{
                            continue;
                        }
                    }elseif ($rwret->rwzt==2){
                        if ($nowrw->rwzl != 3){
                            $npchtml .='<img src="images/tan.gif" />';
                        }elseif ($nowrw->rwcount == $nid){
                            $npchtml .='<img src="images/tan.gif" />';
                        }else{
                            continue;
                        }

                    }
                }
                if ($nowrw->rwlx == 3){
                    if ($rwret){
                        if ($rwret->rwzt==2){
                            if ($nowrw->rwzl != 3){
                                $npchtml .='<img src="images/tan.gif" />';
                            }elseif ($nowrw->rwcount == $nid){
                                $npchtml .='<img src="images/tan.gif" />';
                            }else{
                                continue;
                            }
                        }
                    }else{
                        if ($lastrwid<=0 ){
                            if ($nowrw->rwzl != 3){
                                $npchtml .='<img src="images/wen.gif" />';
                            }elseif ($nowrw->rwyq == $nid){
                                $npchtml .='<img src="images/wen.gif" />';
                            }else{
                                continue;
                            }
                        }else{
                            $rwret = Helpers\layThongTinNhiemVuCuaNguoiChoi($sid,$lastrwid,$dblj);
                            if ($rwret){
                                if ($rwret->rwzt==3){
                                    if ($nowrw->rwzl != 3){
                                        $npchtml .='<img src="images/wen.gif" />';
                                    }elseif ($nowrw->rwyq == $nid){
                                        $npchtml .='<img src="images/wen.gif" />';
                                    }else{
                                        continue;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        $npccmd = $encode->encode("cmd=npc&nid=$nid&sid=$player->sid");
		
        $npchtml .= <<<HTML
      
	<a href="?cmd=$npccmd">{$nname}</a>
HTML;
    }//Đây là$npchtml.....Nhiệm vụ NPC Dấu chấm hỏi nhắc nhở...
}
$texiao = <<<HTML

<IMG width='15' height='15' src='./images/texiao.png'>

HTML;


$sql = 'SELECT * FROM ggliaotian ORDER BY id DESC LIMIT 2';//Nói chuyện phiếm danh sách thu hoạch<!--xiamian Phía dưới vì công cộng nói chuyện phiếm trước xưng【Công cộng】，Ta đã hủy bỏ--!>
$ltcxjg = $dblj->query($sql);
$lthtml='';
if ($ltcxjg){
    $ret = $ltcxjg->fetchAll(PDO::FETCH_ASSOC);
    for ($i=0;$i < count($ret);$i++){
        $uname = $ret[count($ret) - $i-1]['name'];
        $umsg = $ret[count($ret) - $i-1]['msg'];
        $uid = $ret[count($ret) - $i-1]['uid'];
        $ucmd = $encode->encode("cmd=getplayerinfo&uid=$uid&sid=$player->sid");
        if ($uid){
            $lthtml .="<font color=#F4911A></font><font color=#F80000>$texiao</font><font color=#EE8B14></font><font color=#EB8811></font>
			<a href='?cmd=$ucmd''>$uname</a>:$umsg<br>";
        }else{
            $lthtml .="<font color=#F4911A></font><font color=#F80000>$texiao</font><font color=#EE8B14></font><font color=#EB8811></font>
			<div class='hpys' style='display: inline'>$uname:</div>$umsg<br>";
        }

    }
}
//Mới đếm ngược, phối hợp BOSS Công kích tính toán thời gian
$second=floor((strtotime($nowdate)-strtotime($clmid->mgtime))%86400);//Thu hoạch làm mới khoảng cách 86400
$sj = $clmid->ms - $second ;
$sx = $sj+1;
    if ($sj < 0){
        $sj = 0;
	}
    if ($sj>0 && $bossxl<0){  
$djs =<<<HTML
<html>
<body>
<div align="center">
<span class="STYLE7" id="clock" style="color: #f50e0e;">$sj</span>
<strong><span class="STYLE8">Giây sau làm mới BOSS</span>
<script type="text/javascript">
var oclock=document.getElementById("clock");
var start1 = oclock.innerHTML;
var finish = "0";
var timer = null;
run();
function run() {//Định nghĩa thời gian hàm số, để đồng hồ bấm giây mỗi 100ms Biến hóa một lần
timer =setInterval("onTimer()", 1000);//100ms Định thời gian khí
}
function onTimer()
{
if (start1 == finish)//Nếu như đếm ngược kết thúc thanh trừ thời gian hàm số
{
clearInterval(timer);
start1="1";//(Thanh trừ thời gian hàm số sau vẫn là sẽ chấp hành một lần Cho nên cho thêm một cái 10ms Lại cử động thái phú giá trị)
}
start1 -= 1;//Mỗi lần chấp hành ms Giảm 10
oclock.innerHTML = start1;//Một lần nữa cho oclock Phú giá trị
}
</script>
</strong>
<meta http-equiv="refresh" content="$sx">
</div>
</body>
</html>
HTML;
}
	




$mapcmd = $encode->encode("cmd=allmap&sid=$sid");
$xiuliancmd = $encode->encode("cmd=goxiulian&sid=$sid");
$mytask = $encode->encode("cmd=mytask&sid=$sid");
$getbagjncmd = $encode->encode("cmd=getbagjn&sid=$sid");
$fangshi = $encode->encode("cmd=fangshi&fangshi=daoju&sid=$sid");
$shangdian = $encode->encode("cmd=shangdian&canshu=gogoumai&sid=$sid");
$clubcmd = $encode->encode("cmd=club&sid=$sid");
$duihuancmd = $encode->encode("cmd=duihuan&sid=$sid");
$imcmd = $encode->encode("cmd=im&sid=$sid");
$lb = $encode->encode("cmd=getbagyd&sid=$sid");
$qydt = $encode->encode("cmd=qydt&sid=$sid");
$nowhtml = <<<HTML
<font face=Thể chữ lệ color="ae2d61">
<marquee direction="left" style="background: #ffffff;font-size:30 px">
<font color="#FFA000">【 $clmid->mname 】</font>
<font color="#7FE000">$pvphtml</font>
$clmid->midinfo---->Có người trông thấy$clmid->playerinfo
</marquee>
</font>
<!--=====NPC=====<br>-->
$npchtml<br>
<!--=====Quái vật=====<br>--><hr style="height:3px;border:none;border-top:3px double #efa1a1;" />
$djs
$djshtml
$gwhtml
$bosshtml
<!--<div class="juzhong1">=====Phương hướng=====</div>-->
<hr>
$lukouhtml
<hr>
<div class="juzhong1">Vị trí: 『$clmid->mname 』</div>

<hr>
$playerhtml
<br/>
<div id="ltmsg">
<hr>
</div>
$lthtml
<hr>
<div align="center">
<div class="menu">
<a href="?cmd=$mapcmd">
    <strong style="background:#00E000">
    <font color=#FCFCFC>[</font><font color=#F9F9F9>Xem xét </font><font color=#F6F6F6>Thế giới</font><font color=#F3F3F3>]</font></strong>
    </a>
    <a href="?cmd=$mytask">Nhiệm vụ($taskcount)</a>
    <a href="?cmd=$qydt">Địa đồ</a>
    <a href="?cmd=$gonowmid">Làm mới</a>
</div>
<br/>
<hr style="width:280px; height:0px;border:none;border-top:10px groove #a5eaad;"  />
<div class="menu">
<div>
<a href="?cmd=$ztcmd">Trạng thái</a> 
<a href="?cmd=$getbagcmd" >Hành Trang</a> 
<a href="?cmd=$goliaotian" >Trò chuyện</a> 
<a href="?cmd=$cwcmd"      style="background-color:#;color:#f59b11;">Sủng vật</a>
</div>
<div>
<a href="?cmd=$lb" >Shop Bí Ẩn</a>
<a href="?cmd=$phcmd" >Xếp hạng</a> 
<a href="?cmd=$xiuliancmd" >Tu luyện</a> 
<a href="?cmd=$fangshi" >Giao dịch</a> 
</div>
<div>
<a href="?cmd=$clubcmd" >Môn phái</a>
<a href="?cmd=$imcmd" >Hảo hữu</a> 
<a href="?cmd=$duihuancmd" >Nhận quà</a>
<a href="?cmd=$shangdian">
<!--<IMG width="20" height="15" src="./images/pz.png">-->
<font color=#FB4A0E>Cửa hàng</font></a> 
</div>
<!--<a href="index.php"><div class="hsds">Rời khỏi</div></a>-->
<a href="index.php" style="align-content: center;"><div>Rời khỏi</div></a>
</div>
</div>
HTML;
echo $nowhtml;
?>
<!--<font color="#FF2800">Trải</font><font color="#FF5000">Tử</font>--!>
<!--<a href="http://playdreamer.cn/alipay/?id=9&user_id=$player->idNguoiDung" target="_blank">Nạp tiền</a>--!>