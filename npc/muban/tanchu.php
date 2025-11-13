<?php
//新手村村长
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
                if ($player->uyxb<=20000){//判断执行情况，对于某数值的大小进行比较，sjs=随机数
					$sjs = mt_rand(1,4);//倍数在这里调整，随机mt-
					$czsl = 100+ $player->uyxb*(7-$sjs) / 10 +2000;//计算逻辑，增加数量
					$lszj = $czsl-round($player->uyxb);
					
                    \player\changeyxb(1,$czsl,$sid,$dblj);//选择方案，变化率，id，地址；
                    \player\changeplayersx("uyxb",$czsl,$sid,$dblj);//充值地址，充值变化量，id，地址；
                    $player = player\getplayer($sid,$dblj);
                    $gnhtml =<<<HTML
					<!--<link rel="stylesheet" href="./css/choujiang.css">//这里开启为抽奖方框-->
		            <script src="./js/jquery.min.js"></script>
	<link rel="stylesheet" href="./chajian/tanchukuang/css/reset.css">
    <link rel="stylesheet" href="./chajian/tanchukuang/css/style.css">
    <script src="./chajian/tanchukuang/js/modernizr.js"></script>
	<script type="text/javascript">
 function delayURL(url,time){
 setTimeout("top.location.href = '" + url + "'",time);
 }
</script>
                    <br/>
					<font color='#00E000'>
					$npc->nname :</font><br>村长老婆,给的【<font color='#FFA000'>{$lszj}</font>】<br/>
					这是你的灵石 【 $player->uyxb 】<br/>
	===澳门选手===
	
	<div class="content">
    </div>============
	<div class="button">
    <IMG width='30' height='30' src='./npc/aomenxuanshou.png'>
	<button type="button"  class="choujiang" onClick="delayURL('javascript:location.reload();',4500)">
	<font color="#FC0000">
	来一把
	</font></button>	
    <!--<a href="?cmd=npc&nid=$nid&canshu=czyxb&sid=$sid">刷新</a>-->
    </div>
	============
    <script src="./js/choujiang.js" type="text/javascript">
	</script>
	<body>
				<a href="#0" class="cd-popup-trigger">带{$npc->nname}去散散心</a>
    <div class="cd-popup" role="alert">
        <div class="cd-popup-container">
            <p>
			
			
			<table class="cd-popup-container" style="background-color:#ff5722">
<td>{$npc->nname}：要不一起去吃麻辣烫？</td>
</table>
			<!--以下为随机文字
			<div class="list-title text">
			<font face=隶书 color="ae2d61">
			<marquee direction="left" style="background: #ffffff;font-size:30 px">
<body> 
<script language="JavaScript">

var a = Math.random() + ""
var rand1 = a.charAt(16)
quotes = new Array
quotes[1] = '多抽烟，少运动，你凉了，老婆我帮你照顾^0^'
quotes[2] = '出卖自己的灵魂和原则并不丢人，丢人的是没能卖一个好价钱。'
quotes[3] = '直到三十岁才知道，和不同的人说不同的话，表现出不一样的态度，是一种非常可贵的能力，而不是虚伪。'
quotes[4] = '什么都是假的，只有穷是真的。'
quotes[5] = '善良没用，因为只有你先漂亮，别人才能看到你的善良。'
quotes[6] = '嘴上说“我爱你”，却没有实际行动的人，就像一个从不浇花的人说自己爱花。爱是动词，行动才是爱最好的说明书。'
quotes[7] = '生活不止当下的苟且，还有前任的请帖。'
quotes[8] = '总有一天你会遇见你真正喜欢的人，和他的另一半。'
quotes[9] = '就因为太闲了，所以才有精力失眠，所以才有心思矫情；给生活找点事儿做，不至于荒废每一天。'
quotes[0] = '财务自由不是想干什么就干什么，而是不想干什么，就有能力不干什么。'
quotes[10] = '10财务自由不是想干什么就干什么，而是不想干什么，就有能力不干什么。'
var quote = quotes[rand1]

</script>
<script language="JavaScript">

document.write(quote)

</script>
</body>
<font color="#89EE00">^.^</font>


			</marquee></font>
		</div>
		以上为随机文字-->
		
			</p>
            <ul class="cd-buttons">
                <li><a href="?cmd=npc&nid=$nid&canshu=czyxb&sid=$sid"">Yes</a></li>
                <li><a href="?cmd=$gonowmid">No</a></li>
            </ul>
            <a href="#0" class="cd-popup-close img-replace">Close</a>
        </div>
        <!-- cd-popup-container -->
    </div>
    <!-- cd-popup -->
    <script src="./chajian/tanchukuang/js/jquery.1.11.1.js"></script>
    <script src="./chajian/tanchukuang/js/main.js"></script>
    <!-- Resource jQuery -->
</body>






HTML;

                }else{
                    $gnhtml ="<font color=#FC0000>===暂停营业===</font>
                    <br/><font color=#46B853>老板离奇失踪，我们正在努力找……</font><font color=#BED89B>不要慌，别着急，请相信，老板一定不是跑路...</font>
                    <br/>明天再来看看...老板一定<IMG width='30' height='30' src='./images/hui.jpg'>回来的。";}
                break;
				
        }
    }else{
        $gnhtml =<<<HTML
		<link rel="stylesheet" href="./css/choujiang.css">
		<link rel="stylesheet" href="./css/dongtai.css">
		<script src="./js/jquery.min.js"></script>
		<!--图片显示<IMG width="100" height="100" src="./npc/gxzc.png">-->
		
		灵石剩余</font>：$player->uyxb<br/>
		
	  <use href="?cmd=$czyxb">
      <svg viewBox="0 0 900 90">
	  <symbol id="id">
	  <text dy="1em">村长客栈</text>
	  </symbol>
	  <use class="text" xlink:href="#id"></use>
	  <use class="text" xlink:href="#id"></use>
	  <use class="text" xlink:href="#id"></use>
	  <use class="text" xlink:href="#id"></use>
	  <use class="text" xlink:href="#id"></use>
	</svg></use>
		<br/>
		<a href="?cmd=$czyxb">
		<font color=#F03930>客栈</font><font color=#F2553C>入口</font></a><br/>
HTML;
        }
}
?>