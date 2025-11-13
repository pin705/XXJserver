<?php
require_once __DIR__ . '/../Helpers/NguoiChoiHelper.php';
require_once __DIR__ . '/../Helpers/TrangBiHelper.php';
require_once __DIR__ . '/../Helpers/DaoCuHelper.php';
require_once __DIR__ . '/../Helpers/DuocPhamHelper.php';
require_once __DIR__ . '/../Helpers/ClubHelper.php';
use TuTaTuTien\Helpers as Helpers;


$player = \Helpers\layThongTinNguoiChoi($sid,$dblj);
$gonowmid = $encode->encode("cmd=goto_map&newmid=$player->idBanDoHienTai&sid=$sid");
$payhtml='';
$pdjcount = 0;
$fy = "./src/Game/PhongNgu.php";
if (!isset($yeshu)){
    $yeshu = 0;
}
if (!isset($fangshi)){
    exit("<a href='?cmd=$gonowmid'>Trở về trò chơi</a>");
}
switch ($fangshi){
    case "daoju":
        
        if (isset($canshu)){
            if ($canshu == "buy"){
                $fsdj = Helpers\layThongTinFangShi("daoju",$payid,$dblj);
                try{
                    if (!$fsdj){
                        throw new PDOException("Đạo cụ đã bán sạch<br/>");//Cái kia sai lầm ném ra ngoài dị thường
                    }
                    $playerdj = Helpers\layThongTinDaoCuCuaNguoiChoi($sid,$fsdj->idDaoCu,$dblj);
                    if ($playerdj){
                        $pdjcount = $playerdj->soLuong;
                    }
                    $dblj->setAttribute(PDO::ATTR_AUTOCOMMIT, 0);
                    $dblj->setAttribute(PDO::ATTR_ERRMODE,  PDO::ERRMODE_EXCEPTION);
                    $dblj->beginTransaction();
                    $price = $buycount * $fsdj->pay;
                    $sql = "update `game1` set uyxb = uyxb - $price WHERE uyxb >= $price AND sid='$sid'";
                    $affected_rows=$dblj->exec($sql);
                    if(!$affected_rows && $price>0)
                        throw new PDOException("Linh thạch không đủ<br/>");//Cái kia sai lầm ném ra ngoài dị thường

                    $sql = "update `fangshi_dj` set djcount = djcount - $buycount WHERE djcount >= $buycount and payid = $payid";
                    $affected_rows=$dblj->exec($sql);
                    if(!$affected_rows)
                        throw new PDOException("Trong phường thị nên đạo cụ đếm không đủ<br/>");//Cái kia sai lầm ném ra ngoài dị thường

                    $sql = "update `game1` set uyxb = uyxb + {$price} WHERE uid = {$fsdj->idNguoiDung}";
                    $affected_rows=$dblj->exec($sql);
                    if(!$affected_rows)
                        throw new PDOException("Treo lên nên đạo cụ tu sĩ chưa thu được linh thạch<br/>");//Cái kia sai lầm ném ra ngoài dị thường
                    $djsum = $pdjcount + $buycount;
                    $sql = "replace into `playerdaoju`(djname,djsum,uid,sid,djid,djinfo) VALUES('$fsdj->tenDaoCu','$djsum','$player->idNguoiDung','$sid',$fsdj->idDaoCu,'$fsdj->djinfo')";
                    $affected_rows=$dblj->exec($sql);
                    if(!$affected_rows)
                        throw new PDOException("Truyền tống trận tại truyền tống đạo cụ thời điểm truyền tống thất bại<br/>");//Cái kia sai lầm ném ra ngoài dị thường
                    echo "Giao dịch thành công！<br/>";
                    $dblj->commit();//Giao dịch thành công liền đưa ra

                }catch (PDOException $e){
                    echo $e->getMessage();
                    $dblj->rollBack();
                }
                $dblj->setAttribute(PDO::ATTR_AUTOCOMMIT, 1);//Quan bế
                $sql="delete from `fangshi_dj` where djcount = 0";
                $dblj->exec($sql);
                Helpers\thayDoiNhiemVu(1,$fsdj->idDaoCu,1,$sid,$dblj);
            }
        }
        $fsdjall = Helpers\layTatCaFangShi($fangshi,$dblj);
        foreach ($fsdjall as $fsdj){
            $djid = $fsdj['djid'];
            $djname = $fsdj['djname'];
            $djpay = $fsdj['pay'];
            $djcount = $fsdj['djcount'];
            $payid = $fsdj['payid'];
            $goumaidj1 = $encode->encode("cmd=arena&fangshi=daoju&canshu=buy&payid=$payid&buycount=1&sid=$sid");
            $goumaidj5 = $encode->encode("cmd=arena&fangshi=daoju&canshu=buy&payid=$payid&buycount=5&sid=$sid");
            $goumaidj10 = $encode->encode("cmd=arena&fangshi=daoju&canshu=buy&payid=$payid&buycount=10&sid=$sid");
            $djpaycmd = $encode->encode("cmd=item_info&djid=$djid&sid=$sid");
            $payhtml .= "<a href='?cmd=$djpaycmd'>{$djname}x$djcount</a>Đơn giá:$djpay<a href='?cmd=$goumaidj1'>Mua 1</a>
			<!--<a href='?cmd=$goumaidj5'>Mua 5</a> <a href='?cmd=$goumaidj10'>Mua 10</a>--><br/>";
        }
        $zhuangbei = $encode->encode("cmd=arena&fangshi=zhuangbei&sid=$sid");
		$shangdian = $encode->encode("cmd=arena&fangshi=shangdian&sid=$sid");
        $payhtml=<<<HTML
            【Đạo cụ|<a href="?cmd=$zhuangbei">Trang bị</a>|<a href="?cmd=$shangdian">Cửa hàng</a>】<br/>
            $payhtml
            <br/><a href="#" onClick="javascript:history.back(-1);">Trở lại</a>
        <a href="game.php?cmd=$gonowmid" style="float:right;" >Trở về trò chơi</a><br>
HTML;
        break;
    
    
    case "zhuangbei":
        if (isset($canshu)){
            if ($canshu == "buy"){
                try{
                    $fszb = Helpers\layThongTinFangShi("zhuangbei",$payid,$dblj);
					

                    if (!$fszb){
                        echo "Trang bị đã bị bán ra<br/>";//Cái kia sai lầm ném ra ngoài dị thường
                        goto fszblist;
                    }
                    $pay = $fszb->pay;
                    $dblj->setAttribute(PDO::ATTR_AUTOCOMMIT, 0);
                    $dblj->setAttribute(PDO::ATTR_ERRMODE,  PDO::ERRMODE_EXCEPTION);
                    $dblj->beginTransaction();
                    $sql = "update `game1` set uyxb = uyxb - $pay WHERE uyxb >= $pay AND sid='$sid'";
                    $affected_rows = $dblj->exec($sql);
                    if(!$affected_rows && $pay>0)
                        throw new PDOException("Linh thạch không đủ<br/>");//Cái kia sai lầm ném ra ngoài dị thường

//                    -------------------------------------------------------------------------------
                    $sql = "delete from `fangshi_zb` WHERE payid=$payid";
                    $affected_rows = $dblj->exec($sql);
                    if(!$affected_rows)
                        throw new PDOException("Trang bị xuất hàng thất bại<br/>");//Cái kia sai lầm ném ra ngoài dị thường

//                    -------------------------------------------------------------------------------
                    $sql = "update `game1` set uyxb = uyxb+ $pay WHERE uid=$fszb->idNguoiDung";
                    $affected_rows = $dblj->exec($sql);
                    if(!$affected_rows && $pay>0)
                        throw new PDOException("Treo lên nên trang bị tu sĩ chưa thu được linh thạch<br/>");//Cái kia sai lầm ném ra ngoài dị thường

//                    -------------------------------------------------------------------------------
                    $sql = "update `playerzhuangbei` set sid = '$sid',uid=$player->idNguoiDung WHERE zbnowid=$fszb->idTrangBi";
                    $affected_rows = $dblj->exec($sql);
                    if(!$affected_rows)
                        throw new PDOException("Trang bị truyền tống thất bại<br/>");//Cái kia sai lầm ném ra ngoài dị thường
                    echo "Giao dịch thành công！<br/>";
                    $dblj->commit();//Giao dịch thành công liền đưa ra
                }catch (PDOException $e){
                    echo $e->getMessage();
                    $dblj->rollBack();
                }
                $dblj->setAttribute(PDO::ATTR_AUTOCOMMIT, 1);

            }
        }
        fszblist:
        $fsdjall = Helpers\layTatCaFangShi($fangshi,$dblj);
        foreach ($fsdjall as $fsdj){
            $zbnowid = $fsdj['zbnowid'];
            $zbname = $fsdj['zbname'];
			$zbys = $fsdj['zbys'];
            $zbqh = $fsdj['qianghua'];
            $zbpay = $fsdj['pay'];
            $payid = $fsdj['payid'];
            if ($zbqh){
                $zbqh = '+'.$zbqh;
            }else{
                $zbqh='';
            }
            $goumaizb = $encode->encode("cmd=arena&fangshi=zhuangbei&canshu=buy&payid=$payid&sid=$sid");
            $zbpaycmd = $encode->encode("cmd=equipment_info&zbnowid=$zbnowid&sid=$sid");
            $payhtml .= "<div class=menu>
            <a href='?cmd=$zbpaycmd' style='color: $zbys; width: 210px;text-align: left;' >{$zbname}{$zbqh} <br/>Giá cả:$zbpay Linh Thạch</a>
            <a href='?cmd=$goumaizb'>Mua</a></div><br/>";

        }
        $fangshi = $encode->encode("cmd=arena&fangshi=daoju&sid=$sid");
		$zhuangbei = $encode->encode("cmd=arena&fangshi=zhuangbei&sid=$sid");
		$shangdian = $encode->encode("cmd=arena&fangshi=shangdian&sid=$sid");
        $payhtml=<<<HTML
<link rel="stylesheet" href="./css/gamecss.css">
【<a href="?cmd=$fangshi">Đạo cụ</a>|Trang bị|<a href="?cmd=$shangdian">Cửa hàng</a>】<br/>
        $payhtml 

            
            <br/>
            <a href="#" onClick="javascript:history.back(-1);">Trở lại</a>
        <a href="game.php?cmd=$gonowmid" style="float:right;" >Trở về trò chơi</a>
HTML;
        break;
		 break;
    
    
    case "shangdian":
        if (isset($canshu)){
            if ($canshu == "buy"){
                try{
                    $sd = Helpers\layThongTinFangShi("shangdian",$payid,$dblj);

                    if (!$sd){
                        echo "Trang bị đã bị bán ra<br/>";//Cái kia sai lầm ném ra ngoài dị thường
                        goto fssdlist;
                    }
                    $pay = $sd->pay;
                    $dblj->setAttribute(PDO::ATTR_AUTOCOMMIT, 0);
                    $dblj->setAttribute(PDO::ATTR_ERRMODE,  PDO::ERRMODE_EXCEPTION);
                    $dblj->beginTransaction();
                    $sql = "update `game1` set uyxb = uyxb - $pay WHERE uyxb >= $pay AND sid='$sid'";
                    $affected_rows = $dblj->exec($sql);
                    if(!$affected_rows && $pay>0)
                        throw new PDOException("<div align='center' items='100px'><font color='#FF0000'>Linh thạch không đủ</font></div><br/>");//Cái kia sai lầm ném ra ngoài dị thường

//                    -------------------------------------------------------------------------------
                    $sql = "delete from `fangshi_sd` WHERE payid=$payid";
                    $affected_rows = $dblj->exec($sql);
                    if(!$affected_rows)
                        throw new PDOException("Trang bị xuất hàng thất bại<br/>");//Cái kia sai lầm ném ra ngoài dị thường

//                    -------------------------------------------------------------------------------
                    $sql = "update `game1` set uyxb = uyxb+ $pay WHERE uid=$sd->idNguoiDung";
                    $affected_rows = $dblj->exec($sql);
                    if(!$affected_rows && $pay>0)
                        throw new PDOException("Treo lên nên trang bị tu sĩ chưa thu được linh thạch<br/>");//Cái kia sai lầm ném ra ngoài dị thường

//                    -------------------------------------------------------------------------------
                    $sql = "update `playerzhuangbei` set sid = '$sid',uid=$player->idNguoiDung WHERE zbnowid=$sd->idTrangBi";
                    $affected_rows = $dblj->exec($sql);
                    if(!$affected_rows)
                        throw new PDOException("Trang bị truyền tống thất bại<br/>");//Cái kia sai lầm ném ra ngoài dị thường
                    echo "Giao dịch thành công！<br/>";
                    $dblj->commit();//Giao dịch thành công liền đưa ra
                }catch (PDOException $e){
                    echo $e->getMessage();
                    $dblj->rollBack();
                }
                $dblj->setAttribute(PDO::ATTR_AUTOCOMMIT, 1);

            }
        }
		//Còn chờ sửa chữa, phía dưới dấu hiệu không hoàn thiện
        fssdlist:
        $fsdjall = Helpers\layTatCaFangShi($fangshi,$dblj);
        foreach ($fsdjall as $fsdj){
            $zbnowid = $fsdj['zbnowid'];
            $zbname = $fsdj['zbname'];
            $zbqh = $fsdj['qianghua'];
            $zbpay = $fsdj['pay'];
            $payid = $fsdj['payid'];
            if ($zbqh){
                $zbqh = '+'.$zbqh;
            }else{
                $zbqh='';
            }
            $goumaisd = $encode->encode("cmd=arena&fangshi=shangdian&canshu=buy&payid=$payid&sid=$sid");
            $zbpaycmd = $encode->encode("cmd=equipment_info&zbnowid=$zbnowid&sid=$sid");
            //$payhtml .= "<a href='?cmd=$zbpaycmd' style='color: #f50808;'>{$zbname}{$zbqh}</a>Giá cả：<font color='#FF0000'>$zbpay</font><a href='?cmd=$goumaisd'>Mua</a><br/>";
            $payhtml .= "<div class=menu>
            <a href='?cmd=$zbpaycmd' style='color: $zbys; width: 210px;text-align: left;' >{$zbname}{$zbqh} <br/>Giá cả:$zbpzbpayay Linh Thạch</a>
            <a href='?cmd=$goumaisd'>Mua</a></div><br/>";
        }
        $fangshi = $encode->encode("cmd=arena&fangshi=daoju&sid=$sid");
		$zhuangbei = $encode->encode("cmd=arena&fangshi=zhuangbei&sid=$sid");
		$shangdian = $encode->encode("cmd=arena&fangshi=sahngdian&sid=$sid");
        $payhtml=<<<HTML
            【<a href="?cmd=$fangshi">Đạo cụ</a>|<a href="?cmd=$zhuangbei">Trang bị</a>|Đóng cửa】<br/>
			
			<IMG width="280" height="500" src="./images/zxss.png"><br/>
<!--Đằng sau dấu hiệu không hoàn thiện
    <body>
    <div class="page-icon">$payhtml $fy
	<span class="page-disabled"><i></i>Trang trước</span>
    <span class="page-current">1</span>
    <a href="#">2</a>
    <a href="#">3</a>
    <a href="#">4</a>
    <a href="#">5</a>
    <a href="#">6</a>
    <a href="#">7</a>
    ……
    <a href="#">199</a>
    <a href="#">200</a>
    <a class="page-next" href="#">Trang kế tiếp<i></i></a>
    </div>
    </body>
--!> 
			<br/>
		<a href="#" onClick="javascript:history.back(-1);">Trở lại</a>
        <a href="game.php?cmd=$gonowmid" style="float:right;" >Trở về trò chơi</a>
       
HTML;
        break;
}


echo $payhtml;
