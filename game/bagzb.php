<?php
require_once __DIR__ . '/../src/Helpers/NguoiChoiHelper.php';
require_once __DIR__ . '/../src/Helpers/TrangBiHelper.php';
require_once __DIR__ . '/../src/Helpers/DaoCuHelper.php';
use TuTaTuTien\Helpers as Helpers;

$tscg = <<<HTML
             <link rel="stylesheet" type="text/css" href="./chajian/tishikuang/style/dialog.css">
		     <script src="./chajian/tishikuang/javascript/zepto.min.js"></script>
             <script type="text/javascript" src="./chajian/tishikuang/javascript/dialog.min.js"></script>
<body>
<font id="success"></font>
<script type="text/javascript">
	setTimeout(function() {
		// IE
		if(document.all) {
			document.getElementById("success").click();
		}
		// Cái khác trình duyệt
		else {
			var e = document.createEvent("MouseEvents");
			e.initEvent("click", true, true);
			document.getElementById("success").dispatchEvent(e);
		}
	}, 500);
</script>
<script src="./chajian/tishikuang/javascript/zepto.min.js"></script>
<script type="text/javascript" src="./chajian/tishikuang/javascript/dialog.min.js"></script>
<script type="text/javascript">	   
$('#success').click(function(){
   popup({type:'success',msg:"Phân giải thành công",delay:2000,callBack:function(){
	  console.log('callBack~~~');
   }});
})
$('#error').click(function(){
   popup({type:'error',msg:"Thao tác thất bại",delay:2000,bg:true,clickDomCancel:true});
})
$('#tip').click(function(){
   popup({type:'tip',msg:"Nhắc nhở tin tức",delay:3000,bg:true,clickDomCancel:true});
})
</script>
</body>

HTML;


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
   popup({type:'error',msg:"Thất bại",delay:2000,bg:true,clickDomCancel:true});
})
</script>
</body>
HTML;


$nguoiChoi = Helpers\layThongTinNguoiChoi($sid,$dblj);
$tishi = '';
if (isset($canshu)){
    if ($canshu=='maichu'){
        $mczb = Helpers\layThongTinTrangBiTheoId($zbnowid,$dblj);
        $sxzz = $mczb->congKich*50 + $mczb->sinhMenh*3 + $mczb->phongNgu*15 + $mczb->baoKich * 15 + $mczb->hutMau * 15 + $mczb->capCuongHoa*20;
        $mcls = round($sxzz);
        $sql = "delete from playerzhuangbei where zbnowid =$zbnowid AND sid='$sid'";//Xóa bỏ trang bị
        $mcret = $dblj->exec($sql);
        if ($mcret){
            $ret = Helpers\thayDoiTienTroChoi(1,$sxzz,$sid,$dblj);
            $tishi = "Bán [$mczb->tenTrangBi],nhận được  linh thạch:$mcls<hr>";
        }
    }
}
if (!isset($yeshu)){
    $yeshu = 0;
}
if ($cmd == 'delezb'){
    $zhuangbei = Helpers\layThongTinTrangBiTheoId($zbnowid,$dblj);
    $fjls = $zhuangbei->capCuongHoa * 20 + 20;
    $ret = Helpers\thayDoiTienTroChoi(2,$fjls,$sid,$dblj);
    if ($ret){
        $sql = "delete from playerzhuangbei where zbnowid =$zbnowid AND sid='$sid'";//Xóa bỏ trang bị
        $dblj->exec($sql);
        $qhs = round($zhuangbei->capCuongHoa*$zhuangbei->capCuongHoa+($zhuangbei->congKich+$zhuangbei->phongNgu)/2);//Tính toán cường hóa thạch phân giải nhận được  tình huống
        $sjs = mt_rand(1,100);
        if ($sjs <= 30){
            $sjs = mt_rand(1,100);
            if ($sjs>90){
                $qhs = $qhs + 3;
            }elseif($sjs>80){
                $qhs = $qhs + 2;
            }elseif ($sjs>70){
                $qhs = $qhs + 1;
            }
        }
        Helpers\themDaoCu($sid,1,$qhs,$dblj);
        //$tishi = 'Phân giải thành công!';
        if ($qhs >= 0){
            $tishi .= "Phân giải thành công!nhận được  cường hóa thạch:".$qhs."!<hr>";
			$ts .= "".$tscg."";
        }
    }else{
        $tishi = "Linh thạch không đủ!<br/>";
		$ts .= "".$tssb."";
    }
}

$sql = "select * from playerzhuangbei  WHERE sid = '$sid' ORDER BY zbid DESC LIMIT $yeshu,10";
$cxjg = $dblj->query($sql);
$retzb = $cxjg->fetchAll(PDO::FETCH_ASSOC);

$sql = "select count(*) from playerzhuangbei where sid = '$sid'";
$cxjg = $dblj->query($sql);
$zbcount = $cxjg->fetchColumn();

$gonowmid = $encode->encode("cmd=gomid&newmid=$nguoiChoi->idBanDoHienTai&sid=$sid");
$zbhtml = '';
$fanye='';
if ($yeshu!=0){
    $shangcanshu=$yeshu-10;
    $shangyiye = $encode->encode("cmd=getbagzb&yeshu=$shangcanshu&sid=$sid");
    $fanye = '<a href="?cmd='.$shangyiye.'">Trang trước</a>';
}
if ($yeshu +10 < $zbcount){
    $xiacanshu=$yeshu+10;
    $xiayiye = $encode->encode("cmd=getbagzb&yeshu=$xiacanshu&sid=$sid");
    $fanye .= '<a href="?cmd='.$xiayiye.'">Trang kế tiếp</a>';
}
if ($fanye!=''){
    $fanye = '<br/>'.$fanye.'<br/>';
}
$hangshu = 0;
for ($i=0;$i<count($retzb);$i++){
    $zbnowid = $retzb[$i]['zbnowid'];
    $arr = array($nguoiChoi->viTriTrangBi1,$nguoiChoi->viTriTrangBi2,$nguoiChoi->viTriTrangBi3,$nguoiChoi->viTriTrangBi4,$nguoiChoi->viTriTrangBi5,$nguoiChoi->viTriTrangBi6,$nguoiChoi->viTriTrangBi7);
    $hangshu = $hangshu + 1;

    $zbname = $retzb[$i]['zbname'];
    $zbnowid = $retzb[$i]['zbnowid'];
    $zbqh = $retzb[$i]['qianghua'];
    $qhhtml = '';
    if($zbqh>0){
        $qhhtml="+".$zbqh;
    }
    $chakanzb = $encode->encode("cmd=chakanzb&zbnowid=$zbnowid&uid=$nguoiChoi->idNguoiDung&sid=$sid");
    if (!in_array($zbnowid,$arr)){
        $mczb = $encode->encode("cmd=getbagzb&canshu=maichu&yeshu=$yeshu&zbnowid=$zbnowid&sid=$sid");
		$zhuangbei = Helpers\layThongTinTrangBiTheoId($zbnowid,$dblj);
        $delezb = $encode->encode("cmd=delezb&zbnowid=$zbnowid&sid=$sid");
        $zbhtml .= <<<HTML
        [$hangshu].<a href="?cmd=$chakanzb"><font color='{$zhuangbei->phamChat}'>$zbname</font>$qhhtml</a><a href="?cmd=$mczb">Bán </a><a href="?cmd=$delezb">Phân giải</a><br/>
HTML;
    }else{
		$zhuangbei = Helpers\layThongTinTrangBiTheoId($zbnowid,$dblj);
        $zbhtml .= <<<HTML
        [$hangshu].<a href="?cmd=$chakanzb"><font color='{$zhuangbei->phamChat}'>{$zbname}</font>$qhhtml</a>(Đã trang bị)<br/>
HTML;
    }
}
$getbagdjcmd = $encode->encode("cmd=getbagdj&sid=$sid");
$getbagypcmd = $encode->encode("cmd=getbagyp&sid=$sid");
$getbagjncmd = $encode->encode("cmd=getbagjn&sid=$sid");
$getbagydcmd = $encode->encode("cmd=getbagyd&sid=$sid");
$toolhtml =<<<HTML

<font size="2"><div class="menu"><a href="#" style="background-color: gray;">Trang bị</a><a href="?cmd=$getbagdjcmd">Đạo cụ</a><a href="?cmd=$getbagypcmd">Dược phẩm</a><a href="?cmd=$getbagjncmd">Kỹ năng</a>
<a href="?cmd=$getbagydcmd">Đan dược</a></div></font>
<div align="center">
<font style="color: #f90909;">
$tishi$ts
</font>
</div>
$zbhtml
$fanye
<br/>
<a href="#" onClick="javascript:history.back(-1);">Trở lại</a>
        <a href="game.php?cmd=$gonowmid" style="float:right;background-color:#cff3d2;color: #755d5d;" >Trở về trò chơi</a>
HTML;
echo $toolhtml;
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2021 /6/16
 * Time: 17:56
 */?>

