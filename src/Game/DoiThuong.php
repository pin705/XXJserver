<?php
require_once __DIR__ . '/../Helpers/NguoiChoiHelper.php';
require_once __DIR__ . '/../Helpers/TrangBiHelper.php';
require_once __DIR__ . '/../Helpers/DaoCuHelper.php';
require_once __DIR__ . '/../Helpers/DuocPhamHelper.php';
require_once __DIR__ . '/../Helpers/SungVatHelper.php';
require_once __DIR__ . '/../Helpers/NhiemVuHelper.php';
use TuTaTuTien\Helpers as Helpers;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 20 21 /12 /20
 * Time: 18:39
 */

$sjhtml =<<<HTML
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kiểu chữ lấp lóe hiệu quả</title>
    <style>
        body {
            /* background-color: black; */
        }
        div {
            margin: 0px auto;
            width: 100%;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 16px;
           /*  color: #97BCA8; */
        }
        span {
            animation: shan 4s linear infinite;
            text-transform: uppercase;
        }
        div span:nth-child(1){
            animation-delay: 0s;
        }
        div span:nth-child(2){
            animation-delay: .4s;
        }
        div span:nth-child(3){
            animation-delay: .8s;
        }
        div span:nth-child(4){
            animation-delay: 1.2s;
        }
        div span:nth-child(5){
            animation-delay: 1.6s;
        }
        div span:nth-child(6){
            animation-delay: 2s;
        }
        div span:nth-child(7){
            animation-delay: 2.4s;
        }
        div span:nth-child(8){
            animation-delay: 2.8s;
        }
        div span:nth-child(9){
            animation-delay: 3.2s;
        }
        @keyframes shan {
            0% ,100%{
                color: white;
                text-shadow: 0 0 4px  pink ,
                                0 0 10px pink ,
                                0 0 20px pink ,
                                0 0 30px pink ,
                                0 0 40px pink ,
                                0 0 50px pink ,
                                0 0 60px pink ,
                                0 0 70px pink ,
                                0 0 80px pink ,
                                0 0 90px pink ,
                                0 0 100px pink;
            }
            30%,90% {
                color: transparent;
                text-shadow: none;
            }
        }
    </style>
</head>
<body>
    <div>
        <span>v</span>
        <span>i</span>
        <span>p</span>
        <span>6</span>
        <span>6</span>
        <span>6</span>
        <span>8</span>
        <span>8</span>
        <span>8</span>
    </div>
</body>
</html>
HTML;
 

$player = \Helpers\layThongTinNguoiChoi($sid,$dblj);
$gonowmid = $encode->encode("cmd=goto_map&newmid=$player->idBanDoHienTai&sid=$sid");
$tishi = '';
if (isset($dhm)){
		
    $dhm = htmlspecialchars($dhm);
	//Phía dưới viết chính là phán đoán nhận lấy VIP666 Gói quà tình huống
        if ($dhm==vip666888 && $player->dhvip1==1){
            $tishi =  'CDK đã nhập, không thể nhận lại！';
        }else{
        
                if ($dhm==vip666 && $player->dhvip==1){
            $tishi =  'CDK đã nhập, không thể nhận lại！';
        }
		if ($dhm==vip666 && $player->dhvip==0){
    		$dhm=vip666;
    		$sql = "update game1 set dhvip = $player->dhvip + 1  WHERE sid='$sid'";//<!--Hối đoái thêm 1-->
    		$dblj->exec($sql);
	   }
		if ($dhm==vip666888 && $player->dhvip1==0){
    		$dhm=vip666888;
    		$sql = "update game1 set dhvip1 = $player->dhvip1 + 1  WHERE sid='$sid'";//<!--Hối đoái thêm 1-->
    		$dblj->exec($sql);
	}
	
  else{
    $duihuan = Helpers\layThongTinDoiHuan($dhm,$dblj);
    if ($duihuan){
        // $sql = "delete from duihuan WHERE dhm = '$dhm'";
        // $dblj->exec($sql);
        //Kịp thời xóa bỏ hối đoái mã, mở ra tự động xóa bỏ kho số liệu sử dụng hối đoái mã
        $tishi = "Kích hoạt 【{$duihuan->dhname}】 mã thành công, nhận được :<br/>";
        $retallzb = explode(',',$duihuan->dhzb);
        foreach ($retallzb as $zb){
            if ($zb){
                Helpers\themTrangBi($sid,$zb,$dblj);
                $zhuangbei = Helpers\layThongTinTrangBi($zb,$dblj);
                $tishi .= "$zhuangbei->tenTrangBi<br/>";
            }
        }
        $djitem = explode(',',$duihuan->dhdj);
        foreach ($djitem as $djinfo){
            if ($djinfo){
                $dj = explode('|',$djinfo);
                $djid = $dj[0];
                $djcount = $dj[1];
                Helpers\themDaoCu($sid,$djid,$djcount,$dblj);
                $daoju = Helpers\layThongTinDaoCu($djid,$dblj);
                $tishi .= "{$daoju->tenDaoCu}x{$djcount}<br/>";
                Helpers\thayDoiNhiemVu(1,$djid,$djcount,$sid,$dblj);
            }
        }
        $ypitem = explode(',',$duihuan->dhyp);
        foreach ($ypitem as $ypinfo){
            if ($ypinfo){
                $yp = explode('|',$ypinfo);
                $ypid = $yp[0];
                $ypcount = $yp[1];
                Helpers\themDuocPham($sid,$ypid,$ypcount,$dblj);
                $yaopin = Helpers\layThongTinDuocPham($ypid,$dblj);
                $tishi .= "{$yaopin->tenDuocPham}x{$ypcount}<br/>";
            }
        }
        if ($duihuan->dhyxb){
            Helpers\thayDoiTienTroChoi(1,$duihuan->dhyxb,$sid,$dblj);
            $tishi .= "Linh thạch：$duihuan->dhyxb<br/>";
        }
        if ($duihuan->dhczb){
            Helpers\thayDoiMaThach(1,$duihuan->dhczb,$sid,$dblj);
            $tishi .= "Ma thạch：$duihuan->dhczb<br/>";
        }
        if ($duihuan->dhexp){
            Helpers\themKinhNghiem($sid,$dblj,$duihuan->dhexp);
            $tishi .= "Kinh nghiệm：$duihuan->dhexp<br/>";
        }

    }else{
        $tishi =  'Hối đoái thất bại, sai lầm CDK';
    }
  }//Phán đoán VIP Gói quà nhận lấy tình huống 2
	}//Phán đoán vip Gói quà 1

}



$dhhtml =<<<HTML
<form>
    <input type="hidden" name="cmd" value="duihuan">
    <input type="hidden" name="sid" value="$sid">
	
	<div align="center">
	<IMG width='280' height='140' src='./images/duihuan.png'src="./images/rw.png" style="border-radius: 8px;">
	<hr>
    Hối đoái mã:$dhm
	$sjhtml
	<hr>
	<p style="color: #f70808;">$tishi</p>
    <input name="dhm" style="background-color: #ddf7e9;"> <input type="submit" value="Nhận quà">
	</div>
	<br/><br/>
</form>
	<a href="#" onClick="javascript:history.back(-1);">Trở lại</a>
    <a href="game.php?cmd=$gonowmid" style="float:right;" >Trở về trò chơi</a> 

HTML;
echo $dhhtml;
?>

