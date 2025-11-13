<?php
require_once __DIR__ . '/../src/Helpers/NguoiChoiHelper.php';
require_once __DIR__ . '/../src/Helpers/TrangBiHelper.php';
require_once __DIR__ . '/../src/Helpers/DaoCuHelper.php';
require_once __DIR__ . '/../src/Helpers/DuocPhamHelper.php';
require_once __DIR__ . '/../src/Helpers/ClubHelper.php';
use TuTaTuTien\Helpers as Helpers;

$player = Helpers\layThongTinNguoiChoi($sid,$dblj);//Thu hoạch ngươi ID
$gonowmid = $encode->encode("cmd=gomid&newmid=$player->idBanDoHienTai&sid=$sid");

$shangdian = $encode->encode("cmd=shangdian&canshu=gogoumai&sid=$sid");//  PHP ，Lựa chọn văn bản , tăng thêm dấu hiệu , thân phận của ngươi

$shangdian1 = $encode->encode("cmd=shangdian&canshu1=gogoumai1&sid=$sid");

$beibaocmd = $encode->encode("cmd=getbagyd&sid=$sid");
//$gmcmd = $encode->encode("cmd=npc&nid=$nid&canshu=gogoumai&sid=$sid");
//$ydlist = $encode->encode("cmd=npc&nid=$nid&canshu=ydlist&sid=$sid");


$gnhtml = <<<HTML
<br/>
<a href="?cmd=$shangdian"><font color="#ffc100">Linh thạch mua</font></a><br/>
<a href="?cmd=$shangdian1"><font color="#ffc100">Ma thạch mua</font></a>
<br/>
HTML;

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
   popup({type:'success',msg:"Mua thành công",delay:2000,callBack:function(){
	  console.log('callBack~~~');
   }});
})
$('#error').click(function(){
   popup({type:'error',msg:"Thao tác thất bại",delay:2000,bg:true,clickDomCancel:true});
})
$('#load').click(function(){
   popup({type:'load',msg:"Xin chờ đợi",delay:1500,callBack:function(){
	  popup({type:"success",msg:"Tăng thêm thành công",delay:1000});
   }});
})
$('#tip').click(function(){
   popup({type:'tip',msg:"Nhắc nhở tin tức",delay:null,bg:true,clickDomCancel:true});
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
   popup({type:'error',msg:"Mua thất bại",delay:2000,bg:true,clickDomCancel:true});
})
</script>
</body>
HTML;


//Nơi này làm cái xác nhận khung
$qrhtml = <<<HTML

<head>
<script>
if(confirm("Xác nhận"))
alert("……");
else alert("Hủy bỏ");
</script>
</head>
<body>
Cưỡng ép mua thành công~
</body>

HTML;



if (isset($canshu)){
    switch ($canshu){
        case 'gogoumai':
            $gnhtml='';
            if (isset($ydcount) && isset($ydid)){
                $yaodan = Helpers\layThongTinDuocDan($ydid,$dblj);
                $ydjg = $yaodan->ydjg;
                $ydname = $yaodan->ydname;
                $ret = Helpers\thayDoiTienTroChoi(2,$ydjg*$ydcount,$sid,$dblj);
                if ($ret){
                    Helpers\themDuocDan($sid,$ydid,$ydcount,$dblj);
				$gnhtml .= "".$tskcg."";
                }else{
                    $gnhtml .= "".$tsksb."<br/>";
                }
            }
            $yaodan = Helpers\layTatCaDuocDan($dblj);
            foreach ($yaodan as $oneyaodan){
                $ydname = $oneyaodan['ydname'];
                $ydid = $oneyaodan['ydid'];
                $ydjg = $oneyaodan['ydjg'];
				$ydys = $oneyaodan['ydys'];
                $ydcmd = $encode->encode("cmd=ydinfo&ydid=$ydid&sid=$sid");//cmd=php Văn kiện& Văn kiện bên trong vật gì đó kiện&sid Là một cái địa chỉ Thân phận của ngươi
                $gm1yd = $encode->encode("cmd=shangdian&canshu=gogoumai&ydcount=1&ydid=$ydid&sid=$sid");
                //$gm5yd = $encode->encode("cmd=npc&nid=$nid&canshu=gogoumai&ydcount=5&ydid=$ydid&sid=$sid");
                $gm10yd = $encode->encode("cmd=npc&nid=$nid&canshu=gogoumai&ydcount=10&ydid=$ydid&sid=$sid");
			
                $gm1yd = '<a id="load" href="?cmd='.$gm1yd.'">Mua 1</a>';
                //$gm5yd = '<a href="?cmd='.$gm5yd.'">Mua 5</a>';
                  $gm10yd = '<a href="?cmd='.$gm10yd.'">Mua 10</a>';
                $gnhtml .= <<<HTML
                    <br/><div class='menu'>

                    <div style="text-align: left;"><a style="min-width: 200px" href="?cmd=$ydcmd"><font color='{$ydys}'>[$ydname]</font><br/>Giá: $ydjg Linh thạch</a>
                    </div><div style="width: 80px;">$gm1yd$gm5yd$gm10yd</div></div>
					
HTML;
            }
			
            $gnhtml .="<br/>";
            break;
    }
	
}
if (isset($canshu1)){
    switch ($canshu1){
        case 'gogoumai1':
            $gnhtml='';
            if (isset($ydcount) && isset($ydid)){
                $yaodan = Helpers\layThongTinDuocDan($ydid,$dblj);
                $ydjg = $yaodan->ydjgm;
                $ydname = $yaodan->ydname;
                $ret = Helpers\thayDoiMaThach(2,$ydjg*$ydcount,$sid,$dblj);
                if ($ret){
                    Helpers\themDuocDan($sid,$ydid,$ydcount,$dblj);
				//$gnhtml .= $tskhtml."Mua".$ydcount.$ydname.""Nguyên mã
				$gnhtml .= "".$tskcg.""
					;
                }else{
                    $gnhtml .= "".$tsksb."";
                }
            }
            $yaodan = Helpers\layTatCaDuocDan($dblj);
			
            foreach ($yaodan as $oneyaodan){
                $ydname = $oneyaodan['ydname'];
                $ydid = $oneyaodan['ydid'];
                $ydjg = $oneyaodan['ydjgm'];
				$ydys = $oneyaodan['ydys'];
                $ydcmd = $encode->encode("cmd=ydinfo&ydid=$ydid&sid=$sid");//cmd=php Văn kiện& Văn kiện bên trong vật gì đó kiện&sid Là một cái địa chỉ Thân phận của ngươi
                $gm1yd = $encode->encode("cmd=shangdian&canshu1=gogoumai1&ydcount=1&ydid=$ydid&sid=$sid");
                //$gm5yd = $encode->encode("cmd=npc&nid=$nid&canshu=gogoumai&ydcount=5&ydid=$ydid&sid=$sid");
                $gm10yd = $encode->encode("cmd=npc&nid=$nid&canshu=gogoumai&ydcount=10&ydid=$ydid&sid=$sid");
			
                $gm1yd = '<a id="load" href="?cmd='.$gm1yd.'">Mua</a>';
                 //$gm5yd = '<a href="?cmd='.$gm5yd.'">Mua 5</a>';
                 $gm10yd = '<a href="?cmd='.$gm10yd.'">Mua 10</a>';
			
			
			
			
                
                $gnhtml .= <<<HTML
                    <br/><div class='menu'>

                    <div style="text-align: left;"><a style="min-width: 200px" href="?cmd=$ydcmd"><font color='{$ydys}'>[$ydname]</font><br/>Giá: $ydjg Ma thạch</a>
                    </div><div style="width: 80px;">$gm1yd$gm5yd$gm10yd</div></div>
HTML;
            }
			
            $gnhtml .="<br>";
            break;
    }
}
//Phía dưới là một cái tham số cất giữ
        $shangdian = $encode->encode("cmd=shangdian&canshu=gogoumai&sid=$sid");
		$shangdian1 = $encode->encode("cmd=shangdian&canshu1=gogoumai1&sid=$sid");
		$beibaocmd = $encode->encode("cmd=getbagyd&sid=$sid");
		$player = Helpers\layThongTinNguoiChoi($sid,$dblj);

$gnhtml =<<<HTML
              <IMG width='280' height='140' src='./images/shangdian.png'src="./images/rw.png" style="border-radius: 8px;">
           <div class="menu">
                <a href="?cmd=$shangdian">Linh thạch đan dược</a>
                <a href="?cmd=$shangdian1"><font color="#9c27b0">Ma thạch đan dược</font></a>
			     <a href="?cmd=$beibaocmd">Hiệu thuốc</a>
            </div>
            <br/>
            <hr>
			<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=1.0" />
            <link rel="stylesheet" type="text/css" href="./chajian/tishikuang/style/dialog.css">
            Đang có <br/>
			Linh thạch: $player->tienTroChoi<br/>Ma thạch: $player->tienNap<hr>
             $gnhtml<br/>
		<a href="#" onClick="javascript:history.back(-1);">Trở lại</a>
        <a href="game.php?cmd=$gonowmid" style="float:right;background-color:#cff3d2;color: #755d5d;" >Trở về trò chơi</a>
		
		    <script src="./chajian/tishikuang/javascript/zepto.min.js"></script>
             <script type="text/javascript" src="./chajian/tishikuang/javascript/dialog.min.js"></script>
             <script type="text/javascript">
             $('#success').click(function(){
              popup({type:'success',msg:"Thao tác thành công",delay:1000,callBack:function(){
	          console.log('callBack~~~');
               }});
               })
               $('#error').click(function(){
               popup({type:'error',msg:"Thao tác thất bại",delay:2000,bg:true,clickDomCancel:true});
               })
               $('#load').click(function(){
               popup({type:'load',msg:"Xin chờ đợi",delay:1500,callBack:function(){
           	  popup({type:"success",msg:"Tăng thêm thành công",delay:1000});
                 }});
                  })
              $('#tip').click(function(){
              popup({type:'tip',msg:"Nhắc nhở tin tức",delay:null,bg:true,clickDomCancel:true});
              })
            </script>
HTML;
echo $gnhtml
?>