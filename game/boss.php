
require_once __DIR__ . '/../src/Helpers/NguoiChoiHelper.php';
require_once __DIR__ . '/../src/Helpers/TrangBiHelper.php';
require_once __DIR__ . '/../src/Helpers/DaoCuHelper.php';
require_once __DIR__ . '/../src/Helpers/DuocPhamHelper.php';
require_once __DIR__ . '/../src/Helpers/QuaiVatHelper.php';
require_once __DIR__ . '/../src/Helpers/TruongLaoHelper.php';
require_once __DIR__ . '/../src/Helpers/NhiemVuHelper.php';
require_once __DIR__ . '/../src/Helpers/BanDoHelper.php';
require_once __DIR__ . '/../src/Helpers/SungVatHelper.php';
require_once __DIR__ . '/../src/Helpers/KyNangHelper.php';
require_once __DIR__ . '/../src/Helpers/ClubHelper.php';
use TuTaTuTien\Helpers as Helpers;

<?php
$nguoiChoi = \Helpers\layThongTinNguoiChoi($sid,$dblj);
$nowmid=$nguoiChoi->idBanDoHienTai;
$gonowmid = $encode->encode("cmd=gomid&newmid=$nguoiChoi->idBanDoHienTai&sid=$nguoiChoi->sid");
// $pgjcmd = $encode->encode("cmd=pvb&canshu=ptgj&bossid=$bossid&sid=$sid");Vốn có boss Công kích

$pgjcmd = $encode->encode("cmd=pvbgj&bossid=$bossid&sid=$nguoiChoi->sid&nowmid=$nowmid");
// $pgjcmd = $encode->encode("cmd=pvbgj&bossid=$bossid&sid=$nguoiChoi->sid&nowmid=$nowmid");
$boss = Helpers\layThongTinBoss($bossid,$dblj);
$yboss = Helpers\taoMoiBoss();
$wgid = $nguoiChoi->wugong;
$cxwg = Helpers\layThongTinVoCong($wgid,$sid,$dblj);
$wglx = $cxwg->wglx;
// $cxmid = Helpers\layThongTinBanDo($nguoiChoi->idBanDoHienTai,$dblj);
// $cxqy = Helpers\layThongTinKhuVuc($cxmid->mqy,$dblj);
// $gorehpmid = $encode->encode("cmd=gomid&newmid=$cxqy->mid&sid=$nguoiChoi->sid");
if ($nguoiChoi->wugong!=''&&$wglx==1){
	$tishi = "<a href='?cmd=$gonowmid'>$cxwg->wgname</a><br><br> ";
}



 if ($yboss->bossid){
    
	 $yboss = player\getyboss($yboss->bossid,$dblj);
 }
$huode = '';
$useyp1 = $encode->encode("cmd=pvb&canshu=useyp&ypid=$nguoiChoi->yp1&sid=$sid&bossid=$bossid&nowmid=$nowmid");
$useyp2 = $encode->encode("cmd=pvb&canshu=useyp&ypid=$nguoiChoi->yp2&sid=$sid&bossid=$bossid&nowmid=$nowmid");
$useyp3 = $encode->encode("cmd=pvb&canshu=useyp&ypid=$nguoiChoi->yp3&sid=$sid&bossid=$bossid&nowmid=$nowmid");
$ypname1 = 'Dược phẩm 1';
$ypname2 = 'Dược phẩm 2';
$ypname3 = 'Dược phẩm 3';

if ($nguoiChoi->yp1!=0){
    $yaopin = Helpers\layThongTinDuocPhamCuaNguoiChoi($nguoiChoi->yp1,$sid,$dblj);
    $ypname1 = $yaopin->tenDuocPham.'('.$yaopin->ypsum.')';
}
if ($nguoiChoi->yp2!=0){
    $yaopin = Helpers\layThongTinDuocPhamCuaNguoiChoi($nguoiChoi->yp2,$sid,$dblj);
    $ypname2 = $yaopin->tenDuocPham.'('.$yaopin->ypsum.')';
}
if ($nguoiChoi->yp3!=0){
    $yaopin = Helpers\layThongTinDuocPhamCuaNguoiChoi($nguoiChoi->yp3,$sid,$dblj);
    $ypname3 = $yaopin->tenDuocPham.'('.$yaopin->ypsum.')';
}
$cwhurt = '';
$tishihtml='';
if ($boss->bosshp <=0 ){//Nơi này là đối với BOSS Không có sinh mệnh tiến hành làm mới người tiến hành nhắc nhở
		$sql = "update boss set bossmaxhp = bossmaxhp+100  WHERE bossid='$bossid'";//<!--Cho boss Tăng máu-Thêm thuộc tính-->
		$dblj->exec($sql);
		$sql = "update boss set bossgj = bossgj+5  WHERE bossid='$bossid'";//<!--Cho boss Tăng máu-Thêm thuộc tính-->
		$dblj->exec($sql);
	$html = <<<HTML
	<IMG width='280' height='140' src='./images/boss.png'src="./images/rw.png" style="border-radius: 8px;">
        BOSS Đã chạy trốn, chậm rãi BOSS Học xong trưởng thành, không còn thút thít, sức chiến đấu càng ngày càng xâu tạc thiên！<br/>
        <br/>
        <a href="?cmd=$gonowmid">Trở về trò chơi</a>
HTML;
    echo $html;
    exit();
}

if ($nowmid!=$nguoiChoi->idBanDoHienTai){
    $html = <<<HTML
        Mời bình thường chơi đùa！<br/>
        <br/>
        <a href="?cmd=$gonowmid">Trở về trò chơi</a>
HTML;
    echo $html;
    exit();
}

if (($boss->sid!=$nguoiChoi->sid && $boss->sid!='') || ($boss->bossid=='')){
        $html = <<<HTML
        Quái vật đã bị những người khác công kích！<br/>
        Mời thiếu hiệp luyện tập một chút tốc độ tay a
        <br/>
        <a href="?cmd=$gonowmid">Trở về trò chơi</a>
HTML;
        exit($html);
}
$pvbbj = '';
$pvbxx = '';
$pvbsb = '';
$gwbj = '';
if (isset($canshu)){

    if ($canshu == 'useyp'){
        $ret = Helpers\suDungDuocPham($ypid,1,$sid,$dblj);
        $nguoiChoi =  Helpers\layThongTinNguoiChoi($sid,$dblj);
    }
}

if($cmd=='pvb' && $boss->sid==''){

    if ($nguoiChoi->capDo >= 1 && $nguoiChoi->sinhMenh <=0){
        $zdjg = -1;
    }else{
        // $sql = "update boss set sid = '$sid' WHERE id='$bossid'";Nơi này xóa quái, ID Viết xong là được, xảy ra vấn đề, ta có chút im lặng 12.23
        // $dblj->exec($sql);
        $cw = Helpers\layThongTinSungVat($nguoiChoi->cw,$dblj);
        Helpers\thayDoiThuocTinhSungVat('cwhp',$cw->cwmaxhp,$nguoiChoi->cw,$dblj);
        if($nguoiChoi->capDo <= 10){
            Helpers\thayDoiThuocTinhNguoiChoi('uhp',$nguoiChoi->sinhMenhToiDa,$sid,$dblj);
            $nguoiChoi =  Helpers\layThongTinNguoiChoi($sid,$dblj);
        }
    }

}

elseif ($cmd == 'pvbgj' && $bossid != 0){
    //Đòn công kích bình thường
    $hurt = false;
    $ghurt = 0;
    // $jineng = Helpers\taoMoiKyNang();

    // if (isset($canshu)){
        // switch ($canshu){
            // case 'usejn':
                // $ret = Helpers\giamKyNang($jnid,1,$sid,$dblj);
                // if ($ret){
                    // $jineng = Helpers\layThongTinKyNangCuaNguoiChoi($jnid,$sid,$dblj);
                    // $tishihtml = "Sử dụng kỹ năng：$jineng->jnname<br/>";
                // }else{
                    // $tishihtml = "Kỹ năng số lượng không đủ<br/>";
                // }

                // break;
        // }
   // }
    // $nguoiChoi->congKich +=$jineng->jngj;
    // $nguoiChoi->phongNgu +=$jineng->jnfy;
    // $nguoiChoi->baoKich +=$jineng->jnbj;
    // $nguoiChoi->hutMau +=$jineng->jnxx;

    $lvc = $nguoiChoi->capDo - $boss->bosslv;
	//Công kích tổn thương tính toán
    if ($lvc <= 0){
        $lvc = 0;
    }

    $phurt = 0 ;
	$gwsj = mt_rand(1,100);//Khống chế quái vật bạo kích xác suất
    if ($boss->bossbj >= $gwsj){
        $boss->bossgj = round($boss->bossgj * 2.25);
        $gwbj = 'Trọng kích';
    }

    $phurt = round($boss->bossgj - ($nguoiChoi->phongNgu * 0.75),0);//boss Công kích tính toán
	
    if ($phurt < $boss->bossgj*0.15){
        $phurt = round($boss->bossgj*0.25);
    }

    $ran = mt_rand(1,200);//Khống chế bạo kích xác suất
    if ($nguoiChoi->baoKich >= $ran){
        $nguoiChoi->congKich = round($nguoiChoi->congKich * 1.72);
        $pvbbj = 'Bạo kích';
    }
     $cw = Helpers\layThongTinSungVat($nguoiChoi->cw,$dblj);//Dẫn vào sủng vật, phán đoán sủng vật chết sống
	 if ($cw->cwhp > 0){
        $cwgj = round($cw->cwgj * 1);   
    }else{
        $cwgj = 0 ;
    }
	 
    $gphurt = round($cwgj + $nguoiChoi->congKich - ($boss->bossfy * 0.75),0);//Nhân vật chính công kích quái vật chụp máu tình huống, bản thân công kích+Sủng vật công kích
    if ($gphurt < $nguoiChoi->congKich*0.15){
        $gphurt = round( $nguoiChoi->congKich * 0.15);
    }
    $pvbxx = ceil($gphurt * ($nguoiChoi->hutMau/200) );//Khống chế hút máu cường độ

    if ($phurt <= 0){
        $hurt = true;
    }

    if ($phurt < $pvbxx){
        $pvbxx = $phurt - 7;

        if ($pvbxx<0){
            $pvbxx = 0;
			
        }
    }
	$sb = mt_rand(1,100);//Dẫn vào né tránh ngẫu nhiên số
	if ($sb > 80){
		$gphurt = 0;
		$pvbxx = 0;
		$pvbsb = '(Né tránh)';
	}
	
	

    $cw = Helpers\layThongTinSungVat($nguoiChoi->cw,$dblj);
    $sql = "update boss set bosshp = bosshp - {$gphurt} WHERE bossid='$bossid'";
    $dblj->exec($sql);
    $boss = Helpers\layThongTinBoss($bossid,$dblj);
	
    if ($boss->bosshp <=0 ){//Quái vật tử vong, ban thưởng tính toán
	    
        $sql = "delete from boss where bossid = $bossid AND sid='$nguoiChoi->sid'";//Xóa bỏ quái vật
        $dblj->exec($sql);
		$sql = "update mid set mgtime='$nowdate' WHERE mid='$nguoiChoi->idBanDoHienTai'";//Gia tăng thời gian, tính toán
        $dblj->exec($sql);
		//$sql = "update boss set bosshp = bossmaxhp  WHERE bossid='$bossid'";//Cho boss Tăng máu
		//$dblj->exec($sql);
		$sjyxb1 = mt_rand(1,2000);
		$sjyxb = mt_rand(1,5);
        $yxb = round($boss->bosslv*$sjyxb*30) + $sjyxb*110+$sjyxb1;//Tiền trò chơi tính toán
        if ($hurt || $lvc >=35){
            $yxb = 0;//Lớn hơn 35 Cấp năm tiền trò chơi là không
        }
		
		$sjczb = mt_rand(1,5);
		$sj = $sjczb+ round($boss->bosslv /10);
        $ret = Helpers\thayDoiTienTroChoi(1,$yxb,$sid,$dblj);//Lựa chọn 1 Phương án（Thêm tiền），Cải biến số lượng=yxb，id，Quan bế kho số liệu；
		$ret1 = Helpers\thayDoiMaThach(1,$sj,$sid,$dblj);//Ma thạch gia tăng
        if ($ret){
            $huode .= "nhận được  linh thạch:$yxb<br/>nhận được  ma thạch:$sj<br>";
        }
        // $taskarr = Helpers\layDanhSachNhiemVuNguoiChoi($sid,$dblj);//Nơi này là nhiệm vụ tình huống
        // Helpers\thayDoiNhiemVu(2,$boss->gyid,1,$sid,$dblj);
        // for ($i=0;$i<count($taskarr);$i++){
            // $rwyq = $taskarr[$i]['rwyq'];
            // $rwid = $taskarr[$i]['rwid'];
            // $rwzl = $taskarr[$i]['rwzl'];
            // $rwzt = $taskarr[$i]['rwzt'];
            // if ($rwyq==$boss->gyid && $rwzl==2 && $rwzt!=3){
                // $rwnowcount = $taskarr[$i]['rwnowcount']+ 1;
                // $rwts = $taskarr[$i]['rwname'].'('.$rwnowcount."/".$taskarr[$i]['rwcount'].')<br/>';
                // break;
            // }
        // }
	
$jisha = <<<HTML

<IMG width='15' height='15' src='./images/jisha.png' >

HTML;

		//Trang bị tính toán
		$xyz =  $nguoiChoi->tfxy;//Thiên phú may mắn gia nhập

        $sjjv = mt_rand(1,120-$xyz);
		
        if ($boss->dljv >=$sjjv && $boss->bosszb != ''){
			
            $sql = "select * from zhuangbei WHERE zbid in ($boss->bosszb)";
            $cxdljg = $dblj->query($sql);
            if ($cxdljg){
				
                $retzb = $cxdljg->fetchAll(PDO::FETCH_ASSOC);
                $sjdl = mt_rand(0,count($retzb)-1);
                $zbname = $retzb[$sjdl]['zbname'];
                $zbid = $retzb[$sjdl]['zbid'];
                $zbnowid = player\addzb($sid,$zbid,$dblj);
				$zbys = Helpers\layThongTinTrangBi($zbid,$dblj);//Thu hoạch trang bị ID Địa chỉ, đây là dùng để thu hoạch sắc thái
                $chakanzb = $encode->encode("cmd=chakanzb&zbnowid=$zbnowid&uid=$nguoiChoi->idNguoiDung&sid=$sid");
			    $huode .= "nhận được :".'<a href="?cmd='.$chakanzb.'"><font color='.$zbys->phamChat.' >'.$zbname .'</font></a><br>';//Trang bị yếu tố
			        $zbpz = $zbys->congKich + $zbys->phongNgu + $zbys->hutMau +$zbys->baoKich ;//Viết một cái thông cáo, nhận được  trang bị
					if ($zbpz >=5){
			        $sql = "insert into ggliaotian(name,msg,uid) values(?,?,?)";
                    $stmt = $dblj->prepare($sql);
					
$tz = <<<HTML

					[{$nguoiChoi->tenNhanVat}]{$jisha}[{$boss->tenBoss}]nhận được <a href='?cmd=zbinfo_sys&zbid=$zbys->idMauTrangBi&sid=$sid' style="background-color: #f6f7f7;padding: 0px 0px;"><font style="color:{$zbys->phamChat}">[{$zbname}]</font></a>Khiến người ghen tị.
HTML;
                    $stmt->execute(array('【Phụ trương】',$tz,'0'));//Hệ thống thông cáo
					}
            }
        }
		//Đạo cụ tính toán
        $sjjv = mt_rand(1,100);
        if ($boss->djjv >= $sjjv && $boss->bossdj != ''){
            $sql = "select * from daoju WHERE djid in ($boss->bossdj)";
            $cxdljg = $dblj->query($sql);
            if ($cxdljg){
                $retdj = $cxdljg->fetchAll(PDO::FETCH_ASSOC);
                $sjdj = mt_rand(0,count($retdj)-1);
                $djname = $retdj[$sjdj]['djname'];
                $djid = $retdj[$sjdj]['djid'];
                if ($djid == 1 && $lvc == 0){
					
                    goto yp;
                }
                $djsum = mt_rand(3,12);
                Helpers\themDaoCu($sid,$djid,$djsum,$dblj);
                $huode .= "nhận được :<font class='djys'>$djname x$djsum</font><br>";//Sắc thái yếu tố
                for ($i=0;$i<count($taskarr);$i++){
                    $rwyq = $taskarr[$i]['rwyq'];
                    $rwid = $taskarr[$i]['rwid'];
                    $rwzl = $taskarr[$i]['rwzl'];
                    $rwzt = $taskarr[$i]['rwzt'];
                    if ($rwyq==$djid && $rwzl==1 && $rwzt!=3){
                        $rwnowcount = $taskarr[$i]['rwnowcount']+ $djsum;
                        $rwts = $taskarr[$i]['rwname'].'('.$rwnowcount."/".$taskarr[$i]['rwcount'].')<br/>';
                        break;
                    }
                }

             }
        }
        yp:
        $sjjv = mt_rand(1,100);
        if ($boss->ypjv >= $sjjv && $boss->bossyp != ''){
            $sql = "select * from yaopin WHERE ypid in ($boss->bossyp)";
            $cxdljg = $dblj->query($sql);
        if ($cxdljg){
			$retyp = $cxdljg->fetchAll(PDO::FETCH_ASSOC);
            //$sjyp = mt_rand(0, count($retyp) - 1);
			$sjyp = mt_rand(0,5);
            $ypname = $retyp[$sjyp]['ypname'];
            $ypid = $retyp[$sjyp]['ypid'];
            $ypsum = mt_rand(1, 2);//Dược phẩm rơi xuống số lượng
            Helpers\themDuocPham($sid,$ypid,$ypsum,$dblj);
            $huode .= "nhận được :<div class='ypys'>$ypname x$ypsum</div>";
        }
		}
       // $boss->bossexp = round($boss->bossexp / ($lvc+1),0);//Kinh nghiệm tính toán
	    $boss->bossexp = round($boss->bossgj / 2+$nguoiChoi->congKich/2+$nguoiChoi->phongNgu/2,0);
        if($boss->bossexp < 3){
            $boss->bossexp = 3;
        }
        $zdjg = 1;
    }
	
    $pzssh = $phurt - $pvbxx;//Người chơi lượng máu khấu trừ tình huống
	
    $sql = "update game1 set uhp = uhp - $pzssh  WHERE sid = '$sid'";//Viếng thăm kho số liệu, tên, lượng, id,
	
    $dblj->exec($sql);                                                     //Quan bế kho số liệu
    $nguoiChoi =  Helpers\layThongTinNguoiChoi($sid,$dblj);//Người ID Cùng với hắn thuộc tính
    if ($nguoiChoi->sinhMenh > $nguoiChoi->sinhMenhToiDa){//Phán đoán hút máu tràn ra
        $sql = "update game1 set uhp = $nguoiChoi->sinhMenhToiDa WHERE sid = '$sid'";//HP tràn ra một lần nữa tính toán
		//$cwjx = "update playerchongwu set cwhp = cwhp - $cwxl WHERE sid = '$sid'";//Sủng vật HP cũng lần nữa tới một chút, dư thừa...
        $dblj->exec($sql);//Quan bế kho số liệu
        $nguoiChoi->sinhMenh = $nguoiChoi->sinhMenhToiDa;//Cho giá trị
		
    }
	$cwxl = round($phurt*2.2);//Sủng vật bị công kích tổn thương tính toán
	$sql = "update playerchongwu set cwhp = cwhp - $cwxl  WHERE sid = '$sid'";
	$dblj->exec($sql);
	$cw = Helpers\layThongTinSungVat($nguoiChoi->cw,$dblj);
	    if ($cw->cwhp >0){
        $cwts="(-".$cwxl.')';
    }else{
        $cwts = 'Ợ ra rắm';
    }
	
	
	
	
    if ($nguoiChoi->sinhMenh <= 0){//Phán đoán chiến đấu trải qua, HP quá thấp thời điểm
        $zdjg = 0;//Nhảy chuyển tới$zdjg Chiến đấu trải qua
    }
}

if ($nguoiChoi->yp1!=0){
    $yaopin = Helpers\layThongTinDuocPhamCuaNguoiChoi($nguoiChoi->yp1,$sid,$dblj);
    $ypname1 = $yaopin->tenDuocPham.'('.$yaopin->ypsum.')';
}
if ($nguoiChoi->yp2!=0){
    $yaopin = Helpers\layThongTinDuocPhamCuaNguoiChoi($nguoiChoi->yp2,$sid,$dblj);
    $ypname2 = $yaopin->tenDuocPham.'('.$yaopin->ypsum.')';
}
if ($nguoiChoi->yp3!=0){
    $yaopin = Helpers\layThongTinDuocPhamCuaNguoiChoi($nguoiChoi->yp3,$sid,$dblj);
    $ypname3 = $yaopin->tenDuocPham.'('.$yaopin->ypsum.')';
}

// if ($nguoiChoi->jn1!=0){
    // $jineng = Helpers\layThongTinKyNangCuaNguoiChoi($nguoiChoi->jn1,$sid,$dblj);
    // if ($jineng){
        // $jnname1 = $jineng->jnname.'('.$jineng->jncount.')';
    // }
// }
// if ($nguoiChoi->jn2!=0){
    // $jineng = Helpers\layThongTinKyNangCuaNguoiChoi($nguoiChoi->jn2,$sid,$dblj);
    // if ($jineng){
        // $jnname2 = $jineng->jnname.'('.$jineng->jncount.')';
    // }
// }
// if ($nguoiChoi->jn3!=0){
    // $jineng = Helpers\layThongTinKyNangCuaNguoiChoi($nguoiChoi->jn3,$sid,$dblj);;
    // if ($jineng){
        // $jnname3 = $jineng->jnname.'('.$jineng->jncount.')';
    // }
// }

if (isset($zdjg)){//Nơi này là chiến đấu trải qua, có ba cái 0 1-1 Lựa chọn
    switch ($zdjg){
        case 1:

            player\changeexp($sid,$dblj,$boss->bossexp);
			player\changecwexp($nguoiChoi->cw,$boss->bossexp,$dblj);
            $huode.='nhận được  tu vi:'.$boss->bossexp.'<br/>';
		$sql = "update boss set bossmaxhp = bossmaxhp+100  WHERE bossid='$bossid'";//<!--Cho boss Tăng máu-Thêm thuộc tính-->
		$dblj->exec($sql);
		$sql = "update boss set bossgj = bossgj+5  WHERE bossid='$bossid'";//<!--Cho boss Tăng máu-Thêm thuộc tính-->
		$dblj->exec($sql);

            $html = <<<HTML
            Chiến đấu kết quả:<br/>
            Ngươi đánh bại$boss->tenBoss<br/>
            Chiến đấu thắng lợi！<br/>
            $huode
            $rwts<br/>
            <a href="?cmd=$gonowmid">Trở về trò chơi</a>
HTML;
            break;
        case 0:
		    if ($nguoiChoi->sinhMenh <= 0){
			$sql = "insert into ggliaotian(name,msg,uid) values(?,?,?)";
            $stmt = $dblj->prepare($sql);
            $stmt->execute(array('【Phụ trương】',"[{$boss->tenBoss}]Ngay tại trêu đùa[{$nguoiChoi->tenNhanVat}]...",'0'));//Hệ thống thông cáo
			}
            $html = <<<HTML
            Chiến đấu kết quả:<br/>
            Ngươi bị$boss->tenBoss Đánh chết<br/>
            Chiến đấu thất bại！<br/>
            Mời thiếu hiệp lại đến<br/>
            <br/>
            <a href="?cmd=$gonowmid">Trở về trò chơi</a>
HTML;
            break;
        case -1:
            $html = <<<HTML
            Chiến đấu kết quả:<br/>
            Ngươi đã trọng thương, không cách nào lại lần tiến hành chiến đấu！<br/>
            Mời thiếu hiệp khôi phục về sau lại đến<br/>
            <br/>
            <a href="?cmd=$gonowmid">Trở về trò chơi</a>
HTML;
            break;
    }
}

//Phán đoán, chấp hành không có sự sống giá trị lớn hơn 0, có thể tiến hành chiến đấu
else{
    if (isset($gphurt) && $gphurt>0){
        $ghurt='-'.$gphurt;
    }else{
        $ghurt='';
    }
    if (isset($cwhurt) && $cwhurt>0){
        $cwhurt='-'.$cwhurt;
    }else{
        $cwhurt='';
    }
    if (isset($phurt) && $phurt>0){
        $phurt='-'.$phurt;
    }else{
        $phurt='';
    }

    if ($pvbxx>0){
        $pvbxx="(+".$pvbxx.')';
    }else{
        $pvbxx = '';
    }

    if ($nguoiChoi->cw!=0){
        $cw = Helpers\layThongTinSungVat($nguoiChoi->cw,$dblj);
		
        if ($cwhurt!='' || $cw->cwhp>0){
            $cwhtml=<<<HTML
            ===================<br/>
            Sủng vật:$cw->cwname[lv:$cw->cwlv]<br/>
            Khí huyết:(<div class="hpys" style="display: inline">$cw->cwhp</div>/<div class="hpys" style="display: inline">$cw->cwmaxhp</div>)$cwhurt$cwts<br/>
            Công kích:($cw->cwgj)<br/>
            Phòng ngự:($cw->cwfy)<br/>
HTML;
        }

    }

if($boss->bosshp >=10000&&$boss->bosshp<11000){
$sql = "insert into ggliaotian(name,msg,uid) values(?,?,?)";
$stmt = $dblj->prepare($sql);
$stmt->execute(array('【Mới nhất】',"Có người phát hiện[{$nguoiChoi->tenNhanVat}]Ngay tại khiêu chiến{$boss->tenBoss}，Ai sẽ chiến thắng, để chúng ta rửa mắt mà đợi！",'0'));//Hệ thống thông cáo
}
if($boss->bosshp <2200 && $boss->bosshp>1700){
$sql = "insert into ggliaotian(name,msg,uid) values(?,?,?)";
$stmt = $dblj->prepare($sql);
$stmt->execute(array('【Mới nhất】',"Đoạt BOSS ,[{$nguoiChoi->tenNhanVat}]Muốn đánh giết{$boss->tenBoss},Sẽ rơi xuống bảo vật gì đâu？",'0'));//Hệ thống thông cáo
}


$tp = $encode->encode("cmd=taopao&bossid=$bossid&sid=$sid");
if ($cmd == 'taopao'){
	$sji = mt_rand(1,100);
    if ($sji>= 80 ){
		
        $tx = "Chạy trốn thành công";
		
		
		header("refresh:1;url=?cmd=$gonowmid");//Trì hoãn nhảy chuyển 1 Giây
    }else{
		$tx = 'Chạy trốn thất bại<br>';
	}
}

$yaopin = Helpers\layThongTinDuocPhamCuaNguoiChoi($nguoiChoi->yp1,$sid,$dblj);
$ypname1 = $yaopin->tenDuocPham.'('.$yaopin->ypsum.')';
$yaopin = Helpers\layThongTinDuocPhamCuaNguoiChoi($nguoiChoi->yp2,$sid,$dblj);
$ypname2 = $yaopin->tenDuocPham.'('.$yaopin->ypsum.')';
$yaopin = Helpers\layThongTinDuocPhamCuaNguoiChoi($nguoiChoi->yp3,$sid,$dblj);
$ypname3 = $yaopin->tenDuocPham.'('.$yaopin->ypsum.')';
$bl =  round ($boss->bosshp * 80 / $boss->bossmaxhp);

$html=<<<HTML
==BOSS Chiến đấu==<br/>
<IMG width="50" height="50" src="./images/cqgs.png"><BR>
<font style="box-shadow: inset {$bl}px 0px #dc3232;border-radius: 4px;">$boss->tenBoss</font>:[lv:$boss->bosslv]<br/>
Khí huyết:(<div class="hpys" style="display: inline">$boss->bosshp</div>/<div class="hpys" style="display: inline">$boss->bossmaxhp</div>)$pvbsb$pvbbj$ghurt<br/>
Công kích:($boss->bossgj)<br/>
Phòng ngự:($boss->bossfy)<br/>
Trước mắt công kích nhân số:<br/>
===================<br/>
$nguoiChoi->tenNhanVat [lv:$nguoiChoi->capDo]<br/>
Khí huyết:(<div class="hpys" style="display: inline">$nguoiChoi->sinhMenh</div>/<div class="hpys" style="display: inline">$nguoiChoi->sinhMenhToiDa</div>)$gwbj$phurt$pvbxx<br/>
Công kích:($nguoiChoi->congKich)<br/>
Phòng ngự:($nguoiChoi->phongNgu)<br/>
$tishihtml
<br/>

<ul>
$tishi
<li><a href="?cmd=$pgjcmd">Công kích</a></li><br>
$tx
<li><a href="?cmd=$tp">Chạy trốn</a></li><br/>

</ul>

<a href="?cmd=$useyp1">$ypname1</a>.<a href="?cmd=$useyp2">$ypname2</a>
<!--.<a href="?cmd=$useyp3">$ypname3</a><br/>-->
<br/>
HTML;
}
echo $html

?>