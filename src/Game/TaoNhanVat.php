<?php
$selfym = $_SERVER['PHP_SELF'];

$html = <<<HTML
<IMG width='280' height='140' src='./images/rw.png'src="./images/rw.png" style="border-radius: 8px;">
    <div align="center">
	<form action=$selfym method="get">
        
        <input type="hidden" name="cmd" value="cjplayer">
        <input type="hidden" name="token" value='$token'>
        <p>Nhân vật tên：<br>
		<input class="input" type="text" name="username" maxlength="7" style='border-radius: 8px;'>
		</p>
            <p>
			<label>Nam：<input type="radio" name="sex" value="1" checked></label>
            <label>Nữ：<input type="radio" name="sex" value="2"></label>
            </p>
			<label>Chiến sĩ：<input type="radio" name="shenfen" value="1" checked></label>
			<label>Hiệp sĩ：<input type="radio" name="shenfen" value="2"></label>
			<label>Ẩn sĩ：<input type="radio" name="shenfen" value="3"></label><br><br>
			$tishi
        <input type="submit" class="btn-login" style="background-color: #379082;" value="Sáng tạo">
    </form>
</div>
HTML;

echo $html;

?>




