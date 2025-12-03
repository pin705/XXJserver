<?php if (isset($error)): ?>
    <?php echo $error; ?><br/>
    <br/>
    <a href="?cmd=<?php echo $back_cmd; ?>">Trở về trò chơi</a>
<?php else: ?>
    <?php echo $target->uname; ?><br/>
    Cấp bậc: <?php echo $target->ulv; ?><br/>
    Môn phái: 
    <?php if ($clubCmd): ?>
        <a href="?cmd=<?php echo $clubCmd; ?>"><?php echo $clubName; ?></a>
    <?php else: ?>
        <?php echo $clubName; ?>
    <?php endif; ?>
    <br/>
    <br/>
    <?php echo $imMenu; ?>
    <br/>
    <a href="?cmd=<?php echo $back_cmd; ?>">Trở về trò chơi</a>
<?php endif; ?>
