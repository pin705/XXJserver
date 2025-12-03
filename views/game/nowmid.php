<?php
$clmid = $data['clmid'];
$boss = $data['boss'];
$bossHtml = $data['bossHtml'];
$djs = $data['djs'];
$npcs = $data['npcs'];
$monsters = $data['monsters'];
$chats = $data['chats'];
$links = $data['links'];
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $clmid->mname; ?></title>
    <link rel="stylesheet" href="css/gamecss.css">
</head>
<body>
    <div class="container">
        <h3><?php echo $clmid->mname; ?></h3>
        <p><?php echo $clmid->minfo; ?></p>

        <?php if ($bossHtml): ?>
            <div class="boss-section">
                <strong>BOSS:</strong> <?php echo $bossHtml; ?>
            </div>
        <?php elseif ($djs): ?>
            <div class="boss-timer">
                Boss sẽ xuất hiện sau: <span id="countdown"><?php echo $djs; ?></span> giây
                <script>
                    var seconds = <?php echo $djs; ?>;
                    var countdown = setInterval(function() {
                        seconds--;
                        document.getElementById("countdown").textContent = seconds;
                        if (seconds <= 0) clearInterval(countdown);
                    }, 1000);
                </script>
            </div>
        <?php endif; ?>

        <hr>

        <?php if (!empty($npcs)): ?>
            <div class="npc-list">
                <strong>NPC:</strong><br>
                <?php foreach ($npcs as $npc): ?>
                    <?php $npcLink = $encode->encode("cmd=npc&nid={$npc->id}&sid=$sid"); ?>
                    <a href="?cmd=<?php echo $npcLink; ?>"><?php echo $npc->nname; ?></a><br>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($monsters)): ?>
            <div class="monster-list">
                <strong>Quái vật:</strong><br>
                <?php foreach ($monsters as $monster): ?>
                    <?php $monsterLink = $encode->encode("cmd=getginfo&gid={$monster->id}&gyid={$monster->gyid}&sid=$sid"); ?>
                    <a href="?cmd=<?php echo $monsterLink; ?>"><?php echo $monster->gname; ?></a> 
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <hr>

        <div class="exits">
            <?php if ($clmid->upmid): ?>
                Bắc: <a href="?cmd=<?php echo $links['up']; ?>">Đi lên ↑</a><br>
            <?php endif; ?>
            <?php if ($clmid->leftmid): ?>
                Tây: <a href="?cmd=<?php echo $links['left']; ?>">Đi sang trái ←</a><br>
            <?php endif; ?>
            <?php if ($clmid->rightmid): ?>
                Đông: <a href="?cmd=<?php echo $links['right']; ?>">Đi sang phải →</a><br>
            <?php endif; ?>
            <?php if ($clmid->downmid): ?>
                Nam: <a href="?cmd=<?php echo $links['down']; ?>">Đi xuống ↓</a><br>
            <?php endif; ?>
        </div>

        <hr>

        <div class="actions">
            <a href="?cmd=<?php echo $links['refresh']; ?>">Làm mới</a> |
            <a href="?cmd=<?php echo $links['map']; ?>">Bản đồ</a> |
            <a href="?cmd=<?php echo $links['task']; ?>">Nhiệm vụ</a> |
            <a href="?cmd=<?php echo $links['status']; ?>">Trạng thái</a> |
            <a href="?cmd=<?php echo $links['bag']; ?>">Hành trang</a> |
            <a href="?cmd=<?php echo $links['chat']; ?>">Chat</a> |
            <a href="?cmd=<?php echo $links['pet']; ?>">Sủng vật</a> |
            <a href="?cmd=<?php echo $links['shop']; ?>">Cửa hàng</a> |
            <a href="?cmd=<?php echo $links['rank']; ?>">Xếp hạng</a> |
            <a href="?cmd=<?php echo $links['cultivate']; ?>">Tu luyện</a> |
            <a href="?cmd=<?php echo $links['trade']; ?>">Chợ</a> |
            <a href="?cmd=<?php echo $links['club']; ?>">Bang hội</a> |
            <a href="?cmd=<?php echo $links['friend']; ?>">Bạn bè</a> |
            <a href="?cmd=<?php echo $links['gift']; ?>">Đổi quà</a> |
            <a href="?cmd=<?php echo $links['mystery_shop']; ?>">Tiên các</a>
        </div>

        <hr>
        
        <div class="chat-preview">
            <?php foreach ($chats as $chat): ?>
                <div>[<?php echo $chat->name; ?>]: <?php echo $chat->msg; ?></div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>
