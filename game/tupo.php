<?php
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
 
 
 

$player = \player\getplayer($sid,$dblj);
$tupocmd = $encode->encode("cmd=tupo&canshu=tupo&sid=$sid");
$gonowmid = $encode->encode("cmd=gomid&newmid=$player->nowmid&sid=$sid");
$tupo = \player\istupo($sid,$dblj);


$tplshtml="";
$tpls = $tpls = $player->ulv * $player->ulv * $player->ulv * 0.6;

if ($tupo == 1 ){
    $tpls = $player->ulv * $player->ulv * $player->ulv * 0.2;
}
if ($tupo == 3 ){
    $tpls = $player->ulv * $player->ulv * $player->ulv * 0.2;
}
elseif($tupo == 2){
    $tpls = $player->ulv * ($player->ulv+1) * 0.2;
}//Đột phá giai thừa cải thành 8 Cái giai thừa

if ($tupo != 8 ){
    $tplshtml =  "Đột phá cần linh thạch：$tpls/$player->uyxb<br><a href='?cmd=$tupocmd'>Điểm kích đột phá</a> <br/>";
    // $upgj = 100;
    // $upfy = 100;
    // $uphp = 100;
                        $uphp = 4+ round($player->ulv/1.2);
                        $upgj = 2+ round($player->ulv/2.5);
                        $upfy = 3+ round($player->ulv/2);
	if($player->uexp >= $player->umaxexp){
    if (isset($canshu)){
        switch ($canshu){
            case"tupo":
                $ret = \player\changeyxb(2,$tpls,$sid,$dblj);
                if ($ret){
                    $sjs = mt_rand(1,10);
                    if ($sjs <= 7){
                        echo "Đại hắc kiểm$player->uname ，Đột phá thất bại<br/>";
						$ts .= "".$tssb."";
                        break;
                    }
                    if ($tupo == 2){
                        $uphp = 2+ round($player->uhp/20);
                        $upgj = 1+ round($player->ugj/100);
                        $upfy = 1+ round($player->ufy/100);
                    }if ($sjs <= 6){
                        echo "Kỳ tích giáng lâm$player->uname <br/>Linh quang nổi lên, phong quyển tàn vân, sấm sét vang dội<br/>Lão thiên chiếu cố nhận được  thuộc tính：<br/>Công kích+999<br/>Phòng ngự+999<br/>Khí huyết+999<br/>
						<font color=#A2520B>Sữa</font><font color=#A1420D>Mẹ</font>：Tỉnh, chớ ngủ, quang quác Ô Lạp làm gì đâu！！<br/>";
                        break;
                    }
                    if ($tupo == 3){
                        $uphp = 4+ round($player->ulv/1.2);
                        $upgj = 2+ round($player->ulv/2.5);
                        $upfy = 3+ round($player->ulv/2);
                    }
					// if ($sjs <= 7){
                        // echo "Kỳ tích giáng lâm$player->uname <br/>Đáng tiếc không thành công！！<br/>";
                        // break;
                    // }
					
					elseif ($tupo == 1){
                        if ($sjs<8){
                            echo "Thiên Lôi đánh xuống, thành công trúng đích【$player->uname 】Mặt càng đen hơn！<br/>";
                            break;
                        }
                        $uphp = 4+ round($player->ulv/1.2);
                        $upgj = 2+ round($player->ulv/2.5);
                        $upfy = 3+ round($player->ulv/2);
                    }
                    \player\upplayerlv($sid,$dblj);
                    \player\addplayersx("umaxhp",$uphp,$sid,$dblj);
                    \player\addplayersx("ugj",$upgj,$sid,$dblj);
                    \player\addplayersx("ufy",$upfy,$sid,$dblj);
					\player\addplayersx("tf",5,$sid,$dblj);//Thiên phú tăng thêm 5
					
                    $player = \player\getplayer($sid,$dblj);
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
                    echo "<font color='#FF0000'>【Nghĩ P Ăn đâu, tu vi không đủ】</font><br/>==Đột phá cần tu vi：$player->umaxexp==<br/>";
					$ts .= "".$tssb1."";
                }
}
$zhanbi = round($player->uexp / $player->umaxexp *100) ;//Thanh tiến độ biểu hiện chiếm so
if ($zhanbi > 100){
        $zhanbi = 100;
	 }
$tupohtml = <<<HTML
======Đột phá======<br/>
$ts
<link rel="stylesheet"  href="./css/css.css">
Trước mắt đẳng cấp：$player->ulv<br/>
Trước mắt cảnh giới：$player->jingjie $player->cengci<br/>
Trước mắt tu vi：$player->uexp/$player->umaxexp<br/>
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

