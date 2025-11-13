<?php
//新手村村长
$player = player\getplayer($sid,$dblj);
$aomen = $encode->encode("cmd=npc&nid=$nid&canshu=aomen&sid=$sid");
$czyxb = $encode->encode("cmd=npc&nid=$nid&canshu=czyxb&sid=$sid");//访问$czyxb.html这个段的网页代码，
$xiaohao = round($player->ulv*20);
$czsl = 0;
$ii = mt_rand(1,9);
//$iii = mt_rand($a1,$a9);
$a1=1;$a2=2;$a3=3;$a4=4;$a5=5;$a6=6;$a7=7;$a8=8;$a9=9;
$npchtml =<<<HTML
Trò chơi sai lầm
 <p><a href="?cmd=$gonowmid">Trượt rồi trượt rồi</a></p>;
HTML;
$xiaohao = round($player->ulv*20);
if ($nid!=''){
    if (isset($canshu)){
        switch ($canshu){
            case 'aomen':
                if ($player->uyxb>=100){
                    \player\changeyxb(2,$xiaohao,$sid,$dblj);
                    \player\changeplayersx('uhp',$player->umaxhp,$sid,$dblj);
                    $player = player\getplayer($sid,$dblj);
                    $gnhtml =<<<HTML
                    <br/>$npc->nname:少侠，看你今天面相红瑞，必有高中！<br/>
                    灵石情况：$player->uyxb<br/>
					当前运气：$ii <br>
					<br/><a href="?cmd=$czyxb">需要[$xiaohao]灵石进入</a><br/>
HTML;
                }else{
                    $gnhtml ="<br/>
				<font color=#e8690e>=={$player->uyxb}==还想来把妹？</font><br><FONT style='TEXT-DECORATION: line-through' color=#18dc72>你怕是癞蛤蟆日青蛙，想的美还玩的花！！</FONT>
					<br/>";
                }
                break;
        }
	}
}
HTML;
if ($nid!=''){
	$czsl = '';
    if (isset($canshu)){
        switch ($canshu){
            case 'czyxb':
                if ($player->uyxb<=20000){//判断执行情况，对于某数值的大小进行比较，sjs=随机数
					$sjs = mt_rand(1,4);//倍数在这里调整，随机mt-
					//$czsl = 100+ $player->uyxb*(7-$sjs) / 10 +2000;//计算逻辑，增加数量
					$czsl = 0 + 1000 * ($ii-4) ;
					$lszj = $czsl - ($player->uyxb);
                    \player\changeyxb(1,$czsl,$sid,$dblj);//选择方案，变化率，id，地址；
                    \player\changeyxb("uyxb",$czsl,$sid,$dblj);//充值地址，充值变化量，id，地址；
                    $player = player\getplayer($sid,$dblj);
                    $gnhtml =<<<HTML
					<!--<link rel="stylesheet" href="./css/choujiang.css">//这里开启为抽奖方框-->
					
		            <script src="./js/jquery.min.js"></script>
					<script type="text/javascript">function delayURL(url,time){setTimeout("top.location.href ='?cmd=npc&nid=$nid&canshu=czyxb&sid=$sid'",time);}</script>

                    <br/>$npc->nname ：运气不错,获得【 $czsl 】<br/>
					当前灵石：【 $player->uyxb 】<br/>
					===澳门选手===
					
<div class="content"></div>

	
	============
	<div class="button">
	<button type="button"  class="choujiang" onClick="delayURL('javascript:location.reload();',4500)">
	<font color=#FC0000 http-equiv="refresh" content="5">来一把</font>
	</button>
	
	</div>
	============
	<script src="./js/choujiang.js" type="text/javascript"></script>
HTML;

                }else{
                    $gnhtml ="<font color=#FC0000>===暂停营业===</font>
                    <br/><font color=#46B853>老板离奇失踪，我们正在努力找……</font><font color=#BED89B>不要慌，别着急，请相信，老板一定不是跑路...</font>
                    <br/>明天再来看看...老板一定<IMG width='30' height='30' src='./images/hui.jpg'>回来的。";}
                break;
				
        }
    }
    else{
        $gnhtml =<<<HTML
		<link rel="stylesheet" href="./css/choujiang.css">
		<link rel="stylesheet" href="./css/dongtai.css">
		<script src="./js/jquery.min.js"></script>
		<!--图片显示<IMG width="100" height="100" src="./npc/gxzc.png">-->
		灵石剩余</font>：$player->uyxb<br/>
		场地费用：$xiaohao<br>
		
	<use href="?cmd=$czyxb">
         <svg viewBox="0 0 900 90">
	     <symbol id="id">
	     <text dy="1em">澳门客栈</text>
	     </symbol>
	  <use class="text" xlink:href="#id"></use>
	  <use class="text" xlink:href="#id"></use>
	  <use class="text" xlink:href="#id"></use>
	  <use class="text" xlink:href="#id"></use>
	  <use class="text" xlink:href="#id"></use>
	</svg></use>
	
		<br/>
		<a href="?cmd=$aomen">
		<font color=#F03930>客栈</font><font color=#F2553C>入口</font></a><br/>
HTML;
        }
}
?>