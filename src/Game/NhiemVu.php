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

$task = Helpers\layThongTinNhiemVu($rwid,$dblj);
$player = \Helpers\layThongTinNguoiChoi($sid,$dblj);
$ptask = Helpers\layThongTinNhiemVuCuaNguoiChoi($sid,$rwid,$dblj);
$rwdjarr = explode(',',$task->rwdj);
$rwyparr = explode(',',$task->rwyp);
$rwjlhtml = 'Nhiệm vụ ban thưởng：<br/>';
$jldjidarr = array();
$jldjslarr = array();
$jlypidarr = array();
$jlypslarr = array();
$jlzbslarr = array();

$gonowmid = $encode->encode("cmd=gomid&newmid=$player->idBanDoHienTai&sid=$sid");
$jieshourw = $encode->encode("cmd=task&nid=$nid&canshu=jieshou&rwid=$rwid&sid=$sid");
$tijiaorw = $encode->encode("cmd=task&nid=$nid&canshu=tijiao&rwid=$rwid&sid=$sid");
$rwhtml = '';
$tishi = '';
if ($ptask){
    if ($ptask->rwzt == 3){//Nhiệm vụ trạng thái lựa chọn
        echo "<a href=\"?cmd=$gonowmid\">Trở về trò chơi</a>";
        exit();
    }
}

if ($task->rwdj!=''){
    for ($i=0;$i<count($rwdjarr);$i++){
        $djarr = explode('|',$rwdjarr[$i]);
        $djid = $djarr[0];
        $djcount = $djarr[1];
        array_push($jldjidarr,$djid);
        array_push($jldjslarr,$djcount);
        $rwdj = Helpers\layThongTinDaoCu($djid,$dblj);
        $djinfo = $encode->encode("cmd=djinfo&djid=$rwdj->idDaoCu&sid=$sid");
        $rwjlhtml .="<div class='djys'><a href='?cmd=$djinfo'>$rwdj->tenDaoCu</a>x$djcount</div>";
    }
}

if ($task->rwyp!=''){
    for ($i=0;$i<count($rwyparr);$i++){
        $yparr = explode('|',$rwyparr[$i]);
        $ypid = $yparr[0];
        $ypcount = $yparr[1];
        array_push($jlypidarr,$ypid);
        array_push($jlypslarr,$ypcount);
        $rwyp = Helpers\layThongTinDuocPham($ypid,$dblj);
        $ypcmd = $encode->encode("cmd=ypinfo&ypid=$ypid&sid=$sid");
        $rwjlhtml .= "<div class='ypys'><a href='?cmd=$ypcmd'>$rwyp->tenDuocPham</a>x$ypcount</div>";
    }
}

if ($task->rwzb!=''){
    $sql = "select * from zhuangbei where zbid IN ($task->rwzb)";
    $cxjg = $dblj->query($sql);
    $ret = $cxjg->fetchAll(PDO::FETCH_ASSOC);
    for ($i=0;$i<count($ret);$i++){
        $zbid = $ret[$i]['zbid'];
        $zbname = $ret[$i]['zbname'];
        array_push($jlzbslarr,$zbid);
        $zbkzb = Helpers\layThongTinTrangBi($zbid,$dblj);
        $zbcmd = $encode->encode("cmd=zbinfo_sys&zbid=$zbkzb->idMauTrangBi&sid=$sid");
        $rwjlhtml.="<div class='zbys'><a href='?cmd=$zbcmd'>$zbname</a></div>";
    }
}
if ($task->rwexp!=''){
    $rwjlhtml.="Kinh nghiệm：$task->rwexp<br/>";
}
if ($task->rwyxb!=''){
    $rwjlhtml.="Linh thạch：$task->rwyxb<br/>";
}


if (isset($canshu)){
    switch ($canshu){
        case 'jieshou':
            if ($ptask){
                $tishi = 'Xin đừng nên lặp lại xác nhận nhiệm vụ';
                break;
            }
            $day = 0;
            if ($task->rwlx==2){
                $day = date('d');
            }
            $sql = "insert into playerrenwu(rwname,rwzl,rwdj,rwzb,rwexp,rwyxb,sid,rwzt,rwid,rwyq,rwcount,rwlx,`data`) VALUES ('$task->rwname','$task->rwzl','$task->rwdj','$task->rwzb','$task->rwexp','$task->rwyxb','$sid','1','$rwid','$task->rwyq','$task->rwcount','$task->rwlx',$day)";
            $ret = $dblj->exec($sql);
            $tishi = 'Tiếp nhận thành công';
            if ($task->rwzl==1){
                $daoju = Helpers\layThongTinDaoCuCuaNguoiChoi($sid,$task->rwyq,$dblj);
                if ($daoju){
                    if ($daoju->soLuong>0){
                        Helpers\thayDoiNhiemVu($rwid,$daoju->soLuong,$sid,$dblj);
                    }
                }
            }
            if ($task->rwzl==3){
                $sql = "update `playerrenwu` set rwzt = 2 WHERE rwid = $rwid and sid ='$sid'";
                $dblj->exec($sql);
            }
            break;
        case 'tijiao':
            if ($ptask->rwid==$rwid && $ptask->rwzt == 2){
                if ($ptask->rwnowcount>= $ptask->rwcount || $ptask->rwzl == 3){
                    $sql = "update playerrenwu set rwzt=3,rwnowcount=0 WHERE sid='$sid' AND rwid = $rwid";
                    $dblj->exec($sql);
                    Helpers\themKinhNghiem($sid,$dblj,$task->rwexp);
                    Helpers\thayDoiTienTroChoi(1,$task->rwyxb,$sid,$dblj);
                    if ($ptask->rwzl==1){
                        Helpers\giamDaoCu($ptask->rwyq,$ptask->rwcount,$sid,$dblj);
                    }
                    for ($i=0;$i<count($jldjidarr);$i++){
                        Helpers\themDaoCu($sid,$jldjidarr[$i],$jldjslarr[$i],$dblj);
                    }
                    for ($i=0;$i<count($jlypidarr);$i++){
                        Helpers\themDuocPham($sid,$jlypidarr[$i],$jlypslarr[$i],$dblj);
                    }
                    foreach ($jlzbslarr as $jlzbid){
                        Helpers\themTrangBi($sid,$jlzbid,$dblj);
                    }
                    echo "Nhiệm vụ hoàn thành, nhận được ：<br/>$rwjlhtml<a href=\"?cmd=$gonowmid\">Trở về trò chơi</a>";
                    exit();
                }

            }
            break;

    }
}

switch ($task->rwzl){
    case 1://Thu thập
        $rwyq = Helpers\layThongTinDaoCu($task->rwyq,$dblj);
		
        $rwhtml ="Thu thập$task->rwcount$rwyq->tenDaoCu";
        break;
    case 2://Đánh quái
        $gwmid = new Helpers\layThongTinBanDo();
		
        $rwyq = Helpers\layThongTinMauQuaiVat($task->rwyq,$dblj);
		
        $rwhtml ="Đánh giết$task->rwcount$rwyq->tenQuaiVat";
		
        break;
    case 3://Đối thoại
        $tjnpc = Helpers\layThongTinNpc($task->rwcount,$dblj);
		//$clmid = Helpers\layThongTinBanDo($task->rwqy,$dblj); //Thu hoạch địa đồ tin tức, ở đây dư thừa
		//$upmidlj = $encode->encode("cmd=gomid&newmid=$task->rwqy&sid=$sid");//Địa đồ//Thu hoạch đến Nhiệm vụ Địa đồ, tiến hành nhảy chuyển。<--<a href='?cmd=$upmidlj'>Truyền tống</a>-->
        $rwhtml ="Đi tìm$tjnpc->nname";//Biểu hiện nhiệm vụ tình huống, nhảy chuyển nhiệm vụ khu vực, khu vực tại sql, renwu Bên trong viết rwqy
        break;
}
$ptask = Helpers\layThongTinNhiemVuCuaNguoiChoi($sid,$rwid,$dblj);
$rwzthtml='';
    if ($ptask){
        if($ptask->rwzl != 3){
            $rwzthtml = "Tiến độ：$ptask->rwnowcount/$ptask->rwcount<br/>";
            $rwzthtml.= '<a href="?cmd='.$tijiaorw.'">Đưa ra</a>';
        }elseif($ptask->rwcount == $nid){
            $rwzthtml.= '<a href="?cmd='.$tijiaorw.'">Đưa ra</a>';
        }
    }else{
        $rwzthtml = <<<HTML
        <a href="?cmd=$jieshourw">Tiếp nhận</a>
HTML;
    }

$taskhtml = <<<HTML
【$task->rwname 】:<br/>
$task->rwinfo<br/>
$rwhtml<br/>
$tishi<br/>
$rwjlhtml<br/>
$rwzthtml
<a href="?cmd=$gonowmid" style="float:right;">Rời đi</a>

HTML;
echo $taskhtml;
?>