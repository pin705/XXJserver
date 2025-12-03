<?php
/**
 * @var \XXJ\Models\Pet[] $pets
 * @var int $currentPetId
 * @var string|null $popup
 * @var \XXJ\Models\Player $player
 */
$encoder = new \XXJ\Utils\Encoder();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Sủng vật</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <link rel="stylesheet" href="css/gamecss.css">
    <script src="js/jquery-1.11.3.min.js"></script>
</head>
<body>
<div class="main">
    <div class="header">
        Sủng vật
    </div>
    
    <div class="content">
        <p>Ma thạch: <?= $player->uczb ?></p>
        
        <div align="center">
            <a href="?cmd=<?= $encoder->encode("cmd=chongwu&action=draw") ?>" style="color: #fd0000;" onclick="return confirm('Bạn có chắc chắn muốn tiêu 50 Ma thạch để rút thưởng sủng vật không?')">Rút thưởng sủng vật (50 Ma thạch)</a>
        </div>
        <br>

        <?php if (!empty($pets)): ?>
            <?php foreach ($pets as $pet): ?>
                <div class="pet-item" style="border: 1px solid #ccc; padding: 5px; margin-bottom: 5px;">
                    <span style="color: <?= $pet->getQualityColor() ?>"><?= $pet->cwname ?></span> (Lv.<?= $pet->cwlv ?>)
                    <br>
                    Phẩm chất: <span style="color: <?= $pet->getQualityColor() ?>"><?= $pet->getQualityName() ?></span>
                    <br>
                    HP: <?= $pet->cwhp ?>/<?= $pet->total_hp ?> | Công: <?= $pet->total_gj ?> | Thủ: <?= $pet->total_fy ?>
                    <br>
                    
                    <a href="?cmd=<?= $encoder->encode("cmd=chongwu&action=info&cwid={$pet->cwid}") ?>">Xem</a> |
                    
                    <?php if ($currentPetId == $pet->cwid): ?>
                        <a href="?cmd=<?= $encoder->encode("cmd=chongwu&action=recall") ?>">Thu hồi</a>
                    <?php else: ?>
                        <a href="?cmd=<?= $encoder->encode("cmd=chongwu&action=deploy&cwid={$pet->cwid}") ?>">Xuất chiến</a>
                    <?php endif; ?>
                    |
                    <a href="?cmd=<?= $encoder->encode("cmd=chongwu&action=release&cwid={$pet->cwid}") ?>" onclick="return confirm('Bạn có chắc chắn muốn phóng sinh sủng vật này không?')">Phóng sinh</a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Bạn chưa có sủng vật nào.</p>
        <?php endif; ?>
        
        <br>
        <a href="?cmd=<?= $encoder->encode("cmd=gomid&newmid={$player->nowmid}") ?>">Trở về bản đồ</a>
    </div>

    <!-- Popup Logic -->
    <?php if ($popup): ?>
        <font id="popup-trigger"></font>
        <script src="chajian/tishikuang/javascript/zepto.min.js"></script>
        <script type="text/javascript" src="chajian/tishikuang/javascript/dialog.min.js"></script>
        <script type="text/javascript">
            setTimeout(function() {
                // IE
                if(document.all) {
                    document.getElementById("popup-trigger").click();
                }
                // Other browsers
                else {
                    var e = document.createEvent("MouseEvents");
                    e.initEvent("click", true, true);
                    document.getElementById("popup-trigger").dispatchEvent(e);
                }
            }, 500);

            $('#popup-trigger').click(function(){
                <?php if ($popup === 'success'): ?>
                    popup({type:'success',msg:"Rút thưởng thành công!",delay:2000,callBack:function(){}});
                <?php elseif ($popup === 'fail'): ?>
                    popup({type:'error',msg:"Ma thạch không đủ!",delay:2000,bg:true,clickDomCancel:true});
                <?php endif; ?>
            });
        </script>
    <?php endif; ?>

</div>
</body>
</html>
