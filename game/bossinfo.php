<?php
require_once __DIR__ . '/../src/Helpers/TruongLaoHelper.php';
require_once __DIR__ . '/../src/Helpers/TrangBiHelper.php';
require_once __DIR__ . '/../src/Helpers/DaoCuHelper.php';
require_once __DIR__ . '/../src/Helpers/DuocPhamHelper.php';
use TuTaTuTien\Helpers as Helpers;

$boss = Helpers\layThongTinBoss($bossid, $dblj);
$pvb = $encode->encode("cmd=pvb&bossid=$bossid&sid=$sid");

if($boss->sinhMenh>0){
        $dlhtml = '';
        $zbhtml = '';
        $djhtml = '';
        $yphtml = '';
        if ($boss->trangBiRoi!=''){
            $zbarr = explode(',',$boss->trangBiRoi);
            foreach($zbarr as $newstr){
                $zbkzb = Helpers\layThongTinTrangBi($newstr, $dblj);
				//$zhuangbei = new \player\zhuangbei();
                $zbcmd = $encode->encode("cmd=zbinfo_sys&zbid=$zbkzb->idMauTrangBi&sid=$sid");
                $zbhtml .= "<a href='?cmd=$zbcmd'><font color='{$zbkzb->phamChat}'>$zbkzb->tenTrangBi</font></a>";
            }
            $dlhtml .=$zbhtml;
        }
        if ($boss->daoCuRoi!=''){
            $djarr = explode(',',$boss->daoCuRoi);
            foreach($djarr as $newstr){
                $dj = Helpers\layThongTinDaoCu($newstr, $dblj);
                $djinfo = $encode->encode("cmd=djinfo&djid=$dj->idDaoCu&sid=$sid");
                $djhtml .= "<font class='djys'><a href='?cmd=$djinfo'>$dj->tenDaoCu</a></font>";
            }
            $dlhtml .=$djhtml;
        }
        if ($boss->duocPhamRoi!=''){
            $yparr = explode(',',$boss->duocPhamRoi);
            foreach($yparr as $newstr){
                $yp = Helpers\layThongTinDuocPham($newstr, $dblj);
                $ypinfo = $encode->encode("cmd=ypinfo&ypid=$yp->idDuocPham&sid=$sid");

                $yphtml .= "<font class='ypys'><a href='?cmd=$ypinfo'>$yp->tenDuocPham</a></font>";
            }
            $dlhtml .=$yphtml;
        }

}else{
        $html = <<<HTML
        Quái vật đã bị những người khác công kích！<br/>
        Mời thiếu hiệp luyện tập một chút tốc độ tay a
        <br/>
        <a href="?cmd=$backcmd">Trở về trò chơi</a>
HTML;
}
$bossinfohtml = <<<HTML
[$boss->tenBoss]Công kích:{$boss->congKich}Phòng ngự:$boss->phongNgu<hr>
$boss->moTaBoss<hr>
<div style="border: #dcd4a1; border-style: dashed; border-top-width: 1px;
border-right-width: 1px; border-bottom-width: 1px; border-left-width: 1px">$dlhtml</div><hr>
<br/>
<!--<IMG width="25" height="15" src="./images/pk.png">-->
<a href="?cmd=$pvb" style="color: #ec0808;">Giàu có nhờ trời！</a>
<!--<IMG width="25" height="15" src="./images/pk.png">-->
<!--<IMG width="25" height="15" src="./images/ct.png">-->
<a style="float:right;" onClick="javascript :history.back(-1);">Quấy rầy...<IMG width="15" height="15" src="./images/ct.png"></a>
<br/>
HTML;
echo $bossinfohtml;

?>