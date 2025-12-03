<?php
$encode = new \XXJ\Classes\Encode();
$gonowmid = $encode->encode("cmd=gomid&newmid={$player->nowmid}&sid={$player->sid}");

// Actions
$joinLink = $encode->encode("cmd=joinclub&clubid={$club->clubid}&sid={$player->sid}");
$leaveLink = $encode->encode("cmd=outclub&sid={$player->sid}");
$disbandLink = $encode->encode("cmd=club&action=disband&sid={$player->sid}");
?>

<h3><?php echo $club->clubname; ?> (Lv<?php echo $club->clublv; ?>)</h3>
Giới thiệu: <?php echo $club->clubinfo; ?><br/>
Kinh nghiệm: <?php echo $club->clubexp; ?><br/>
<br/>

<?php if ($viewMode == 'guest'): ?>
    <a href="?cmd=<?php echo $joinLink; ?>">Gia nhập môn phái</a><br/>
<?php else: ?>
    <!-- Member Actions -->
    
    <?php if ($currentMember->uclv == 1): ?>
        <a href="?cmd=<?php echo $disbandLink; ?>" onclick="return confirm('Bạn có chắc muốn giải tán môn phái?');">Giải tán môn phái</a><br/>
        <!-- Management Links could go here -->
    <?php else: ?>
        <a href="?cmd=<?php echo $leaveLink; ?>" onclick="return confirm('Bạn có chắc muốn rời môn phái?');">Rời môn phái</a><br/>
    <?php endif; ?>
<?php endif; ?>

<hr/>
<h4>Thành viên:</h4>
<?php foreach ($members as $member): ?>
    <?php
    $rankName = '';
    switch ($member->uclv) {
        case 1: $rankName = 'Chưởng môn'; break;
        case 2: $rankName = 'Phó chưởng môn'; break;
        case 3: $rankName = 'Trưởng lão'; break;
        case 4: $rankName = 'Chấp sự'; break;
        case 5: $rankName = 'Tinh anh'; break;
        default: $rankName = 'Đệ tử'; break;
    }
    
    $memberLink = $encode->encode("cmd=getplayerinfo&uid={$member->uid}&sid={$player->sid}");
    ?>
    [<?php echo $rankName; ?>] <a href="?cmd=<?php echo $memberLink; ?>"><?php echo $member->uname; ?></a><br/>
<?php endforeach; ?>

<br/>
<div class="menu">
    <a href="#" onClick="javascript:history.back(-1);">Trở lại</a>
    <a href="?cmd=<?php echo $gonowmid; ?>" style="float:right;">Trở về trò chơi</a>
</div>
