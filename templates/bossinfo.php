<?php
// Variables: $boss, $drops, $sid, $encode
$pvb = $encode->encode("cmd=pvb&bossid={$boss->bossid}&sid=$sid");
?>
[<?php echo $boss->bossname; ?>]Công kích:<?php echo $boss->bossgj; ?>Phòng ngự:<?php echo $boss->bossfy; ?><hr>
<?php echo $boss->bossinfo; ?><hr>
<div style="border: #dcd4a1; border-style: dashed; border-top-width: 1px;
border-right-width: 1px; border-bottom-width: 1px; border-left-width: 1px">
<?php foreach ($drops as $drop): ?>
    <?php if ($drop['type'] == 'zb'): ?>
        <a href='?cmd=<?php echo $encode->encode("cmd=zbinfo_sys&zbid={$drop['item']->zbid}&sid=$sid"); ?>'><font color='<?php echo $drop['item']->zbys; ?>'><?php echo $drop['item']->zbname; ?></font></a>
    <?php elseif ($drop['type'] == 'dj'): ?>
        <font class='djys'><a href='?cmd=<?php echo $encode->encode("cmd=djinfo&djid={$drop['item']->djid}&sid=$sid"); ?>'><?php echo $drop['item']->djname; ?></a></font>
    <?php elseif ($drop['type'] == 'yp'): ?>
        <font class='ypys'><a href='?cmd=<?php echo $encode->encode("cmd=ypinfo&ypid={$drop['item']->ypid}&sid=$sid"); ?>'><?php echo $drop['item']->ypname; ?></a></font>
    <?php endif; ?>
<?php endforeach; ?>
</div><hr>
<br/>
<!--<IMG width="25" height="15" src="./images/pk.png">-->
<a href="?cmd=<?php echo $pvb; ?>" style="color: #ec0808;">Giàu có nhờ trời！</a>
<!--<IMG width="25" height="15" src="./images/pk.png">-->
<!--<IMG width="25" height="15" src="./images/ct.png">-->
<a style="float:right;" onClick="javascript :history.back(-1);">Quấy rầy...<IMG width="15" height="15" src="./images/ct.png"></a>
<br/>
