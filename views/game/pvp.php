<?php if (isset($error)): ?>
    <?php echo $error; ?><br/>
    <br/>
    <a href="?cmd=<?php echo $back_cmd; ?>">Trở về trò chơi</a>
<?php else: ?>
    <?php echo $msg; ?><br/>
    <br/>
    Đối thủ: <?php echo $target->uname; ?><br/>
    HP: <?php echo $target->uhp; ?>/<?php echo $target->umaxhp; ?><br/>
    <br/>
    <?php if ($target->uhp > 0): ?>
        <a href="?cmd=<?php echo $attack_cmd; ?>">Tiếp tục công kích</a><br/>
    <?php endif; ?>
    <br/>
    <a href="?cmd=<?php echo $back_cmd; ?>">Trở về trò chơi</a>
<?php endif; ?>
