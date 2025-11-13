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
quotes[1] = 'Nhiều hút thuốc, ít vận động, ngươi lạnh, lão bà ta giúp ngươi chiếu cố ^0^'
quotes[2] = 'Bán linh hồn của mình cùng nguyên tắc cũng không mất mặt, mất mặt chính là không có thể bán một cái giá tốt.'
quotes[3] = 'Thẳng đến ba mươi tuổi mới biết được, cùng người khác nhau nói khác biệt, biểu hiện ra không giống thái độ, là một loại phi thường đáng ngưỡng mộ năng lực, mà không phải dối trá.'
quotes[4] = 'Cái gì đều là giả, chỉ có nghèo là thật.'
quotes[5] = 'Thiện lương vô dụng, bởi vì chỉ có ngươi trước xinh đẹp, người khác mới có thể nhìn thấy ngươi thiện lương.'
quotes[6] = 'Ngoài miệng nói"Ta yêu ngươi", nhưng không có hành động thực tế người, tựa như một cái chưa từng tưới hoa người nói mình yêu hoa. Yêu là động từ, hành động mới là yêu tốt nhất sách hướng dẫn.'
quotes[7] = 'Sinh hoạt không chỉ lập tức cẩu thả, còn có tiền nhiệm thiếp mời.'
quotes[8] = 'Một ngày nào đó ngươi sẽ gặp phải ngươi chân chính thích người, cùng hắn một nửa khác.'
quotes[9] = 'Cũng bởi vì quá nhàn, cho nên mới có tinh lực mất ngủ, cho nên mới có tâm tư già mồm; Cho sinh hoạt tìm một chút sự tình làm, không đến mức hoang phế mỗi một ngày.'
quotes[0] = 'Tài vụ tự do không phải muốn làm cái gì thì làm cái đó, mà là không muốn làm cái gì, liền có năng lực không làm gì.'
quotes[10] = 'Tôm bự ngươi bây giờ muốn làm cái gì thì làm cái đó đi thôi, muốn ăn cái gì tranh thủ thời gian nắm chặt ăn chút....'
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



