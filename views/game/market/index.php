<?php
$player = $data['player'];
$items = $data['items'];
$type = $data['type'];
$page = $data['page'];
$sid = $data['sid'];

$gonowmid = "gomid&newmid=$player->nowmid&sid=$sid";
?>
<p>Phường Thị</p>
<p>
    【<?php echo $type == 'daoju' ? 'Đạo cụ' : "<a href='?cmd=fangshi&fangshi=daoju&sid=$sid'>Đạo cụ</a>"; ?>|
    <?php echo $type == 'zhuangbei' ? 'Trang bị' : "<a href='?cmd=fangshi&fangshi=zhuangbei&sid=$sid'>Trang bị</a>"; ?>|
    <a href="?cmd=shangdian&sid=<?php echo $sid; ?>">Cửa hàng</a>】
</p>

<?php if (empty($items)): ?>
    <p>Không có vật phẩm nào được bày bán.</p>
<?php else: ?>
    <?php foreach ($items as $item): ?>
        <p>
            <?php 
            if ($type == 'daoju') {
                $name = $item->djname;
                $count = $item->djcount;
                $price = $item->pay;
                $payid = $item->payid;
                $infoCmd = "djinfo&djid={$item->djid}&sid=$sid";
            } else {
                $name = $item->zbname;
                $count = 1;
                $price = $item->pay;
                $payid = $item->payid;
                $infoCmd = "zbinfo&zbnowid={$item->zbid}&sid=$sid"; // Assuming zbid is unique ID for equip
            }
            
            $buy1 = "fangshi_buy&fangshi=$type&payid=$payid&buycount=1&sid=$sid";
            ?>
            <a href="?cmd=<?php echo $infoCmd; ?>"><?php echo $name; ?></a> x<?php echo $count; ?>
            Đơn giá: <?php echo $price; ?> Linh thạch
            <a href="?cmd=<?php echo $buy1; ?>">Mua</a>
        </p>
    <?php endforeach; ?>
<?php endif; ?>

<p>
    <a href="#" onClick="javascript:history.back(-1);">Trở lại</a>
    <a href="?cmd=<?php echo $gonowmid; ?>" style="float:right;">Trở về trò chơi</a>
</p>
