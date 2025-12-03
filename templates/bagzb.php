<?php
// Template for bagzb (Equipment Bag)
// Variables: $player, $items, $page, $totalPages, $encoder, $sid
?>
<div class="title">Hành trang trang bị</div>
<br>

<?php if (empty($items)): ?>
    Hành trang trống.<br>
<?php else: ?>
    <?php foreach ($items as $item): ?>
        <?php 
            $viewCmd = $encoder->encode("cmd=chakanzb&zbnowid=$item->zbnowid&uid=$player->uid&sid=$sid");
            $equipCmd = $encoder->encode("cmd=setzbwz&zbnowid=$item->zbnowid&zbwz=$item->tool&sid=$sid"); // Assuming item->tool is the slot
            $color = $item->zbys ?? '#000000';
            $plus = $item->qianghua > 0 ? "+{$item->qianghua}" : "";
        ?>
        <a href="?cmd=<?= $viewCmd ?>"><font color="<?= $color ?>"><?= $item->zbname ?></font><?= $plus ?></a>
        <?php if ($item->tool): ?>
            <a href="?cmd=<?= $equipCmd ?>"> [Trang bị]</a>
        <?php endif; ?>
        <br>
    <?php endforeach; ?>
<?php endif; ?>

<hr>
<!-- Pagination -->
<?php if ($page > 1): ?>
    <?php $prevCmd = $encoder->encode("cmd=getbagzb&sid=$sid&page=" . ($page - 1)); ?>
    <a href="?cmd=<?= $prevCmd ?>">Trang trước</a>
<?php endif; ?>

<?php if ($page < $totalPages): ?>
    <?php $nextCmd = $encoder->encode("cmd=getbagzb&sid=$sid&page=" . ($page + 1)); ?>
    <a href="?cmd=<?= $nextCmd ?>">Trang sau</a>
<?php endif; ?>

<br>
<?php 
$backCmd = $encoder->encode("cmd=gomid&newmid=$player->nowmid&sid=$sid");
?>
<a href="?cmd=<?= $backCmd ?>">Trở về</a>
