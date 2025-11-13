<?php
//新手村村长
$player = player\getplayer($sid,$dblj);
$npc = player\getnpc($nid,$dblj);
$rehp = $encode->encode("cmd=npc&nid=$nid&canshu=rehp&sid=$sid");
$npchtml =<<<HTML
Trò chơi sai lầm
 <p><a href="?cmd=$gonowmid">Trở lại trò chơi</a></p>;
HTML;






$sjhtml =<<<HTML
<div class="list-title text">
<font face=隶书 color="ae2d61">
<marquee direction="left" style="background: #89EE00;font-size:30 px"></marquee></font><!--动态文字条-->
<font color="#09BDAA">
<body> 
<script language="JavaScript">
<!-- Hide
var a = Math.random() + ""
var rand1 = a.charAt(11)
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
quotes[10] = '大虾你现在想干什么就干什么去吧，想吃啥赶紧抓紧吃点...。'
var quote = quotes[rand1]
</script>
<script language="JavaScript">
<!-- Hide
document.write(quote)
</script>
</body>
</font>
<font color="#89EE00">---$npc->nname</font>
</div>
HTML;


$xiaohao = round($player->ulv*15.2);
if ($nid!=''){
    if (isset($canshu)){
        switch ($canshu){
            case 'rehp':
                if ($player->uhp<=1000){
                    \player\changeyxb(2,$xiaohao,$sid,$dblj);
                    \player\changeplayersx('uhp',$player->umaxhp,$sid,$dblj);
                    $player = player\getplayer($sid,$dblj);
                    $gnhtml =<<<HTML
                    <br/>$npc->nname:少侠，进过老夫不懈努力的抢救，你现在已经恢复了！又可以去打架了<br/>
                    生命：$player->uhp/$player->umaxhp<br/>
HTML;
                }else{
                    $gnhtml ="<br/>大虾！您这毛病不好治啊...<font color='#BC4613'>【抢救失败】</font>$sjhtml"
					;
					
                }
                break;
        }
    }else{
        $gnhtml =<<<HTML
				<link rel="stylesheet" href="./css/choujiang.css">
		<link rel="stylesheet" href="./css/dongtai.css">
		<script src="./js/jquery.min.js"></script>
			<use href="?cmd=$czyxb">
         <svg viewBox="0 0 900 90">
	     <symbol id="id">
	     <text dy="1em">TỔ TRUYỀN BÍ THUẬT</text>
	     </symbol>
	  <use class="text" xlink:href="#id"></use>
	  <use class="text" xlink:href="#id"></use>
	  <use class="text" xlink:href="#id"></use>
	  <use class="text" xlink:href="#id"></use>
	  <use class="text" xlink:href="#id"></use>
	</svg></use>
		
        <br/><a href="?cmd=$rehp">Bắt mạch chữa bệnh</a><br/>
		
		
HTML;
        }
}
?>



