<?php
require_once __DIR__ . '/../Helpers/NguoiChoiHelper.php';
require_once __DIR__ . '/../Helpers/TrangBiHelper.php';
require_once __DIR__ . '/../Helpers/DaoCuHelper.php';
require_once __DIR__ . '/../Helpers/DuocPhamHelper.php';
require_once __DIR__ . '/../Helpers/QuaiVatHelper.php';
require_once __DIR__ . '/../Helpers/TruongLaoHelper.php';
require_once __DIR__ . '/../Helpers/NhiemVuHelper.php';
require_once __DIR__ . '/../Helpers/BanDoHelper.php';
require_once __DIR__ . '/../Helpers/SungVatHelper.php';
require_once __DIR__ . '/../Helpers/KyNangHelper.php';
require_once __DIR__ . '/../Helpers/ClubHelper.php';
use TuTaTuTien\Helpers as Helpers;

$player =  Helpers\layThongTinNguoiChoi($sid,$dblj);
$gonowmid = $encode->encode("cmd=gomid&newmid=$player->idBanDoHienTai&sid=$player->sid");
$cxmid = Helpers\layThongTinBanDo($player->idBanDoHienTai,$dblj);
$cxqy = Helpers\layThongTinKhuVuc($cxmid->mqy,$dblj);
$gorehpmid = $encode->encode("cmd=gomid&newmid=$cxqy->mid&sid=$player->sid");
$rwts = '';
$cwhtml='';
$pgjcmd = $encode->encode("cmd=pvegj&gid=$gid&sid=$player->sid&nowmid=$nowmid");
$guaiwu = Helpers\layThongTinQuaiVat($gid,$dblj);
$yguaiwu = new Helpers\layThongTinQuaiVat();

if ($guaiwu->gyid){
    $yguaiwu = player\getyguaiwu($guaiwu->gyid,$dblj);
}
$huode = '';
$useyp1 = $encode->encode("cmd=pve&canshu=useyp&ypid=$player->yp1&sid=$sid&gid=$gid&nowmid=$nowmid");
$useyp2 = $encode->encode("cmd=pve&canshu=useyp&ypid=$player->yp2&sid=$sid&gid=$gid&nowmid=$nowmid");
$useyp3 = $encode->encode("cmd=pve&canshu=useyp&ypid=$player->yp3&sid=$sid&gid=$gid&nowmid=$nowmid");

$usejn1 = $encode->encode("cmd=pvegj&canshu=usejn&jnid=$player->jn1&sid=$sid&gid=$gid&nowmid=$nowmid");
$usejn2 = $encode->encode("cmd=pvegj&canshu=usejn&jnid=$player->jn2&sid=$sid&gid=$gid&nowmid=$nowmid");
$usejn3 = $encode->encode("cmd=pvegj&canshu=usejn&jnid=$player->jn3&sid=$sid&gid=$gid&nowmid=$nowmid");

$ypname1 = 'Dược phẩm 1';
$ypname2 = 'Dược phẩm 2';
$ypname3 = 'Dược phẩm 3';

$jnname1 = 'Phù lục 1';
$jnname2 = 'Phù lục 2';
$jnname3 = 'Phù lục 3';

$cwhurt = '';
$tishihtml='';
if ($nowmid!=$player->idBanDoHienTai){
    $html = <<<HTML
        Mời bình thường chơi đùa！<br/>
        <br/>
        <a href="?cmd=$gonowmid">Trở về trò chơi</a>
HTML;
    echo $html;
    exit();
}

if (($guaiwu->sid!=$player->sid && $guaiwu->sid!='') || ($guaiwu->gid=='')){
        $html = <<<HTML
        Quái vật đã bị những người khác công kích！<br/>
        Mời thiếu hiệp luyện tập một chút tốc độ tay a
        <br/>
        <a href="?cmd=$gonowmid">Trở về trò chơi</a>
HTML;
        exit($html);
}
$pvebj = '';
$pvexx = '';

if (isset($canshu)){

    if ($canshu == 'useyp'){
        $ret = Helpers\suDungDuocPham($ypid,1,$sid,$dblj);
        $player =  Helpers\layThongTinNguoiChoi($sid,$dblj);
    }
}
//Sủng vật công kích cái gì
if($cmd=='pve' && $guaiwu->sid==''){

    if ($player->capDo >= 10 && $player->sinhMenh <=0){
        $zdjg = -1;
    }else{
        $sql = "update midguaiwu set sid = '$sid' WHERE id='$gid'";
        $dblj->exec($sql);
        $cw = Helpers\layThongTinSungVat($player->cw,$dblj);
        Helpers\thayDoiThuocTinhSungVat('cwhp',$cw->cwmaxhp,$player->cw,$dblj);
        if($player->capDo <= 10){
            Helpers\thayDoiThuocTinhNguoiChoi('uhp',$player->sinhMenhToiDa,$sid,$dblj);
            $player =  Helpers\layThongTinNguoiChoi($sid,$dblj);
        }
    }

}elseif ($cmd == 'pvegj' && $gid != 0){
    //Đòn công kích bình thường
    $hurt = false;
    $ghurt = 0;
    $jineng = Helpers\taoMoiKyNang();

    if (isset($canshu)){
        switch ($canshu){
            case 'usejn':
                $ret = Helpers\giamKyNang($jnid,1,$sid,$dblj);
                if ($ret){
                    $jineng = Helpers\layThongTinKyNangCuaNguoiChoi($jnid,$sid,$dblj);
                    $tishihtml = "Sử dụng kỹ năng：$jineng->jnname<br/>";
                }else{
                    $tishihtml = "Kỹ năng số lượng không đủ<br/>";
                }

                break;
        }
    }

    $player->congKich +=$jineng->jngj;
    $player->phongNgu +=$jineng->jnfy;
    $player->baoKich +=$jineng->jnbj;
    $player->hutMau +=$jineng->jnxx;

    $lvc = $player->capDo - $guaiwu->capDo;
	//Công kích tổn thương tính toán
    if ($lvc <= 0){
        $lvc = 0;
    }

    $phurt = 0 ;
	

    $phurt = round($guaiwu->congKich - ($player->phongNgu * 0.75),0);
	
    if ($phurt < $guaiwu->congKich*0.15){
        $phurt = round($guaiwu->congKich*0.15);
    }

    $ran = mt_rand(1,200);//Khống chế bạo kích xác suất
    if ($player->baoKich >= $ran){
        $player->congKich = round($player->congKich * 1.72);
        $pvebj = 'Bạo kích';
    }
     $cw = Helpers\layThongTinSungVat($player->cw,$dblj);//Dẫn vào sủng vật, phán đoán sủng vật chết sống
	 if ($cw->cwhp > 0){
        $cwgj = round($cw->cwgj * 1);   
    }else{
        $cwgj = 0 ;
    }
	 
	 
    $gphurt = round($cwgj + $player->congKich - ($guaiwu->phongNgu * 0.75),0);//Nhân vật chính công kích quái vật chụp máu tình huống, bản thân công kích+Sủng vật công kích
    if ($gphurt < $player->congKich*0.15){
        $gphurt = round( $player->congKich * 0.15);
    }
    $pvexx = ceil($gphurt * ($player->hutMau/200) );//Khống chế hút máu cường độ

    if ($phurt <= 0){
        $hurt = true;
    }

    if ($phurt < $pvexx){
        $pvexx = $phurt - 7;

        if ($pvexx<0){
            $pvexx = 0;
			
        }
    }
     $cw = Helpers\layThongTinSungVat($player->cw,$dblj);
    $sql = "update midguaiwu set ghp = ghp - {$gphurt} WHERE id='$gid'";
    $dblj->exec($sql);
    $guaiwu = Helpers\layThongTinQuaiVat($gid,$dblj);
    if ($guaiwu->ghp<=0){//Quái vật tử vong, ban thưởng tính toán
        $sql = "delete from midguaiwu where id = $gid AND sid='$player->sid'";//Xóa bỏ quái vật
        $dblj->exec($sql);
		$sjyxb = mt_rand(1,200);
        $yxb = round($guaiwu->capDo*22.5) + $sjyxb;//Tiền trò chơi linh thạch chiến đấu sau tính toán
        if ($hurt || $lvc >=30){//Phán đoán quái vật đẳng cấp nhỏ hơn người chơi 30 Cấp, không linh thạch rơi xuống
            $yxb = 0;
        }

        $ret = Helpers\thayDoiTienTroChoi(1,$yxb,$sid,$dblj);
        if ($ret){
            $huode .= "nhận được  linh thạch:$yxb<br/>";
        }
        $taskarr = Helpers\layDanhSachNhiemVuNguoiChoi($sid,$dblj);
        Helpers\thayDoiNhiemVu(2,$guaiwu->gyid,1,$sid,$dblj);
        for ($i=0;$i<count($taskarr);$i++){
            $rwyq = $taskarr[$i]['rwyq'];
            $rwid = $taskarr[$i]['rwid'];
            $rwzl = $taskarr[$i]['rwzl'];
            $rwzt = $taskarr[$i]['rwzt'];
            if ($rwyq==$guaiwu->gyid && $rwzl==2 && $rwzt!=3){
                $rwnowcount = $taskarr[$i]['rwnowcount']+ 1;
                $rwts = $taskarr[$i]['rwname'].'('.$rwnowcount."/".$taskarr[$i]['rwcount'].')<br/>';
                break;
            }
        }
		
$jisha = <<<HTML

<IMG width='15' height='15' src='./images/jisha.png' >

HTML;
		
		
		
		//Trang bị tính toán

        $sjjv = mt_rand(1,120);
        if ($yguaiwu->dljv >=$sjjv && $yguaiwu->trangBiRoi != ''){
            $sql = "select * from zhuangbei WHERE zbid in ($yguaiwu->trangBiRoi)";
            $cxdljg = $dblj->query($sql);
            if ($cxdljg){
				
                $retzb = $cxdljg->fetchAll(PDO::FETCH_ASSOC);
                $sjdl = mt_rand(0,count($retzb)-1);
                $zbname = $retzb[$sjdl]['zbname'];
                $zbid = $retzb[$sjdl]['zbid'];
                $zbnowid = player\addzb($sid,$zbid,$dblj);
				$zbys = Helpers\layThongTinTrangBi($zbid,$dblj);//Thu hoạch trang bị ID Địa chỉ, đây là dùng để thu hoạch sắc thái
                $chakanzb = $encode->encode("cmd=chakanzb&zbnowid=$zbnowid&uid=$player->idNguoiDung&sid=$sid");
			$huode .= "nhận được :".'<a href="?cmd='.$chakanzb.'"><font color='.$zbys->phamChat.' >'.$zbname .'</font></a><br>';//Trang bị yếu tố
			        $zbpz = $zbys->congKich + $zbys->phongNgu + $zbys->hutMau +$zbys->baoKich ;//Viết một cái thông cáo, nhận được  trang bị
					if ($zbpz >=5){
			        $sql = "insert into ggliaotian(name,msg,uid) values(?,?,?)";
                    $stmt = $dblj->prepare($sql);
                    $stmt->execute(array('【Phụ trương】',"[{$player->tenNhanVat}]{$jisha}[{$guaiwu->tenQuaiVat}]nhận được [{$zbname}]Khiến người ghen tị。",'0'));//Hệ thống thông cáo
					}
            }
        }
		//Đạo cụ tính toán
        $sjjv = mt_rand(1,180);
        if ($yguaiwu->djjv >= $sjjv && $yguaiwu->daoCuRoi != ''){
            $sql = "select * from daoju WHERE djid in ($yguaiwu->daoCuRoi)";
            $cxdljg = $dblj->query($sql);
            if ($cxdljg){
                $retdj = $cxdljg->fetchAll(PDO::FETCH_ASSOC);
                $sjdj = mt_rand(0,count($retdj)-1);
                $djname = $retdj[$sjdj]['djname'];
                $djid = $retdj[$sjdj]['djid'];
                if ($djid == 1 && $lvc == 0){
                    goto yp;
                }
                $djsum = mt_rand(1,2);
                Helpers\themDaoCu($sid,$djid,$djsum,$dblj);
                $huode .= "nhận được :<div class='djys'>$djname x$djsum</div>";//Sắc thái yếu tố

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
        if ($yguaiwu->ypjv >= $sjjv && $yguaiwu->duocPhamRoi != ''){
            $sql = "select * from yaopin WHERE ypid in ($yguaiwu->duocPhamRoi)";
            $cxdljg = $dblj->query($sql);
            $retyp = $cxdljg->fetchAll(PDO::FETCH_ASSOC);
            $sjdj = mt_rand(0, count($retyp) - 1);
            $ypname = $retyp[$sjdj]['ypname'];
            $ypid = $retyp[$sjdj]['ypid'];
            $ypsum = mt_rand(1, 2);//Dược phẩm rơi xuống số lượng
            Helpers\themDuocPham($sid,$ypid,$ypsum,$dblj);
            $huode .= "nhận được :<div class='ypys'>$ypname x$ypsum</div>";
        }

        $guaiwu->gexp = round($guaiwu->gexp / ($lvc+1),0);//Kinh nghiệm tính toán
        if($guaiwu->gexp < 3){
            $guaiwu->gexp = 3;
        }
        $zdjg = 1;
    }
	
    $pzssh = $phurt - $pvexx;//Lượng biến đổi
	
    $sql = "update game1 set uhp = uhp - $pzssh  WHERE sid = '$sid'";//Viếng thăm kho số liệu, tên, lượng, id,
	
    $dblj->exec($sql);                                                     //Quan bế kho số liệu
    $player =  Helpers\layThongTinNguoiChoi($sid,$dblj);//Người ID Cùng với hắn thuộc tính
    if ($player->sinhMenh > $player->sinhMenhToiDa){//Phán đoán hút máu tràn ra
        $sql = "update game1 set uhp = $player->sinhMenhToiDa WHERE sid = '$sid'";//HP tràn ra một lần nữa tính toán
		//$cwjx = "update playerchongwu set cwhp = cwhp - $cwxl WHERE sid = '$sid'";//Sủng vật HP cũng lần nữa tới một chút, dư thừa...
        $dblj->exec($sql);//Quan bế kho số liệu
        $player->sinhMenh = $player->sinhMenhToiDa;//Cho giá trị
		
    }
	$cwxl = round($phurt*2.2);//Sủng vật bị công kích tổn thương tính toán
	$sql = "update playerchongwu set cwhp = cwhp - $cwxl  WHERE sid = '$sid'";
	$dblj->exec($sql);
	$cw = Helpers\layThongTinSungVat($player->cw,$dblj);
	    if ($cw->cwhp >0){
        $cwts="(-".$cwxl.')';
    }else{
        $cwts = 'Ợ ra rắm';
    }
	
	
	
	
    if ($player->sinhMenh <= 0){//Phán đoán chiến đấu trải qua, HP quá thấp thời điểm
        $zdjg = 0;//Nhảy chuyển tới$zdjg Chiến đấu trải qua
    }
}

if ($player->yp1!=0){
    $yaopin = Helpers\layThongTinDuocPhamCuaNguoiChoi($player->yp1,$sid,$dblj);
    $ypname1 = $yaopin->tenDuocPham.'('.$yaopin->ypsum.')';
}
if ($player->yp2!=0){
    $yaopin = Helpers\layThongTinDuocPhamCuaNguoiChoi($player->yp2,$sid,$dblj);
    $ypname2 = $yaopin->tenDuocPham.'('.$yaopin->ypsum.')';
}
if ($player->yp3!=0){
    $yaopin = Helpers\layThongTinDuocPhamCuaNguoiChoi($player->yp3,$sid,$dblj);
    $ypname3 = $yaopin->tenDuocPham.'('.$yaopin->ypsum.')';
}

if ($player->jn1!=0){
    $jineng = Helpers\layThongTinKyNangCuaNguoiChoi($player->jn1,$sid,$dblj);
    if ($jineng){
        $jnname1 = $jineng->jnname.'('.$jineng->jncount.')';
    }
}
if ($player->jn2!=0){
    $jineng = Helpers\layThongTinKyNangCuaNguoiChoi($player->jn2,$sid,$dblj);
    if ($jineng){
        $jnname2 = $jineng->jnname.'('.$jineng->jncount.')';
    }
}
if ($player->jn3!=0){
    $jineng = Helpers\layThongTinKyNangCuaNguoiChoi($player->jn3,$sid,$dblj);;
    if ($jineng){
        $jnname3 = $jineng->jnname.'('.$jineng->jncount.')';
    }
}

if (isset($zdjg)){//Nơi này là chiến đấu trải qua, có ba cái 0 1-1 Lựa chọn
    switch ($zdjg){
        case 1:

            player\changeexp($sid,$dblj,$guaiwu->gexp);
			player\changecwexp($player->cw,$guaiwu->gexp,$dblj);
            $huode.='nhận được  tu vi:'.$guaiwu->gexp.'<br/>';

            $html = <<<HTML
            Chiến đấu kết quả:<br/>
            Ngươi đánh chết$guaiwu->tenQuaiVat<br/>
            Chiến đấu thắng lợi！<br/>
            $huode
            $rwts<br/>
            <a href="?cmd=$gonowmid">Trở về trò chơi</a>
HTML;
            break;
        case 0:
            $html = <<<HTML
            Chiến đấu kết quả:<br/>
            Ngươi bị$guaiwu->tenQuaiVat Đánh chết<br/>
            Chiến đấu thất bại！<br/>
            Mời thiếu hiệp lại đến<br/>
            <br/>
            <a href="?cmd=$gorehpmid">Trở về trò chơi</a>
HTML;
            break;
        case -1:
            $html = <<<HTML
            Chiến đấu kết quả:<br/>
            Ngươi đã trọng thương, không cách nào lại lần tiến hành chiến đấu！<br/>
            Mời thiếu hiệp khôi phục về sau lại đến<br/>
            <br/>
            <a href="?cmd=$gorehpmid">Trở về trò chơi</a>
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

    if ($pvexx>0){
        $pvexx="(+".$pvexx.')';
    }else{
        $pvexx = '';
    }

    if ($player->cw!=0){
        $cw = Helpers\layThongTinSungVat($player->cw,$dblj);
		
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
	
	
	
	
$djshtml = <<<HTML
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Máy bấm giờ</title>

<script type="text/javascript" src="./chajian/djs/js/jquery.js"></script>
<script type="text/javascript" src="./chajian/djs/js/time_js.js"></script>

<link type="text/css" rel="stylesheet" href="./chajian/djs/css/time_css.css" />

</head>

<body>

<div class="game_time">

	<div class="hold">
		<div class="pie pie1"></div>
	</div>

	<div class="hold">
		<div class="pie pie2"></div>
	</div>

	<div class="bg"> </div>
	
	<div class="time"></div>
	
</div>

<script type="text/javascript">
countDown();
</script>

</body>

HTML;
//Phía trên là đếm ngược một đoạn
	
	
	
	
	
$gwxl = $guaiwu->ghp / $guaiwu->gmaxhp *100 ;
$html = <<<HTML
==Chiến đấu==<br/>
$guaiwu->tenQuaiVat [lv:$guaiwu->capDo]<br/>
<link rel="stylesheet"  href="./css/css.css">
<div class = "dise" width="100" height="100%">
<img class = "skills"  width="$gwxl%" height="100%"></img >
</div> 
Khí huyết:(<div class="hpys" style="display: inline">$guaiwu->ghp</div>/<div class="hpys" style="display: inline">$guaiwu->gmaxhp</div>)$pvebj$ghurt<br/>
Công kích:($guaiwu->congKich)<br/>
Phòng ngự:($guaiwu->phongNgu)<br/>
===================<br/>
$player->tenNhanVat [lv:$player->capDo]<br/>
Khí huyết:(<div class="hpys" style="display: inline">$player->sinhMenh</div>/<div class="hpys" style="display: inline">$player->sinhMenhToiDa</div>)$phurt$pvexx<br/>
Công kích:($player->congKich)<br/>
Phòng ngự:($player->phongNgu)<br/>
$tishihtml
$cwhtml
<meta http-equiv="refresh" content="2"><!--Tự động công kích làm mới khoảng cách-->
<br/>
<ul>
<li><a href="?cmd=$gonowmid">Chạy trốn</a></li><br/>
<li><a href="?cmd=$pgjcmd">Công kích</a></li>
</ul>
<a href="?cmd=$usejn1">$jnname1</a>.<a href="?cmd=$usejn2">$jnname2</a>.<a href="?cmd=$usejn3">$jnname3</a><br/>
<a href="?cmd=$useyp1">$ypname1</a>.<a href="?cmd=$useyp2">$ypname2</a>.<a href="?cmd=$useyp3">$ypname3</a><br/>
<br/>
HTML;


}
echo $html;
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2021 /6/11
 * Time: 12:09
 */
?>