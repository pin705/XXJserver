<?php
// Template for zhuangtai (Player Status)
// Variables: $player, $equippedItems, $encoder, $sid, $errorMsg
?>
<?php if ($errorMsg): ?>
    <div style="color: red;"><?= $errorMsg ?></div>
<?php endif; ?>

<div class="title">Trạng thái nhân vật</div>
<br>
Tên: <?= $player->uname ?><br>
Level: <?= $player->ulv ?><br>
HP: <?= $player->uhp ?>/<?= $player->umaxhp ?><br>
Công kích: <?= $player->ugj ?><br>
Phòng thủ: <?= $player->ufy ?><br>
<hr>

<!-- Equipment Slots -->
<?php 
$slots = [
    1 => 'Vũ khí',
    2 => 'Mũ',
    3 => 'Áo',
    4 => 'Quần',
    5 => 'Giày',
    6 => 'Trang sức',
    7 => 'Pháp bảo'
];
?>

<?php foreach ($slots as $slotId => $slotName): ?>
    <?= $slotName ?>: 
    <?php if (isset($equippedItems[$slotId])): ?>
        <?php 
            $item = $equippedItems[$slotId];
            $viewCmd = $encoder->encode("cmd=chakanzb&zbnowid=$item->zbnowid&uid=$player->uid&sid=$sid");
            $unequipCmd = $encoder->encode("cmd=xxzb&zbwz=$slotId&sid=$sid");
            $color = $item->zbys ?? '#000000';
            $plus = $item->qianghua > 0 ? "+{$item->qianghua}" : "";
        ?>
        <a href="?cmd=<?= $viewCmd ?>"><font color="<?= $color ?>"><?= $item->zbname ?></font><?= $plus ?></a>
        <a href="?cmd=<?= $unequipCmd ?>"> [Dỡ]</a>
    <?php else: ?>
        Trống
    <?php endif; ?>
    <br>
<?php endforeach; ?>

<hr>
<?php 
$backCmd = $encoder->encode("cmd=gomid&newmid=$player->nowmid&sid=$sid");
$bagCmd = $encoder->encode("cmd=getbagzb&sid=$sid");
?>
<a href="?cmd=<?= $bagCmd ?>">Hành trang</a><br>
<a href="?cmd=<?= $backCmd ?>">Trở về</a>
