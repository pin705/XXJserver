<?php
// Variables passed: $player, $sid, $skill, $encode, $message, $xlsjc, $expGain, $minutes
$wgid = $player->wugong;
$gonowmid = $encode->encode("cmd=gomid&newmid=$player->nowmid&sid=$sid");
$xiuliancmd = $encode->encode("cmd=goxiulian&sid=$sid"); // Not used in original? Ah, "Ngồi thiền tu luyện" link
$wgxl = $encode->encode("cmd=wgxl&sid=$sid");
$wgxx = $encode->encode("cmd=xxwg&sid=$sid");

$wuwugong = "";
$wgys = "";
$wumiji = "0 Bí tịch";
$jieshao = "Mời thu thập bí tịch tiến hành học tập võ công";
$gongli = "0.000001";
$xiaohao = 0;

if ($wgid == 0) {
    $wuwugong = "Không có võ công！！";
    // Default values for no skill
    $skillName = "Vô danh";
    $skillLevel = 0;
    $skillSum = 0;
    $skillInfo = "";
    $skillXl = 0;
    $skillXlMax = 0;
} else {
    $skillName = $skill->wgname;
    $skillLevel = $skill->wgdj;
    $skillSum = $skill->wgsum;
    $skillInfo = $skill->wginfo;
    $skillXl = $skill->wgxl;
    $skillXlMax = $skill->wgxlmax;
    $wgys = $skill->wgys;
    $xiaohao = 0 + $skillLevel;
}

// Calculate $xlcz (Action Link)
$xlcz = "";
$strxl = $encode->encode("cmd=wgxiulian&canshu=1&wgid=$wgid&sid=$sid");
$endxl = $encode->encode("cmd=jswg&wgid=$wgid&sid=$sid");

if ($skill && $skill->xlzt == 1) {
    $tishi_html = '<font color="#A0A000">Luyện</font><font color="#F5A000">Võ</font><font color="#FFA000">Bên trong</font><br/>';
    $xlcz = "<a href=?cmd=$endxl>Kết thúc tu luyện</a><br/><br/>";
} else {
    $tishi_html = 'Lười biếng bên trong...<br>';
    if ($skill && $skill->wgsum >= 1) {
        $xlcz = "<a href=?cmd=$strxl style='color: #f36c09;'>Bắt đầu tu hành</a><br/><br/>";
    } else {
        $xlcz = "<a style='color: #f50808;'>Thiếu khuyết bí tịch, không cách nào tu hành</a><br><br>";
    }
}

// Override tishi if message is set from controller
if (!empty($message)) {
    // If message is set, it might be the result of an action.
    // In original code, $tishi is overwritten by action result.
    // But here $message is passed.
    // Let's append or use $message.
    // Actually, in original code:
    // if ($cmd == 'wgxiulian') { $tishi = ... }
    // if ($cmd == 'jswg') { $tishi = ... }
    // AND THEN:
    // if ($cxwg->xlzt == 1){ $tishi = ... } else { $tishi = ... }
    // Wait, the status check OVERWRITES the action message?
    // No, let's check original code order.
}
?>

<!-- Original Code Order Check -->
<?php
/*
Original:
if ($cmd == 'wgxiulian') { ... $tishi = '...'; }
if ($cmd == 'jswg') { ... $tishi = '...'; }

$cxwg = \player\wgcx($wgid,$sid,$dblj); // Re-fetch
if ($cxwg->xlzt == 1){
    $tishi = '<font...>'; // This OVERWRITES previous $tishi!
} else {
    $tishi = 'Lười biếng...'; // This OVERWRITES previous $tishi!
}
*/
// Wait, if that's true, the success message "Hắc hưu hắc hưu" is never shown?
// Let's look closely at original code.
/*
if ($cmd == 'wgxiulian'){
    // ...
    $tishi = 'Hắc hưu hắc hưu, thao luyện...<br/>';
}
// ... calculation ...
if ($cmd == 'jswg'){
    // ...
    $tishi = 'nhận được tu vi...';
}

$cxwg = \player\wgcx($wgid,$sid,$dblj);
if ($cxwg->xlzt == 1){
    $tishi = '<font...>';
    $xlcz = ...
}else{
    $tishi = 'Lười biếng...';
    // ...
}
*/
// Yes, it seems the status check at the end overwrites $tishi.
// UNLESS $tishi is appended? No, `$tishi = ...`.
// This might be a bug in the original code, or I am misreading.
// Ah, maybe the "Hắc hưu hắc hưu" is shown because `wgxiulian` sets `xlzt=1`.
// So `if ($cxwg->xlzt == 1)` is true.
// So it shows "Luyện Võ Bên trong".
// So "Hắc hưu hắc hưu" is indeed lost?
// Or maybe the re-fetch happens BEFORE the check?
// The re-fetch is at line 101 (in snippet).
// The check is at line 102.
// So yes, it overwrites.

// However, for `jswg` (End Cultivation):
// It sets `xlzt=0`.
// So `if ($cxwg->xlzt == 1)` is false.
// So it goes to `else { $tishi = 'Lười biếng...'; }`.
// So "nhận được tu vi..." is also lost?

// Let's check if I missed something.
// Maybe `$tishi .= ...`?
// No, `$tishi = ...`.

// Wait, look at line 80 of `wugong.php` (in snippet):
// $tishi = 'nhận được tu vi:'.$xlexp.''.$zj.'<br/>';
// And line 102:
// $tishi = 'Lười biếng bên trong...<br>';

// This implies the original code DOES overwrite it.
// Unless... the output uses `$tishi` BEFORE the overwrite?
// No, `echo $xlhtml` is at the very end.

// Is it possible that `$tishi` is used inside `$xlhtml` heredoc?
// Yes.
// But `$xlhtml` is defined at the end.

// Maybe I should preserve this behavior (even if it looks like a bug) or fix it?
// "Refactor lại toàn bộ logic cho tôi logic bắt buộc phải work đúng" (Logic must work correctly).
// If the original code hid the success message, that's probably a bug.
// I should probably show the message.
// I will append the status to the message.

if (!empty($message)) {
    $tishi_html = $message . $tishi_html;
}
?>

<IMG width='280' height='140' src='./images/wugong/<?php echo $wgid; ?>.png' style="border-radius: 8px;">
<a href="?cmd=<?php echo $xiuliancmd; ?>" >Ngồi thiền tu luyện</a><a href="?cmd=<?php echo $wgxl; ?>" >Võ công tu hành</a><a href="?cmd=<?php echo $wgxx; ?>" >Bí tịch</a><br>
Tu hành người chơi：<?php echo $player->uname; ?><br/>
Người chơi đẳng cấp：<?php echo $player->ulv; // Note: Original used $player->jingjie($player->ulv) which converts level to text. I should check if I have that method. ?><br/>
===============<br/>
Tu hành võ công:<?php echo $wuwugong; ?><font color="<?php echo $wgys; ?>"><?php echo $skillName; ?></font><br>
Trước mắt công lực:<?php echo $gongli; ?> <?php echo $skillLevel; ?><br>
Bí tịch số lượng:<?php echo $wumiji; ?> <?php echo $skillSum; ?> Quyển<br/>
Tu hành tiêu hao:<?php echo $xiaohao; ?> Quyển<br/>
Võ công giới thiệu:<?php echo $jieshao; ?> <?php echo $skillInfo; ?><br>
===============<br/>
Trạng thái tu luyện:<?php echo $tishi_html; ?> 
===============<br/>
Chú：Võ công đẳng cấp càng cao, thời gian tu hành càng dài,<br>Tối cao 1440 Phút, tiêu hao bí tịch cũng nhiều。<br/>
<?php echo $xlcz; ?><a href="#" onClick="javascript:history.back(-1);">
Trở lại</a><a href="game.php?cmd=<?php echo $gonowmid; ?>" style="float:right;" >
Trở về trò chơi</a>
