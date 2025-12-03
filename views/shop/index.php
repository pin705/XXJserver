<?php
$player = $data['player'];
$items = $data['items'];
$message = $data['message'];
$sid = $data['sid'];
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cửa Hàng - Tu Tiên Giới</title>
    <link rel="stylesheet" href="/css/gamecss.css">
    <style>
        .shop-container {
            padding: 10px;
        }
        .currency-info {
            background: #f0f0f0;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        .item-list {
            width: 100%;
            border-collapse: collapse;
        }
        .item-list th, .item-list td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .item-list th {
            background-color: #4CAF50;
            color: white;
        }
        .item-list tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .buy-btn {
            display: inline-block;
            padding: 5px 10px;
            margin: 2px;
            text-decoration: none;
            color: white;
            border-radius: 3px;
            font-size: 12px;
        }
        .btn-uyxb {
            background-color: #2196F3;
        }
        .btn-uczb {
            background-color: #FF9800;
        }
        .message {
            padding: 10px;
            margin-bottom: 10px;
            background-color: #dff0d8;
            border: 1px solid #d6e9c6;
            color: #3c763d;
            border-radius: 4px;
        }
        .nav-links {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="shop-container">
        <h2>Cửa Hàng</h2>
        
        <?php if ($message): ?>
            <div class="message"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>

        <div class="currency-info">
            <strong>Tài sản của bạn:</strong><br>
            Linh thạch: <?php echo number_format($player->uyxb); ?><br>
            Tiên thạch: <?php echo number_format($player->uczb); ?>
        </div>

        <table class="item-list">
            <thead>
                <tr>
                    <th>Vật phẩm</th>
                    <th>Hiệu quả</th>
                    <th>Giá</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $item): ?>
                    <tr>
                        <td>
                            <strong><?php echo htmlspecialchars($item['ydname']); ?></strong>
                        </td>
                        <td>
                            <?php echo htmlspecialchars($item['yddesc'] ?? 'Hồi phục HP/MP'); ?>
                        </td>
                        <td>
                            <?php echo number_format($item['jiage']); ?>
                        </td>
                        <td>
                            <a href="?cmd=shop&buy_id=<?php echo $item['id']; ?>&amount=1&currency=uyxb" class="buy-btn btn-uyxb">Mua (Linh thạch)</a>
                            <a href="?cmd=shop&buy_id=<?php echo $item['id']; ?>&amount=1&currency=uczb" class="buy-btn btn-uczb">Mua (Tiên thạch)</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="nav-links">
            <a href="game.php">Quay lại trò chơi</a>
        </div>
    </div>
</body>
</html>