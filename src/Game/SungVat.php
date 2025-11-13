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
$chouqucmd = $encode->encode("cmd=pet&canshu=chouqu&sid=$sid");
$queren = $encode->encode("cmd=pet&canshu=queren&sid=$sid");

//Nơi này nghĩ dựng cái thành công nhắc nhở khung
$tskcg = <<<HTML
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
   popup({type:'error',msg:"Bạch chơi thất bại!",delay:2000,bg:true,clickDomCancel:true});
})
</script>
</body>
HTML;
//Chưa sửa chữa hoàn thành
$cwcmd = $encode->encode("cmd=pet&sid=$sid");
$qr1 =<<<html
<div align="center">
<a id="load" href="?cmd=$chouqucmd"style="color: #fd0000;">Xác nhận rút ra</a>
<a id="load" href="?cmd=$cwcmd">Hủy bỏ rút ra</a><br>
<br>
</div>
html;

if (isset($canshu)){
    switch ($canshu) {
		case 'queren':
		$qr = "$qr1";
		 break;
		
        case 'chouqu':
            if (Helpers\thayDoiMaThach(2, 50, $sid, $dblj)) {
                Helpers\themSungVat($sid, $dblj);
				$tscg .= "".$tskcg."";
            } else {
              //  echo "Ma thạch không đủ 50<br/>";
				$tssb .= "".$tsksb."";
            }
            break;
        case 'chuzhan':
            Helpers\thayDoiThuocTinhNguoiChoi('cw',$cwid,$sid,$dblj);
            $player = \Helpers\layThongTinNguoiChoi($sid,$dblj);
            break;
        case 'shouhui':
            Helpers\thayDoiThuocTinhNguoiChoi('cw',0,$sid,$dblj);
            $player = \Helpers\layThongTinNguoiChoi($sid,$dblj);
            break;
        case 'fangsheng':
            Helpers\xoaSungVat($cwid,$sid,$dblj);
            break;
        case 'cwinfo':
            $chongwu = Helpers\layThongTinSungVat($cwid, $dblj);
            $pzarr = array('<font color=#00C000>Phổ thông</font>', '<font color=#1a80da>Ưu tú</font>', '<font color=#a08f0a>Trác tuyệt</font>', '<font color=#14b8b9>Phi phàm</font>', '<font color=#f16613>Hoàn mỹ</font>', '<font color=#ec0909>Nghịch thiên</font>');
            $cwpz = $pzarr[$chongwu->cwpz];
            $chongwu->cwpz = $chongwu->cwpz * 10;
			$ztcmd = $encode->encode("cmd=character_status&sid=$sid");
            $cwinfo = $encode->encode("cmd=pet&cwid=$player->cw&canshu=cwinfo&sid=$sid");
            $cwid = $cw['cwid'];
            $gm =  $encode->encode("cmd=recharge_gm&canshu2=gaiming2&sid=$sid");
			$sz =  $encode->encode("cmd=equipment_set&sid=$sid");
            $cwhtml = <<<HTML
			<div class="menu">
            <a href="?cmd=$ztcmd">Nhân vật</a><a href="?cmd=$cwinfo"><font color="#9c27b0">Sủng vật</font></a><a href="?cmd=$sz">Thần trang</a><a href="?cmd=$gm">Đổi tên</a></div><br/>
            Danh tự:[$chongwu->cwname]<br/>
            Đẳng cấp:$chongwu->cwlv<br/>
            Phẩm chất:$cwpz<br/>
            Kinh nghiệm:$chongwu->cwexp/$chongwu->cwmaxexp<br/>
            Khí huyết:($chongwu->cwhp/$chongwu->cwmaxhp)<br/>
            Công kích:$chongwu->cwgj<br/>
            Phòng ngự:$chongwu->cwfy<br/>
            Bạo kích:$chongwu->cwbj<br/>
            Hút máu:$chongwu->cwxx<br/>
            <hr>
            Khí huyết trưởng thành:$chongwu->uphp<br/>
            Công kích trưởng thành:$chongwu->upgj<br/>
            Phòng ngự trưởng thành:$chongwu->upfy<br/>
            Phẩm chất[$cwpz]Tại thăng cấp lúc tăng thêm$chongwu->cwpz%<br/>
            <hr>
            <a href="#" onClick="javascript:history.back(-1);" style="background-color: #cff3d2;">Trở lại</a>
            <a href="game.php?cmd=$gonowmid" style="float:right;background-color:#cff3d2;color: #755d5d;" >Trở về trò chơi</a>
HTML;
            echo $cwhtml;
            exit();
            break;
    }
}

$allcw = Helpers\layTatCaSungVat($sid,$dblj);
if ($allcw){
    foreach ($allcw as $cw){
        $cwid = $cw['cwid'];
        $czcmd='';
        if ($cwid!=$player->cw){
            $czcmd = $encode->encode("cmd=pet&canshu=chuzhan&cwid=$cwid&sid=$sid");
            $fscmd = $encode->encode("cmd=pet&canshu=fangsheng&cwid=$cwid&sid=$sid");
            $czcmd = '<a href="?cmd='.$czcmd.'">Xuất chiến</a>';
            $fscmd = '<a href="?cmd='.$fscmd.'">Phóng sinh</a>';
            $gncmd = $czcmd.$fscmd;
        }else{
            $shcmd = $encode->encode("cmd=pet&canshu=shouhui&cwid=$cwid&sid=$sid");
            $shcmd = '<a href="?cmd='.$shcmd.'">Thu hồi</a>';
            $gncmd = '<a style="background-color: #ef0a0a;color: #ecf3ea;border-radius:10px;">(Đã xuất chiến)</a>'.$shcmd;
        }
        $cwinfo = $encode->encode("cmd=pet&cwid=$cwid&canshu=cwinfo&sid=$sid");
		$chongwu = Helpers\layThongTinSungVat($cwid, $dblj);
        $sc = array('#00C000', '#1a80da', '#a08f0a', '#14b8b9', '#f16613', '#ec0909');
		$pz = array('Phổ thông', 'Ưu tú', 'Trác tuyệt', 'Phi phàm', 'Hoàn mỹ', 'Nghịch thiên');
        $cwsc = $sc[$chongwu->cwpz];//Sủng vật sắc thái
		$cwpinzhi = $pz[$chongwu->cwpz];//Sủng vật phẩm chất
        $cwnamehtml.="[$cwpinzhi]".'<a href="?cmd='.$cwinfo.'"><font color='.$cwsc.'>'.$cw['cwname'].'</font></a>'.$gncmd.'<br/>';
        
    }
}else{
    $cwnamehtml= 'Ngươi trước mắt không có sủng vật';
}

$cwhtml = <<<HTML
<IMG width='280' height='140' src='./images/cw.png'src="./images/rw.png" style="border-radius: 8px;">
$cwnamehtml
$tssb
$tscg
<br/><div align="center">
$qr
<a id="load" href="?cmd=$queren"style="color: #18a558;">Rút ra sủng vật[Ma thạch 50]</a></div>
<br/>
<a href="#" onClick="javascript:history.back(-1);" style="">Trở lại</a>
<a href="game.php?cmd=$gonowmid" style="float:right;" >Trở về trò chơi</a>

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