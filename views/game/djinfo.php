<?php if (!$item): ?>
    Đạo cụ không tồn tại.<br/>
    <a href="#" onClick="javascript:history.back(-1);">Trở lại</a>
<?php else: ?>
    <font class="djys"><?php echo $item->djname; ?></font><br/>
    Giới thiệu: <?php echo $item->djinfo; ?><br/>
    <br/>
    <?php if ($playerItem && $playerItem->djsum > 0): ?>
        Số lượng: <?php echo $playerItem->djsum; ?><br/>
        <br/>
        <!-- Auction Form (Placeholder for now, logic needs to be implemented) -->
        <form action="?">
            <input type="hidden" name="cmd" value="sellitem">
            <input type="hidden" name="djid" value="<?php echo $item->djid; ?>">
            <input type="hidden" name="sid" value="<?php echo $player->sid; ?>">
            Đấu giá số lượng：<br/>
            <input type="number" name="count" min="1" max="<?php echo $playerItem->djsum; ?>"><br/>
            Đấu giá đơn giá：<br/>
            <input type="number" name="price"><br/>
            <input type="submit" value="Đấu giá">
        </form>
    <?php else: ?>
        Bạn không có đạo cụ này.<br/>
    <?php endif; ?>
    <br/>
    <a href="#" onClick="javascript:history.back(-1);">Trở lại</a>
    <a href="?cmd=gomid&newmid=<?php echo $player->nowmid; ?>&sid=<?php echo $player->sid; ?>" style="float:right;background-color:#cff3d2;color: #755d5d;" >Trở về trò chơi</a>
<?php endif; ?>
