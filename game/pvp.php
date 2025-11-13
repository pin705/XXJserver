<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2021 /12/19 Chuẩn bị sửa chữa sủng vật xuất trạm Cùng thuộc tính trưởng thành
 * Time: 22:22
 */
//if (!isset($uid)){
//
//}
$cxmid = \player\getmid($player->nowmid,$dblj);
$cxqy = \player\getqy($cxmid->mqy,$dblj);
$gorehpmid = $encode->encode("cmd=gomid&newmid=$cxqy->mid&sid=$player->sid");
$player = \player\getplayer($sid,$dblj);
$pvper = \player\getplayer1($uid,$dblj);
$gonowmid = $encode->encode("cmd=gomid&newmid=$player->nowmid&sid=$player->sid");
if ($cxmid->ispvp == 0){
    \player\changeplayersx("ispvp",0,$sid,$dblj);
    $tishihtml = 'Trước mắt địa đồ không cho phép PK<br/><br/>'.
        '<a href="?cmd='.$gonowmid.'">Trở về trò chơi</a>';
    exit($tishihtml);;
}

if ($pvper->sfzx == 0){
    \player\changeplayersx("ispvp",0,$sid,$dblj);
    $tishihtml = 'Nên người chơi không có online<br/><br/>'.
        '<a href="?cmd='.$gonowmid.'">Trở về trò chơi</a>';
    exit($tishihtml);;
}
if ($pvper->nowmid != $player->nowmid){
    \player\changeplayersx("ispvp",0,$sid,$dblj);
    $tishihtml = 'Nên người chơi không có ở nơi đó đồ<br/><br/>'.
        '<a href="?cmd='.$gonowmid.'">Trở về trò chơi</a>';
    exit($tishihtml);
}
if ($player->uhp<=0){
    \player\changeplayersx("ispvp",0,$sid,$dblj);
    $tishihtml = 'Ngươi là thân bị trọng thương, không cách nào tiến hành chiến đấu<br/><br/>'.
        '<a href="?cmd='.$gorehpmid.'">Trở về trò chơi</a>';
    exit($tishihtml);
}
if ($pvper->uhp<=0){
    \player\changeplayersx("ispvp",0,$sid,$dblj);
	 \player\changeplayersx("ispvp",0,$pvper->sid,$dblj);
	 
    $tishihtml = '<FONT color="#ff7888" size="3.5&sid">Nên người chơi đã nhận bạo lực một kích, trước mắt chính vùng vẫy giãy chết, còn xin đại hiệp giơ cao đánh khẽ。</FONT><br/><br/>'.

        '<a href="?cmd='.$gonowmid.'">Trở về trò chơi</a>';
    exit($tishihtml);
}
//\player\changeplayersx("ispvp",$pvper->uid,$sid,$dblj);
\player\changeplayersx("ispvp",$player->uid,$pvper->sid,$dblj);
$pvperhurt = '';
$tishihtml = '';
$pvpbj = '';
if (isset($canshu)){
    switch ($canshu){
        case 'gj':
            $jineng = new \player\jineng();
            if (isset($jnid)){
                $ret = \player\delejnsum($jnid,1,$sid,$dblj);
                if ($ret){
                    $jineng = \player\getplayerjineng($jnid,$sid,$dblj);
                    $tishihtml = "Sử dụng kỹ năng：$jineng->jnname<br/>";
                }else{
                    $tishihtml = "Kỹ năng số lượng không đủ<br/>";
                }
            }
            $player->ugj +=$jineng->jngj;
            $player->ufy +=$jineng->jnfy;
            $player->ubj +=$jineng->jnbj;
            $player->uxx +=$jineng->jnxx;

            $ran = mt_rand(1,100);
            if ($player->ubj >= $ran){
                $player->ugj = round($player->ugj * 1.82);
                $pvpbj = 'Bạo kích';
            }

            $pvperhurt = round($player->ugj - $pvper->ufy * 0.75,0);
            if ($pvperhurt < $player->ugj * 0.05){
                $pvperhurt = round($player->ugj*0.05);
            }

            $pvpxx = round($pvperhurt*($player->uxx/100));

            $sql = "update game1 set uhp = uhp - $pvperhurt  WHERE sid = '$pvper->sid'";
            $dblj->exec($sql);


            \player\addplayersx("uhp",$pvpxx,$sid,$dblj);

            $player =  player\getplayer($sid,$dblj);
			
            if ($player->uhp > $player->umaxhp){
                \player\changeplayersx("uhp",$player->umaxhp,$sid,$dblj);
                $player =  player\getplayer($sid,$dblj);
            }
            $pvper = \player\getplayer1($uid,$dblj);
            $pvperhurt = '-'.$pvperhurt;
            if ($pvper->uhp<=0){
                \player\changeplayersx("ispvp",0,$sid,$dblj);
                \player\changeplayersx("ispvp",0,$pvper->sid,$dblj);
				
				
                $dieinfo = ["Nghe nói$player->uname Đánh chết$pvper->uname","$pvper->uname Bị$player->uname Đánh cho hoa rơi nước chảy"," $player->uname Đem$pvper->uname Đánh cho sinh hoạt không thể tự gánh vác"];
				
				
                $randdie = mt_rand(0,count($dieinfo)-1);
                $msg = $dieinfo[$randdie];
                $sql = "insert into ggliaotian(name,msg,uid) values('【Nghe đồn】','$msg','0')";
                $cxjg = $dblj->exec($sql);
                $html = '
                    Chiến đấu kết quả:<br/>
                    Ngươi đánh chết'.$pvper->uname.'<br/>
                    Chiến đấu thắng lợi！<br/>
                    <a href="?cmd='.$gonowmid.'">Trở về trò chơi</a>';
                exit($html);
            }
            break;
    }
}

if ($player->uhp<=0){
    $cxmid = \player\getmid($player->nowmid,$dblj);
    $cxqy = \player\getqy($cxmid->mqy,$dblj);
    \player\changeplayersx("ispvp",0,$sid,$dblj);
    \player\changeplayersx("ispvp",0,$pvper->sid,$dblj);
    $html = <<<HTML
            Chiến đấu kết quả:<br/>
            Ngươi bị$guaiwu->gname Đánh chết<br/>
            Chiến đấu thất bại！<br/>
            Mời thiếu hiệp lại đến<br/>
            <br/>
            <a href="?cmd=$gorehpmid">Trở về trò chơi</a>
HTML;
    exit($html);
}

$pgjcmd = $encode->encode("cmd=pvp&canshu=gj&uid=$uid&sid=$player->sid");

$usejn1 = $encode->encode("cmd=pvp&canshu=usejn&jnid=$player->jn1&sid=$sid&uid=$uid");
$usejn2 = $encode->encode("cmd=pvp&canshu=usejn&jnid=$player->jn2&sid=$sid&uid=$uid");
$usejn3 = $encode->encode("cmd=pvp&canshu=usejn&jnid=$player->jn3&sid=$sid&uid=$uid");

$jnname1 = 'Phù lục 1';
$jnname2 = 'Phù lục 2';
$jnname3 = 'Phù lục 3';


if ($player->jn1!=0){
    $jineng = \player\getplayerjineng($player->jn1,$sid,$dblj);
    if ($jineng){
        $jnname1 = $jineng->jnname.'('.$jineng->jncount.')';
    }
}
if ($player->jn2!=0){
    $jineng = \player\getplayerjineng($player->jn2,$sid,$dblj);
    if ($jineng){
        $jnname2 = $jineng->jnname.'('.$jineng->jncount.')';
    }
}
if ($player->jn3!=0){
    $jineng = \player\getplayerjineng($player->jn3,$sid,$dblj);;
    if ($jineng){
        $jnname3 = $jineng->jnname.'('.$jineng->jncount.')';
    }
}

$html = <<<HTML
==Chiến đấu==<br/>
$pvper->uname [lv:$pvper->ulv]<br/>

Khí huyết:(<div class="hpys" style="display: inline">$pvper->uhp</div>/<div class="hpys" style="display: inline">$pvper->umaxhp</div>)$pvpbj $pvperhurt<br/>
Công kích:($pvper->ugj)<br/>
Phòng ngự:($pvper->ufy)<br/>
===================<br/>
$player->uname [lv:$player->ulv]<br/>
Khí huyết:(<div class="hpys" style="display: inline">$player->uhp</div>/<div class="hpys" style="display: inline">$player->umaxhp</div>)<br/>
Công kích:($player->ugj)<br/>
Phòng ngự:($player->ufy)<br/>
$tishihtml
<ul>
<li><a href="?cmd=$pgjcmd">Công kích</a></li><br/>
<li><a href="?cmd=$gonowmid">Chạy trốn</a></li>
</ul>
<a href="?cmd=$usejn1">$jnname1</a>.<a href="?cmd=$usejn2">$jnname2</a>.<a href="?cmd=$usejn3">$jnname3</a><br/>
<br/>
HTML;
echo $html;
