<?php
// Template for nowmid
// Variables available: $player, $clmid, $boss, $bossHtml, $djs, $npcs, $monsters, $chats, $links, $encoder, $sid
?>
<font face=Thể chữ lệ color="ae2d61">
<marquee direction="left" style="background: #ffffff;font-size:30 px">
<font color="#FFA000">【 <?= $clmid->mname ?> 】</font>
<font color="#7FE000"><?= $clmid->ispvp ? "<font color='#FF0000'>[PVP]</font>" : "[Khu vực an toàn]" ?></font>
<?= $clmid->midinfo ?>---->Có người trông thấy<?= $clmid->playerinfo ?>
</marquee>
</font>

<!-- NPCs -->
<?php foreach ($npcs as $npc): ?>
    <?php $npccmd = $encoder->encode("cmd=npc&nid=$npc->id&sid=$sid"); ?>
    <a href="?cmd=<?= $npccmd ?>"><?= $npc->nname ?></a>
<?php endforeach; ?>
<br>

<!-- Monsters/Boss -->
<hr style="height:3px;border:none;border-top:3px double #efa1a1;" />
<?php if ($djs): ?>
    <div align="center">
    <span class="STYLE7" id="clock" style="color: #f50e0e;"><?= $djs ?></span>
    <strong><span class="STYLE8">Giây sau làm mới BOSS</span>
    <script type="text/javascript">
    var oclock=document.getElementById("clock");
    var start1 = oclock.innerHTML;
    var finish = "0";
    var timer = null;
    run();
    function run() {
    timer =setInterval("onTimer()", 1000);
    }
    function onTimer()
    {
    if (start1 == finish)
    {
    clearInterval(timer);
    start1="1";
    }
    start1 -= 1;
    oclock.innerHTML = start1;
    }
    </script>
    </strong>
    <meta http-equiv="refresh" content="<?= $djs + 1 ?>">
    </div>
<?php endif; ?>

<?= $bossHtml ?>

<?php foreach ($monsters as $monster): ?>
    <?php $gwcmd = $encoder->encode("cmd=pve&gid=$monster->id&sid=$sid"); ?>
    <a href="?cmd=<?= $gwcmd ?>"><?= $monster->gname ?></a>
<?php endforeach; ?>

<hr>
<!-- Directions -->
<?php if ($clmid->upmid): ?><a href="?cmd=<?= $links['up'] ?>">Lên: <?= $clmid->upmid ?></a><br><?php endif; ?>
<?php if ($clmid->downmid): ?><a href="?cmd=<?= $links['down'] ?>">Xuống: <?= $clmid->downmid ?></a><br><?php endif; ?>
<?php if ($clmid->leftmid): ?><a href="?cmd=<?= $links['left'] ?>">Trái: <?= $clmid->leftmid ?></a><br><?php endif; ?>
<?php if ($clmid->rightmid): ?><a href="?cmd=<?= $links['right'] ?>">Phải: <?= $clmid->rightmid ?></a><br><?php endif; ?>

<hr>
<div class="juzhong1">Vị trí: 『<?= $clmid->mname ?> 』</div>

<hr>
<!-- Player Info -->
HP: <?= $player->uhp ?>/<?= $player->umaxhp ?><br>
Level: <?= $player->ulv ?><br>

<br/>
<div id="ltmsg">
<hr>
</div>
<!-- Chat -->
<?php foreach ($chats as $chat): ?>
    <?php $ucmd = $encoder->encode("cmd=getplayerinfo&uid={$chat['uid']}&sid=$sid"); ?>
    <a href='?cmd=<?= $ucmd ?>'><?= $chat['name'] ?></a>:<?= $chat['msg'] ?><br>
<?php endforeach; ?>

<hr>
<div align="center">
<div class="menu">
<a href="?cmd=<?= $links['map'] ?>">
    <strong style="background:#00E000">
    <font color=#FCFCFC>[</font><font color=#F9F9F9>Xem xét </font><font color=#F6F6F6>Thế giới</font><font color=#F3F3F3>]</font></strong>
    </a>
    <a href="?cmd=<?= $links['task'] ?>">Nhiệm vụ</a>
    <a href="?cmd=<?= $links['map'] ?>">Địa đồ</a>
    <a href="?cmd=<?= $links['refresh'] ?>">Làm mới</a>
</div>
<br/>
<hr style="width:280px; height:0px;border:none;border-top:10px groove #a5eaad;"  />
<div class="menu">
<div>
<a href="?cmd=<?= $links['status'] ?>">Trạng thái</a> 
<a href="?cmd=<?= $links['bag'] ?>" >Hành Trang</a> 
<a href="?cmd=<?= $links['chat'] ?>" >Trò chuyện</a> 
<a href="?cmd=<?= $links['pet'] ?>"      style="background-color:#;color:#f59b11;">Sủng vật</a>
</div>
<div>
<a href="?cmd=<?= $links['mystery_shop'] ?>" >Shop Bí Ẩn</a>
<a href="?cmd=<?= $links['rank'] ?>" >Xếp hạng</a> 
<a href="?cmd=<?= $links['cultivate'] ?>" >Tu luyện</a> 
<a href="?cmd=<?= $links['trade'] ?>" >Giao dịch</a> 
</div>
<div>
<a href="?cmd=<?= $links['club'] ?>" >Môn phái</a>
<a href="?cmd=<?= $links['friend'] ?>" >Hảo hữu</a> 
<a href="?cmd=<?= $links['gift'] ?>" >Nhận quà</a>
<a href="?cmd=<?= $links['shop'] ?>">
<font color=#FB4A0E>Cửa hàng</font></a> 
</div>
<a href="index.php" style="align-content: center;"><div>Rời khỏi</div></a>
</div>
</div>
