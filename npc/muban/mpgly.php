<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 202 1/1 2/26 0026
 * Time: 19:06
 */
// Redirect to new Club Controller
$newclub = $encode->encode("cmd=club&action=create&sid=$sid");
$player = \player\getplayer($sid,$dblj);
$gnhtml =<<<HTML

=======Môn phái sáng lập=======<br/>
Thiên địa bất nhân, tu đạo tức tu đạo<br/>
Đại đạo bất chỉ, đại đạo lộ bất chỉ<br/>
Muốn trộm ra tiên lộ, một người.. quá khó..<br/>
<a href="?cmd=$newclub" >Sáng lập môn phái</a><br/>
HTML;
?>

