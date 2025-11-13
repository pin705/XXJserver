<?php
require_once __DIR__ . '/../src/Helpers/NguoiChoiHelper.php';
require_once __DIR__ . '/../src/Helpers/TrangBiHelper.php';
require_once __DIR__ . '/../src/Helpers/DaoCuHelper.php';
require_once __DIR__ . '/../src/Helpers/DuocPhamHelper.php';
require_once __DIR__ . '/../src/Helpers/ClubHelper.php';
use TuTaTuTien\Helpers as Helpers;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2021 /8/22
 * Time: 22:30
 */
//Nơi này nghĩ dựng cái thành công nhắc nhở khung
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
   popup({type:'success',msg:"Đột phá thành công",delay:2000,callBack:function(){
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


$tssb1 = <<<HTML
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
   popup({type:'error',msg:"Tu vi không đủ",delay:2000,bg:true,clickDomCancel:true});
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
   popup({type:'error',msg:"Mặt đen..",delay:2000,bg:true,clickDomCancel:true});
})
</script>
</body>
HTML;
 
 
 

$nguoiChoi = \Helpers\layThongTinNguoiChoi($sid,$dblj);
$tupocmd = $encode->encode("cmd=tupo&canshu=tupo&sid=$sid");
$gonowmid = $encode->encode("cmd=gomid&newmid=$nguoiChoi->idBanDoHienTai&sid=$sid");
$tupo = Helpers\kiemTraDieuKienTuPha($sid,$dblj);


$tplshtml="";
$tpls = $tpls = $nguoiChoi->capDo * $nguoiChoi->capDo * $nguoiChoi->capDo * 0.6;

if ($tupo == 1 ){
    $tpls = $nguoiChoi->capDo * $nguoiChoi->capDo * $nguoiChoi->capDo * 0.2;
}
if ($tupo == 3 ){
    $tpls = $nguoiChoi->capDo * $nguoiChoi->capDo * $nguoiChoi->capDo * 0.2;
}
elseif($tupo == 2){
    $tpls = $nguoiChoi->capDo * ($nguoiChoi->capDo+1) * 0.2;
}//Đột phá giai thừa cải thành 8 Cái giai thừa

if ($tupo != 8 ){
    $tplshtml =  "Đột phá cần linh thạch：$tpls/$nguoiChoi->tienTroChoi<br><a href='?cmd=$tupocmd'>Điểm kích đột phá</a> <br/>";
    // $upgj = 100;
    // $upfy = 100;
    // $uphp = 100;
                        $uphp = 4+ round($nguoiChoi->capDo/1.2);
                        $upgj = 2+ round($nguoiChoi->capDo/2.5);
                        $upfy = 3+ round($nguoiChoi->capDo/2);
	if($nguoiChoi->kinhNghiem >= $nguoiChoi->kinhNghiemToiDa){
    if (isset($canshu)){
        switch ($canshu){
            case"tupo":
                $ret = Helpers\thayDoiTienTroChoi(2,$tpls,$sid,$dblj);
                if ($ret){
                    $sjs = mt_rand(1,10);
                    if ($sjs <= 7){
                        echo "Đại hắc kiểm$nguoiChoi->tenNhanVat ，Đột phá thất bại<br/>";
						$ts .= "".$tssb."";
                        break;
                    }
                    if ($tupo == 2){
                        $uphp = 2+ round($nguoiChoi->sinhMenh/20);
                        $upgj = 1+ round($nguoiChoi->congKich/100);
                        $upfy = 1+ round($nguoiChoi->phongNgu/100);
                    }if ($sjs <= 6){
                        echo "Kỳ tích giáng lâm$nguoiChoi->tenNhanVat <br/>Linh quang nổi lên, phong quyển tàn vân, sấm sét vang dội<br/>Lão thiên chiếu cố nhận được  thuộc tính：<br/>Công kích+999<br/>Phòng ngự+999<br/>Khí huyết+999<br/>
						<font color=#A2520B>Sữa</font><font color=#A1420D>Mẹ</font>：Tỉnh, chớ ngủ, quang quác Ô Lạp làm gì đâu！！<br/>";
                        break;
                    }
                    if ($tupo == 3){
                        $uphp = 4+ round($nguoiChoi->capDo/1.2);
                        $upgj = 2+ round($nguoiChoi->capDo/2.5);
                        $upfy = 3+ round($nguoiChoi->capDo/2);
                    }
					// if ($sjs <= 7){
                        // echo "Kỳ tích giáng lâm$nguoiChoi->tenNhanVat <br/>Đáng tiếc không thành công！！<br/>";
                        // break;
                    // }
					
					elseif ($tupo == 1){
                        if ($sjs<8){
                            echo "Thiên Lôi đánh xuống, thành công trúng đích【$nguoiChoi->tenNhanVat 】Mặt càng đen hơn！<br/>";
                            break;
                        }
                        $uphp = 4+ round($nguoiChoi->capDo/1.2);
                        $upgj = 2+ round($nguoiChoi->capDo/2.5);
                        $upfy = 3+ round($nguoiChoi->capDo/2);
                    }
                    Helpers\nangCapChoNguoiChoi($sid,$dblj);
                    Helpers\themThuocTinhNguoiChoi("umaxhp",$uphp,$sid,$dblj);
                    Helpers\themThuocTinhNguoiChoi("ugj",$upgj,$sid,$dblj);
                    Helpers\themThuocTinhNguoiChoi("ufy",$upfy,$sid,$dblj);
					Helpers\themThuocTinhNguoiChoi("tf",5,$sid,$dblj);//Thiên phú tăng thêm 5
					
                    $nguoiChoi = \Helpers\layThongTinNguoiChoi($sid,$dblj);
                    echo "Linh quang nổi lên, phong quyển tàn vân, sấm sét vang dội。<br/>Đột phá thành công nhận được  thuộc tính：<br/>Công kích+$upgj<br/>Phòng ngự+$upfy<br/>Khí huyết+$uphp<br/>";
					$ts .= "".$tscg."";
                }
				
				else{
                    echo "<font color='#FF0000'>Linh thạch không đủ, không cách nào đột phá</font><br/>Đột phá cần linh thạch：$tpls<br/>";
                }
                break;
        }
    }}
	else{
                    echo "<font color='#FF0000'>【Nghĩ P Ăn đâu, tu vi không đủ】</font><br/>==Đột phá cần tu vi：$nguoiChoi->kinhNghiemToiDa==<br/>";
					$ts .= "".$tssb1."";
                }
}
$zhanbi = round($nguoiChoi->kinhNghiem / $nguoiChoi->kinhNghiemToiDa *100) ;//Thanh tiến độ biểu hiện chiếm so
if ($zhanbi > 100){
        $zhanbi = 100;
	 }
$tupohtml = <<<HTML
======Đột phá======<br/>
$ts
<link rel="stylesheet"  href="./css/css.css">
Trước mắt đẳng cấp：$nguoiChoi->capDo<br/>
Trước mắt cảnh giới：$nguoiChoi->canhGioi $nguoiChoi->tangCanhGioi<br/>
Trước mắt tu vi：$nguoiChoi->kinhNghiem/$nguoiChoi->kinhNghiemToiDa<br/>
<div class = "dise" width="100" height="100%">
<img class = "skills"  width="$zhanbi%" height="100%"></img >
</div>  
$tplshtml
<br/>
		<a href="#" onClick="javascript:history.back(-1);">Trở lại</a>
        <a href="game.php?cmd=$gonowmid" style="float:right;" >Trở về trò chơi</a>
HTML;
echo $tupohtml;
?>

