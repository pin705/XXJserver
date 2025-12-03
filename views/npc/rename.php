<div class="main">
    <h3>Cải Danh Dịch Vụ</h3>
    <hr>
    <div align="center">
        ==Làm lại cuộc đời==<br/>
        Ẩn tính mai danh<br/>
        Không hỏi thế sự<br/>
        Hay là...<br/>
        Đại sát tứ phương<br>
        <br>
        <?php if ($message): ?>
            <div style="color: red; font-weight: bold;"><?= $message ?></div>
            <hr>
        <?php endif; ?>

        <?php if (empty($message) || strpos($message, 'thành công') === false): ?>
            <form action="" method="get">
                <input type="hidden" name="cmd" value="gaiming">
                <input type="hidden" name="canshu" value="process">
                <input type="hidden" name="nid" value="<?= $nid ?>">
                <input type="hidden" name="sid" value="<?= $sid ?>">
                
                <input name="newname" placeholder="Tên mới (6-12 ký tự)">
                <br><br>
                <p>Phí đổi tên: 200 Tiên thạch</p>
                <input type="submit" value="Đổi Tên" style="background-color: #49bb7c;color: white;border-radius: 4px;">
            </form>
        <?php endif; ?>
        
        <br>
        <a href="?cmd=<?= $encoder->encode("cmd=npc&nid=$nid&sid=$sid") ?>">Trở về</a>
    </div>
</div>
