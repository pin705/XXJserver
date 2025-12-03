<?php
$gonowmid = $encode->encode("cmd=gomid&newmid=$player->nowmid&sid=$sid");
$drawCmd = $encode->encode("cmd=skill_draw&sid=$sid");
$trainCmd = $encode->encode("cmd=skill_train&sid=$sid");
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Võ Công</title>
    <link rel="stylesheet" href="css/gamecss.css">
    <style>
        .skill-item {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
        }
        .skill-active {
            border-color: gold;
            background-color: #fffbe6;
        }
        .btn {
            display: inline-block;
            padding: 5px 10px;
            background-color: #eee;
            border: 1px solid #ccc;
            text-decoration: none;
            color: #333;
            border-radius: 3px;
            margin-right: 5px;
        }
        .btn-primary {
            background-color: #007bff;
            color: white;
            border-color: #007bff;
        }
        .btn-danger {
            background-color: #dc3545;
            color: white;
            border-color: #dc3545;
        }
        .btn-success {
            background-color: #28a745;
            color: white;
            border-color: #28a745;
        }
    </style>
</head>
<body>
    <div class="container">
        <h3>Hệ Thống Võ Công</h3>
        
        <?php if (isset($error)): ?>
            <div style="color: red; margin-bottom: 10px;"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <?php if (isset($success)): ?>
            <div style="color: green; margin-bottom: 10px;"><?php echo $success; ?></div>
        <?php endif; ?>

        <div style="margin-bottom: 15px; text-align: center;">
            <?php if ($activeSkillId): ?>
                <div style="margin-bottom: 10px;">
                    <img src="images/wugong/<?php echo $activeSkillId; ?>.png" style="width: 100px; border-radius: 8px;"><br>
                    Đang tu luyện: <strong><?php 
                        foreach ($skills as $s) {
                            if ($s->wgid == $activeSkillId) {
                                echo $s->wgname;
                                break;
                            }
                        }
                    ?></strong>
                </div>
                <a href="?cmd=<?php echo $trainCmd; ?>" class="btn btn-success">Vào Tu Luyện</a>
            <?php else: ?>
                <p>Chưa chọn võ công để tu luyện.</p>
            <?php endif; ?>
        </div>

        <hr>

        <h4>Danh sách bí tịch</h4>
        
        <?php if (empty($skills)): ?>
            <p>Bạn chưa có bí tịch nào.</p>
        <?php else: ?>
            <?php foreach ($skills as $skill): ?>
                <?php 
                    $isActive = $skill->wgid == $activeSkillId;
                    $learnCmd = $encode->encode("cmd=skill_learn&wgid={$skill->wgid}&sid=$sid");
                    $unlearnCmd = $encode->encode("cmd=skill_unlearn&wgid={$skill->wgid}&sid=$sid");
                    $discardCmd = $encode->encode("cmd=skill_discard&wgid={$skill->wgid}&sid=$sid");
                ?>
                <div class="skill-item <?php echo $isActive ? 'skill-active' : ''; ?>">
                    <div style="font-weight: bold; color: <?php echo $skill->wgys; ?>">
                        <?php echo $skill->wgname; ?> (x<?php echo $skill->wgsum; ?>)
                    </div>
                    <div>Cấp độ: <?php echo $skill->wgdj; ?></div>
                    <div>Kinh nghiệm: <?php echo $skill['wgxl']; ?> / <?php echo $skill['wgxlmax']; ?></div>
                    <div style="margin-top: 5px;">
                        <?php if ($isActive): ?>
                            <span class="btn btn-primary">(Đang học)</span>
                            <a href="?cmd=<?php echo $unlearnCmd; ?>" class="btn">Bế quan</a>
                        <?php else: ?>
                            <a href="?cmd=<?php echo $learnCmd; ?>" class="btn">Học tập</a>
                            <a href="?cmd=<?php echo $discardCmd; ?>" class="btn btn-danger" onclick="return confirm('Bạn có chắc muốn vứt bỏ bí tịch này?');">Vứt bỏ</a>
                        <?php endif; ?>
                    </div>
                    <div style="font-size: 0.9em; color: #666; margin-top: 5px;">
                        <?php echo $skill['wginfo']; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <hr>
        <div style="text-align: center;">
            <p>Rút bí tịch (200 Tiên ngọc/lần)</p>
            <a href="?cmd=<?php echo $drawCmd; ?>" class="btn btn-primary">Rút Bí Tịch</a>
        </div>

        <hr>
        <a href="game.php?cmd=<?php echo $gonowmid; ?>" class="btn">Trở về trò chơi</a>
    </div>
</body>
</html>
