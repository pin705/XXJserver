<?php
require_once __DIR__ . '/../src/Helpers/NhiemVuHelper.php';
use TuTaTuTien\Helpers as Helpers;

$rwhtml .= <<<HTML
<IMG width='280' height='140' src='./images/rw.png'src="./images/rw.png" style="border-radius: 8px;">
HTML;

$playertask = Helpers\layTatCaNhiemVuCuaNguoiChoi($sid, $dblj);
$gonowmid = $encode->encode("cmd=gomid&newmid=$player->nowmid&sid=$sid");
$mytaskinfo = '';
$taskhtml='';
$rwzt='';
$rwhtml;
for ($n=0;$n<count($playertask);$n++){
    $rwid = $playertask[$n]['rwid'];
    $mytaskinfo = $encode->encode("cmd=mytaskinfo&rwid=$rwid&sid=$sid");
    $rwname = $playertask[$n]['rwname'];
    $rwlx = $playertask[$n]['rwlx'];
	
    if ($rwlx==2 && $playertask[$n]['rwzt']!=3){
        $taskhtml .='[Mỗi ngày]';
    }
    if ($rwlx==3 && $playertask[$n]['rwzt']!=3){
		
        $taskhtml .='[<font class="aa" color="#F3160B">Chủ tuyến</font>]';
    }
    if ($rwlx==1 && $playertask[$n]['rwzt']!=3){
        $taskhtml .='[Phổ thông]';
    }
    switch ($playertask[$n]['rwzt']){
        case 1:
            $taskhtml .=<<<HTML
			
            <a href="?cmd=$mytaskinfo">$rwname</a><br/><img src="images/wen.gif"/>
HTML;
            break;
        case 2:
            $taskhtml .=<<<HTML
            <a href="?cmd=$mytaskinfo">$rwname</a><img src="images/tan.gif"/><br/>
HTML;
            break;
        case 3:
            break;
    }
}
$html .= <<<HTML
$rwhtml<br>
$taskhtml
<br/>
<a href="#" onClick="javascript:history.back(-1);"  background-color: #ecf7ed;">Trở lại</a>
            <a href="game.php?cmd=$gonowmid" style="float:right;background-color:#cdefea57;" >Trở về trò chơi</a>
HTML;
echo $html;