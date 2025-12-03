<?php
/**
 * @var \XXJ\Models\Club $club
 * @var \XXJ\Models\ClubMember[] $members
 * @var \XXJ\Models\ClubMember|null $currentMember
 * @var string $viewMode 'guest' or 'member'
 * @var \XXJ\Models\Player $player
 */
$encoder = new \XXJ\Utils\Encoder();
$isLeader = $currentMember && $currentMember->uclv == 1;
$canManage = $currentMember && $currentMember->uclv <= 2;
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title><?= $club->clubname ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <link rel="stylesheet" href="css/gamecss.css">
</head>
<body>
<div class="main">
    <div class="header">
        <?= $club->clubname ?>
    </div>
    
    <div class="content">
        <div align="center">
            <img src="./images/menpai.png" width="280" height="140" style="border-radius: 8px;">
        </div>
        
        <p>Cấp độ: <?= $club->clublv ?></p>
        <p>Kinh nghiệm: <?= $club->clubexp ?></p>
        <p>Tuyên ngôn: <?= $club->clubinfo ?></p>
        
        <hr>
        
        <?php if ($viewMode === 'guest'): ?>
            <?php if (!$currentMember): // Only show Join if not in ANY club ?>
                <div align="center">
                    <a href="?cmd=<?= $encoder->encode("cmd=club&action=join&clubid={$club->clubid}") ?>">Gia nhập môn phái</a>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <div align="center">
                <?php if ($isLeader): ?>
                    <a href="?cmd=<?= $encoder->encode("cmd=club&action=disband") ?>" onclick="return confirm('Bạn có chắc chắn muốn giải tán môn phái? Hành động này không thể hoàn tác!')" style="color: red;">Giải tán môn phái</a>
                <?php else: ?>
                    <a href="?cmd=<?= $encoder->encode("cmd=club&action=leave") ?>" onclick="return confirm('Bạn có chắc chắn muốn rời khỏi môn phái?')">Rời khỏi môn phái</a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        
        <hr>
        <h3>Thành viên (<?= count($members) ?>)</h3>
        
        <?php foreach ($members as $member): ?>
            <div>
                <span style="color: #a08f0a">[<?= $member->getRankName() ?>]</span> 
                <?= $member->uname ?> (Lv.<?= $member->ulv ?>)
                
                <?php if ($canManage && $member->uid != $player->uid && $member->uclv > $currentMember->uclv): ?>
                    <!-- Management Actions -->
                    <br>
                    &nbsp;&nbsp;↳ Bổ nhiệm: 
                    <?php if ($currentMember->uclv == 1): ?>
                        <a href="?cmd=<?= $encoder->encode("cmd=club&action=manage&subaction=appoint&uid={$member->uid}&rank=2") ?>">Phó CM</a> |
                    <?php endif; ?>
                    <a href="?cmd=<?= $encoder->encode("cmd=club&action=manage&subaction=appoint&uid={$member->uid}&rank=3") ?>">Trưởng lão</a> |
                    <a href="?cmd=<?= $encoder->encode("cmd=club&action=manage&subaction=appoint&uid={$member->uid}&rank=4") ?>">Chấp sự</a> |
                    <a href="?cmd=<?= $encoder->encode("cmd=club&action=manage&subaction=appoint&uid={$member->uid}&rank=5") ?>">Tinh anh</a> |
                    <a href="?cmd=<?= $encoder->encode("cmd=club&action=manage&subaction=appoint&uid={$member->uid}&rank=6") ?>">Đệ tử</a>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
        
        <br>
        <a href="?cmd=<?= $encoder->encode("cmd=club") ?>">Danh sách môn phái</a>
        <br>
        <a href="?cmd=<?= $encoder->encode("cmd=gomid&newmid={$player->nowmid}") ?>">Trở về bản đồ</a>
    </div>
</div>
</body>
</html>
