<?php
require_once __DIR__ . '/../Helpers/NguoiChoiHelper.php';
require_once __DIR__ . '/../Helpers/TrangBiHelper.php';
require_once __DIR__ . '/../Helpers/DaoCuHelper.php';
require_once __DIR__ . '/../Helpers/DuocPhamHelper.php';
require_once __DIR__ . '/../Helpers/SungVatHelper.php';
require_once __DIR__ . '/../Helpers/NhiemVuHelper.php';
use TuTaTuTien\Helpers as Helpers;

$task = Helpers\layThongTinNhiemVuCuaNguoiChoi($sid,$rwid,$dblj);
$cs = Helpers\layThongTinNhiemVu($rwid,$dblj);
$player = \Helpers\layThongTinNguoiChoi($sid,$dblj);

$gonowmid = $encode->encode("cmd=goto_map&newmid=$player->idBanDoHienTai&sid=$sid");
$rwdjarr = explode(',',$task->rwdj);
$rwjlhtml = 'Nhiệm vụ ban thưởng：<br/>';
$rwhtml='';
if ($task->rwdj!=''){
    for ($i=0;$i<count($rwdjarr);$i++){
        $djarr = explode('|',$rwdjarr[$i]);
        $djid = $djarr[0];
        $djcount = $djarr[1];
        $rwdj = Helpers\layThongTinDaoCu($djid,$dblj);
        $djinfo = $encode->encode("cmd=item_info&djid=$rwdj->idDaoCu&sid=$sid");
        $rwjlhtml .="<div class='djys'><a href='?cmd=$djinfo'>$rwdj->tenDaoCu</a>x$djcount</div>";
    }
}
if ($task->rwzb!=''){
    $sql = "select * from zhuangbei where zbid IN ($task->rwzb)";
    $cxjg = $dblj->query($sql);
    $ret = $cxjg->fetchAll(PDO::FETCH_BOUND);
    for ($i=0;$i<count($ret);$i++){
        $zbname = $ret[$i]['zbname'];
        $zbid = $ret[$i]['zbid'];
        $zbcmd = $encode->encode("cmd=system_equipment_info&zbid=$zbid&sid=$sid");
        $rwjlhtml.="<div class='zbys'><a href='?cmd=$zbcmd'>$zbname</a></div>";
    }
}
if ($task->rwexp!=''){
    $rwjlhtml.="Kinh nghiệm：$task->rwexp<br/>";
}
if ($task->rwyxb!=''){
    $rwjlhtml.="Linh thạch：$task->rwyxb<br/>";
}


//Phía dưới muốn tiến hành một cái thu phí truyền tống dựng
$cs = Helpers\layThongTinNhiemVu($rwid,$dblj);//Truyền tống địa chỉ ID
$upmidlj = $encode->encode("cmd=goto_map&newmid=$cs->rwqy&sid=$sid");//Truyền tống kết nối thu hoạch
$dt = Helpers\layThongTinBanDo($cs->rwqy,$dblj);
//$xiaohao = round($player->capDo*2);//Tính toán linh thạch truyền tống tiêu hao
$xiaohao = round($player->capDo*12+500);
if ($player->tienTroChoi>$xiaohao){
                    Helpers\thayDoiTienTroChoi(2,$xiaohao,$sid,$dblj);
                    //Helpers\thayDoiThuocTinhNguoiChoi('uhp',$player->sinhMenhToiDa,$sid,$dblj);Nơi này tăng máu
                    $player = \Helpers\layThongTinNguoiChoi($sid,$dblj);
                    $sfhtml =<<<HTML
					<a href='?cmd=$upmidlj'>Truyền tống[{$xiaohao}]</a><br>
HTML;
                }else{
                    $sfhtml ="<font color='#12e271'>【Truyền tống quan bế】</font>Nghĩ bạch chơi?Không đủ:$xiaohao<hr>Bản đồ nhiệm vụ：$dt->mname<hr>"
					;	
                }
//2021 12 1 8 Viết（Chép），Cứ như vậy đi, lông một góc 11710 20 663 Cạc cạc cạc



switch ($task->rwzl){
    case 1://Thu thập
        $daoju = Helpers\layThongTinDaoCuCuaNguoiChoi($sid,$task->rwyq,$dblj);
        $rwyq = Helpers\layThongTinDaoCu($cs->rwyq,$dblj);
		//$cs = Helpers\layThongTinNhiemVu($rwid,$dblj);Truyền tống địa chỉ thu hoạch, ý là tìm tới SQL Nhiệm vụ bên trong nào đó đầu ID, phía dưới tiến hành nên đầu ID Nguyên tố phía trên tiến hành tra tìm từ mấu chốt
		//$upmidlj = $encode->encode("cmd=goto_map&newmid=$cs->rwqy&sid=$sid");//Truyền tống kết nối thu hoạch<a href='?cmd=$upmidlj'>Truyền tống</a>
        $rwhtml ="Thu thập$task->rwcount$rwyq->tenDaoCu<br/>Tiến độ：$task->rwnowcount/$task->rwcount";
        break;
    case 2://Đánh quái
        $rwyq = Helpers\layThongTinMauQuaiVat($task->rwyq,$dblj);
		//$upmidlj = $encode->encode("cmd=goto_map&newmid=$cs->rwqy&sid=$sid");
        $rwhtml ="Đánh giết$task->rwcount$rwyq->tenQuaiVat<br/>Tiến độ：$task->rwnowcount/$task->rwcount";
        break;
    case 3://Đối thoại
        $tjnpc = Helpers\layThongTinNpc($task->rwcount,$dblj);
        
		//$upmidlj = $encode->encode("cmd=goto_map&newmid=$cs->rwqy&sid=$sid");//Địa đồ
        $rwhtml ="Đi tìm$tjnpc->nname";
        break;
}
$taskinfo = <<<HTML

$task->rwname:<br/>
$rwhtml<br/>
$rwjlhtml
$sfhtml<br>
<a href="#" onClick="javascript:history.back(-1);">Trở lại</a><br/>
<a href="?cmd=$gonowmid">Trở về trò chơi</a>
HTML;
echo $taskinfo;
?>