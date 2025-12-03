<?php
$encode = new \XXJ\Classes\Encode();
$gonowmid = $encode->encode("cmd=gomid&newmid={$player->nowmid}&sid={$player->sid}");
?>
<img width='280' height='140' src='images/rw.png' style="border-radius: 8px;"><br/>

<?php if (empty($tasks)): ?>
    Hiện tại không có nhiệm vụ nào.<br/>
<?php else: ?>
    <?php foreach ($tasks as $task): ?>
        <?php
        $rwid = $task->rwid;
        $rwname = $task->rwname;
        $rwlx = $task->rwlx;
        $rwzt = $task->rwzt;
        
        $mytaskinfo = $encode->encode("cmd=mytaskinfo&rwid=$rwid&sid={$player->sid}");
        
        $prefix = '';
        if ($rwlx == 2 && $rwzt != 3) {
            $prefix = '[Mỗi ngày]';
        } elseif ($rwlx == 3 && $rwzt != 3) {
            $prefix = '[<font class="aa" color="#F3160B">Chủ tuyến</font>]';
        } elseif ($rwlx == 1 && $rwzt != 3) {
            $prefix = '[Phổ thông]';
        }
        ?>
        
        <?php echo $prefix; ?>
        <a href="?cmd=<?php echo $mytaskinfo; ?>"><?php echo $rwname; ?></a>
        
        <?php if ($rwzt == 1): ?>
            <br/><img src="images/wen.gif"/>
        <?php elseif ($rwzt == 2): ?>
            <img src="images/tan.gif"/><br/>
        <?php endif; ?>
        <br/>
    <?php endforeach; ?>
<?php endif; ?>

<br/>
<a href="#" onClick="javascript:history.back(-1);">Trở lại</a>
<a href="?cmd=<?php echo $gonowmid; ?>" style="float:right;">Trở về trò chơi</a>
