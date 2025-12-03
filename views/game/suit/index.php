<?php
$player = $data['player'];
$equippedItems = $data['equippedItems'];
$suits = $data['suits'];
$sid = $player->sid;
$gonowmid = "gomid&newmid=$player->nowmid&sid=$sid";
?>
<p>Bộ Trang Bị (Sáo Trang)</p>

<p>Trang bị hiện tại:</p>
<ul>
    <?php 
    $slots = [
        1 => 'Vũ khí',
        2 => 'Đồ phòng ngự',
        3 => 'Đồ trang sức',
        4 => 'Thư tịch',
        5 => 'Tọa kỵ',
        6 => 'Lệnh bài',
        7 => 'Ám khí'
    ];
    
    foreach ($slots as $i => $name) {
        $itemName = isset($equippedItems[$i]) ? $equippedItems[$i]->zbname : "{$name} vì không！";
        $suitName = isset($equippedItems[$i]) && $equippedItems[$i]->taozhuang ? "(Bộ: {$equippedItems[$i]->taozhuang})" : "";
        echo "<li>{$name}: {$itemName} {$suitName}</li>";
    }
    ?>
</ul>

<p>Kích hoạt bộ:</p>
<?php if (empty($suits)): ?>
    <p>Không có bộ trang bị nào được kích hoạt.</p>
<?php else: ?>
    <ul>
        <?php foreach ($suits as $suitId => $count): ?>
            <li>Bộ <?php echo $suitId; ?>: <?php echo $count; ?> món</li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<p>
    <a href="#" onClick="javascript:history.back(-1);">Trở lại</a>
    <a href="?cmd=<?php echo $gonowmid; ?>" style="float:right;">Trở về trò chơi</a>
</p>
