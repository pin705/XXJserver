<?php if (isset($error)): ?>
    <?php echo $error; ?><br/>
    <br/>
    <a href="?cmd=<?php echo $back_cmd; ?>">Trở về trò chơi</a>
<?php else: ?>
    <?php echo $template->gname; ?><br/>
    Cấp bậc: <?php echo $template->glv; ?><br/>
    Giới thiệu: <?php echo $template->ginfo; ?><br/>
    HP: <?php echo $monster->ghp; ?>/<?php echo $monster->gmaxhp; ?><br/>
    Công kích: <?php echo $template->ggj; ?><br/>
    Phòng ngự: <?php echo $template->gfy; ?><br/>
    <br/>
    <a href="?cmd=<?php echo $pve_cmd; ?>">Công kích</a><br/>
    <br/>
    Rơi xuống:<br/>
    <?php foreach ($drops as $drop): ?>
        <?php if ($drop['type'] == 'equip'): ?>
            <a href="?cmd=<?php echo $drop['cmd']; ?>"><font color="<?php echo $drop['color']; ?>"><?php echo $drop['name']; ?></font></a>
        <?php elseif ($drop['type'] == 'item'): ?>
            <font class="djys"><a href="?cmd=<?php echo $drop['cmd']; ?>"><?php echo $drop['name']; ?></a></font>
        <?php elseif ($drop['type'] == 'potion'): ?>
            <a href="?cmd=<?php echo $drop['cmd']; ?>"><?php echo $drop['name']; ?></a>
        <?php endif; ?>
    <?php endforeach; ?>
    <br/>
    <br/>
    <a href="?cmd=<?php echo $back_cmd; ?>">Trở về trò chơi</a>
<?php endif; ?>
