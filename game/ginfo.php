<?php
require_once __DIR__ . '/../bootstrap.php';
use TuTaTuTien\Helpers as Helpers;
use TuTaTuTien\Core\GameHandler;

$game = new GameHandler($dblj, $encode, $sid);
$player = $game->getNguoiChoi();
$backcmd = $game->getLinkQuayVeBanDo();

// Validate bản đồ
$validation = $game->validateBanDo($nowmid);
if (!$validation['valid']) {
    echo $validation['message'];
    exit();
}
if (isset($gid)){
    $guaiwu = Helpers\layThongTinQuaiVat($gid, $dblj);
    $yguaiwu = Helpers\layThongTinMauQuaiVat($gyid, $dblj);
    $pvecmd=$encode->encode("cmd=pve&gid=$gid&sid=$sid&nowmid=$nowmid");
    if ($yguaiwu->ginfo==''){
        $yguaiwu->ginfo = 'Không có bất kỳ cái gì danh khí';
    }
    
    if ($guaiwu->sid !='' or $guaiwu->gname==''){
        $html = <<<HTML
        Quái vật đã bị những người khác công kích！<br/>
        Mời thiếu hiệp luyện tập một chút tốc độ tay a
        <br/>
        <a href="?cmd=$backcmd">Trở về trò chơi</a>
HTML;
    }  else{
        $dlhtml = '';
        $zbhtml = '';
        $djhtml = '';
        $yphtml = '';
        if ($yguaiwu->trangBiRoi!=''){
            $zbarr = explode(',',$yguaiwu->trangBiRoi);
            foreach($zbarr as $newstr){
                $zbkzb = Helpers\layThongTinTrangBi($newstr, $dblj);
				//$zhuangbei = new \player\zhuangbei();
                $zbcmd = $encode->encode("cmd=zbinfo_sys&zbid=$zbkzb->idMauTrangBi&sid=$sid");
                $zbhtml .= "<a href='?cmd=$zbcmd'><font color='{$zbkzb->phamChat}'>$zbkzb->tenTrangBi</font></a>";
            }
            $dlhtml .=$zbhtml;
        }
        if ($yguaiwu->daoCuRoi!=''){
            $djarr = explode(',',$yguaiwu->daoCuRoi);
            foreach($djarr as $newstr){
                $dj = Helpers\layThongTinDaoCu($newstr, $dblj);
                $djinfo = $encode->encode("cmd=djinfo&djid=$dj->idDaoCu&sid=$sid");
                $djhtml .= "<font class='djys'><a href='?cmd=$djinfo'>$dj->tenDaoCu</a></font>";
            }
            $dlhtml .=$djhtml;
        }
        if ($yguaiwu->duocPhamRoi!=''){
            $yparr = explode(',',$yguaiwu->duocPhamRoi);
            foreach($yparr as $newstr){
                $yp = Helpers\layThongTinDuocPham($newstr, $dblj);
                $ypinfo = $encode->encode("cmd=ypinfo&ypid=$yp->idDuocPham&sid=$sid");

                $yphtml .= "<font class='ypys'><a href='?cmd=$ypinfo'>$yp->tenDuocPham</a></font>";
            }
            $dlhtml .=$yphtml;
        }

        if ($dlhtml == ''){
            $dlhtml = 'Nên quái vật nói ngươi tùy ý, ta chính là không cho ngươi trang bị, thà chết không theo。<br/>';
        }
	


	
$sjhtml =<<<HTML
<font face=Thể chữ lệ color="ae2d61">
<!--<marquee direction="left" style="background: #89EE00;font-size:30 px"></marquee></font>--><!--Động thái văn tự đầu-->
<font color="#09BDAA">
<body> 
<script language="JavaScript">
<!-- Hide
var a = Math.random() + ""
var rand1 = a.charAt(15)
quotes = new Array
quotes[0] = 'Im lặng là vàng, ta đều trầm mặc lâu như vậy, làm sao lại không thấy vàng。'
quotes[1] = 'Nhiều hút thuốc, ít vận động, ngươi lạnh, lão bà ta giúp ngươi chiếu cố^0^'
quotes[2] = 'Ngươi dáng dấp còn có thể, bất quá ta cảm giác vẫn là ngươi làm mặt màng thời điểm đẹp mắt。'
quotes[3] = 'Cho sự vật giao phó dạng gì giá trị, mọi người liền có dạng gì hành động。Đem khó khăn nâng tại trên đầu, nó chính là ngập đầu thạch；Đem khó khăn giẫm tại dưới chân, nó chính là bàn đạp。Xuất phát chạy dẫn trước một bước nhỏ, nhân sinh dẫn trước một bước dài。'
quotes[4] = 'Cái gì đều là giả, chỉ có nghèo là thật。'
quotes[5] = 'Cười cho mình nhìn。Nước mắt cho mình lưu。Không dối trá。Không làm bộ。'
quotes[6] = 'Thật phi thường cảm tạ đã từng đả kích ta người, để cho ta học xong đả kích đừng tiểu quái...。'
quotes[7] = 'Sáng sớm cho mình một cái mỉm cười, gieo xuống một ngày 旳 Ánh nắng。'
quotes[8] = 'Bằng hữu nếu như có thể bán, ta đoán chừng còn có thể phát bút tiểu tài。'
quotes[9] = 'Có đôi khi cảm thấy mình biến dạng, xuất ra thẻ căn cước xem xét, phát hiện quá lo lắng。'
quotes[10] = 'Nữ nhân không tốn, sao là xinh đẹp như hoa。Nam nhân không xấu, sao là hậu thế。'
quotes[12] = 'Tôm bự ngươi bây giờ muốn làm cái gì thì làm cái đó đi thôi, muốn ăn cái gì tranh thủ thời gian nắm chặt ăn chút...。'
quotes[13] = 'Nếu có kiếp sau, ta muốn làm đầu chăn mền, không phải nằm ở trên giường chính là tại phơi nắng！'
quotes[14] = 'Bất luận cái gì phim kinh dị đều không chống đỡ được từ cửa sổ đột nhiên toát ra sơn đại vương。'
quotes[15] = 'Thật phi thường cảm tạ đã từng đả kích ta người, để cho ta học xong đả kích đừng tiểu quái...。'
var quote = quotes[rand1]
</script>
<script language="JavaScript">
<!-- Hide
document.write(quote)
</script>
</body>
</font>
<font color="#89EE00">---$yguaiwu->gname</font>
</font>
HTML;
		
		
		
		
		
		
		
		
		
		$gonowmid = $encode->encode("cmd=gomid&newmid=$player->idBanDoHienTai&sid=$sid");
        $html = <<<HTML
        [<font color="#F13F0B">$yguaiwu->tenQuaiVat</font>] · $yguaiwu->gioiTinh<br/>
        Đẳng cấp:$yguaiwu->capDo<br/>
		Công kích:$guaiwu->congKich<br/>
		Phòng ngự:$guaiwu->phongNgu<br/>
		Cảnh giới:$guaiwu->canhGioi<br/>
		Tin tức:<FONT style="TEXT-DECORATION: line-through">$yguaiwu->moTa</font>Làm ngươi nhìn cái này gặp đoạn văn tự, mới phát hiện chữ này chút đều sai là loạn。
		$sjhtml<br>
        
        =========Rơi xuống========<br/>
        $dlhtml<br>
		=====================<br>
		<a href="?cmd=$pvecmd" style="color: #f50707" >Công kích</a>
        <a href="?cmd=$pvecmd" style="float:right;color: #f50707" >Công kích</a>
		<br><br>
		<a href="#" onClick="javascript:history.back(-1);" >Trở lại</a><!--Cư trái-float:left;-->
            <a href="game.php?cmd=$gonowmid" style="float:right;" >Làm lương nhân</a>
HTML;
    }
}
echo $html;
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 202 1 myj /6/11
 * Time: 10:08
 */
?>

