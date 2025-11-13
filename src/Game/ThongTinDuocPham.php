<?php
require_once __DIR__ . '/../Helpers/NguoiChoiHelper.php';
require_once __DIR__ . '/../Helpers/TrangBiHelper.php';
require_once __DIR__ . '/../Helpers/DaoCuHelper.php';
require_once __DIR__ . '/../Helpers/DuocPhamHelper.php';
require_once __DIR__ . '/../Helpers/SungVatHelper.php';
require_once __DIR__ . '/../Helpers/NhiemVuHelper.php';
use TuTaTuTien\Helpers as Helpers;

//Nơi này nghĩ dựng cái thành công nhắc nhở khung
$tscg = <<<HTML
<html> 
<body>
<!--Nơi này ta tiến hành ẩn tàng, dùng cho phía dưới mô phỏng điểm kích-->
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


$tssb = <<<HTML
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




/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 20 2 1/12/12
 * Time: 15:57
 */
$ydhp = '';
$ydgj = '';
$ydfy = '';
$ydbj = '';
$ydxx = '';
$gonowmid = $encode->encode("cmd=gomid&newmid=$player->idBanDoHienTai&sid=$sid");
$yaodan = Helpers\layThongTinDuocDan($ydid,$dblj);
$playeryd = Helpers\layThongTinDuocDanCuaNguoiChoi($ydid,$sid,$dblj);
$setyd = '';
$tishi='';
if (isset($canshu)){
    switch ($canshu){
        case 'setyd1':
            Helpers\thayDoiThuocTinhNguoiChoi('yd1',$ydid,$sid,$dblj);
            $tishi = "Thiết trí dược phẩm 1 Thành công<br/>";
            break;
        case 'setyd2':
            Helpers\thayDoiThuocTinhNguoiChoi('yd2',$ydid,$sid,$dblj);
            $tishi = "Thiết trí dược phẩm 2 Thành công<br/>";
            break;
        case 'setyd3':
            Helpers\thayDoiThuocTinhNguoiChoi('yd3',$ydid,$sid,$dblj);
            $tishi = "Thiết trí dược phẩm 3 Thành công<br/>";
            break;
			
        case 'useyd':
		if ($playeryd->ydsum > 0){
		$sjs = mt_rand(0,10);
		if ($sjs > 2){
            
            if ($sjs > 3){
				$userydret = Helpers\suDungDuocDan($ydid,1,$sid,$dblj);
                $tishi = "Tăng lên thành công<br/>";
				$ts .= "".$tscg."";
            }else{
				$userydret = Helpers\giamDuocDan($sid,$ydid,1,$dblj);
                $tishi = "Tăng lên thất bại, vận khí không đủ<br/>";
				$ts .= "".$tssb."";
            }
		}else{
			 $userydret = Helpers\giamDuocDan($sid,$ydid,1,$dblj);
             $tishi = "Tẩu hỏa nhập ma, tăng lên thất bại<br/>";
			 $ts .= "".$tssb."";
            }break;
		}else{
			$tishi = "<hr>Đan dược không đủ！！！<hr>";
			 $ts .= "".$tssb."";
		}break;
			
		case 'daoli':
		if ($playeryd->ydsum > 0){
		$sjs = mt_rand(0,10);
		if ($sjs > 0){
            
            if ($sjs > 1){
				$userydret = Helpers\suDungDuocDan($ydid,1,$sid,$dblj);
                $tishi = "Là kẻ hung hãn, tăng lên thành công<br/>";
				$ts .= "".$tscg."";
            }else{
				$userydret = Helpers\giamDuocDan($sid,$ydid,1,$dblj);
                $tishi = "Lành lạnh, nếm thử những phương thức khác nhìn xem..<br/>";
				$ts .= "".$tssb."";
            }
		}else{
			 $userydret = Helpers\giamDuocDan($sid,$ydid,1,$dblj);
             $tishi = "Tẩu hỏa nhập ma, tăng lên thất bại<br/>";
			 $ts .= "".$tssb."";
            }break;
		}else{
			$tishi = "<hr>Làm sao lưu hành dựng ngược ăn không khí<hr>";
			 $ts .= "".$tssb."";
		}break;
		
    }
}
if ($playeryd){
    $setyd1 = $encode->encode("cmd=ydinfo&canshu=setyd1&ydid=$ydid&sid=$sid");
    $setyd2 = $encode->encode("cmd=ydinfo&canshu=setyd2&ydid=$ydid&sid=$sid");
    $setyd3 = $encode->encode("cmd=ydinfo&canshu=setyd3&ydid=$ydid&sid=$sid");
    $useyd = $encode->encode("cmd=ydinfo&canshu=useyd&ydid=$ydid&sid=$sid");
	$daoli = $encode->encode("cmd=ydinfo&canshu=daoli&ydid=$ydid&sid=$sid");
$tshtml = <<<html
	<a id="load" href="?cmd=$daoli"style="background-color:#7b156f;color: #ffffff;">Dựng ngược chậm nhai</a>
html;
	if($player->wugong==3){//Võ công sử dụng====Trên dưới điên đảo====
		$wgdaoli = "$tshtml";
	}
    $setyd = <<<HTML
    <br/>
    <!--<a href="?cmd=$setyd1">Trang bị dược phẩm 1.</a>
    <a href="?cmd=$setyd2">Trang bị dược phẩm 2.</a>
    <a href="?cmd=$setyd3">Trang bị dược phẩm 3.</a><br/>-->
	<a id="load" href="?cmd=$useyd"style="background-color: #f9c508;color: #ffffff;">Bên ngoài xóa</a>
    <a id="load" href="?cmd=$useyd"style="background-color: #f9c508;color: #f10b0b;">Nuốt</a><br>
	$wgdaoli
HTML;
}
if($yaodan->ydhp!=0){
    $ydhp = "Khí huyết+".$yaodan->ydhp."<br/>";
}
if ($yaodan->ydgj!=0){
    $ydgj = "Công kích+".$yaodan->ydgj."<br/>";
}
if ($yaodan->ydfy!=0){
    $ydfy = "Phòng ngự+".$yaodan->ydfy."<br/>";
}
if ($yaodan->ydbj!=0){
    $ydbj = "Bạo kích+".$yaodan->ydbj."<br/>";
}
if ($yaodan->ydxx!=0){
    $ydxx = "Hút máu+".$yaodan->ydxx."<br/>";
}
$ydsx = "<br/>".$ydhp.$ydgj.$ydfy.$ydbj.$ydxx;
$playeryd = Helpers\layThongTinDuocDanCuaNguoiChoi($ydid,$sid,$dblj);
$ydinfo = <<<HTML
<IMG width='280' height='140' src='./images/rw.png'src="./images/rw.png" style="border-radius: 8px;">
<div align="center">
$tishi======<br>
<font color='{$yaodan->ydys}'>[$yaodan->ydname]</font><br>Còn thừa：{$playeryd->ydsum}<br/>
======
$ydsx
$setyd
$ts
</div>
<br/><br>
<a href="#" onClick="javascript:history.back(-1);">Trở lại</a>
        <a href="game.php?cmd=$gonowmid" style="float:right;background-color:#cff3d2;color: #755d5d;" >Trở về trò chơi</a>
		
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
echo $ydinfo;