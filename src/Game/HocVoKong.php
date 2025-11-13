<?php
require_once __DIR__ . '/../Helpers/NguoiChoiHelper.php';
require_once __DIR__ . '/../Helpers/TrangBiHelper.php';
require_once __DIR__ . '/../Helpers/DaoCuHelper.php';
require_once __DIR__ . '/../Helpers/DuocPhamHelper.php';
require_once __DIR__ . '/../Helpers/SungVatHelper.php';
require_once __DIR__ . '/../Helpers/NhiemVuHelper.php';
use TuTaTuTien\Helpers as Helpers;


$player = \Helpers\layThongTinNguoiChoi($sid,$dblj);

$gonowmid = $encode->encode("cmd=goto_map&newmid=$player->idBanDoHienTai&sid=$sid");
$cwhtml='';
$cwnamehtml= '';
$chouqucmd = $encode->encode("cmd=learn_martial_arts&canshu=chouqu&sid=$sid");
//Nơi này nghĩ dựng cái thành công nhắc nhở khung
$tskcg = <<<HTML
<html> 
<body>
    <font id="success"></font>
	
    <!--<input type="button" id="error" value="Sai lầm" />
    <input type="button" id="load" value="Now loading" />
    <input type="button" id="tip" value="Nhắc nhở" />-->

<script type="text/javascript">
//Nhiều ít giây mô phỏng điểm kích, tự động chấp hành điểm kích input, cũng chính là ID
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
   popup({type:'success',msg:"Thành công",delay:2000,callBack:function(){
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
</html>
HTML;


$tsksb = <<<HTML
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
   popup({type:'error',msg:"Thất bại!",delay:2000,bg:true,clickDomCancel:true});
})
</script>
</body>
HTML;


if (isset($canshu)){
    switch ($canshu) {
        case 'chouqu':
		
            if (Helpers\thayDoiMaThach(2, 200, $sid, $dblj)) {
				$cqsjs = mt_rand(1,3);
				$vip = $player->vip;
				if($vip>0){
					$cqsjs = mt_rand(1,10);
				}
                Helpers\xoaVoCong($cqsjs,$sid,$dblj);
				$tscg .= "".$tskcg."";
            } else {
                $tiss .= "<font style='color: #f70404;box-shadow: inset 2px -8px 16px 31px black;'>Xin liên lạc GM Tiến hành thể nghiệm</font><br>";
				$tssb .= "".$tsksb."";	
            }
            break;
        case 'xuexi':
            Helpers\thayDoiThuocTinhNguoiChoi('wugong',$wgid,$sid,$dblj);
            $player = \Helpers\layThongTinNguoiChoi($sid,$dblj);
            break;
        case 'biguan':
            Helpers\thayDoiThuocTinhNguoiChoi('wugong',0,$sid,$dblj);
            $player = \Helpers\layThongTinNguoiChoi($sid,$dblj);
            break;
        case 'fangsheng':
            Helpers\xoaVoCong($wgid,$sid,$dblj);
            break;
        case 'cwinfo':
            $cx = Helpers\layThongTinVoCong($wgid,$sid,$dblj);
			
            $cwinfo = $encode->encode("cmd=learn_martial_arts&wgid=$player->wugong&canshu=cwinfo&sid=$sid");
			$wgxx = $encode->encode("cmd=learn_martial_arts&sid=$sid");
			$xiuliancmd = $encode->encode("cmd=goto_cultivation&sid=$sid");
            $wgxl = $encode->encode("cmd=martial_training&sid=$sid");
            
$cwhtml = <<<HTML
			<IMG width='280' height='140' src='./images/wugong/$wgid.png' style="border-radius: 8px;">
            <a href="?cmd=$xiuliancmd" >Ngồi thiền tu luyện</a><a href="?cmd=$wgxl" >Võ công tu hành</a><a href="?cmd=$wgxx" >Bí tịch</a><hr>
			
            Võ công tên:[$cx->wgname]<br/>
            Võ công đẳng cấp:$cx->wgdj<br/>
            Võ công phẩm chất:$cx->wgys<br/>
            Võ công kinh nghiệm:$cx->wgxl / $cx->wgxlmax<br/>
            
            <hr>
			Võ công giới thiệu:($cx->wginfo)
            <hr>
            <a href="#" onClick="javascript:history.back(-1);" style="background-color: #cff3d2;">Trở lại</a>
            <a href="game.php?cmd=$gonowmid" style="float:right;background-color:#cff3d2;color: #755d5d;" >Trở về trò chơi</a>
HTML;
            echo $cwhtml;
            exit();
            break;
    }
}

$allcw = Helpers\suLucVoCong($sid,$dblj);
if ($allcw){
    foreach ($allcw as $cw){
        $wgid = $cw['wgid'];
        $czcmd='';
        if ($wgid!=$player->wugong){
            $czcmd = $encode->encode("cmd=learn_martial_arts&canshu=xuexi&wgid=$wgid&sid=$sid");
            $fscmd = $encode->encode("cmd=learn_martial_arts&canshu=fangsheng&wgid=$wgid&sid=$sid");
            $czcmd = '<a href="?cmd='.$czcmd.'">Học tập</a>';
            $fscmd = '<a href="?cmd='.$fscmd.'">Vứt bỏ</a>';
            $gncmd = $czcmd.$fscmd;
        }else{
            $shcmd = $encode->encode("cmd=learn_martial_arts&canshu=biguan&wgid=$wgid&sid=$sid");
            $shcmd = '<a href="?cmd='.$shcmd.'">Bế quan</a>';
            $gncmd = '<a style="background-color: #27a2c7;color: #ffffff;border-radius:10px;">(Học tập bên trong)</a>'.$shcmd;
        }
		
        $wginfo = $encode->encode("cmd=learn_martial_arts&canshu=cwinfo&wgid=$wgid&sid=$sid");
        $cwnamehtml.="$cwpinzhi".'<a style="color: '.$cw['wgys'].';" href="?cmd='.$wginfo.'"><font color='.$cwsc.'>'.$cw['wgname'].'</font></a>x'.$cw['wgsum'].''.$gncmd.'<br/>';
        
    }
}else{
    $cwnamehtml= 'Ngươi trước mắt không có bí tịch võ công, trước mắt phiên bản bí tịch nội trắc。Như cần thể nghiệm, xin liên lạc GM。';
}
$wgid = $player->wugong ;
if($wgid==''){
	$wgid = 0 ;
}
$xiuliancmd = $encode->encode("cmd=goto_cultivation&sid=$sid");
$wgxl = $encode->encode("cmd=martial_training&sid=$sid");
$wgxx = $encode->encode("cmd=learn_martial_arts&sid=$sid");

$tupian = <<<html
<IMG width='280' height='140' src='./images/wugong/$wgid.png' style="border-radius: 8px;">
html;

$cwhtml = <<<HTML
$tupian
<a href="?cmd=$xiuliancmd" >Ngồi thiền tu luyện</a><a href="?cmd=$wgxl" >Võ công tu hành</a><a href="?cmd=$wgxx" >Bí tịch</a><hr>
$cwnamehtml
$tssb
$tscg
<br/>
<div align="center">
$tiss
<a id="load" href="?cmd=$chouqucmd"style="color: red">Tân thủ bí tịch</a>
</div>
<br/>
<a href="#" onClick="javascript:history.back(-1);" style="background-color: #cff3df78;">Trở lại</a>
<a href="game.php?cmd=$gonowmid" style="float:right;background-color:#cff3df78;" >Trở về trò chơi</a>

            <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=1.0" />
            <link rel="stylesheet" type="text/css" href="./chajian/tishikuang/style/dialog.css">
		    <script src="./chajian/tishikuang/javascript/zepto.min.js"></script>
             <script type="text/javascript" src="./chajian/tishikuang/javascript/dialog.min.js"></script>
             <script type="text/javascript">
               $('#load').click(function(){
               popup({type:'load',msg:"Xin chờ đợi",delay:1500,callBack:function(){
           	  popup({type:"success",msg:"Tăng thêm thành công",delay:1000});
                 }});
                  })
            </script>
HTML;
echo $cwhtml;