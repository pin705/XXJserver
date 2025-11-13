<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/6/17
 * Time: 16:01
 */
require_once __DIR__ . '/../Helpers/NguoiChoiHelper.php';
require_once __DIR__ . '/../Helpers/DaoCuHelper.php';
use TuTaTuTien\Helpers as Helpers;

$nguoiChoi = Helpers\layThongTinNguoiChoi($sid, $dblj);
$gonowmid = $encode->encode("cmd=gomid&newmid=$nguoiChoi->idBanDoHienTai&sid=$sid");
if (isset($canshu)){
    $getyxb = 0;
    if ($canshu == "maichu1"){
        $ret = Helpers\xoaDaoCuCuaNguoiChoi($djid, 1, $sid, $dblj);
        if ($ret){
            $daoju = Helpers\layThongTinDaoCu($djid, $dblj);
            Helpers\thayDoiTienTroChoi(1, $daoju->giaTien, $sid, $dblj);
            $getyxb = $daoju->giaTien;
        }
    }
    if ($canshu == "maichu5"){
        $ret = Helpers\xoaDaoCuCuaNguoiChoi($djid, 5, $sid, $dblj);
        if ($ret){
            $daoju = Helpers\layThongTinDaoCu($djid, $dblj);
            Helpers\thayDoiTienTroChoi(1, $daoju->giaTien * 5, $sid, $dblj);
            $getyxb = $daoju->giaTien * 5;
        }
    }
    if ($canshu == "maichu10"){
        $ret = Helpers\xoaDaoCuCuaNguoiChoi($djid, 10, $sid, $dblj);
        if ($ret){
            $daoju = Helpers\layThongTinDaoCu($djid, $dblj);
            Helpers\thayDoiTienTroChoi(1, $daoju->giaTien * 10, $sid, $dblj);
            $getyxb = $daoju->giaTien * 10;
        }
    }
    echo "Bán  thành công, nhận được {$getyxb}Linh thạch<br/>";
}

$sql = "select * from playerdaoju WHERE sid = '$sid'";
$cxjg = $dblj->query($sql);
if ($cxjg){
    $retdj = $cxjg->fetchAll(PDO::FETCH_ASSOC);
}
$djhtml = '';
$hangshu = 0;
for ($i=0;$i<count($retdj);$i++){
    $djname = $retdj[$i]['djname'];
    $djid = $retdj[$i]['djid'];
    $djsum = $retdj[$i]['djsum'];
    if ($djsum>0){
        $hangshu = $hangshu + 1;
        $chakandj = $encode->encode("cmd=djinfo&djid=$djid&uid=$nguoiChoi->idNguoiDung&sid=$sid");
        $maichu1 = $encode->encode("cmd=getbagdj&canshu=maichu1&djid=$djid&uid=$nguoiChoi->idNguoiDung&sid=$sid");
        $maichu5 = $encode->encode("cmd=getbagdj&canshu=maichu5&djid=$djid&uid=$nguoiChoi->idNguoiDung&sid=$sid");
        $maichu10 = $encode->encode("cmd=getbagdj&canshu=maichu10&djid=$djid&uid=$nguoiChoi->idNguoiDung&sid=$sid");
        $djhtml .="[$hangshu]<a href='?cmd=$chakandj'>{$djname}x{$djsum}</a><a href='?cmd=$maichu1'>Bán  1</a>
		<!--<a href='?cmd=$maichu5'>Bán  5</a><a href='?cmd=$maichu10'>Bán  10</a>-->
		<br/>";
    }

}
$getbagzbcmd = $encode->encode("cmd=getbagzb&sid=$sid");
$getbagypcmd = $encode->encode("cmd=getbagyp&sid=$sid");
$getbagjncmd = $encode->encode("cmd=getbagjn&sid=$sid");
$getbagydcmd = $encode->encode("cmd=getbagyd&sid=$sid");
$bagdjhtml =<<<HTML
<font size="2"><div class="menu"><a href="?cmd=$getbagzbcmd">Trang bị</a><a href="#" style="background-color: gray;">Đạo cụ</a><a href="?cmd=$getbagypcmd">Dược phẩm</a><a href="?cmd=$getbagjncmd">Kỹ năng</a><a href="?cmd=$getbagydcmd">Đan dược</a></div></font><br>
<br/>
$djhtml
<br/>
<a href="#" onClick="javascript:history.back(-1);">Trở lại</a>
        <a href="game.php?cmd=$gonowmid" style="float:right;background-color:#cff3d2;color: #755d5d;" >Trở về trò chơi</a>
HTML;
echo $bagdjhtml;