<?php
$tscg = <<<HTML
             <link rel="stylesheet" type="text/css" href="./chajian/tishikuang/style/dialog.css">
		     <script src="./chajian/tishikuang/javascript/zepto.min.js"></script>
             <script type="text/javascript" src="./chajian/tishikuang/javascript/dialog.min.js"></script>
<body>
<font id="success"></font>
<script type="text/javascript">
	setTimeout(function() {
		// IE
		if(document.all) {
			document.getElementById("success").click();
		}
		// Trình duyệt
		else {
			var e = document.createEvent("MouseEvents");
			e.initEvent("click", true, true);
			document.getElementById("success").dispatchEvent(e);
		}
	}, 500);
</script>
<script src="./chajian/tishikuang/javascript/zepto.min.js"></script>
<script type="text/javascript" src="./chajian/tishikuang/javascript/dialog.min.js"></script>
<script type="text/javascript">	   
$('#success').click(function(){
   popup({type:'success',msg:"3 Giây sau nhảy chuyển",delay:2000,callBack:function(){
	  console.log('callBack~~~');
   }});
})
$('#error').click(function(){
   popup({type:'error',msg:"Thao tác thất bại",delay:2000,bg:true,clickDomCancel:true});
})
$('#tip').click(function(){
   popup({type:'tip',msg:"Nhắc nhở tin tức",delay:3000,bg:true,clickDomCancel:true});
})
</script>
</body>

HTML;
$tssb = <<<HTML
<link rel="stylesheet" type="text/css" href="./chajian/tishikuang/style/dialog.css">
		    <script src="./chajian/tishikuang/javascript/zepto.min.js"></script>
             <script type="text/javascript" src="./chajian/tishikuang/javascript/dialog.min.js"></script>
<body>
    <font id="error"></font>
<script type="text/javascript">
	setTimeout(function() {
		// IE
		if(document.all) {
			document.getElementById("error").click();
		}
		// Cái khác
		else {
			var e = document.createEvent("MouseEvents");
			e.initEvent("click", true, true);
			document.getElementById("error").dispatchEvent(e);
		}
	}, 500);
</script>
<script src="./chajian/tishikuang/javascript/zepto.min.js"></script>
<script type="text/javascript" src="./chajian/tishikuang/javascript/dialog.min.js"></script>
<script type="text/javascript">	   
$('#error').click(function(){
   popup({type:'error',msg:"Thất bại",delay:2000,bg:true,clickDomCancel:true});
})
</script>
</body>
HTML;

include 'pdo.php';
require_once 'class/encode.php';
//header('Access-Control-Allow-Origin:*');
$encode = new \encode\encode();
$a = '';
if (isset($_POST[ 'submit']) && $_POST['submit']){

    $username = $_POST['username'];
    $userpass = $_POST['userpass'];
    $username = htmlspecialchars($username);
    $userpass = htmlspecialchars($userpass);
    $sql = "select * from userinfo where username = ? and userpass = ?";
    $stmt = $dblj->prepare($sql);
    $bool = $stmt->execute(array($username,$userpass));
    $stmt->bindColumn('username',$cxusername);
    $stmt->bindColumn('userpass',$cxuserpass);
    $stmt->bindColumn('token',$cxtoken);
    $exeres = $stmt->fetch(PDO::FETCH_BOUND);

    if ((strlen($username) < 6 || strlen($userpass) < 6) && !$exeres){
        $a = 'Tài khoản hoặc mật mã sai lầm';
		$ts .= "".$tssb."";
    }elseif ($cxusername == $username && $cxuserpass == $userpass){

        $sql = "select * from game1 where token='$cxtoken'";
        $cxjg = $dblj->query($sql);
        $cxjg->bindColumn('sid',$sid);
        $cxjg->fetch(PDO::FETCH_BOUND);
        if ($sid==null){
            $cmd = "cmd=create_character&token=$cxtoken";
        }else{
            $cmd = "cmd=login&sid=$sid";
            $nowdate = date('Y-m-d H:i:s');

            $sql = "update game1 set endtime = '$nowdate',sfzx=1 WHERE sid=?";
            $stmt = $dblj->prepare($sql);
            $stmt->execute(array($sid));
        }
        $cmd = $encode->encode($cmd);
        header("refresh:1;url=game.php?cmd=$cmd");//Trì hoãn nhảy chuyển 1 Giây
    }

}
?>
<html lang="en">

<head>

    <meta charset="utf-8" content="width=device-width,user-scalable=no" name="viewport" />
    <title>Tự Ta Tu Tiên</title>
    <link rel="stylesheet" href="css/gamecss.css">

</head>


<body>
<div class="main">
<img src="images/11.jpg" width="280" height="200"><br/>
<div id="mainfont">
Nguyệt lạnh Thiên Sơn sông từ bích, băng sườn núi vạn trượng không lưu ý。<br/>
Tìm đạo độc ảnh hoa sen rơi, Trúc Âm thưa thớt nghe mới khúc。<br/>
Tiên nhân nghe ai say minh nguyệt, lướt sóng đạp gió theo yến đi。<br/>
Kỷ cương nhân luân tâm như tang, một say hồng trần tiêu trăm tự。<br/>
Ma trước chụp thủ ba ngàn năm, quay đầu hồng trần không làm tiên。<br/>
</div>
<div class="login">
<form action=<?php echo $_SERVER['PHP_SELF']; ?> method="post">
    
    <input type="text" name="username" placeholder="Số tài khoản" class="input" style="border: 1px solid #869e91;border-radius: 5px;"><br/>

    <input type="password" name="userpass" placeholder="Mật mã" class="input" style="border: 1px solid #869e91;border-radius: 5px;"><br/>
    <?php echo $a ?>
	<?php echo $ts ?>
    <p><input type="submit" name="submit" class="btn-login" value="Đăng nhập" style="background: #2d715f;"> <a href="reguser.php" id="btn" style="border: 1px solid #2d715f;border-radius: 5px;color: #2d715f;">Đăng kí</a></p>
</form>
</div>
<div class="fix" align="center">
	<h2>Cập nhật:【Bí tịch võ công】</h2>
	<p>Mới nhất:【Sáo trang】【Phó bản】<p>
	<p>Sáo trang：Gia tăng thuộc tính。Phó bản：Độc lập boss</p>
	<p>1.Gia tăng bí tịch võ công học tập, bí tịch thu hoạch phương thức giữ bí mật。</p>
	<p>2.30 Cấp mở ra thiên phú bồi dưỡng, gia nhập né tránh, may mắn vân vân thuộc tính</p>
	<p>3.Hoạt động hối đoái mã：vip666888</p>
	<h2>Fix bug:</h2>
	<p>1.Võ công tiêu hao cùng điệp gia vấn đề</p>
	<p>2.boss Trưởng thành vấn đề</p>
</div>
</div>
</body>

<div class="footer">
<footer>
	<script type="text/javascript" src="js/jquery-1.6.2.min.js"></script>
	
    <script>
	function changetime(){
	var ary = Array("Chủ Nhật","Thứ hai","Thứ ba","Thứ tư","Thứ năm","Thứ sáu","Thứ bảy");
	var Timehtml = document.getElementById('CurrentTime');
	var date = new Date();
	Timehtml.innerHTML = ''+date.toLocaleString()+' '+ary[date.getDay()];
	}
	window.onload = function(){
	changetime();
	setInterval(changetime,1000);
	}
	</script>

	<div id="CurrentTime"><?php echo date('Y-m-d H:i:s') ?></div>
</footer>
</div>

</html>