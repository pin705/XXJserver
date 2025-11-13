<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/8/27 0027
 * Time: 11:49
 */
require_once __DIR__ . '/../Helpers/NguoiChoiHelper.php';
require_once __DIR__ . '/../Helpers/ClubHelper.php';
use TuTaTuTien\Helpers as Helpers;

$clublist = '';
$allclub = Helpers\layTatCaClub($dblj);
$nguoiChoi = Helpers\layThongTinNguoiChoi($sid, $dblj);
$gonowmid = $encode->encode("cmd=goto_map&newmid=$nguoiChoi->idBanDoHienTai&sid=$sid");

if ($allclub){
    $i = 0;
    foreach ($allclub as $club){
        $i++;
        $clubcmd = $encode->encode("cmd=guild&clubid={$club['clubid']}&sid=$sid");
        $clublist .= "[$i]<a href='?cmd=$clubcmd' >{$club['clubname']}</a><br/>";
    }
}

$clubhtml =<<<HTML
<IMG width='280' height='140' src='./images/menpai.png'src="./images/rw.png" style="border-radius: 8px;">
===========Thiên Bảng===========
      <br/>
      $clublist<br/>
	   <div class="menu"><a href="#" onClick="javascript:history.back(-1);">Trở lại</a>
    <a href="game.php?cmd=$gonowmid" style="float:right;" >Trở về trò chơi</a> </div>
HTML;



echo $clubhtml;