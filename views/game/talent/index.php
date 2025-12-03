<?php
$player = $data['player'];
$message = $data['message'];
$sid = $player->sid;
$gonowmid = "gomid&newmid=$player->nowmid&sid=$sid";

// Links
$resetLink = "tianfu&action=reset&sid=$sid";
$infoLink = "tianfu&action=info&sid=$sid";
?>
<p>Thiên Phú</p>
<?php if ($message): ?>
    <p style="color:red"><?php echo $message; ?></p>
<?php endif; ?>

<p>
    Thiên phú còn lại: <?php echo $player->tf; ?><br/>
    <a href="?cmd=<?php echo $resetLink; ?>">Nghịch thiên cải mệnh</a> (Reset)<br/>
    <a href="?cmd=<?php echo $infoLink; ?>">Xem hướng dẫn</a>
</p>

<table border="1">
    <tr>
        <td>Thuộc tính</td>
        <td>Điểm</td>
        <td>Thao tác</td>
    </tr>
    <tr>
        <td>May mắn (tfxy)</td>
        <td><?php echo $player->tfxy; ?></td>
        <td><a href="?cmd=tianfu&action=upgrade&type=tfxy&sid=<?php echo $sid; ?>">Tăng</a></td>
    </tr>
    <tr>
        <td>Né tránh (tfsb)</td>
        <td><?php echo $player->tfsb; ?></td>
        <td><a href="?cmd=tianfu&action=upgrade&type=tfsb&sid=<?php echo $sid; ?>">Tăng</a></td>
    </tr>
    <tr>
        <td>Phòng ngự (tffy)</td>
        <td><?php echo $player->tffy; ?></td>
        <td><a href="?cmd=tianfu&action=upgrade&type=tffy&sid=<?php echo $sid; ?>">Tăng</a></td>
    </tr>
    <tr>
        <td>HP (tfhp)</td>
        <td><?php echo $player->tfhp; ?></td>
        <td><a href="?cmd=tianfu&action=upgrade&type=tfhp&sid=<?php echo $sid; ?>">Tăng</a></td>
    </tr>
    <tr>
        <td>Bạo kích (tfbj)</td>
        <td><?php echo $player->tfbj; ?></td>
        <td><a href="?cmd=tianfu&action=upgrade&type=tfbj&sid=<?php echo $sid; ?>">Tăng</a></td>
    </tr>
    <tr>
        <td>Hút máu (tfxx)</td>
        <td><?php echo $player->tfxx; ?></td>
        <td><a href="?cmd=tianfu&action=upgrade&type=tfxx&sid=<?php echo $sid; ?>">Tăng</a></td>
    </tr>
    <tr>
        <td>Công kích (tfgj)</td>
        <td><?php echo $player->tfgj; ?></td>
        <td><a href="?cmd=tianfu&action=upgrade&type=tfgj&sid=<?php echo $sid; ?>">Tăng</a></td>
    </tr>
</table>

<p>
    <a href="#" onClick="javascript:history.back(-1);">Trở lại</a>
    <a href="?cmd=<?php echo $gonowmid; ?>" style="float:right;">Trở về trò chơi</a>
</p>
