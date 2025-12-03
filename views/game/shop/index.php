<?php
$encode = new \XXJ\Classes\Encode();
$gonowmid = $encode->encode("cmd=gomid&newmid={$player->nowmid}&sid={$player->sid}");

// Mode links
$linkLinhThach = $encode->encode("cmd=shangdian&canshu=gogoumai&sid={$player->sid}");
$linkMaThach = $encode->encode("cmd=shangdian&canshu1=gogoumai1&sid={$player->sid}");
?>

<?php if ($message): ?>
    <div style="color: <?php echo $messageType == 'success' ? 'green' : 'red'; ?>;">
        <?php echo $message; ?>
    </div>
<?php endif; ?>

<br/>
<a href="?cmd=<?php echo $linkLinhThach; ?>"><font color="#ffc100">Linh thạch mua</font></a><br/>
<a href="?cmd=<?php echo $linkMaThach; ?>"><font color="#ffc100">Ma thạch mua</font></a>
<br/>

<?php if (!empty($items)): ?>
    <?php foreach ($items as $item): ?>
        <?php
        $ydid = $item['ydid'];
        $ydname = $item['ydname'];
        $ydys = $item['ydys']; // Color
        $ydjg = $item['ydjg']; // Linh thạch price
        $ydjgm = $item['ydjgm']; // Ma thạch price
        
        $infoLink = $encode->encode("cmd=ydinfo&ydid=$ydid&sid={$player->sid}");
        
        // Buy links
        $buy1 = '';
        $buy10 = '';
        $priceDisplay = '';
        
        if ($mode == 'mathach') {
            $priceDisplay = "Giá: $ydjgm Ma thạch";
            $buy1Link = $encode->encode("cmd=shangdian&canshu1=gogoumai1&ydcount=1&ydid=$ydid&sid={$player->sid}");
            $buy10Link = $encode->encode("cmd=shangdian&canshu1=gogoumai1&ydcount=10&ydid=$ydid&sid={$player->sid}");
        } else {
            $priceDisplay = "Giá: $ydjg Linh thạch";
            $buy1Link = $encode->encode("cmd=shangdian&canshu=gogoumai&ydcount=1&ydid=$ydid&sid={$player->sid}");
            $buy10Link = $encode->encode("cmd=shangdian&canshu=gogoumai&ydcount=10&ydid=$ydid&sid={$player->sid}");
        }
        ?>
        
        <br/>
        <div class='menu'>
            <div style="text-align: left;">
                <a style="min-width: 200px" href="?cmd=<?php echo $infoLink; ?>">
                    <font color='<?php echo $ydys; ?>'>[<?php echo $ydname; ?>]</font><br/>
                    <?php echo $priceDisplay; ?>
                </a>
            </div>
            <div style="width: 80px;">
                <a href="?cmd=<?php echo $buy1Link; ?>">Mua 1</a>
                <a href="?cmd=<?php echo $buy10Link; ?>">Mua 10</a>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

<br/>
<div class="menu">
    <a href="#" onClick="javascript:history.back(-1);">Trở lại</a>
    <a href="?cmd=<?php echo $gonowmid; ?>" style="float:right;">Trở về trò chơi</a>
</div>
