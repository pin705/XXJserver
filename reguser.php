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
		// Cái khác trình duyệt
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
   popup({type:'success',msg:"Chuẩn bị nhảy chuyển",delay:2000,callBack:function(){
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
		// Cái khác trình duyệt
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
$a = '';
    if (isset($_POST[ 'submit']) && $_POST['submit'] ){
        $username = $_POST['username'];
        $userpass = $_POST['userpass'];
        $userpass2 = $_POST['userpass2'];
        $username = htmlspecialchars($username);
        $userpass = htmlspecialchars($userpass);
        $sql = "select * from userinfo where username=?";
        $stmt = $dblj->prepare($sql);
        $stmt->execute(array($username));
        $stmt->bindColumn('username',$cxusername);
        $ret = $stmt->fetch(PDO::FETCH_ASSOC);

        if($userpass2 != $userpass){
            $a = '<br>Hai lần điền mật mã vào không nhất trí<br><br>';
			$ts .= "".$tssb."";
        }elseif (strlen($username) < 6 or strlen($userpass)< 6){
            $a = '<br>Tài khoản hoặc mật mã chiều dài mời lớn hơn hoặc đợi tại 6 Vị<br><br>';
			$ts .= "".$tssb."";
        }elseif ($ret){
            $a = '<br>Đăng kí thất bại, tài khoản'.$cxusername.'Đã tồn tại<br><br>';
			$ts .= "".$tssb."";
        }else{
            $token = md5("$username.$userpass".strtotime(date('Y-m-d H:i:s')));
            $sql = "insert into userinfo(username,userpass,token) values('$username','$userpass','$token')";
            $cxjg = $dblj->exec($sql);
            $a = 'Đăng kí thành công<br>';
			$ts .= "".$tscg."";
            header("refresh:3;url=index.php");//Trì hoãn nhảy chuyển
        }
    }


    ?>
<html lang="en">
<head>
    <meta charset="utf-8" content="width=device-width,user-scalable=no" name="viewport">
    <title>Tự Ta Tu Tiên</title>
    <link rel="stylesheet" href="css/gamecss.css">
</head>
<body>
<div class="main">
<img src="images/11.jpg" width="280" height="200">
<div id="mainfont">
<p>Thiên hạ phong vân ra chúng ta, vừa vào giang hồ tuế nguyệt thúc</p>
<p>Hoàng Đồ bá nghiệp trong lúc nói cười, không thắng nhân sinh một cơn say</p>
<p>Rút kiếm cưỡi vung quỷ mưa, bạch cốt như sơn chim kinh bay</p>
<p>Chuyện đời như nước thủy triều người như nước, chỉ thán giang hồ mấy người trở về</p>
</div>

<div class="login">
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    Tài khoản:
    <input type="text" name="username" class="input" style="border: 1px solid #869e91;border-radius: 5px;border-radius: 5px;"><br/>
    Mật mã:
    <input type="password" name="userpass" class="input" style="border: 1px solid #869e91;border-radius: 5px;border-radius: 5px;"><br/>
    Mật mã:
    <input type="password" name="userpass2" class="input" style="border: 1px solid #869e91;border-radius: 5px;border-radius: 5px;"><br/>
    <?php echo $a?>
	<?php echo $ts?>
    <p><a href="index.php" id="btn" style="border: 1px solid #2d715f;borderradius: 5px;color: #2d715f;">Đăng nhập</a><input id="load" type="submit" name="submit" value="Đăng kí" class="btn-login" style="background-color: #2d715f;"></p>
</form>
</div>
</div>
</body><div class="footer">
<?php echo date('Y-m-d H:i:s') ?></div>
<div>
</html>

