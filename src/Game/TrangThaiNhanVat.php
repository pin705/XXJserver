<?php
require_once __DIR__ . '/../Helpers/NguoiChoiHelper.php';
require_once __DIR__ . '/../Helpers/TrangBiHelper.php';
use TuTaTuTien\Helpers as Helpers;

$tssb = <<<HTML
<link rel="stylesheet" type="text/css" href="./chajian/tishikuang/style/dialog.css">
		    <script src="./chajian/tishikuang/javascript/zepto.min.js"></script>
             <script type="text/javascript" src="./chajian/tishikuang/javascript/dialog.min.js"></script>
<body>
    <font id="error"></font>
<script type="text/javascript">
	setTimeout(function() {
		// IE
		if(document.all) {
			document.getElementById("error").click();
		}
		// Cái khác trình duyệt
		else {
			var e = document.createEvent("MouseEvents");
			e.initEvent("click", true, true);
			document.getElementById("error").dispatchEvent(e);
		}
	}, 500);
</script>
<script src="./chajian/tishikuang/javascript/zepto.min.js"></script>
<script type="text/javascript" src="./chajian/tishikuang/javascript/dialog.min.js"></script>
<script type="text/javascript">	   
$('#error').click(function(){
   popup({type:'error',msg:"Cấp bậc chưa đủ",delay:2000,bg:true,clickDomCancel:true});
})
</script>
</body>
HTML;

$player = Helpers\layThongTinNguoiChoi($sid, $dblj);
$gonowmid = $encode->encode("cmd=gomid&newmid=$player->idBanDoHienTai&sid=$sid");
$getbagzbcmd = $encode->encode("cmd=getbagzb&sid=$sid");
//$clubplayer = \player\getclubplayer_once($sid,$dblj);
//if ($clubplayer){
//    $club = \player\getclub($clubplayer->clubid,$dblj);
//    $clubcmd = $encode->encode("cmd=club&sid=$sid");
//    $clubname ="<a href='?cmd=$clubcmd'>$club->clubname</a>";
//}else{
//    $clubname = "Không môn không phái";
//}
if ($cmd == 'xxzb'){
    if (isset($zbwz)){
        $sql = "update game1 set tool$zbwz = 0 WHERE sid = '$sid'";
        $dblj->exec($sql);
        $player = Helpers\layThongTinNguoiChoi($sid, $dblj);
    }
}
if ($cmd == 'setzbwz'){
    $arr = array($player->tool1,$player->tool2,$player->tool3,$player->tool4,$player->tool5,$player->tool6,$player->tool7);


    if (isset($zbnowid) && isset($zbwz)){
        if (!in_array($zbnowid,$arr)){
            $nowzb = Helpers\layThongTinTrangBiTheoId($zbnowid, $dblj);
            if ($nowzb->idNguoiDung != $player->idNguoiDung){
                echo "Ngươi không có nên trang bị, không cách nào trang bị<br/>";

            }elseif($nowzb->capDoYeuCau - $player->capDo > 5){
                echo "Trang bị lớn hơn người chơi đẳng cấp, không cách nào trang bị<br/>$tssb";
            }elseif($nowzb->viTriTrangBi!=$zbwz && $nowzb->viTriTrangBi){
                echo "Trang bị chủng loại không phù hợp, không cách nào trang bị<br/>";
            }else{
                $sql = "update game1 set tool{$zbwz} = $zbnowid WHERE sid = '$sid'";
                $dblj->exec($sql);
                $player = Helpers\layThongTinNguoiChoi($sid, $dblj);
            }

        }
    }
}

$tool1 = '';
$tool2 = '';
$tool3 = '';
$tool4 = '';
$tool5 = '';
$tool6 = '';
$tool7 = '';


if ($player->tool1!=0){
    $zhuangbei = Helpers\layThongTinTrangBiTheoId($player->tool1, $dblj);
	
    $qhs = '';
    if ($zhuangbei->capCuongHoa>0){
        $qhs = '+'.$zhuangbei->capCuongHoa;
    }
    $xxzb1 = '<a href="?cmd='.$encode->encode("cmd=xxzb&zbwz=1&sid=$sid").'">Dỡ xuống</a>';
	
$tool1 = '<a href="?cmd='.$encode->encode("cmd=chakanzb&zbnowid=$player->tool1&uid=$player->idNguoiDung&sid=$sid").'">
<font color='.$zhuangbei->phamChat.'>'.$zhuangbei->tenTrangBi.'</font>'.$qhs.'</a>'.$xxzb1;
}
if ($player->tool2!=0){
    $zhuangbei = Helpers\layThongTinTrangBiTheoId($player->tool2, $dblj);
    $qhs = '';
    if ($zhuangbei->capCuongHoa>0){
        $qhs = '+'.$zhuangbei->capCuongHoa;
    }
    $xxzb2 = '<a href="?cmd='.$encode->encode("cmd=xxzb&zbwz=2&sid=$sid").'">Dỡ xuống</a>';
    $tool2 = '<a href="?cmd='.$encode->encode("cmd=chakanzb&zbnowid=$player->tool2&uid=$player->idNguoiDung&sid=$sid").'"><font color='.$zhuangbei->phamChat.'>'.$zhuangbei->tenTrangBi.'</font>'.$qhs.'</a>'.$xxzb2;
}
if ($player->tool3!=0){
    $zhuangbei = Helpers\layThongTinTrangBiTheoId($player->tool3, $dblj);
    $qhs = '';
    if ($zhuangbei->capCuongHoa>0){
        $qhs = '+'.$zhuangbei->capCuongHoa;
    }
    $xxzb3 = '<a href="?cmd='.$encode->encode("cmd=xxzb&zbwz=3&sid=$sid").'">Dỡ xuống</a>';
    $tool3 = '<a href="?cmd='.$encode->encode("cmd=chakanzb&zbnowid=$player->tool3&uid=$player->idNguoiDung&sid=$sid").'"><font color='.$zhuangbei->phamChat.'>'.$zhuangbei->tenTrangBi.'</font>'.$qhs.'</a>'.$xxzb3;
}
if ($player->tool4!=0){
    $zhuangbei = Helpers\layThongTinTrangBiTheoId($player->tool4, $dblj);
    $qhs = '';
    if ($zhuangbei->capCuongHoa>0){
        $qhs = '+'.$zhuangbei->capCuongHoa;
    }
    $xxzb4 = '<a href="?cmd='.$encode->encode("cmd=xxzb&zbwz=4&sid=$sid").'">Dỡ xuống</a>';
    $tool4 = '<a href="?cmd='.$encode->encode("cmd=chakanzb&zbnowid=$player->tool4&uid=$player->idNguoiDung&sid=$sid").'"><font color='.$zhuangbei->phamChat.'>'.$zhuangbei->tenTrangBi.'</font>'.$qhs.'</a>'.$xxzb4;
}
if ($player->tool5!=0){
    $zhuangbei = Helpers\layThongTinTrangBiTheoId($player->tool5, $dblj);
    $qhs = '';
    if ($zhuangbei->capCuongHoa>0){
        $qhs = '+'.$zhuangbei->capCuongHoa;
    }
    $xxzb5 = '<a href="?cmd='.$encode->encode("cmd=xxzb&zbwz=5&sid=$sid").'">Dỡ xuống</a>';
    $tool5 = '<a href="?cmd='.$encode->encode("cmd=chakanzb&zbnowid=$player->tool5&uid=$player->idNguoiDung&sid=$sid").'"><font color='.$zhuangbei->phamChat.'>'.$zhuangbei->tenTrangBi.'</font>'.$qhs.'</a>'.$xxzb5;
}
if ($player->tool6!=0){
    $zhuangbei = Helpers\layThongTinTrangBiTheoId($player->tool6, $dblj);
    $qhs = '';
    if ($zhuangbei->capCuongHoa>0){
        $qhs = '+'.$zhuangbei->capCuongHoa;
    }
    $xxzb6 = '<a href="?cmd='.$encode->encode("cmd=xxzb&zbwz=6&sid=$sid").'">Dỡ xuống</a>';
    $tool6 = '<a href="?cmd='.$encode->encode("cmd=chakanzb&zbnowid=$player->tool6&uid=$player->idNguoiDung&sid=$sid").'"><font color='.$zhuangbei->phamChat.'>'.$zhuangbei->tenTrangBi.'</font>'.$qhs.'</a>'.$xxzb6;

}




if ($player->tool7!=0){
    $zhuangbei = Helpers\layThongTinTrangBiTheoId($player->tool7, $dblj);
    $qhs = '';
    if ($zhuangbei->capCuongHoa>0){
        $qhs = '+'.$zhuangbei->capCuongHoa;
    }
    $xxzb7 = '<a href="?cmd='.$encode->encode("cmd=xxzb&zbwz=7&sid=$sid").'">Dỡ xuống</a>';
    $tool7 = '<a href="?cmd='.$encode->encode("cmd=chakanzb&zbnowid=$player->tool7&uid=$player->idNguoiDung&sid=$sid").'"><font color='.$zhuangbei->phamChat.'>'.$zhuangbei->tenTrangBi.'</font>'.$qhs.'</a>'.$xxzb7;
}


if (isset($tswb)){
    switch ($tswb){
        case "xy":
            if ($player->ulv>0){ 
$wenben = <<<HTML
             <link rel="stylesheet" type="text/css" href="./chajian/tishikuang/style/dialog.css">
		     <script src="./chajian/tishikuang/javascript/zepto.min.js"></script>
             <script type="text/javascript" src="./chajian/tishikuang/javascript/dialog.min.js"></script>
<body>
<font id="tip"></font>
<script type="text/javascript">
	setTimeout(function() {
		// IE
		if(document.all) {
			document.getElementById("tip").click();
		}
		// Cái khác trình duyệt
		else {
			var e = document.createEvent("MouseEvents");
			e.initEvent("click", true, true);
			document.getElementById("tip").dispatchEvent(e);
		}
	}, 500);
</script>
<script src="./chajian/tishikuang/javascript/zepto.min.js"></script>
<script type="text/javascript" src="./chajian/tishikuang/javascript/dialog.min.js"></script>
<script type="text/javascript">	   
$('#success').click(function(){
   popup({type:'success',msg:"Thành công",delay:2000,callBack:function(){
	  console.log('callBack~~~');
   }});
})
$('#error').click(function(){
   popup({type:'error',msg:"Thao tác thất bại",delay:2000,bg:true,clickDomCancel:true});
})
$('#tip').click(function(){
   popup({type:'tip',msg:"<font color='#ff0000'>Chiến sĩ：【Công, bạo】<br>Hiệp sĩ：【Phòng, hút】<br>Ẩn sĩ：【Máu, vận】</font>",delay:100000,bg:true,clickDomCancel:true});
})
</script>
</body>
HTML;
}}}


$tssb = <<<HTML
<link rel="stylesheet" type="text/css" href="./chajian/tishikuang/style/dialog.css">
		    <script src="./chajian/tishikuang/javascript/zepto.min.js"></script>
             <script type="text/javascript" src="./chajian/tishikuang/javascript/dialog.min.js"></script>
<body>
    <font id="error"></font>
<script type="text/javascript">
	setTimeout(function() {
		// IE
		if(document.all) {
			document.getElementById("error").click();
		}
		// Cái khác trình duyệt
		else {
			var e = document.createEvent("MouseEvents");
			e.initEvent("click", true, true);
			document.getElementById("error").dispatchEvent(e);
		}
	}, 500);
</script>
<script src="./chajian/tishikuang/javascript/zepto.min.js"></script>
<script type="text/javascript" src="./chajian/tishikuang/javascript/dialog.min.js"></script>
<script type="text/javascript">	   
$('#error').click(function(){
   popup({type:'error',msg:"Cấp bậc chưa đủ",delay:2000,bg:true,clickDomCancel:true});
})
</script>
</body>
HTML;
if (isset($jzjr)){
    switch ($jzjr){
        case "xy":
            if ($player->ulv<30){
			  $ts =  "Đẳng cấp nhỏ hơn 30, dễ dàng tẩu hỏa nhập ma！Không cách nào tu luyện$tssb <hr>";
                break;}
			 else{
				echo "<hr>Tu vi tạm chưa đạt tới nên cảnh giới！<hr>";
			 break;}
	}
}
if($player->ulv>=30){
	$tianfu =  $encode->encode("cmd=tianfu&sid=$sid");
}
else{
	$tianfu =  $encode->encode("cmd=zhuangtai&jzjr=xy&sid=$sid");	
}
$player = Helpers\layThongTinNguoiChoi($sid, $dblj);
$shenfen = array('Chiến sĩ','Chiến sĩ', 'Hiệp sĩ', 'Ẩn sĩ');
$sf = $shenfen[$player->thanPhan];
//$tianfu =  $encode->encode("cmd=tianfu&sid=$sid");
$ztcmd = $encode->encode("cmd=zhuangtai&sid=$sid");
$cwinfo = $encode->encode("cmd=chongwu&cwid=$player->cw&canshu=cwinfo&sid=$sid");
$cwid = $cw['cwid'];
$gm =  $encode->encode("cmd=czbgm&canshu2=gaiming2&sid=$sid");
$xiuliancmd = $encode->encode("cmd=goxiulian&sid=$sid");
$wbts =  $encode->encode("cmd=zhuangtai&tswb=xy&sid=$sid");
$sz =  $encode->encode("cmd=taozhuang&sid=$sid");
$html = <<<HTML

<div class="menu"><a href="?cmd=$ztcmd">Nhân vật</a><a href="?cmd=$cwinfo"><font color="#9c27b0">Sủng vật</font></a><a href="?cmd=$sz">Thần trang</a><a href="?cmd=$gm">Đổi tên</a></div><br/>
<IMG width="50" height="50" src="./images/$player->gioiTinh.png"><BR>
Biệt danh:$player->tenNhanVat<br/>
Thân phận:$sf <a href="?cmd=$wbts" style="border-radius: 15px;margin-top: 0px;">!</a>$wenben<br>
Cảnh giới:$player->canhGioi $player->tangCanhGioi<br/>
Đẳng cấp:$player->capDo<br/>
<span style="display: flex;">VIP:<IMG width="30" height="25" src="./images/vi$player->vip.png"></span>
Ma thạch:<font color="#ff0000" size="3.5">$player->tienNap</font><br/>
Linh thạch:$player->tienTroChoi<br/>

Tu vi:$player->kinhNghiem/$player->kinhNghiemToiDa<br/>
Khí huyết:$player->sinhMenh/$player->sinhMenhToiDa<br/>
Công kích:$player->congKich<br>
<!--Sáo trang tăng thêm:{$gj}00%<br/>-->
Phòng ngự:$player->phongNgu<br/>
Bạo kích:$player->baoKich<br/>
Hút máu:$player->hutMau<br/>
Thiên phú:$player->tf<br>
May mắn:$player->thienPhuMayMan<br>
Né tránh:$player->thienPhuNeTranh<br>
<hr>

<IMG width="25" height="15" src="./images/wq.png">Vũ khí:<FONT color="#ff7888" size="3.5&sid">$tool1</FONT><br/>
<IMG width="25" height="15" src="./images/fj.png">Đồ phòng ngự:$tool2<br/>
<IMG width="25" height="15" src="./images/ss.png">Đồ trang sức:$tool3<br/>
<IMG width="25" height="15" src="./images/sj.png">Thư tịch:$tool4<br/>
<IMG width="25" height="15" src="./images/zq.png">Tọa kỵ:$tool5<br/>
<IMG width="25" height="15" src="./images/lp.png">Lệnh bài:$tool6<br/>
<IMG width="25" height="15" src="./images/aq.png">Ám khí:$tool7<br/>
<hr>

<!--<font color="#ff7888" size="3.5">Cao cấp dấu hiệu</font>--!>
$ts
<div class="menu">
    <a href="?cmd=$getbagzbcmd">Ba lô trang bị</a>
    <a href="?cmd=$tianfu">Thiên phú huấn luyện</a>
    <a href="?cmd=$xiuliancmd">Treo máy tu luyện</a>
</div>
<br/><hr/>
<a href="#" onClick="javascript:history.back(-1);" >Trở lại</a><!--Cư trái-float:left;-->
            <a href="game.php?cmd=$gonowmid" style="float:right;" >Trở về trò chơi</a>
HTML;
echo $html;
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 221 /6/10
 * Time: 17:34
 */?>