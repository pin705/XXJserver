<?php
$player = player\getplayer($sid,$dblj);
$player1 = player\getplayer1($uid,$dblj);
$immenu='';

$gonowmid = $encode->encode("cmd=gomid&newmid=$player->nowmid&sid=$sid");
$pkcmd = $encode->encode("cmd=pvp&uid=$uid&sid=$sid");
$clubplayer = \player\getclubplayer_once($player1->sid,$dblj);
if (isset($canshu)){
    if ($canshu == "addim"){
        \player\addim($uid,$sid,$dblj);
    }
}

if ($clubplayer){
    $club = \player\getclub($clubplayer->clubid,$dblj);
    $clubcmd = $encode->encode("cmd=club&clubid=$club->clubid&sid=$sid");
    $clubname ="<a href='?cmd=$clubcmd'>$club->clubname</a>";
}else{
    $clubname = "Không môn không phái";
}
if ($player->sid != $player1->sid){
    $immenu = "<a href='?cmd=$pkcmd' style='color:#ff0000'>Công kích</a>";
    $ret = \player\isim($uid,$sid,$dblj);
    if (!$ret){
        $addim=  $encode->encode("cmd=getplayerinfo&canshu=addim&uid=$uid&sid=$sid");
        $immenu.="<a href='?cmd=$addim' style='
    color: #009688;'>Kết giao</a><hr>";
    }else{
        $chat=  $encode->encode("cmd=getplayerinfo&canshu=addim&uid=$uid&sid=$sid");
        $deim=  $encode->encode("cmd=im&canshu=deim&uid=$uid&sid=$sid");
        $immenu.=<<<HTML
        </a><a href='?cmd=$deim'>Xóa bỏ hảo hữu</a>
<form>
<input type="hidden" name="cmd" value="sendliaotian">
<input type="hidden" name="ltlx" value="im">
<input type="hidden" name="sid" value="$sid">
<input type="hidden" name="imuid" value="$uid">
<input name="ltmsg">
<input type="submit" value="Gửi đi nói chuyện riêng">
</form>

HTML;
    }
    $immenu .= "<br/>";
}

$tool1 = '';
$tool2 = '';
$tool3 = '';
$tool4 = '';
$tool5 = '';
$tool6 = '';
$tool7 = '';

if ($player1->tool1!=0){
    $zhuangbei = player\getzb($player1->tool1,$dblj);
    $qhs = '';
    if ($zhuangbei->qianghua>0){
        $qhs = '+'.$zhuangbei->qianghua;
    }
    $zbcmd = $encode->encode("cmd=chakanzb&zbnowid=$player1->tool1&uid=$player1->uid&sid=$sid");
	
$tool1 = "Vũ khí:<a href='?cmd=$zbcmd'><font color='$zhuangbei->zbys'>{$zhuangbei->zbname}</font>{$qhs}</a><br/>";//Hai cái điểm trong dấu ngoặc cao cấp không cần'.#FFF.'Trực tiếp'#FF'

}
if ($player1->tool2!=0){
    $zhuangbei = player\getzb($player1->tool2,$dblj);
    $qhs = '';
    if ($zhuangbei->qianghua>0){
        $qhs = '+'.$zhuangbei->qianghua;
    }
    $zbcmd = $encode->encode("cmd=chakanzb&zbnowid=$player1->tool2&uid=$player1->uid&sid=$sid");
    $tool2 = "Đồ phòng ngự:<a href='?cmd=$zbcmd'><font color='$zhuangbei->zbys'>{$zhuangbei->zbname}</font>{$qhs}</a><br/>";
}
if ($player1->tool3!=0){
    $zhuangbei = player\getzb($player1->tool3,$dblj);
    $qhs = '';
    if ($zhuangbei->qianghua>0){
        $qhs = '+'.$zhuangbei->qianghua;
    }
    $zbcmd = $encode->encode("cmd=chakanzb&zbnowid=$player1->tool3&uid=$player1->uid&sid=$sid");
    $tool3 = "Đồ trang sức:<a href='?cmd=$zbcmd'><font color='$zhuangbei->zbys'>{$zhuangbei->zbname}</font>{$qhs}</a><br/>";
}
if ($player1->tool4!=0){
    $zhuangbei = player\getzb($player1->tool4,$dblj);
    $qhs = '';
    if ($zhuangbei->qianghua>0){
        $qhs = '+'.$zhuangbei->qianghua;
    }
    $zbcmd = $encode->encode("cmd=chakanzb&zbnowid=$player1->tool4&uid=$player1->uid&sid=$sid");
    $tool4 = "Thư tịch:<a href='?cmd=$zbcmd'><font color='$zhuangbei->zbys'>{$zhuangbei->zbname}</font>{$qhs}</a><br/>";
}
if ($player1->tool5!=0){
    $zhuangbei = player\getzb($player1->tool5,$dblj);
    $qhs = '';
    if ($zhuangbei->qianghua>0){
        $qhs = '+'.$zhuangbei->qianghua;
    }
    $zbcmd = $encode->encode("cmd=chakanzb&zbnowid=$player1->tool5&uid=$player1->uid&sid=$sid");
    $tool5 = "Tọa kỵ:<a href='?cmd=$zbcmd'><font color='$zhuangbei->zbys'>{$zhuangbei->zbname}</font>{$qhs}</a><br/>";;
}
if ($player1->tool6!=0){
    $zhuangbei = player\getzb($player1->tool6,$dblj);
    $qhs = '';
    if ($zhuangbei->qianghua>0){
        $qhs = '+'.$zhuangbei->qianghua;
    }
    $zbcmd = $encode->encode("cmd=chakanzb&zbnowid=$player1->tool6&uid=$player1->uid&sid=$sid");
    $tool6 = "Lệnh bài:<a href='?cmd=$zbcmd'><font color='$zhuangbei->zbys'>{$zhuangbei->zbname}</font>{$qhs}</a><br/>";;
}
if ($player1->tool7!=0){
    $zhuangbei = player\getzb($player1->tool7,$dblj);
    $qhs = '';
    if ($zhuangbei->qianghua>0){
        $qhs = '+'.$zhuangbei->qianghua;
    }
    $zbcmd = $encode->encode("cmd=chakanzb&zbnowid=$player1->tool7&uid=$player1->uid&sid=$sid");
    $tool7 = "Ám khí:<a href='?cmd=$zbcmd'><font color='$zhuangbei->zbys'>{$zhuangbei->zbname}</font>{$qhs}</a><br/>";;
}
//Dẫn vào võ công, mượn gió bẻ măng
$wgid = $player->wugong;
$cxwg = \player\wgcx($wgid,$sid,$dblj);
$wglx = $cxwg->wglx;
$wgys = $cxwg->wgys;
if ($player->wugong!=0&&$wglx==0){
	$tishi = "<a href='?cmd=$gonowmid' style='color:$wgys'>$cxwg->wgname</a>";
}

$ztcmd = $encode->encode("cmd=otherzhuangtai&sid=$sid");//Thông tin cá nhân
$cwinfo = $encode->encode("cmd=chongwu&cwid=$player1->cw&canshu=cwinfo&sid=$sid");//Sủng vật kết nối
$html = <<<HTML
【<a>Thông tin cá nhân</a><a href="?cmd=$cwinfo"><font color="#e28e0c">Sủng vật tin tức</font></a>】<br/>
Biệt danh:$player1->uname<br/>
Môn phái:$clubname<br/>
Cảnh giới:$player1->jingjie $player1->cengci<br/>
Đẳng cấp:$player1->ulv<br/>
Tu vi:$player1->uexp/$player1->umaxexp<br/>
Linh thạch:$player1->uyxb$tishi<br/>
Ma thạch:$player1->uczb<br/>
Khí huyết:$player1->uhp/$player1->umaxhp<br/>
Công kích:$player1->ugj<br/>
Phòng ngự:$player1->ufy<br/>
Bạo kích:$player1->ubj<br/>
Hút máu:$player1->uxx<br/>
<hr>
$tool1
$tool2
$tool3
$tool4
$tool5
$tool6
$tool7
<hr>
$immenu
<a href="#" onClick="javascript:history.back(-1);" style=" background-color: #ecf7ed;">Trở lại</a><!--Cư trái-float:left;-->
<a href="game.php?cmd=$gonowmid" style="float:right;background-color:#ecf7ed;" >Trở về trò chơi</a>
HTML;
echo $html;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/ 12/01
 * Time: 18:10
 */?>