<?php
$player = $data['player'];
$cost = $data['cost'];
$isStuck = $data['isStuck'];
$message = $data['message'];
$resultType = $data['resultType'];
$sid = $player->sid;
$gonowmid = "gomid&newmid=$player->nowmid&sid=$sid";

$percent = 0;
if ($player->umaxexp > 0) {
    $percent = min(100, round(($player->uexp / $player->umaxexp) * 100));
}
?>
<p>Đột Phá</p>

<?php if ($message): ?>
    <p class="<?php echo $resultType; ?>" style="color: <?php echo $resultType == 'success' ? 'green' : 'red'; ?>">
        <?php echo $message; ?>
    </p>
<?php endif; ?>

<p>
    Đẳng cấp: <?php echo $player->ulv; ?><br/>
    Tu vi: <?php echo $player->uexp; ?> / <?php echo $player->umaxexp; ?> (<?php echo $percent; ?>%)<br/>
</p>

<div style="width: 200px; border: 1px solid #ccc; height: 20px;">
    <div style="width: <?php echo $percent; ?>%; background-color: green; height: 100%;"></div>
</div>
<br/>

<?php if ($isStuck): ?>
    <p>
        Bạn đã đạt đến bình cảnh, cần đột phá để tiếp tục tu luyện.<br/>
        Chi phí đột phá: <?php echo $cost; ?> Linh thạch.<br/>
        <a href="?cmd=tupo&action=breakthrough&sid=<?php echo $sid; ?>">Tiến hành đột phá</a>
    </p>
<?php else: ?>
    <p>
        Tu vi chưa đủ để đột phá. Hãy tiếp tục tu luyện.
    </p>
<?php endif; ?>

<p>
    <a href="#" onClick="javascript:history.back(-1);">Trở lại</a>
    <a href="?cmd=<?php echo $gonowmid; ?>" style="float:right;">Trở về trò chơi</a>
</p>
