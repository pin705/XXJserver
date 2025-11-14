<?php 
namespace player ;
class player
{
    var $uname;//Biệt danh
    var $uid;
    var $sid;//sid 
    var $ulv;//Đẳng cấp
    var $uyxb;//Tiền trò chơi
    var $uczb;//Nạp tiền tệ
    var $uexp;//Kinh nghiệm
    var $umaxexp;//Kinh nghiệm hạn mức cao nhất
    var $uhp;//Sinh mệnh
    var $umaxhp;//Sinh mệnh
    var $ugj;//Công kích
    var $ufy;//Phòng ngự
    var $ubj;//Bạo kích
    var $uxx;//Hút máu
    var $uwx;//Ngũ Hành
    var $usex;//Giới tính
    var $vip;//vip
    var $nowmid;//Trước mắt địa đồ
    var $endtime;
    var $tool1;
    var $tool2;
    var $tool3;
    var $tool4;
    var $tool5;
    var $tool6;
    var $tool7;
    var $jingjie;
    var $sfxl;
    var $sfzx;
    var $xiuliantime;
    var $yp1;
    var $yp2;
    var $yp3;
    var $cw;
    var $jn1;
    var $jn2;
    var $jn3;
    var $ispvp;
    var $cengci;
	var $yd1;
	var $yd2;
	var $yd3;
	var $shenfen;//Thân phận
	var $dhvip;//Hối đoái vip Trang bị phán đoán
	var $dhvip1;//Hối đoái vip Trang bị phán đoán
	var $tf;//Thiên phú
	var $tfgj;//Thiên phú công kích
	var $tfxy;//Thiên phú nhỏ may mắn
	var $tfsb;//Né tránh
	var $tfxx;//Hút máu
	var $tfhp;
	var $tffy;
	var $tfbj;
	var $wugong;
}
function getplayer($sid,$dblj){
    $player = new player();
    $sql="select * from game1 where sid='$sid'";
    $cxjg = $dblj->query($sql);
    $cxjg->bindColumn('uname',$player->uname);
    $cxjg->bindColumn('sid',$player->sid);
    $cxjg->bindColumn('uid',$player->uid);
    $cxjg->bindColumn('ulv',$player->ulv);
    $cxjg->bindColumn('uyxb',$player->uyxb);
    $cxjg->bindColumn('uczb',$player->uczb);
    $cxjg->bindColumn('uexp',$player->uexp);
    $cxjg->bindColumn('uhp',$player->uhp);
    $cxjg->bindColumn('umaxhp',$player->umaxhp);
    $cxjg->bindColumn('ugj',$player->ugj);
    $cxjg->bindColumn('ufy',$player->ufy);
    $cxjg->bindColumn('ubj',$player->ubj);
    $cxjg->bindColumn('uxx',$player->uxx);
    $cxjg->bindColumn('uwx',$player->uwx);
    $cxjg->bindColumn('usex',$player->usex);
    $cxjg->bindColumn('vip',$player->vip);
    $cxjg->bindColumn('nowmid',$player->nowmid);
    $cxjg->bindColumn('endtime',$player->endtime);
    $cxjg->bindColumn('tool1',$player->tool1);
    $cxjg->bindColumn('tool2',$player->tool2);
    $cxjg->bindColumn('tool3',$player->tool3);
    $cxjg->bindColumn('tool4',$player->tool4);
    $cxjg->bindColumn('tool5',$player->tool5);
    $cxjg->bindColumn('tool6',$player->tool6);
    $cxjg->bindColumn('tool7',$player->tool7);
    $cxjg->bindColumn('sfxl',$player->sfxl);
    $cxjg->bindColumn('xiuliantime',$player->xiuliantime);
    $cxjg->bindColumn('yp1',$player->yp1);
    $cxjg->bindColumn('yp2',$player->yp2);
    $cxjg->bindColumn('yp3',$player->yp3);
    $cxjg->bindColumn('jn1',$player->jn1);
    $cxjg->bindColumn('jn2',$player->jn2);
    $cxjg->bindColumn('jn3',$player->jn3);
    $cxjg->bindColumn('cw',$player->cw);
    $cxjg->bindColumn('sfzx',$player->sfzx);
    $cxjg->bindColumn('ispvp',$player->ispvp);
	$cxjg->bindColumn('dhvip',$player->dhvip);
	$cxjg->bindColumn('dhvip1',$player->dhvip1);
	$cxjg->bindColumn('tf',$player->tf);
	$cxjg->bindColumn('tfgj',$player->tfgj);
	$cxjg->bindColumn('tfxy',$player->tfxy);
	$cxjg->bindColumn('tfsb',$player->tfsb);
	$cxjg->bindColumn('tfxx',$player->tfxx);
	$cxjg->bindColumn('tfhp',$player->tfhp);
	$cxjg->bindColumn('tffy',$player->tffy);
	$cxjg->bindColumn('tfbj',$player->tfbj);
	$cxjg->bindColumn('wugong',$player->wugong);
	$cxjg->bindColumn('shenfen',$player->shenfen);
	
    $cxjg->fetch(\PDO::FETCH_ASSOC);
	
    $tools = [$player->tool1, $player->tool2, $player->tool3, $player->tool4, $player->tool5, $player->tool6, $player->tool7];
    foreach ($tools as $toolId) {
        if ($toolId != 0) {
            $zhuangbei = getzb($toolId, $dblj);
            $player->ugj += $zhuangbei->zbgj;
            $player->ufy += $zhuangbei->zbfy;
            $player->ubj += $zhuangbei->zbbj;
            $player->uxx += $zhuangbei->zbxx;
            $player->umaxhp += $zhuangbei->zbhp;
        }
    }

    if ($player->tfgj!=0){//Thiên phú công kích tăng thêm
        $tfgj = $player->tfgj*5;
        $player->ugj += $tfgj;
    }

    if ($player->tfbj!=0){//Thiên phú tăng thêm-Bạo kích
        $tfbj = $player->tfbj*1.5;
        $player->ubj += $tfbj;
    }

    if ($player->tfxx!=0){//Thiên phú tăng thêm-Hút máu
        $tfxx = $player->tfxx*2;
        $player->uxx += $tfxx;
    }

    if ($player->tfhp!=0){//Thiên phú tăng thêm-HP
        $tfhp = $player->tfhp*10;
        $player->umaxhp += $tfhp;
    }

    if ($player->tffy!=0){//Thiên phú tăng thêm-Phòng ngự
        $tffy = $player->tffy*5;
        $player->ufy += $tffy;
    }
    $rangeslv = array(0, 30, 50, 70, 80, 90, 100, 110);
    $rangesexp = array(2.5, 5, 7.5, 10, 12.5, 15, 17.5);
    $playernextlv = $player->ulv + 1;
    $rangesjj = array('<font color=#C7C7C7>Luyện</font><font color=#D7D7D7>Khí</font>', '<font color=#78CAC6>Trúc</font><font color=#75C7C3>Cơ</font>', '<font color=#A78104>Kim</font><font color=#A36208>Đan</font>', '<font color=#FAC389>Nguyên</font><font color=#F7C086>Anh</font>', '<font color=#F49477>Hóa</font><font color=#F19174>Thần</font>', '<font color=#EB1A21>Luyện</font><font color=#E8171E>Hư</font>', '<font color=#9D0F36>Hợp</font><font color=#4C0148>Thể</font>', '<font color=#770035>Lớn</font><font color=#740044>Thừa</font>');
    for ($i=0;$i < count($rangeslv);$i++){
        if ($player->ulv >= $rangeslv[$i] && $player->ulv < $rangeslv[$i+1]){
            $rangesjd = array('<font color=#C7C7C7>Một</font><font color=#D7D7D7>Giai</font>','<font color=#78CAC6>Hai</font><font color=#75C7C3>Giai</font>','<font color=#A78104>Ba</font><font color=#A36208>Giai</font>','<font color=#A78104>Bốn</font><font color=#A36208>Giai</font>','<font color=#F49477>Năm</font><font color=#F19174>Giai</font>','<font color=#F49477>Sáu</font><font color=#F19174>Giai</font>','<font color=#EB1A21>Bảy</font><font color=#E8171E>Giai</font>','<font color=#9D0F36>Tám</font><font color=#4C0148>Giai</font>','<font color=#9D0F36>Chín</font><font color=#4C0148>Giai</font>','<font color=#770035>Mười</font><font color=#740044>Toàn</font>');
            $djc = $player->ulv - $rangeslv[$i];
            $jds = ($rangeslv[$i+1]-$rangeslv[$i])/10;
            $jieduan = floor($djc/$jds);
            $jd = $rangesjd[$jieduan];
            $player->jingjie = $rangesjj[$i];
            $player->cengci = $jd.'';
            $player->umaxexp = $playernextlv*($playernextlv+round($playernextlv/2))*10*$rangesexp[$i]+$playernextlv;//Tu vi tính toán
            break;
        }

    }
    return $player;
}
function getplayer1($uid,$dblj){
    $player = new player();
    $sql="select * from game1 where uid='$uid'";
    $cxjg = $dblj->query($sql);
    $cxjg->bindColumn('sid',$player->sid);
    $cxjg->fetch(\PDO::FETCH_ASSOC);
    $player = getplayer($player->sid,$dblj);
    return $player;
}

class guaiwu
{
    var $gname;//Biệt danh
    var $ginfo;
    var $gsex;
    var $gzb;//Trang bị
    var $dljv;//Trang bị tỉ lệ
    var $gdj;//Đạo cụ
    var $djjv;//Đạo cụ tỉ lệ
    var $gyp;//Dược phẩm
    var $ypjv;//Dược phẩm tỉ lệ
    var $gid;
    var $sid;
    var $glv;
    var $gexp;//Kinh nghiệm
    var $ghp;//Sinh mệnh
    var $gmaxhp;
    var $ggj;//Công kích
    var $gfy;//Phòng ngự
    var $gbj;//Bạo kích
    var $gxx;//Hút máu
    var $gyid;
    var $jingjie;
}

function getguaiwu($gid,$dblj){//Thu hoạch quái vật
    $guaiwu = new guaiwu();

    $sql = "select * from midguaiwu where id = $gid";
    $cxjg = $dblj->query($sql);

    $cxjg->bindColumn('gname',$guaiwu->gname);
    $cxjg->bindColumn('id',$guaiwu->gid);
    $cxjg->bindColumn('sid',$guaiwu->sid);
    $cxjg->bindColumn('glv',$guaiwu->glv);
    $cxjg->bindColumn('gexp',$guaiwu->gexp);
    $cxjg->bindColumn('ghp',$guaiwu->ghp);
    $cxjg->bindColumn('gmaxhp',$guaiwu->gmaxhp);
    $cxjg->bindColumn('ggj',$guaiwu->ggj);
    $cxjg->bindColumn('gfy',$guaiwu->gfy);
    $cxjg->bindColumn('gbj',$guaiwu->gbj);
    $cxjg->bindColumn('gxx',$guaiwu->gxx);
    $cxjg->bindColumn('gyid',$guaiwu->gyid);
    $cxjg->fetch(\PDO::FETCH_ASSOC);

    $rangeslv = array(0, 30, 50, 70, 80, 90, 100, 110);
    $rangesjj = array('Luyện khí', 'Trúc cơ', 'Kim Đan', 'Nguyên Anh', 'Hóa Thần', 'Luyện Hư', 'Hợp thể', 'Đại Thừa');
    for ($i=0;$i < count($rangeslv);$i++){
        if ($guaiwu->glv >= $rangeslv[$i] && $guaiwu->glv < $rangeslv[$i+1]){
            $rangesjd = array('Một','Hai','Ba','Bốn','Năm','Sáu','Bảy','Tám','Chín','Mười');
            $djc = $guaiwu->glv - $rangeslv[$i];
            $jds = ($rangeslv[$i+1]-$rangeslv[$i])/10;
            $jieduan = floor($djc/$jds);
            $jd = $rangesjd[$jieduan];
            $guaiwu->jingjie = $rangesjj[$i].$jd.'Tầng';
            break;
        }
    }

    return $guaiwu;
}
function getyguaiwu($gyid,$dblj){//Thu hoạch quái vật kho quái vật
    $guaiwu = new guaiwu();
    $sql = "select * from guaiwu where id=$gyid";
    $cxjg = $dblj->query($sql);
    if ($cxjg){
        $cxjg->bindColumn('gname',$guaiwu->gname);
        $cxjg->bindColumn('ginfo',$guaiwu->ginfo);
        $cxjg->bindColumn('gsex',$guaiwu->gsex);
        $cxjg->bindColumn('glv',$guaiwu->glv);
        $cxjg->bindColumn('gzb',$guaiwu->gzb);
        $cxjg->bindColumn('gdj',$guaiwu->gdj);
        $cxjg->bindColumn('ghp',$guaiwu->ghp);
        $cxjg->bindColumn('ggj',$guaiwu->ggj);
        $cxjg->bindColumn('gfy',$guaiwu->gfy);
        $cxjg->bindColumn('gbj',$guaiwu->gbj);
        $cxjg->bindColumn('gxx',$guaiwu->gxx);
        $cxjg->bindColumn('gyp',$guaiwu->gyp);
        $cxjg->bindColumn('dljv',$guaiwu->dljv);
        $cxjg->bindColumn('ypjv',$guaiwu->ypjv);
        $cxjg->bindColumn('djjv',$guaiwu->djjv);
        $cxjg->fetch(\PDO::FETCH_ASSOC);
    }
    return $guaiwu;
}

function getyboss($bossid,$dblj){//Thu hoạch quái vật kho boss,boss, thêm thuốc
    $boss = new boss();
    $sql = "select * from boss where id=$bossid";
    $cxjg = $dblj->query($sql);
    if ($cxjg){
        $cxjg->bindColumn('bossname',$boss->bossname);
        $cxjg->bindColumn('bossinfo',$boss->bossinfo);
        // $cxjg->bindColumn('bosssex',$boss->bosssex);
        $cxjg->bindColumn('bosslv',$boss->glv);
        $cxjg->bindColumn('bosszb',$boss->bosszb);
        $cxjg->bindColumn('bossdj',$boss->bossdj);
        $cxjg->bindColumn('bosshp',$boss->bosshp);
        $cxjg->bindColumn('bossgj',$boss->bossgj);
        $cxjg->bindColumn('bossfy',$boss->bossfy);
        $cxjg->bindColumn('bossbj',$boss->bossbj);
        $cxjg->bindColumn('bossxx',$boss->bossxx);
		$cxjg->bindColumn('dllv',$boss->dllv);
		$cxjg->bindColumn('djlv',$boss->djlv);
		$cxjg->bindColumn('sid',$boss->sid);
        $cxjg->bindColumn('bossyp',$boss->bossyp);
       $cxjg->bindColumn('dljv',$boss->dljv);
        $cxjg->bindColumn('ypjv',$boss->ypjv);
        $cxjg->bindColumn('djjv',$boss->djjv);
        $cxjg->fetch(\PDO::FETCH_ASSOC);
    }
    return $boss;
}



class clmid
{
    var $mname;//
    var $mgid;
    var $mid;//
    var $mnpc;//Kinh nghiệm
    var $upmid;
    var $downmid;
    var $leftmid;
    var $rightmid;
    var $mgtime;
    var $midboss;
    var $ms;
    var $midinfo;
    var $mqy;
    var $playerinfo;
    var $ispvp;
}

function getmid($mid,$dblj){
    $clmid = new clmid();
    $sql = "select * from mid where mid='$mid'";
    $cxjg = $dblj->query($sql);
    $cxjg->bindColumn('mname',$clmid->mname);
    $cxjg->bindColumn('mgid',$clmid->mgid);
    $cxjg->bindColumn('mid',$clmid->mid);
    $cxjg->bindColumn('mup',$clmid->upmid);
    $cxjg->bindColumn('mdown',$clmid->downmid);
    $cxjg->bindColumn('mleft',$clmid->leftmid);
    $cxjg->bindColumn('mright',$clmid->rightmid);
    $cxjg->bindColumn('mnpc',$clmid->mnpc);
    $cxjg->bindColumn('mgtime',$clmid->mgtime);
    $cxjg->bindColumn('midboss',$clmid->midboss);
    $cxjg->bindColumn('ms',$clmid->ms);
    $cxjg->bindColumn('midinfo',$clmid->midinfo);
    $cxjg->bindColumn('mqy',$clmid->mqy);
    $cxjg->bindColumn('playerinfo',$clmid->playerinfo);
    $cxjg->bindColumn('ispvp',$clmid->ispvp);
    $cxjg->fetch(\PDO::FETCH_ASSOC);
    return $clmid;
}
function istupo($sid,$dblj){
    $player = getplayer($sid,$dblj);
    $rangeslv = array(0, 30, 50, 70, 80, 90, 100, 110);
    $playernextlv = $player->ulv + 1;
    $rangesjj = array('Luyện khí', 'Trúc cơ', 'Kim Đan', 'Nguyên Anh', 'Hóa Thần', 'Luyện Hư', 'Hợp thể', 'Đại Thừa');
    for ($i=0;$i < count($rangeslv)-1;$i++){
        if ($playernextlv >= $rangeslv[$i] && $playernextlv < $rangeslv[$i+1]){
            
            if($player->jingjie != $rangesjj[$i]){
                return 1;//Giai đoạn đột phá
            }
            $rangesjd = array('Một','Hai','Ba','Bốn','Năm','Sáu','Bảy','Tám','Chín','Mười');
            $djc = $playernextlv - $rangeslv[$i];
            $jds = ($rangeslv[$i+1]-$rangeslv[$i])/10;
            $jieduan = floor($djc/$jds);
            $jd = $rangesjd[$jieduan];
            if($player->cengci != $jd.'Tầng'){
                return 2;//Cấp độ đột phá
            }
            return 0;
        }
    }
}
function changeexp($sid,$dblj,$exp){
    if (istupo($sid,$dblj) != 8){
        $player = getplayer($sid,$dblj);
        if($player->uexp >= $player->umaxexp){
            return;
        }
    }
    $sql = "update game1 set uexp = uexp + $exp where sid='$sid'";
    $ret = $dblj->exec($sql);//Vốn có 0 Cái giai đoạn, ta cải thành 8 Cái giai đoạn
    if (istupo($sid,$dblj) == 8){
        upplayerlv($sid,$dblj);
    }
}

function cwexp($sid,$dblj,$exp){//Lúc đầu chuẩn bị đổi nơi này cho sủng vật, phát hiện phía dưới 1000 Nhiều đi có sủng vật tính toán tăng thêm logic ha ha ha 2021-12-19
    if (istupo($sid,$dblj) != 8){
        $player = getplayer($sid,$dblj);
        if($player->uexp >= $player->umaxexp){
            return;
        }
    }
    $sql = "update playerchongwu set cwexp = cwexp + $exp where sid='$sid'";
    $ret = $dblj->exec($sql);//Vốn có 0 Cái giai đoạn, ta cải thành 8 Cái giai đoạn
    if (istupo($sid,$dblj) == 8){
        upplayerlv($sid,$dblj);
    }
}


// if($player->shenfen == 1){
// $zs=1 ;
// }else{$zs=0;}
// if($player->shenfen == 2){
// $xs=1 ;
// }else{$xs=0;}
// if($player->shenfen == 3){
// $ys=1 ;
// }else{$ys=0;}

//Vượt qua 30 Cấp về sau ngầm thừa nhận tăng thêm Đột phá tăng thêm
function upplayerlv($sid,$dblj){
    $player = getplayer($sid,$dblj);
	//Thân phận thuộc tính tăng thêm
if($player->shenfen == 1){
$zs=1 ;
}else{$zs=0;}
if($player->shenfen == 2){
$xs=1 ;
}else{$xs=0;}
if($player->shenfen == 3){
$ys=1 ;
}else{$ys=0;}

    if ($player->uexp >= $player->umaxexp){
        $sql = "update game1 set uexp = uexp - $player->umaxexp where sid='$sid'";
        $dblj->exec($sql);

        $rangeslv = array(1, 30, 50, 70, 80, 90, 100, 110);
        $rangesgj = array(2.5, 5, 7.5, 10, 12.5, 15, 17.5);
        $rangesfy = array(2.5, 5, 7.5, 10, 12.5, 15, 17.5);
        $rangeswx = array(2, 4, 6, 8, 10, 12, 14);
        $rangeshp = array(30, 50, 70, 90, 110, 130, 170);
		$rangesbj = array($zs, $zs, $zs, $zs, $zs, $zs*2, $zs*2);//Bạo kích-------Đây đều là thêm đến thiên phú bên trong, thiên phú thiết lập lại những này không tính, xem như tổn thất
		$rangesxx = array($xs, $xs, $xs, $xs, $xs*1.5, $xs*1.5, $xs*1.5);//Thân phận thuộc tính tăng thêm Hút máu
		$rangesxy = array($ys, $ys, $ys, $ys, $ys*1.5, $ys*1.5, $ys*1.5);//May mắn
		$tfhp1 =  array($ys*2, $ys*3, $ys*3, $ys*4, $ys*4, $ys*5, $ys*10);//HP
		$tffy1 = array($xs, $xs, $xs, $xs, $xs*1.5, $xs*1.5, $xs*1.5);//Phòng ngự
		$tfgj1 = array($zs, $zs, $zs, $zs, $zs*1.5, $zs*1.5, $zs*1.5);//Công kích
        $playernextlv = $player->ulv + 1;

        for ($i=0;$i<count($rangeslv)-1;$i++){
            if ($playernextlv >= $rangeslv[$i] && $playernextlv < $rangeslv[$i+1]){
                $sql = "update game1 set ulv = ulv + 1,
                                           umaxhp = umaxhp + $rangeshp[$i],
                                           ugj = ugj + $rangesgj[$i],
                                           ufy = ufy + $rangesfy[$i],
										   tfbj = tfbj + $rangesbj[$i],
										   tfxx = tfxx + $rangesxx[$i],
										   tfxy = tfxy + $rangesxy[$i],
										   tfhp = tfhp + $tfhp1[$i],
										   tffy = tffy + $tffy1[$i],
										   tfgj = tfgj + $tfgj1[$i],
                                           uwx = uwx + $rangeswx[$i]
                                           where sid='$sid'";
                break;
            }
        }
        $dblj->exec($sql);
    }
}


class npc{
    var $nid;
    var $nname;
    var $nsex;
    var $ninfo;
    var $taskid;
    var $muban;
	var $rwqy;
}

function getnpc($nid,$dblj){
    $npc = new npc();
    $sql = "select * from npc where id = $nid";
    $cxjg = $dblj->query($sql);
    $cxjg->bindColumn('nname',$npc->nname);
    $cxjg->bindColumn('id',$npc->nid);
    $cxjg->bindColumn('nsex',$npc->nsex);
    $cxjg->bindColumn('ninfo',$npc->ninfo);
    $cxjg->bindColumn('taskid',$npc->taskid);
    $cxjg->bindColumn('muban',$npc->muban);
	$cxjg->bindColumn('rwqy',$npc->qy);
    $cxjg->fetch(\PDO::FETCH_ASSOC);
    return $npc;
}
class zhuangbei{
    var $zbname;
    var $zbinfo;
    var $zbgj;
    var $zbfy;
    var $zbbj;
    var $zbxx;
    var $zbid;
    var $uid;
    var $zbnowid;
    var $qianghua;
    var $zbhp;
    var $zblv;
    var $tool;
	var $zbys;
}
function getzb($zbnowid,$dblj){
    $zhuangbei = new zhuangbei();
    $sql = "select * from playerzhuangbei where zbnowid = $zbnowid";
    $cxjg = $dblj->query($sql);
    $cxjg->bindColumn('zbname',$zhuangbei->zbname);
    $cxjg->bindColumn('zbinfo',$zhuangbei->zbinfo);
    $cxjg->bindColumn('zbgj',$zhuangbei->zbgj);
    $cxjg->bindColumn('zbfy',$zhuangbei->zbfy);
    $cxjg->bindColumn('zbhp',$zhuangbei->zbhp);
    $cxjg->bindColumn('zbbj',$zhuangbei->zbbj);
    $cxjg->bindColumn('zbxx',$zhuangbei->zbxx);
    $cxjg->bindColumn('zbid',$zhuangbei->zbid);
    $cxjg->bindColumn('uid',$zhuangbei->uid);
    $cxjg->bindColumn('zbnowid',$zhuangbei->zbnowid);
    $cxjg->bindColumn('qianghua',$zhuangbei->qianghua);
    $cxjg->bindColumn('zblv',$zhuangbei->zblv);
    $cxjg->bindColumn('zbtool',$zhuangbei->tool);
	$cxjg->bindColumn('zbys',$zhuangbei->zbys);
	//$cxjg->bindColumn('tz',$zhuangbei->tz);
    $cxjg->fetch(\PDO::FETCH_ASSOC);
    return $zhuangbei;
}
function getzbkzb($zbid,$dblj){
    $zb = new zhuangbei();
    $sql = "select * from zhuangbei WHERE zbid = $zbid";
    $cxjg = $dblj->query($sql);
    $cxjg->bindColumn('zbname',$zb->zbname);
    $cxjg->bindColumn('zbinfo',$zb->zbinfo);
    $cxjg->bindColumn('zbgj',$zb->zbgj);
    $cxjg->bindColumn('zbfy',$zb->zbfy);
    $cxjg->bindColumn('zbhp',$zb->zbhp);
    $cxjg->bindColumn('zbbj',$zb->zbbj);
    $cxjg->bindColumn('zbxx',$zb->zbxx);
    $cxjg->bindColumn('zbid',$zb->zbid);
    $cxjg->bindColumn('zbtool',$zb->tool);
	$cxjg->bindColumn('zbys',$zb->zbys);
	$cxjg->bindColumn('zblv',$zb->zblv);
    $cxjg->fetch(\PDO::FETCH_ASSOC);
    return $zb;
}
function addzb($sid,$zbid,$dblj){
    $player = getplayer($sid,$dblj);
    $zb = getzbkzb($zbid,$dblj);
    $sql = "insert into playerzhuangbei(zbname,zbinfo,zbgj,zbfy,zbhp,zbbj,zbxx,zbid,uid,sid,zbtool,zbys,zblv) VALUES ('$zb->zbname','$zb->zbinfo','$zb->zbgj','$zb->zbfy','$zb->zbhp','$zb->zbbj','$zb->zbxx','$zb->zbid','$player->uid','$sid',$zb->tool,'$zb->zbys','$zb->zblv')";
    $dblj->exec($sql);
    $ret = $dblj->lastInsertId();
    return $ret;
}


class daoju{
    var $djname;
    var $djzl;
    var $djinfo;
    var $djid;
    var $djsum;//playerdaoju
    var $djyxb;
}
function adddj($sid,$djid,$djsum,$dblj){
    $player = getplayer($sid,$dblj);
    $sql = "select * from playerdaoju where sid='$sid' and djid = $djid";
    $cxjg = $dblj->query($sql);
    $ret = $cxjg->fetch(\PDO::FETCH_ASSOC);
    if ($ret){
        $sql = "update playerdaoju set djsum = djsum + $djsum where sid='$sid' and djid = $djid";
        $dblj->exec($sql);
    }else{
        $daoju = getdaoju($djid,$dblj);
        if ($daoju){
            $sql = "insert into playerdaoju(djname,djinfo,djzl,djid,djsum,sid,uid) VALUES ('$daoju->djname','$daoju->djinfo','$daoju->djzl','$daoju->djid',$djsum,'$sid','$player->uid')";
            $dblj->exec($sql);;
        }
    }
    changerwyq1(1,$djid,$djsum,$sid,$dblj);
}

function changerwyq1($rwzl,$rwyq,$gaibian,$sid,$dblj){
    if ($rwzl == 1){
        $daoju = getplayerdaoju($sid,$rwyq,$dblj);
        $sql = "update playerrenwu set rwnowcount = $daoju->djsum WHERE sid='$sid' AND rwyq = $rwyq AND $rwzl = $rwzl AND rwzt = 1";
        $rwt = $dblj->exec($sql);
    }elseif($rwzl == 2){
        $sql="update playerrenwu set rwnowcount = rwnowcount + $gaibian WHERE sid = '$sid' AND rwyq = $rwyq AND $rwzl = $rwzl AND rwzt = 1";
        $rwt = $dblj->exec($sql);
    }
    $sql = "update playerrenwu set rwzt = 2 WHERE sid = '$sid' AND rwyq = '$rwyq' AND $rwzl= $rwzl AND rwnowcount >= rwcount AND rwzt = 1";
    $dblj->exec($sql);
}



function getplayerdaoju($sid,$djid,$dblj){
    $daoju = new daoju();
    $sql = "select * from playerdaoju where djid = $djid AND sid='$sid'";
    $cxjg = $dblj->query($sql);
    $cxjg->bindColumn('djname',$daoju->djname);
    $cxjg->bindColumn('djzl',$daoju->djzl);
    $cxjg->bindColumn('djinfo',$daoju->djinfo);
    $cxjg->bindColumn('djid',$daoju->djid);
    $cxjg->bindColumn('djsum',$daoju->djsum);
    $ret = $cxjg->fetch(\PDO::FETCH_ASSOC);
    
    if ($ret){
        return $daoju;
    }else{
        return false;
    }

}

function deledjsum($djid,$djsum,$sid,$dblj){
    $daoju = \player\getplayerdaoju($sid,$djid,$dblj);

    if ($daoju){
        if ($daoju->djsum >= $djsum){
            $sql = "update playerdaoju set djsum = djsum - $djsum where sid='$sid' and djid = $djid";
            $dblj->exec($sql);
            return true;
        }else{
            return false;
        }
    }else{
        return false;
    }
}

function getdaoju($djid,$dblj){
    $daoju = new daoju();
    $sql = "select * from daoju where djid = $djid";
    $cxjg = $dblj->query($sql);
    $cxjg->bindColumn('djname',$daoju->djname);
    $cxjg->bindColumn('djzl',$daoju->djzl);
    $cxjg->bindColumn('djinfo',$daoju->djinfo);
    $cxjg->bindColumn('djid',$daoju->djid);
    $cxjg->bindColumn('djyxb',$daoju->djyxb);
    $ret = $cxjg->fetch(\PDO::FETCH_ASSOC);
    if ($ret){
        return $daoju;
    }else{
        return false;
    }
}
function changezbsx($upsx,$changeint,$zbnowid,$dblj){
    $sql = "update playerzhuangbei set $upsx= $upsx + $changeint WHERE zbnowid=$zbnowid";
    $dblj->exec($sql);
}

function upzbsx($zbnowid,$upsx,$sid,$dblj){
    $zbsx = '';
    $zbqh = '';
    $sql = "select * from playerzhuangbei WHERE zbnowid=$zbnowid AND sid='$sid'";
    $cxjg = $dblj->query($sql);
    $cxjg->bindColumn("$upsx",$zbsx);
    $cxjg->bindColumn("qianghua",$zbqh);
    $cxjg->fetch(\PDO::FETCH_ASSOC);
    $djsum = $zbqh *3+1;
    $ret = \player\deledjsum(1,$djsum,$sid,$dblj);
    if ($ret){
        $upint = round($zbsx*0.08);//Cường hóa trưởng thành, cường hóa tăng thêm
        if ($upint<1){
            $upint = 1;
        }
        $sjs = mt_rand(1,35);
        if ($sjs <= $zbqh){
            return 0;//Thất bại
        }
        $sjs = mt_rand(1,30);
        if ($zbqh <= $sjs){
            \player\changezbsx($upsx,$upint,$zbnowid,$dblj);
            changezbsx('qianghua',1,$zbnowid,$dblj);
            return 1;
        }else{
            return 0;//Thất bại
        }
    }else{
        return -1;//Không đủ
    }
}
class yaopin{
    var $ypname;
    var $ypid;
    var $yphp;
    var $ypgj;
    var $ypfy;
    var $ypjg;
    var $ypbj;
    var $ypxx;
    var $ypsum;
}
class yaodan{
    var $ydname;
    var $ydid;
    var $ydhp;
    var $ydgj;
    var $ydfy;
    var $ydjg;
    var $ydbj;
    var $ydxx;
    var $ydsum;
	var $ydys;
	var $ydjgm;
}
function getyaopin($dblj){
    $sql = "select * from yaopin";
    $cxjg = $dblj->query($sql);
    $yaopin = $cxjg->fetchAll(\PDO::FETCH_ASSOC);
    return $yaopin;
//    $cxjg->bindColumn('ypname',$yaopin->ypname);
//    $cxjg->bindColumn('yphp',$yaopin->yphp);
//    $cxjg->bindColumn('ypgj',$yaopin->ypgj);
//    $cxjg->bindColumn('ypfy',$yaopin->ypfy);
//    $cxjg->bindColumn('ypjg',$yaopin->ypjg);
//    $cxjg->bindColumn('ypbj',$yaopin->ypbj);
//    $cxjg->bindColumn('ypxx',$yaopin->ypxx);
}
function getyaodan($dblj){
    $sql = "select * from yaodan";
    $cxjg = $dblj->query($sql);
    $yaodan = $cxjg->fetchAll(\PDO::FETCH_ASSOC);
    return $yaodan;
//    $cxjg->bindColumn('ypname',$yaopin->ypname);
//    $cxjg->bindColumn('yphp',$yaopin->yphp);
//    $cxjg->bindColumn('ypgj',$yaopin->ypgj);
//    $cxjg->bindColumn('ypfy',$yaopin->ypfy);
//    $cxjg->bindColumn('ypjg',$yaopin->ypjg);
//    $cxjg->bindColumn('ypbj',$yaopin->ypbj);
//    $cxjg->bindColumn('ypxx',$yaopin->ypxx);
}

function getyaopinonce($ypid,$dblj){
    $yaopin = new yaopin();
    $sql = "select * from yaopin WHERE ypid=$ypid";
    $cxjg = $dblj->query($sql);
    $cxjg->bindColumn('ypname',$yaopin->ypname);
    $cxjg->bindColumn('yphp',$yaopin->yphp);
    $cxjg->bindColumn('ypgj',$yaopin->ypgj);
    $cxjg->bindColumn('ypfy',$yaopin->ypfy);
    $cxjg->bindColumn('ypjg',$yaopin->ypjg);
    $cxjg->bindColumn('ypbj',$yaopin->ypbj);
    $cxjg->bindColumn('ypid',$yaopin->ypid);
    $cxjg->fetch(\PDO::FETCH_ASSOC);
    return $yaopin;
}
function getyaodanonce($ydid,$dblj){
    $yaodan = new yaodan();
    $sql = "select * from yaodan WHERE ydid=$ydid";
    $cxjg = $dblj->query($sql);
    $cxjg->bindColumn('ydname',$yaodan->ydname);
    $cxjg->bindColumn('ydhp',$yaodan->ydhp);
    $cxjg->bindColumn('ydgj',$yaodan->ydgj);
    $cxjg->bindColumn('ydfy',$yaodan->ydfy);
    $cxjg->bindColumn('ydjg',$yaodan->ydjg);
    $cxjg->bindColumn('ydbj',$yaodan->ydbj);
	$cxjg->bindColumn('ydxx',$yaodan->ydxx);
    $cxjg->bindColumn('ydid',$yaodan->ydid);
	$cxjg->bindColumn('ydys',$yaodan->ydys);	
	$cxjg->bindColumn('ydjgm',$yaodan->ydjgm);
    $cxjg->fetch(\PDO::FETCH_ASSOC);
    return $yaodan;
}

function getplayeryaopin($ypid,$sid,$dblj){
    $yaopin = new yaopin();
    $sql = "select * from playeryaopin WHERE ypid=$ypid AND sid='$sid'";
    $cxjg = $dblj->query($sql);
    $cxjg->bindColumn('ypname',$yaopin->ypname);
    $cxjg->bindColumn('yphp',$yaopin->yphp);
    $cxjg->bindColumn('ypgj',$yaopin->ypgj);
    $cxjg->bindColumn('ypfy',$yaopin->ypfy);
    $cxjg->bindColumn('ypjg',$yaopin->ypjg);
    $cxjg->bindColumn('ypbj',$yaopin->ypbj);
    $cxjg->bindColumn('ypxx',$yaopin->ypxx);
    $cxjg->bindColumn('ypsum',$yaopin->ypsum);
    $ret = $cxjg->fetch(\PDO::FETCH_ASSOC);
    if ($ret){
        return $yaopin;
    }else{
        return false;
    }
}

function getplayeryaodan($ydid,$sid,$dblj){
    $yaodan = new yaodan();
    $sql = "select * from playeryaodan WHERE ydid=$ydid AND sid='$sid'";
    $cxjg = $dblj->query($sql);
    $cxjg->bindColumn('ydname',$yaodan->ydname);
    $cxjg->bindColumn('ydhp',$yaodan->ydhp);
    $cxjg->bindColumn('ydgj',$yaodan->ydgj);
    $cxjg->bindColumn('ydfy',$yaodan->ydfy);
    $cxjg->bindColumn('ydjg',$yaodan->ydjg);
    $cxjg->bindColumn('ydbj',$yaodan->ydbj);
    $cxjg->bindColumn('ydxx',$yaodan->ydxx);
    $cxjg->bindColumn('ydsum',$yaodan->ydsum);
	$cxjg->bindColumn('ydjgm',$yaodan->ydjgm);
    $ret = $cxjg->fetch(\PDO::FETCH_ASSOC);
    if ($ret){
        return $yaodan;
    }else{
        return false;
    }
}

function getplayeryaopinall($sid,$dblj){
    $sql = "select * from playeryaopin WHERE sid='$sid'";
    $cxjg = $dblj->query($sql);
    if ($cxjg){
        $ret = $cxjg->fetchAll(\PDO::FETCH_ASSOC);
        return $ret;
    }else{
        return false;
    }

}

function getplayeryaodanall($sid,$dblj){
    $sql = "select * from playeryaodan WHERE sid='$sid'";
    $cxjg = $dblj->query($sql);
    if ($cxjg){
        $ret = $cxjg->fetchAll(\PDO::FETCH_ASSOC);
        return $ret;
    }else{
        return false;
    }

}

function addyaopin($sid,$ypid,$ypsum,$dblj){
    $yaopin = getplayeryaopin($ypid,$sid,$dblj);
    if ($yaopin){
        $sql = "update playeryaopin set ypsum = ypsum + $ypsum WHERE ypid=$ypid AND sid='$sid'";
        $dblj->exec($sql);
    }else{
        $yaopin = getyaopinonce($ypid,$dblj);
        $sql = "insert into playeryaopin(ypname,yphp,ypgj,ypfy,ypbj,ypxx,ypid,ypjg,ypsum,sid) VALUES('$yaopin->ypname','$yaopin->yphp','$yaopin->ypgj','$yaopin->ypfy','$yaopin->ypbj','$yaopin->ypxx',$ypid,'$yaopin->ypjg','$ypsum','$sid')";
        $ret = $dblj->exec($sql);
    }
}

function addyaodan($sid,$ydid,$ydsum,$dblj){
    $yaodan = getplayeryaodan($ydid,$sid,$dblj);
    if ($yaodan){
        $sql = "update playeryaodan set ydsum = ydsum + $ydsum WHERE ydid=$ydid AND sid='$sid'";
        $dblj->exec($sql);
    }else{
        $yaodan = getyaodanonce($ydid,$dblj);
        $sql = "insert into playeryaodan(ydname,ydhp,ydgj,ydfy,ydbj,ydxx,ydid,ydjg,ydsum,sid,ydjgm) VALUES('$yaodan->ydname','$yaodan->ydhp','$yaodan->ydgj','$yaodan->ydfy','$yaodan->ydbj','$yaodan->ydxx',$ydid,'$yaodan->ydjg','$ydsum','$sid','$ydjgm')";
        $ret = $dblj->exec($sql);
    }
}

function deleyaopin($sid,$ypid,$ypsum,$dblj){
    $yaopin = getplayeryaopin($ypid,$sid,$dblj);
    if ($yaopin){
        if ($yaopin->ypsum>=$ypsum){
            $sql = "update playeryaopin set ypsum = ypsum - $ypsum WHERE ypid=$ypid AND sid='$sid'";
            $dblj->exec($sql);
            return true;
        }else{
            return false;
        }
    }else{
        return false;
    }
}

function deleyaodan($sid,$ydid,$ydsum,$dblj){
    $yaodan = getplayeryaodan($ydid,$sid,$dblj);
    if ($yaodan){
        if ($yaodan->ydsum>=$ydsum){
            $sql = "update playeryaodan set ydsum = ydsum - $ydsum WHERE ydid=$ydid AND sid='$sid'";
            $dblj->exec($sql);
            return true;
        }else{
            return false;
        }
    }else{
        return false;
    }
}

function changeplayersx($sx,$gaibian,$sid,$dblj){
    $sql = "update game1 set $sx = '$gaibian' WHERE sid='$sid'";//Cải biến người chơi thuộc tính
    $ret = $dblj->exec($sql);
}
function gaibianwg($sx,$gaibian,$wgid,$sid,$dblj){
    $sql = "update playerwugong set $sx = '$gaibian' WHERE $wgid='$wgid' and sid='$sid'";//Cải biến võ công
    $ret = $dblj->exec($sql);
}
function changecwsx($sx,$gaibian,$cwid,$dblj){
    $sql = "update playerchongwu set $sx = '$gaibian' WHERE cwid='$cwid'";//Cải biến sủng vật thuộc tính
    $ret = $dblj->exec($sql);
}

function addplayersx($sx,$gaibian,$sid,$dblj){
    $sql = "update game1 set $sx = $sx + '$gaibian' WHERE sid='$sid'";//Gia tăng người chơi thuộc tính
    $ret = $dblj->exec($sql);
}
function addcwsx($sx,$gaibian,$cwid,$dblj){
    $sql = "update playerchongwu set $sx = $sx + '$gaibian' WHERE cwid='$cwid'";//Gia tăng cw Thuộc tính
    $ret = $dblj->exec($sql);
}

function changeyxb($lx,$gaibian,$sid,$dblj){//Cải biến tiền tệ, tiền trò chơi địa chỉ, biến hóa, ID, xác định,
    $player = getplayer($sid,$dblj);
    if ($lx==1){
        $sql = "update game1 set uyxb = uyxb + $gaibian WHERE sid='$sid'";
        $dblj->exec($sql);
        return true;
    }elseif($lx==2){
        if ($player->uyxb - $gaibian >= 0){
            $sql = "update game1 set uyxb = uyxb - $gaibian WHERE sid='$sid'";
            $dblj->exec($sql);
            return true;
        }else{
            return false;
        }

    }
}
function changeczb($lx,$gaibian,$sid,$dblj){//Cải biến tiền tệ, nạp tiền tệ
    $player = getplayer($sid,$dblj);
    if ($lx==1){
        $sql = "update game1 set uczb = uczb + $gaibian WHERE sid='$sid'";
        $dblj->exec($sql);
        return true;
    }elseif($lx==2){
        if ($player->uczb - $gaibian >= 0){
            $sql = "update game1 set uczb = uczb - $gaibian WHERE sid='$sid'";
            $dblj->exec($sql);
            return true;
        }else{
            return false;
        }

    }
}

function changeyd($lx,$gaibian,$sid,$dblj){//Cải biến công kích,【Loại hình, biến hóa, ID, xác định,】【Người sửa chữa bên trong】……Khảo thí
    $player = getplayer($sid,$dblj);
    if ($lx==1){
        $sql = "update game1 set uyxb = ugj + $gaibian WHERE sid='$sid'";
        $dblj->exec($sql);
        return true;
    }elseif($lx==2){
        if ($player->uyxb - $gaibian >= 0){
            $sql = "update game1 set ugj = uyxb - $gaibian WHERE sid='$sid'";
            $dblj->exec($sql);
            return true;
        }else{
            return false;
        }

    }
}

class task{
    var $rwname;
    var $rwinfo;
    var $rwid;
    var $rwzl;
    var $rwyq;
    var $rwdj;
    var $rwzb;
    var $rwexp;
    var $rwyxb;
    var $sid;
    var $rwzt;//Trạng thái
    var $rwcount;
    var $rwyp;
    var $rwlx;
    var $rwnowcount;
    var $lastrwid;
}
function getplayerrenwu($sid,$dblj){
    $sql = "select * from playerrenwu WHERE sid='$sid'";
    $cxjg = $dblj->query($sql);
    $cxjg->bindColumn("rwname",$task->rwname);
//    $cxjg->bindColumn("rwinfo",$task->rwinfo);
//    $cxjg->bindColumn("rwid",$task->rwid);
//    $cxjg->bindColumn("rwzl",$task->rwzl);
//    $cxjg->bindColumn("rwyq",$task->rwyq);
//    $cxjg->bindColumn("rwdj",$task->rwdj);
//    $cxjg->bindColumn("rwzb",$task->rwzb);
//    $cxjg->bindColumn("rwexp",$task->rwexp);
//    $cxjg->bindColumn("rwyxb",$task->rwyxb);
//    $cxjg->bindColumn("rwzt",$task->rwzt);
//    $cxjg->bindColumn("rwcount",$task->rwcount);
    $task = $cxjg->fetchAll(\PDO::FETCH_ASSOC);
    return $task;
}
function gettask($rwid,$dblj){
    $task = new task();
    $sql = "select * from renwu WHERE rwid='$rwid'";
    $cxjg = $dblj->query($sql);
    $cxjg->bindColumn("rwname",$task->rwname);
    $cxjg->bindColumn("rwinfo",$task->rwinfo);
    $cxjg->bindColumn("rwzl",$task->rwzl);
    $cxjg->bindColumn("rwid",$task->rwid);
    $cxjg->bindColumn("rwyq",$task->rwyq);
    $cxjg->bindColumn("rwdj",$task->rwdj);
    $cxjg->bindColumn("rwzb",$task->rwzb);
    $cxjg->bindColumn("rwexp",$task->rwexp);
    $cxjg->bindColumn("rwyxb",$task->rwyxb);
    $cxjg->bindColumn("rwcount",$task->rwcount);
    $cxjg->bindColumn("rwlx",$task->rwlx);
    $cxjg->bindColumn("rwyp",$task->rwyp);
    $cxjg->bindColumn("lastrwid",$task->lastrwid);
	$cxjg->bindColumn("rwqy",$task->rwqy);
    $cxjg->fetchAll(\PDO::FETCH_ASSOC);
    return $task;
}
function getplayerrenwuonce($sid,$rwid,$dblj){
    $task = new task();
    $sql = "select * from playerrenwu WHERE sid='$sid' AND rwid=$rwid";
    $cxjg = $dblj->query($sql);

    $cxjg->bindColumn("rwname",$task->rwname);
    $cxjg->bindColumn("rwid",$task->rwid);
    $cxjg->bindColumn("rwzl",$task->rwzl);
    $cxjg->bindColumn("rwyq",$task->rwyq);
    $cxjg->bindColumn("rwdj",$task->rwdj);
    $cxjg->bindColumn("rwzb",$task->rwzb);
    $cxjg->bindColumn("rwexp",$task->rwexp);
    $cxjg->bindColumn("rwyxb",$task->rwyxb);
    $cxjg->bindColumn("rwzt",$task->rwzt);
    $cxjg->bindColumn("rwcount",$task->rwcount);
    $cxjg->bindColumn("rwnowcount",$task->rwnowcount);
    $cxjg->bindColumn("rwlx",$task->rwlx);
    $cxjg->bindColumn("rwyp",$task->rwyp);
    $ret = $cxjg->fetch(\PDO::FETCH_ASSOC);
    if (!$ret){
        return false;
    }
    return $task;
}
class boss{
    var $bossname;
    var $bosslv;
    var $bossid;
    var $bosstime;
    var $bs;
    var $bossinfo;
    var $bosshp;
    var $bossmaxhp;
    var $bossgj;
    var $bossfy;
    var $bossbj;
    var $bossxx;
    var $bossdj;
    var $bosszb;
	var $djjv;
	var $dljv;
	var $sid;
	var $yojv;
	var $bossyp;
}
function getboss($bossid,$dblj){
    $boss = new boss();
    $sql = "select * from boss WHERE bossid=$bossid";
    $cxjg = $dblj->query($sql);
    $cxjg->bindColumn('bossname',$boss->bossname);
    $cxjg->bindColumn('bossid',$boss->bossid);
    $cxjg->bindColumn('bosstime',$boss->bosstime);
    $cxjg->bindColumn('bs',$boss->bs);
    $cxjg->bindColumn('bossinfo',$boss->bossinfo);
    $cxjg->bindColumn('bosshp',$boss->bosshp);
	$cxjg->bindColumn('bossmaxhp',$boss->bossmaxhp);
    $cxjg->bindColumn('bosslv',$boss->bosslv);
    $cxjg->bindColumn('bossgj',$boss->bossgj);
    $cxjg->bindColumn('bossfy',$boss->bossfy);
    $cxjg->bindColumn('bossbj',$boss->bossbj);
    $cxjg->bindColumn('bossxx',$boss->bossxx);
    $cxjg->bindColumn('bossdj',$boss->bossdj);
    $cxjg->bindColumn('bosszb',$boss->bosszb);
	$cxjg->bindColumn('bossyp',$boss->bossyp);
	$cxjg->bindColumn('ypjv',$boss->dljv);
	$cxjg->bindColumn('dljv',$boss->dljv);
	$cxjg->bindColumn('djjv',$boss->djjv);
	$cxjg->bindColumn('sid',$boss->sid);
	
    $cxjg->fetch(\PDO::FETCH_ASSOC);
    return $boss;
}
function useyaopin($ypid,$ypsum,$sid,$dblj){
    $player = getplayer($sid,$dblj);
    if ($player->uhp<=0){
        return false;
    }
    $ret = deleyaopin($sid,$ypid,$ypsum,$dblj);
    if ($ret){

        $hpc = $player->umaxhp - $player->uhp;
        $yaopin = getyaopinonce($ypid,$dblj);
        if ($yaopin->yphp >= $hpc){
            addplayersx('uhp',$hpc,$sid,$dblj);
        }else{
            addplayersx('uhp',$yaopin->yphp,$sid,$dblj);
        }
        addplayersx('ugj',$yaopin->ypgj,$sid,$dblj);
        addplayersx('ufy',$yaopin->ypfy,$sid,$dblj);
        addplayersx('ugj',$yaopin->ypbj,$sid,$dblj);
        addplayersx('ugj',$yaopin->ypxx,$sid,$dblj);
    }
    return $ret;
}

function useyaodan($ydid,$ydsum,$sid,$dblj){
    $player = getplayer($sid,$dblj);//Thu hoạch tên, không có đi hàng ngũ nhứ nhất tả hữu tăng thêm
    if ($player->ugj<=0){//Phán đoán điều kiện chấp hành phía dưới
        return false;
    }
    $ret = deleyaodan($sid,$ydid,$ydsum,$dblj);
    if ($ret){

        $hpc = $yaodan->ugj;
        $yaodan = getyaodanonce($ydid,$dblj);//Dược phẩm thuộc tính
        if ($yaodan->ydgj >= $hpc){
            addplayersx('ugj',$hpc,$sid,$dblj);
        }else{
            addplayersx('ugj',$yaodan->ydgj,$sid,$dblj);//Khống chế công kích tăng thêm
        }
        addplayersx('ugj',$yaodan->ydgj,$sid,$dblj);
        addplayersx('ufy',$yaodan->ydfy,$sid,$dblj);
        addplayersx('ubj',$yaodan->ydbj,$sid,$dblj);
        addplayersx('uxx',$yaodan->ydxx,$sid,$dblj);
		addplayersx('uhp',$yaodan->ydhp,$sid,$dblj);
    }
    return $ret;
}

class chongwu{
    var $cwname;
    var $cwlv;
    var $cwexp;
    var $cwmaxexp;
    var $cwhp;
    var $cwmaxhp;
    var $cwgj;
    var $cwfy;
    var $cwbj;
    var $cwxx;
    var $uphp;
    var $upgj;
    var $upfy;
    var $cwpz;
    var $tool1;
    var $tool2;
    var $tool3;
    var $tool4;
    var $tool5;
    var $tool6;
    var $tool7;
}

/**
 * @param $cwid
 * @param $dblj
 * @return chongwu//Sủng vật tăng thêm tính toán, ta cảm giác kinh nghiệm nhận được  tăng thêm cùng uexp Đồng dạng, quá nhiều, khó
 */
function getchongwu($cwid, $dblj){
    $chongwu = new chongwu();
    $rangeslv = array(0, 30, 50, 70, 80, 90, 100, 110);
    $rangesgj = array(2.5, 5, 7.5, 10, 12.5, 15, 17.5);
    $rangesfy = array(2.5, 5, 7.5, 10, 12.5, 15, 17.5);
    $rangeshp = array(30, 50, 70, 90, 110, 130, 170);
    $rangesexp = array(2, 4, 6, 9, 12.5, 15, 17.5);
    $sql = "select * from playerchongwu WHERE cwid = $cwid ";
    $cxjg = $dblj->query($sql);
    $cxjg->bindColumn("cwname",$chongwu->cwname);
    $cxjg->bindColumn("cwlv",$chongwu->cwlv);
    $cxjg->bindColumn("cwexp",$chongwu->cwexp);
    $cxjg->bindColumn("cwhp",$chongwu->cwhp);
    $cxjg->bindColumn("cwmaxhp",$chongwu->cwmaxhp);
    $cxjg->bindColumn("cwgj",$chongwu->cwgj);
    $cxjg->bindColumn("cwfy",$chongwu->cwfy);
    $cxjg->bindColumn("cwbj",$chongwu->cwbj);
    $cxjg->bindColumn("cwxx",$chongwu->cwxx);
    $cxjg->bindColumn("uphp",$chongwu->uphp);
    $cxjg->bindColumn("upgj",$chongwu->upgj);
    $cxjg->bindColumn("upfy",$chongwu->upfy);
    $cxjg->bindColumn("cwpz",$chongwu->cwpz);
    $cxjg->bindColumn("tool1",$chongwu->tool1);
    $cxjg->bindColumn("tool2",$chongwu->tool2);
    $cxjg->bindColumn("tool3",$chongwu->tool3);
    $cxjg->bindColumn("tool4",$chongwu->tool4);
    $cxjg->bindColumn("tool5",$chongwu->tool5);
    $cxjg->bindColumn("tool6",$chongwu->tool6);
    $cxjg->bindColumn("tool7",$chongwu->tool7);


    $tools = [$chongwu->tool1, $chongwu->tool2, $chongwu->tool3, $chongwu->tool4, $chongwu->tool5, $chongwu->tool6, $chongwu->tool7];
    foreach ($tools as $toolId) {
        if ($toolId != 0) {
            $zhuangbei = getzb($toolId, $dblj);
            $chongwu->ugj = $chongwu->cwgj + $zhuangbei->zbgj;
            $chongwu->ufy = $chongwu->cwfy + $zhuangbei->zbfy;
            $chongwu->ubj = $chongwu->cwbj + $zhuangbei->zbbj;
            $chongwu->uxx = $chongwu->cwxx + $zhuangbei->zbxx;
            $chongwu->umaxhp = $chongwu->cwmaxhp + $zhuangbei->zbhp;
        }
    }

    $ret = $cxjg->fetch(\PDO::FETCH_ASSOC);
    for ($i=0;$i<count($rangeslv)-1;$i++){
        if ($chongwu->cwlv>=$rangeslv[$i] && $chongwu->cwlv<$rangeslv[$i+1]){
            $cwnextlv = $chongwu->cwlv + 1;
            $chongwu->cwmaxexp = $cwnextlv *($cwnextlv+round($cwnextlv/2))*50*$rangesexp[$i]+$cwnextlv;//Sủng vật thăng cấp cwmaxexp Thăng cấp tính toán, ta đổi thành 50 Lần ngầm thừa nhận 10 Lần
            break;
        }
    }
    return $chongwu;
}

function getchongwuall($sid,$dblj){
    $sql = "select * from playerchongwu WHERE sid = '$sid'";
    $cxjg = $dblj->query($sql);
    if ($cxjg){
        $ret = $cxjg->fetchAll(\PDO::FETCH_ASSOC);
        return $ret;
    }else{
        return false;
    }
}
class wg1{
    var $wgname;
    var $wgid;
    var $wgdj;
    var $uid;
    var $sid;
    var $wglx;
	var $wgys;
	var $wgsum;
	var $wginfo;
	var $wgxl;
	var $wgxlmax;
	var $xlzt;
	var $xlsj;
}
function wugongcs($wgid,$sid, $dblj){
    $chongwu = new wg1();
    $rangeslv = array(0, 2, 4, 6, 8, 10, 12, 15);
    $sql = "select * from playerwugong WHERE wgid = $wgid and sid=$sid ";
    $cxjg = $dblj->query($sql);
    $cxjg->bindColumn("wgname",$chongwu->wgname);
    $cxjg->bindColumn("wgdj",$chongwu->wgdj);
    $cxjg->bindColumn("wgys",$chongwu->wgys);
    $cxjg->bindColumn("wginfo",$chongwu->wginfo);
    $cxjg->bindColumn("wgid",$chongwu->wgid);
    $cxjg->bindColumn("wgsum",$chongwu->wgsum);
    $cxjg->bindColumn("uid",$chongwu->uid);
    $cxjg->bindColumn("sid",$chongwu->sid);
    $cxjg->bindColumn("wgxl",$chongwu->wgxl);
    $cxjg->bindColumn("wgxlmax",$chongwu->wgxlmax);
    $cxjg->bindColumn("wglx",$chongwu->wglx);


    $ret = $cxjg->fetch(\PDO::FETCH_ASSOC);
    for ($i=0;$i<count($rangeslv)-1;$i++){
        if ($chongwu->wgdj>=$rangeslv[$i] && $chongwu->wgdj<$rangeslv[$i+1]){
            $cwnextlv = $chongwu->wgdj + 1;
            $chongwu->wgdj = $cwnextlv + 0 ;
            
            break;
        }
    }
    return $chongwu;
}
function wgsl($sid,$dblj){
    $sql = "select * from playerwugong WHERE sid = '$sid'";
    $cxjg = $dblj->query($sql);
    if ($cxjg){
        $ret = $cxjg->fetchAll(\PDO::FETCH_ASSOC);
        return $ret;
    }else{
        return false;
    }
}

function addchongwu($sid,$dblj){
    $cw1 = array('Cú Mang','Ngu cương','Thần đồ', 'Chúc Long','Bạch Trạch');
    $cw2 = array('Thanh Long','Bạch Hổ','Chu Tước','Huyền Vũ');
    $cw3 = array('Thao Thiết','Thọ ngột','Hỗn độn','Cùng Kỳ');
    $cw4 = array('Lanh lợi chuột','Ngây ngốc trâu','Uy uy hổ', 'Nhảy nhót thỏ','Lạnh lùng rồng','Tiêu xài một chút rắn','Linh lợi ngựa','Be be dê','Đẹp trai đẹp trai khỉ','Trứng gà đẻ','Ngoan ngoãn chó','Heo thần tài');
    $uphp = mt_rand(8,25);
    $upgj = mt_rand(2,5);
    $upfy = mt_rand(3,8);
    $cwpz = mt_rand(0,500);
    if ($cwpz<200){
        $cwpz=0;
    }elseif ($cwpz<350){
        $cwpz=1;
    }elseif ($cwpz<430){
        $cwpz=2;
    }elseif ($cwpz<470){
        $cwpz=3;
    }elseif ($cwpz<495){
        $cwpz=4;
    }elseif ($cwpz<600){//Nơi này trước kia ngầm thừa nhận 500 Không có cân nhắc tương đương 500, tương đương 500 Nhưng chính là trực tiếp chuyển vận, đổi 600
        $cwpz=5;
    }
    $sjs1 = mt_rand(0,15);
    $cwlv = 1;
    $cwmaxhp = 100;
    $cwhp = 100;
    $cwgj = 6+$sjs1;
    $cwfy = $sjs1;
    $sjs = mt_rand(0,11);
    $sql = "insert into playerchongwu(cwname,cwlv,cwhp,cwmaxhp,cwgj,cwfy,uphp,upgj,upfy,cwpz,sid,cwmaxexp) VALUES ('$cw4[$sjs]','$cwlv','$cwhp','$cwmaxhp','$cwgj','$cwfy','$uphp','$upgj','$upfy','$cwpz','$sid','cwmaxexp')";
    $cxjg = $dblj->exec($sql);
}



function delechongwu($cwid,$sid,$dblj){
    
    $sql = "delete from `playerchongwu` WHERE cwid=$cwid AND sid='$sid'";
    $dblj->exec($sql);
}




function changecwexp($cwid,$exp,$dblj){
    $sql = "update playerchongwu set cwexp = cwexp + $exp where cwid='$cwid'";
    $ret = $dblj->exec($sql);
    $cw = getchongwu($cwid,$dblj);
    if ($cw->cwexp >= $cw->cwmaxexp){
        $sql = "update playerchongwu set cwexp = cwexp - $cw->cwmaxexp where cwid='$cwid'";
        $dblj->exec($sql);

        $rangeslv = array(1, 30, 50, 70, 80, 90, 100, 110);
        $playernextlv = $cw->cwlv + 1;
        for ($i=0;$i<count($rangeslv)-1;$i++){
            if ($playernextlv >= $rangeslv[$i] && $playernextlv < $rangeslv[$i+1]){

                $rangeshp = array(20, 30, 50, 70, 90, 110, 140);
                $rangesgj = array(2.5, 5, 7.5, 10, 12.5, 15, 17.5);
                $rangesfy = array(2.5, 5, 7.5, 10, 12.5, 15, 17.5);

                $uphp = $cw->uphp * (1 + ($cw->cwpz/10));
                $upgj = $cw->upgj * (1 + ($cw->cwpz/10));
                $upfy = $cw->upfy * (1 + ($cw->cwpz/10));
                $sql = "update playerchongwu set cwlv = cwlv + 1,
                                           cwmaxhp = cwmaxhp + $uphp,
                                           cwgj = cwgj + $upgj,  
                                           cwfy = cwfy + $upfy
                                           where cwid = '$cwid'";
                $ret = $dblj->exec($sql);
                break;
            }
        }
    }
}

class jineng{
    var $jnname;
    var $jnid;
    var $jngj;
    var $jnfy;
    var $jnbj;
    var $jnxx;
    var $jndj;
    var $djcount;
    var $jncount;
}

function getjineng_all($dblj){
    $sql = "select * from jineng";
    $cxjg = $dblj->query($sql);
    $retjn = $cxjg->fetchAll(\PDO::FETCH_ASSOC);
    return $retjn;
}
function getplayerjineng_all($sid,$dblj){
    $sql = "select * from playerjineng WHERE sid='$sid'";
    $cxjg = $dblj->query($sql);
    $retjn = $cxjg->fetchAll(\PDO::FETCH_ASSOC);
    return $retjn;
}
function getjineng_once($jnid,$dblj){
    $jineng = new jineng();
    $sql = "select * from jineng WHERE jnid=$jnid";
    $cxjg = $dblj->query($sql);
    $cxjg->bindColumn("jnname",$jineng->jnname);
    $cxjg->bindColumn("jnid",$jineng->jnid);
    $cxjg->bindColumn("jngj",$jineng->jngj);
    $cxjg->bindColumn("jnfy",$jineng->jnfy);
    $cxjg->bindColumn("jnbj",$jineng->jnbj);
    $cxjg->bindColumn("jnxx",$jineng->jnxx);
    $cxjg->bindColumn("jndj",$jineng->jndj);
    $cxjg->bindColumn("djcount",$jineng->djcount);
    $cxjg->fetch(\PDO::FETCH_ASSOC);
    return $jineng;
}

function getplayerjineng($jnid,$sid,$dblj){
    $jineng = new jineng();
    $sql = "select * from playerjineng WHERE jnid=$jnid and sid='$sid'";
    $cxjg = $dblj->query($sql);

    $cxjg->bindColumn("jnname",$jineng->jnname);
    $cxjg->bindColumn("jnid",$jineng->jnid);
    $cxjg->bindColumn("jngj",$jineng->jngj);
    $cxjg->bindColumn("jnfy",$jineng->jnfy);
    $cxjg->bindColumn("jnbj",$jineng->jnbj);
    $cxjg->bindColumn("jnxx",$jineng->jnxx);
    $cxjg->bindColumn("jncount",$jineng->jncount);
    $ret = $cxjg->fetch(\PDO::FETCH_ASSOC);

    if ($ret){
        return $jineng;
    }
    return $ret;
}

function addjineng($jnid,$jncount,$sid,$dblj){
    $jineng = getjineng_once($jnid,$dblj);
    $ret = getplayerjineng($jnid,$sid,$dblj);
    if ($ret){
        $sql = "update `playerjineng` set jncount= jncount + $jncount WHERE jnid = $jnid AND sid='$sid'";
    }else{
        $sql = "insert into `playerjineng`(jnname,jnid,jngj,jnfy,jnbj,jnxx,sid,jncount) VALUES ('$jineng->jnname','$jineng->jnid','$jineng->jngj','$jineng->jnfy','$jineng->jnbj','$jineng->jnxx','$sid','$jncount')";
    }
    $ret = $dblj->exec($sql);
}

function delejnsum($jnid,$jnsum,$sid,$dblj){
    $jnneng = getplayerjineng($jnid,$sid,$dblj);
    if ($jnneng){
        if ($jnneng->jncount >= $jnsum && $jnsum > 0){
            $sql = "update playerjineng set jncount = jncount - $jnsum where sid='$sid' and jnid = $jnid";
            $dblj->exec($sql);
            return true;
        }else{
            return false;
        }
    }else{
        return false;
    }
}
class mqy{
    var $qyname;
    var $qyid;
    var $mid;
}

function getqy($qyid,$dblj){
    $qy = new mqy();
    $sql = "select * from `qy` WHERE qyid=$qyid";
    $cxjg = $dblj->query($sql);
    $cxjg->bindColumn('qyname',$qy->qyname);
    $cxjg->bindColumn('qyid',$qy->qyid);
    $cxjg->bindColumn('mid',$qy->mid);
    $cxjg->fetch(\PDO::FETCH_ASSOC);
    return $qy;
}
function getqy_all($dblj){
    $sql = "select * from `qy`";
    $cxjg = $dblj->query($sql);
    $ret = $cxjg->fetchAll(\PDO::FETCH_ASSOC);
    return $ret;
}
function getqy_dt($dblj){
    $sql = "select * from `mid`";
    $cxjg = $dblj->query($sql);
    $ret = $cxjg->fetchAll(\PDO::FETCH_ASSOC);
    return $ret;
}
class gameconfig{
    var $firstmid;
}
function getgameconfig($dblj){
    $gameconfig = new gameconfig();
    $sql = "select * from `gameconfig`";
    $cxjg = $dblj->query($sql);
    $cxjg->bindColumn('firstmid',$gameconfig->firstmid);
    $ret = $cxjg->fetch(\PDO::FETCH_ASSOC);
    return $gameconfig;
}

class fangshi_dj{
    var $djid;
    var $djname;
    var $pay;
    var $uid;
    var $djcount;
    var $payid;
    var $djinfo;
}

/**
 * @property  djid
 */
class fangshi_zb{
    var $zbnowid;
    var $pay;
    var $payid;
    var $uid;
}
function getfangshi_once($lx,$payid,$dblj){
    switch ($lx){
        case "daoju":
            $fsdj = new fangshi_dj();
            $sql = "select * from `fangshi_dj` WHERE payid = $payid";
            $redj = $dblj->query($sql);
            $redj->bindColumn('djid',$fsdj->djid);
            $redj->bindColumn('djname',$fsdj->djname);
            $redj->bindColumn('pay',$fsdj->pay);
            $redj->bindColumn('uid',$fsdj->uid);
            $redj->bindColumn('djcount',$fsdj->djcount);
            $redj->bindColumn('payid',$fsdj->payid);
            $redj->bindColumn('djinfo',$fsdj->djinfo);
            $dj = $redj->fetch(\PDO::FETCH_ASSOC);
            if ($dj){
                return $fsdj;
            }
            return $dj;
        case "zhuangbei":
            $fszb = new fangshi_zb();
            $sql = "select * from `fangshi_zb` WHERE payid = $payid ";
            $redj = $dblj->query($sql);
            $redj->bindColumn('zbnowid',$fszb->zbnowid);
            $redj->bindColumn('payid',$fszb->payid);
            $redj->bindColumn('uid',$fszb->uid);
            $redj->bindColumn("pay",$fszb->pay);
            $zb = $redj->fetch(\PDO::FETCH_ASSOC);
            if ($zb){
                return $fszb;
            }
            return $zb;
		case "shangdian":
            $fszb = new fangshi_zb();
            $sql = "select * from `fangshi_sd` WHERE payid = $payid";
            $redj = $dblj->query($sql);
            $redj->bindColumn('zbnowid',$fszb->zbnowid);
            $redj->bindColumn('payid',$fszb->payid);
            $redj->bindColumn('uid',$fszb->uid);
            $redj->bindColumn("pay",$fszb->pay);
            $zb = $redj->fetch(\PDO::FETCH_ASSOC);
            if ($zb){
                return $fszb;
            }
            return $zb;
    }

}

/**
 * @param $lx
 * @param $dblj
 * @return mixed
 */
function getfangshi_all($lx, $dblj){
    switch ($lx){
        case "daoju":
            $sql = "select * from `fangshi_dj`";
            $redj = $dblj->query($sql);
            $dj = $redj->fetchAll(\PDO::FETCH_ASSOC);
            return $dj;
        case "zhuangbei":
		    $sql = "select * from youtable order by rand() limit 5";
		
            $sql = "select * from `fangshi_zb`";
			
            $redj = $dblj->query($sql);
            $dj = $redj->fetchAll(\PDO::FETCH_ASSOC);
            return $dj;
		case "shangdian":
            $sql = "select * from `fangshi_sd` ";
			
            $redj = $dblj->query($sql);
            $dj = $redj->fetchAll(\PDO::FETCH_ASSOC);
            return $dj;
    }

}

class club{
    var $clubname;
    var $clubid;
    var $clublv;
    var $clubexp;
    var $clubno1;
    var $clubinfo;
    var $clubyxb;
    var $clubczb;
}
function getclub($clubid,$dblj){
    $club = new club();
    $sql = "select * from `club` WHERE clubid = $clubid ";
    $retc = $dblj->query($sql);
    $retc->bindColumn("clubname",$club->clubname);
    $retc->bindColumn("clubinfo",$club->clubinfo);
    $retc->bindColumn("clublv",$club->clublv);
    $retc->bindColumn("clubexp",$club->clubexp);
    $retc->bindColumn("clubid",$club->clubid);
    $retc->bindColumn("clubno1",$club->clubno1);
    $retc->bindColumn("clubyxb",$club->clubyxb);
    $retc->bindColumn("clubczb",$club->clubczb);
    $retc->fetch(\PDO::FETCH_ASSOC);
    return $club;
}

function getclub_all($dblj){
    $sql = "select * from `club`";
    $retc = $dblj->query($sql);
    $club = $retc->fetchAll(\PDO::FETCH_ASSOC);
    return $club;
}

class clubplayer{
    var $clubid;
    var $uid;
    var $sid;
    var $uclv;
}

/**
 * @param $sid
 * @param $dblj
 * @return clubplayer
 */
function getclubplayer_once($sid, $dblj){
    $clubplayer = new clubplayer();
    $sql = "select * from `clubplayer` WHERE sid = '$sid'";
    $retc = $dblj->query($sql);
    $retc->bindColumn('clubid',$clubplayer->clubid);
    $retc->bindColumn('uid',$clubplayer->uid);
    $retc->bindColumn('uid',$clubplayer->uid);
    $retc->bindColumn('uclv',$clubplayer->uclv);
    $ret = $retc->fetch(\PDO::FETCH_ASSOC);
    if (!$ret){
        return $ret;
    }
    return $clubplayer;
}

class duihuan{
    var $dhid;
    var $dhm;
    var $dhzb;
    var $dhdj;
    var $dhyp;
    var $dhyxb;
    var $dhczb;
    var $dhname;
    var $dhexp;
}

function getduihuan($dhm,$dblj){
    $duihuan = new duihuan();
    $sql = "select * from duihuan WHERE dhm = '$dhm'";
    $ret = $dblj->query($sql);
    $ret->bindColumn('dhid',$duihuan->dhid);
    $ret->bindColumn('dhm',$duihuan->dhm);
    $ret->bindColumn('dhzb',$duihuan->dhzb);
    $ret->bindColumn('dhdj',$duihuan->dhdj);
    $ret->bindColumn('dhyp',$duihuan->dhyp);
    $ret->bindColumn('dhyxb',$duihuan->dhyxb);
    $ret->bindColumn('dhczb',$duihuan->dhczb);
    $ret->bindColumn('dhname',$duihuan->dhname);
    $ret->bindColumn('dhexp',$duihuan->dhexp);
    $ret = $ret->fetch(\PDO::FETCH_ASSOC);
    if ($ret){
        return $duihuan;
    }
    return $ret;
}
class im{
    var $imuid;
    var $uid;
    var $sid;
}
function isim($uid,$sid,$dblj){
    $sql="select imuid from im WHERE imuid = $uid AND sid = '$sid'";
    $ret = $dblj->query($sql);
    $row = $ret->rowCount();
    return $row;
}
class wg{
    var $wgname;
    var $wgid;
    var $wgdj;
    var $uid;
    var $sid;
    var $wglx;
	var $wgys;
	var $wgsum;
	var $wginfo;
	var $wgxl;
	var $wgxlmax;
	var $xlzt;
	var $xlsj;
}
function wgcx($wgid,$sid,$dblj){
    $wgcx = new wg();
    $sql = "select * from playerwugong WHERE wgid='$wgid' and sid='$sid'";
    $cxjg = $dblj->query($sql);
        $cxjg->bindColumn('wgdj',$wgcx->wgdj);
        $cxjg->bindColumn('sid',$wgcx->sid);
        $cxjg->bindColumn('uid',$wgcx->uid);
        $cxjg->bindColumn('wgys',$wgcx->wgys);
        $cxjg->bindColumn('wgname',$wgcx->wgname);
        $cxjg->bindColumn('wgid',$wgcx->wgid);
        $cxjg->bindColumn('wglx',$wgcx->wglx);
        $cxjg->bindColumn('wginfo',$wgcx->wginfo);
		$cxjg->bindColumn('wgsum',$wgcx->wgsum);
		$cxjg->bindColumn('wgxl',$wgcx->wgxl);
		$cxjg->bindColumn('wgxlmax',$wgcx->wgxlmax);
		$cxjg->bindColumn('xlzt',$wgcx->xlzt);
		$cxjg->bindColumn('xlsj',$wgcx->xlsj);
		
    $ret = $cxjg->fetch(\PDO::FETCH_ASSOC);
    if ($ret){
        return $wgcx;
    }else{
        return false;
    }
}
//Xóa bỏ võ công
function delewugong($wgid,$sid,$dblj){
    $cx = wgcx($wgid,$sid,$dblj);
    if($cx->wgsum == 0){
    $sql = "delete from `playerchongwu` WHERE wgid=$wgid AND sid='$sid'";
    $dblj->exec($sql);
    }else{
     $sql = "update playerwugong set wgsum = wgsum - 1 WHERE wgid=$wgid AND sid='$sid'";
    $dblj->exec($sql);
    }
}


function wgcs($wgid,$sid,$dblj){
    $wgcs = new wg();
    $sql = "select * from playerwugong WHERE wgid='$wgid' and sid='$sid'";
    $cxjg = $dblj->query($sql);
        $cxjg->bindColumn('wgdj',$wgcs->wgdj);
        $cxjg->bindColumn('sid',$wgcs->sid);
        $cxjg->bindColumn('uid',$wgcs->uid);
        $cxjg->bindColumn('wgys',$wgcs->wgys);
        $cxjg->bindColumn('wgname',$wgcs->wgname);
        $cxjg->bindColumn('wgid',$wgcs->wgid);
        $cxjg->bindColumn('wglx',$wgcs->wglx);
        $cxjg->bindColumn('wginfo',$wgcs->wginfo);
		$cxjg->bindColumn('wgsum',$wgcs->wgsum);
		$cxjg->bindColumn('wgxl',$wgcs->wgxl);
		$cxjg->bindColumn('wgxlmax',$wgcs->wgxlmax);
		$cxjg->bindColumn('xlzt',$wgcs->xlzt);
		$cxjg->bindColumn('xlsj',$wgcs->xlsj);
		
    $ret = $cxjg->fetch(\PDO::FETCH_ASSOC);
    if ($ret){
        return $wgcs;
    }else{
        return false;
    }
}

class miji{
    var $wgname;
    var $wginfo;
    var $wgys;
	var $wgid;
	var $wglx;
}
function cqmj($wgid,$dblj){
    $miji = new miji();
    $sql = "select * from wugong where wgid='$wgid'";
    $cxjg = $dblj->query($sql);
    $cxjg->bindColumn('wgname',$miji->wgname);
    $cxjg->bindColumn('wginfo',$miji->wginfo);
    $cxjg->bindColumn('wgid',$miji->wgid);
    $cxjg->bindColumn('wgys',$miji->wgys);
    $cxjg->bindColumn('wglx',$miji->wglx);
    $cxjg->fetch(\PDO::FETCH_ASSOC);
    return $miji;
}
function mjcx($cqsjs,$dblj){
    $miji = new miji();
    $sql = "select * from wugong WHERE wgid='$cqsjs'";
    $cxjg = $dblj->query($sql);
    $cxjg->bindColumn('wgname',$miji->wgname);
    $cxjg->bindColumn('wginfo',$miji->wginfo);
    $cxjg->bindColumn('wgid',$miji->wgid);
    $cxjg->bindColumn('wgys',$miji->wgys);
    $cxjg->bindColumn('wglx',$miji->wglx);
    $ret = $cxjg->fetch(\PDO::FETCH_ASSOC);
    if ($ret){
        return $miji;
    }else{
        return false;
    }
}

//Rút ra bí tịch, nơi này tuyển trước ba bản
function cqwg($cqsjs,$sid,$dblj){
	$wgsum = 1 ;
	$wg = wgcx($cqsjs,$sid,$dblj);
	
	// $cqmj = mjcx($cqsjs,$dblj);
	// $wgname = $cqmj->wgname;
	// $wginfo = $cqmj->wginfo;
	// $wgid = $cqmj->wgid;
	// $wgys = $cqmj->wgys;
	// $wglx = $cqmj->wglx;
	
	if ($wg){
		$sql = "update playerwugong set wgsum = wgsum + $wgsum WHERE wgid='$cqsjs' AND sid='$sid'";
        $dblj->exec($sql);
    }else{
    $mj = new miji();
    $sql = "select * from wugong WHERE wgid='$cqsjs'";
    $cxjg = $dblj->query($sql);
    $cxjg->bindColumn('wgname',$mj->wgname);
    $cxjg->bindColumn('wginfo',$mj->wginfo);
    $cxjg->bindColumn('wgid',$mj->wgid);
    $cxjg->bindColumn('wgys',$mj->wgys);
	$cxjg->bindColumn('wglx',$mj->wglx);
    $cxjg->fetch(\PDO::FETCH_ASSOC);
	$wgname = $mj->wgname;
	$wginfo = $mj->wginfo;
	$wgid = $mj->wgid;
	$wgys = $mj->wgys;
	$wglx = $mj->wglx;

	$sql = "insert into playerwugong(wgname,wgid,wginfo,wgys,sid,uid,wglx,wgsum) VALUES ('$wgname','$wgid','$wginfo','$wgys','$sid','$uid','$wglx','$wgsum')";
    $dblj->exec($sql);
	
	}

}


function addim($imuid,$sid,$dblj){
    $player = getplayer($sid,$dblj);
    $sql = "insert into `im`(imuid, sid, uid) VALUES ($imuid,'$sid',$player->uid)";
    $dblj->exec($sql);
}
