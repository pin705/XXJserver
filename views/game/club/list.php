<?php
$encode = new \XXJ\Classes\Encode();
$gonowmid = $encode->encode("cmd=gomid&newmid={$player->nowmid}&sid={$player->sid}");
$createClubLink = $encode->encode("cmd=cjclub&sid={$player->sid}");
?>

<img width='280' height='140' src='./images/menpai.png' style="border-radius: 8px;">
<br/>
===========Thiên Bảng===========
<br/>

<?php if (empty($clubs)): ?>
    Hiện tại chưa có môn phái nào.<br/>
<?php else: ?>
    <?php foreach ($clubs as $index => $club): ?>
        <?php
        $clubcmd = $encode->encode("cmd=club&clubid={$club->clubid}&sid={$player->sid}");
        ?>
        [<?php echo $index + 1; ?>] <a href="?cmd=<?php echo $clubcmd; ?>"><?php echo $club->clubname; ?></a> (Lv<?php echo $club->clublv; ?>)<br/>
    <?php endforeach; ?>
<?php endif; ?>

<br/>
<a href="?cmd=<?php echo $createClubLink; ?>">Tạo môn phái (100 Ma thạch)</a><br/>
<br/>

<div class="menu">
    <a href="#" onClick="javascript:history.back(-1);">Trở lại</a>
    <a href="?cmd=<?php echo $gonowmid; ?>" style="float:right;">Trở về trò chơi</a>
</div>
