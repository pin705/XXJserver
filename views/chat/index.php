<?php
$messages = $data['messages'];
$ltlx = $data['ltlx'];
$player = $data['player'];
$sid = $data['sid'];

$globalLink = "?cmd=liaotian&ltlx=all&sid=$sid";
$privateLink = "?cmd=liaotian&ltlx=im&sid=$sid";
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trò Chuyện - Tu Tiên Giới</title>
    <link rel="stylesheet" href="/css/gamecss.css">
    <style>
        .chat-container {
            padding: 10px;
        }
        .chat-nav {
            margin-bottom: 10px;
        }
        .chat-nav a {
            margin-right: 10px;
            text-decoration: none;
            font-weight: bold;
        }
        .chat-nav a.active {
            color: red;
        }
        .chat-box {
            border: 1px dashed #dcd4a1;
            padding: 5px;
            height: 300px;
            overflow-y: auto;
            background-color: #fff;
            margin-bottom: 10px;
        }
        .chat-msg {
            margin-bottom: 5px;
            font-size: 14px;
        }
        .chat-sender {
            color: #0000FF;
            text-decoration: none;
        }
        .chat-form {
            display: flex;
        }
        .chat-input {
            flex: 1;
            padding: 5px;
        }
        .chat-submit {
            padding: 5px 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        .refresh-link {
            margin-left: 10px;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="chat-container">
        <div class="chat-nav">
            <a href="<?php echo $globalLink; ?>" class="<?php echo $ltlx == 'all' ? 'active' : ''; ?>">【Công cộng】</a>
            <a href="<?php echo $privateLink; ?>" class="<?php echo $ltlx == 'im' ? 'active' : ''; ?>">【Riêng tư】</a>
        </div>

        <div class="chat-box">
            <?php if (empty($messages)): ?>
                <div class="chat-msg">Chưa có tin nhắn nào.</div>
            <?php else: ?>
                <?php foreach ($messages as $msg): ?>
                    <div class="chat-msg">
                        <?php 
                            $senderName = htmlspecialchars($msg['name']);
                            $content = htmlspecialchars($msg['msg']);
                            $uid = $msg['uid'];
                            // Link to view player info
                            $playerLink = "?cmd=getplayerinfo&uid=$uid&sid=$sid";
                        ?>
                        <a href="<?php echo $playerLink; ?>" class="chat-sender"><?php echo $senderName; ?></a>: 
                        <?php echo $content; ?>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <form action="game.php" method="GET" class="chat-form">
            <input type="hidden" name="cmd" value="sendliaotian">
            <input type="hidden" name="ltlx" value="<?php echo $ltlx; ?>">
            <input type="hidden" name="sid" value="<?php echo $sid; ?>">
            <?php if ($ltlx == 'im'): ?>
                <!-- For private chat, we might need a target UID. 
                     Legacy simplified this or used context. 
                     For now, let's assume we are replying to someone or just listing.
                     If this is a general private chat view, maybe we don't send from here easily without selecting a target.
                     But legacy allowed sending? Let's check legacy again.
                     Legacy: <input type="text" name="ltmsg">
                     It seems legacy 'im' view lists messages involving you.
                -->
            <?php endif; ?>
            
            <input type="text" name="ltmsg" class="chat-input" maxlength="50" placeholder="Nhập tin nhắn..." required>
            <button type="submit" class="chat-submit">Gửi</button>
            <a href="?cmd=liaotian&ltlx=<?php echo $ltlx; ?>&sid=<?php echo $sid; ?>" class="refresh-link">Làm mới</a>
        </form>
        
        <div style="margin-top: 10px;">
            <a href="game.php">Quay lại trò chơi</a>
        </div>
    </div>
</body>
</html>