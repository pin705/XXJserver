<?php
$encode = new \XXJ\Classes\Encode();
$gonowmid = $encode->encode("cmd=gomid&newmid={$player->nowmid}&sid={$player->sid}");

// Links for tabs
$linkLevel = $encode->encode("cmd=paihang&type=level&sid={$player->sid}");
$linkAttack = $encode->encode("cmd=paihang&type=attack&sid={$player->sid}");
$linkDefense = $encode->encode("cmd=paihang&type=defense&sid={$player->sid}");
$linkWealth = $encode->encode("cmd=paihang&type=wealth&sid={$player->sid}");
?>

<div class="ranking-tabs">
    <a href="?cmd=<?php echo $linkLevel; ?>" <?php echo $type == 'level' ? 'style="font-weight:bold"' : ''; ?>>Đẳng cấp</a> | 
    <a href="?cmd=<?php echo $linkAttack; ?>" <?php echo $type == 'attack' ? 'style="font-weight:bold"' : ''; ?>>Công kích</a> | 
    <a href="?cmd=<?php echo $linkDefense; ?>" <?php echo $type == 'defense' ? 'style="font-weight:bold"' : ''; ?>>Phòng ngự</a> | 
    <a href="?cmd=<?php echo $linkWealth; ?>" <?php echo $type == 'wealth' ? 'style="font-weight:bold"' : ''; ?>>Tài phú</a>
</div>
<hr/>

<h3><?php echo $title; ?></h3>

<?php if (empty($rankings)): ?>
    Chưa có dữ liệu xếp hạng.
<?php else: ?>
    <?php foreach ($rankings as $index => $rank): ?>
        <?php
        $xuhao = $index + 1;
        $ucmd = $encode->encode("cmd=getplayerinfo&uid={$rank->uid}&sid={$player->sid}");
        
        // Club name (if available in query)
        $clubName = isset($rank->clubname) && $rank->clubname ? "[{$rank->clubname}]" : "";
        
        // Value to display based on type
        $valueDisplay = "";
        if ($type == 'attack') $valueDisplay = " (Công: {$rank->ugj})";
        elseif ($type == 'defense') $valueDisplay = " (Thủ: {$rank->ufy})";
        elseif ($type == 'wealth') $valueDisplay = " (Linh thạch: {$rank->uyxb})";
        ?>
        
        <?php echo $xuhao; ?>. [Lv<?php echo $rank->ulv; ?>] 
        <a href="?cmd=<?php echo $ucmd; ?>"><?php echo $clubName . $rank->uname; ?></a>
        <?php echo $valueDisplay; ?><br/>
    <?php endforeach; ?>
<?php endif; ?>

<br/>
<div class="menu">
    <a href="#" onClick="javascript:history.back(-1);">Trở lại</a>
    <a href="?cmd=<?php echo $gonowmid; ?>" style="float:right;">Trở về trò chơi</a>
</div>
