<?php
//新手村村长九 零 一 起玩www. 9 0 1 75.com
$player = player\getplayer($sid,$dblj);
$czyxb = $encode->encode("cmd=npc&nid=$nid&canshu=czyxb&sid=$sid");
$czsl = 0;
$npchtml =<<<HTML
Trò chơi sai lầm
 <p><a href="?cmd=$gonowmid">Trượt rồi trượt rồi</a></p>;

HTML;

if ($nid!=''){
	$czsl = 0;
    if (isset($canshu)){
        switch ($canshu){
            case 'czyxb':
                if ($player->uyxb<=2000){//判断执行情况，对于某数值的大小进行比较，sjs=随机数
					$sjs = mt_rand(1,4);//倍数在这里调整，随机mt-
					$czsl = 1+ $player->uyxb*$sjs;//计算逻辑，增加数量
					$lszj = $czsl-round($player->uyxb);
					
                    \player\changeyxb(1,$czsl,$sid,$dblj);//选择方案，变化率，id，地址；
                    \player\changeplayersx("uyxb",$czsl,$sid,$dblj);//充值地址，充值变化量，id，地址；
                    $player = player\getplayer($sid,$dblj);
                    $gnhtml =<<<HTML
                    <br/>$npc->nname : Tiết kiệm một chút hoa! Lão nương cũng không có nhiều ít hàng tích trữ!<br/>
                    Linh thạch nạp tiền số lượng:$lszj<br/>
					Linh thạch có:$player->uyxb<br/>
HTML;

                }else{
                    $gnhtml ="<font color=#FC0000> Ngươi </font><font color=#F90000> So </font><font color=#F60000> Ta </font><font color=#F30000> Có </font><font color=#F00000> Tiền </font><font color=#ED0000>, </font><font color=#EA0000> Ta </font><font color=#E70000> Cho </font><font color=#E40000> Không </font><font color=#E10000> </font><font color=#DE0000> Ngươi </font><font color=#DB0000> Tiền </font><font color=#D80000>!</font><br/><font color=#46B853> Cho ngươi cái đề nghị: Đánh không lại </font><font color=#55BC5C> Người khác thời điểm </font><font color=#64C065></font><font color=#73C46E>! Liền </font><font color=#82C877> Tranh thủ thời gian </font><font color=#91CC80> </font><font color=#A0D089> Trốn </font><font color=#AFD492> Chạy </font><font color=#BED89B> Mà!!</font><br/> Chờ ngươi xấu hổ ví tiền rỗng tuếch lại đến xem một chút đi";}
                break;
				
        }
    }else{
        $gnhtml =<<<HTML
		<a/><IMG width="100" height="100" src="./npc/gxzc.png">
        <br/><a href="?cmd=$czyxb">Linh thạch dư lượng:$player->uyxb<br/>【<font color=#F03930>Linh</font><font color=#F2553C>Thạch</font><font color=#F47148>Miễn phí</font><font color=#F68D54>Nạp tiền</font>】</a><br/>
HTML;
        }
}
?>