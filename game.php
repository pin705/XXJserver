<?php
//error_reporting(0);
require_once 'bootstrap.php'; // Load tất cả classes và helpers
require_once 'class/player.php';
require_once 'class/encode.php';
include_once 'pdo.php';

header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");

$encode = new \encode\encode();
$player = new \player\player();
$guaiwu = new \player\guaiwu();
$clmid = new \player\clmid();
$npc = new \player\npc();

$ym = 'src/Game/BanDoHienTai.php';
$Dcmd = $_SERVER['QUERY_STRING'];
$pvpts ='';
$tpts = '';
session_start();
$allow_sep = "220";
function getMillisecond() {
    list($t1, $t2) = explode(' ', microtime());
    return (float)sprintf('%.0f',(floatval($t1) + floatval($t2)) * 1000);
}
if (isset($_SESSION["post_sep"]))
{

    if (getMillisecond() - $_SESSION["post_sep"] < $allow_sep)
    {

        $msg = '<meta charset="utf-8" content="width=device-width,user-scalable=no" name="viewport">Ngươi điểm kích quá nhanh^_^!<br/><a href="?'.$Dcmd.'">Tiếp tục</a>';
        exit($msg);
    }
    else
    {
        $_SESSION["post_sep"] = getMillisecond();
    }
}
else
{
    $_SESSION["post_sep"] = getMillisecond();
}

parse_str($Dcmd, $parsedParams);
extract($parsedParams);
if (isset($cmd)){

    if ($cmd == 'create_player'){
        $Dcmd = $encode->encode($Dcmd);
        header("refresh:1;url=?cmd=$Dcmd");
        exit();
    }
    if ($cmd == 'item_info'){
        $Dcmd = $encode->encode($Dcmd);
        header("refresh:1;url=?cmd=$Dcmd");
        exit();
    }
    if ($cmd == 'equipment_info'){
        $Dcmd = $encode->encode($Dcmd);
        header("refresh:1;url=?cmd=$Dcmd");
        exit();
    }
    if ($cmd == 'npc'){
        $Dcmd = $encode->encode($Dcmd);
        header("refresh:1;url=?cmd=$Dcmd");
        exit();
    }
    if ($cmd == 'exchange'){
        $Dcmd = $encode->encode($Dcmd);
        header("refresh:1;url=?cmd=$Dcmd");
        exit();
    }
	if ($cmd == 'shop'){
        $Dcmd = $encode->encode($Dcmd);
        header("refresh:1;url=?cmd=$Dcmd");
        exit();
    }
    if ($cmd == 'send_chat'){
        $Dcmd = $encode->encode($Dcmd);
        header("refresh:1;url=?cmd=$Dcmd");
        exit();
    }
    $Dcmd = $encode->decode($cmd);
//    var_dump($Dcmd);
    parse_str($Dcmd, $parsedParams);
    extract($parsedParams);
    switch ($cmd){
        case 'create_character':
            $ym = 'src/Game/TaoNhanVat.php';
            break;
        case 'login';
            $player = \player\getplayer($sid,$dblj);
            $gonowmid = $encode->encode("cmd=goto_map&newmid=$player->nowmid&sid=$sid");
            $nowdate = date('Y-m-d H:i:s');
            $sql = "update game1 set endtime='$nowdate',sfzx=1 WHERE sid='$sid'";
            $cxjg = $dblj->exec($sql);
            header("refresh:1;url=?cmd=$gonowmid");
            exit();
            break;
        case 'character_status';
            $ym = 'src/Game/TrangThaiNhanVat.php';
            break;
        case 'create_player':

            if (isset($token) && isset($username) && isset($sex)){
				
				// Kiểm tra và set giá trị mặc định cho shenfen
				if (!isset($shenfen)) {
					$shenfen = 1; // Giá trị mặc định là Chiến sĩ
				}
				
				//Phán đoán danh tự lặp lại
				 $sql = "select * from game1 where uname=?";
                 $stmt = $dblj->prepare($sql);
                 $stmt->execute(array($username));
                 $stmt->bindColumn('uname',$cxusername);
                 $ret = $stmt->fetch(PDO::FETCH_BOUND);
				 
				 if($ret){
                  $tishi = 'Người chơi:【'.$cxusername.'】Đã tồn tại<br><br>';
				  $ym = 'src/Game/TaoNhanVat.php';
				  break;
				 }
				//Phán đoán danh tự dài ngắn
                if(strlen($username)<6 || strlen($username)>12){
                    //echo "Người sử dụng tên không thể quá ngắn hoặc là quá dài";
					$tishi = "Người sử dụng tên không thể quá ngắn hoặc là quá dài<br><br>";
                    $ym = 'src/Game/TaoNhanVat.php';
                    break;
                }
                $username = htmlspecialchars($username);
                $sid = md5($username.$token.'229');//Ban đầu điểm phục sinh, phi thường trọng yếu, nhất định phải thiết trí đối
                
                // Debug: Log generated SID
                error_log("Generated SID: $sid for username: $username, token: $token");
                
                $sql="select * from game1 where token='$token'";
                $cxjg = $dblj->query($sql);
                $existingSid = '';
                $cxjg->bindColumn('sid',$existingSid);
                $ret = $cxjg->fetch(PDO::FETCH_BOUND);
                
                // Debug: Check if player exists
                error_log("Existing player check - existingSid: " . ($existingSid ? $existingSid : 'EMPTY') . ", ret: " . ($ret ? 'true' : 'false'));
                
                $nowdate = date('Y-m-d H:i:s');
                
                // Kiểm tra nếu đã có nhân vật với token này
                if ($ret && $existingSid != '') {
                    // Người chơi đã có nhân vật, chuyển đến trang game
                    error_log("Player already exists with SID: $existingSid");
                    $player = \player\getplayer($existingSid,$dblj);
                    $gonowmid = $encode->encode("cmd=goto_map&newmid=$player->nowmid&sid=$existingSid");
                    header("refresh:1;url=?cmd=$gonowmid");
                    exit();
                }
                
                // Tạo nhân vật mới
                if ($existingSid ==''){
                    $gameconfig = \player\getgameconfig($dblj);
                    $firstmid = $gameconfig->firstmid;
                    
                    // Debug log
                    error_log("Creating new character - SID: $sid, Username: $username, Token: $token");
                    
                    // Kiểm tra xem cột shenfen có tồn tại không
                    try {
                        $sql = "insert into game1(token,sid,uname,ulv,uyxb,uczb,uexp,uhp,umaxhp,ugj,ufy,uwx,usex,vip,nowmid,endtime,sfzx,shenfen,nowguaiwu) values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
                        $stmt = $dblj->prepare($sql);
                        $result = $stmt->execute(array($token,$sid,$username,'1','2000','100','0','35','35','12','5','0',$sex,'0',$firstmid,$nowdate,'1',$shenfen,'0'));
                        
                        if (!$result) {
                            $errorInfo = $stmt->errorInfo();
                            error_log("INSERT FAILED with shenfen: " . print_r($errorInfo, true));
                            
                            // Hiển thị lỗi chi tiết
                            echo '<meta charset="utf-8">';
                            echo "<h3>Lỗi tạo nhân vật (với shenfen):</h3>";
                            echo "<p>SQLSTATE: {$errorInfo[0]}</p>";
                            echo "<p>Error Code: {$errorInfo[1]}</p>";
                            echo "<p>Error Message: {$errorInfo[2]}</p>";
                            echo "<hr>";
                            echo "<p>Đang thử tạo lại không có cột shenfen...</p>";
                            
                            // Thử không có shenfen
                            throw new PDOException("Force fallback to without shenfen");
                        }
                        error_log("Character created successfully with shenfen column");
                    } catch (PDOException $e) {
                        error_log("Failed to insert with shenfen, trying without: " . $e->getMessage());
                        // Nếu cột shenfen không tồn tại, insert không có cột này
                        $sql = "insert into game1(token,sid,uname,ulv,uyxb,uczb,uexp,uhp,umaxhp,ugj,ufy,uwx,usex,vip,nowmid,endtime,sfzx,nowguaiwu) values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
                        $stmt = $dblj->prepare($sql);
                        $result = $stmt->execute(array($token,$sid,$username,'1','2000','100','0','35','35','12','5','0',$sex,'0',$firstmid,$nowdate,'1','0'));
                        
                        if (!$result) {
                            $errorInfo = $stmt->errorInfo();
                            error_log("INSERT FAILED without shenfen: " . print_r($errorInfo, true));
                            
                            // Hiển thị lỗi chi tiết cho user
                            echo '<meta charset="utf-8">';
                            echo "<h2>❌ Lỗi: Không thể tạo nhân vật!</h2>";
                            echo "<h3>Chi tiết lỗi:</h3>";
                            echo "<p><strong>SQLSTATE:</strong> {$errorInfo[0]}</p>";
                            echo "<p><strong>Error Code:</strong> {$errorInfo[1]}</p>";
                            echo "<p><strong>Error Message:</strong> {$errorInfo[2]}</p>";
                            echo "<hr>";
                            echo "<h3>Thông tin debug:</h3>";
                            echo "<p>Username: $username</p>";
                            echo "<p>SID: $sid</p>";
                            echo "<p>Token: " . substr($token, 0, 10) . "...</p>";
                            echo "<p>Sex: $sex</p>";
                            echo "<hr>";
                            echo "<p><a href='src/Game/TaoNhanVat.php'>← Quay lại tạo nhân vật</a></p>";
                            exit();
                        }
                        error_log("Character created successfully without shenfen column");
                    } catch (Exception $e) {
                        // Catch any other exception
                        error_log("Unexpected error: " . $e->getMessage());
                        echo '<meta charset="utf-8">';
                        echo "<h2>Lỗi hệ thống:</h2>";
                        echo "<p>" . $e->getMessage() . "</p>";
                        echo "<p><a href='src/Game/TaoNhanVat.php'>← Quay lại</a></p>";
                        exit();
                    }
//Tiến vào tham số thiết trí
                    $gonowmid = $encode->encode("cmd=goto_map&newmid=$gameconfig->firstmid&sid=$sid");
                    echo '<meta charset="utf-8" content="width=device-width,user-scalable=no" name="viewport">';
					
                    echo $username."<font color=#8EBE67>Hoan</font><font color=#9FB85B>Nghênh</font><font color=#B0B24F>Đến</font><font color=#C1AC43>Đến</font><font color=#D2A637>Tìm</font><font color=#E3A02B>Tiên</font><font color=#F49A1F>Kỷ, now loading……</font>";
					
                    $sql = "insert into ggliaotian(name,msg,uid) values(?,?,?)";
                    $stmt = $dblj->prepare($sql);
                    $stmt->execute(array('【Hệ thống】',"Vạn người không được một{$username}Bước lên tiên đồ",'0'));//Hệ thống thông cáo
					
                    header("refresh:2;url=?cmd=$gonowmid");//Trì hoãn thời gian
                    exit();
                }
                
                // Nếu code chạy đến đây nghĩa là có vấn đề
                error_log("ERROR: Character creation logic issue - existingSid: $existingSid");
                die("Lỗi hệ thống! Vui lòng liên hệ admin.");
            }
            break;
        case 'goto_map':
            $ym = 'src/Game/BanDoHienTai.php';
            break;
        case 'get_game_info':
            $ym = 'src/Game/ThongTinTroChoi.php';
            break;
        case 'pve':
            $ym = 'src/Game/ChienDauQuaiVat.php';
            break;
        case 'pvp':
            $ym = 'src/Game/ChienDauNguoiChoi.php';
            break;
        case 'pve_attack':
            $ym = 'src/Game/ChienDauQuaiVat.php';
            break;
		case 'boss_attack':
            $ym = 'src/Game/ChienDauTruongLao.php';
            break;
        case 'send_chat':
            if (isset($ltlx) && isset($ltmsg)){
                switch ($ltlx){
                    case 'all':
                        $player = player\getplayer($sid,$dblj);
                        if ($player->uname!=''){
                            $ltmsg = htmlspecialchars($ltmsg);
                            $sql = "insert into ggliaotian(name,msg,uid) values(?,?,?)";
                            $stmt = $dblj->prepare($sql);
                            $exeres = $stmt->execute(array($player->uname,$ltmsg,$player->uid));
                        }
                        $ym = 'src/Game/TroChuyen.php';
                        break;
                    case "im":
                        $player = player\getplayer($sid,$dblj);
                        if ($player->uname!=''){
                            $ltmsg = htmlspecialchars($ltmsg);
                            $sql = "insert into imliaotian(name,msg,uid,imuid) values('$player->uname','$ltmsg',$player->uid,{$imuid})";

                            $cxjg = $dblj->exec($sql);
                            
                        }
                        $ym = 'src/Game/TroChuyen.php';
                        break;
                }
            }
            break;
        case 'chat':
            $ym ='src/Game/TroChuyen.php';
            break;
        case 'get_player_info':
            $ym ='src/Game/TrangThaiNguoiKhac.php';
            break;
        case 'equipment_info':
            $ym = 'src/Game/ThongTinTrangBi.php';
            break;
        case 'npc':
            $ym = "npc/npc.php";
            break;
        case 'ranking';
            $ym = 'src/Game/BangXepHang.php';
            break;
        case 'view_equipment':
            $ym = 'src/Game/ThongTinTrangBi.php';
            break;
        case 'item_info':
            $ym = 'src/Game/ThongTinDaoCu.php';
            break;
        case 'get_equipment_bag':
            $ym = 'src/Game/TuiTrangBi.php';
            break;
        case 'get_pill_bag':
            $ym = 'src/Game/TuiDan.php';
            break;
        case 'get_medicine_bag':
            $ym = 'src/Game/TuiDuocPham.php';
            break;
		
		case 'get_skill_bag':
            $ym = 'src/Game/TuiKyNang.php';
            break;
        case 'unequip':
            $ym = 'src/Game/TrangThaiNhanVat.php';
            break;
        case 'set_equipment_position':
            $ym = 'src/Game/TrangThaiNhanVat.php';
            break;
        case 'all_maps':
            $ym = 'src/Game/TatCaBanDo.php';
            break;
        case 'delete_equipment':
            $ym = 'src/Game/TuiTrangBi.php';
            break;
        case 'get_item_bag':
            $ym = 'src/Game/TuiDaoCu.php';
            break;
        case 'upgrade_equipment':
            $ym = 'src/Game/ThongTinTrangBi.php';
            break;
        case 'goto_cultivation':
            $ym = 'src/Game/TuLuyen.php';
            break;
		case 'martial_arts_training':
            $ym = 'src/Game/VoKong.php';
            break;
		case 'martial_training':
            $ym = 'src/Game/VoKong.php';
            break;
		case 'flee':
            $ym = 'src/Game/ChienDauTruongLao.php';
            break;
		case 'end_martial_training':
            $ym = 'src/Game/VoKong.php';
            break;
		case 'learn_martial_arts':
            $ym = 'src/Game/HocVoKong.php';
            break;
        case 'start_cultivation':
            $ym = 'src/Game/TuLuyen.php';
            break;
        case 'end_cultivation':
            $ym = 'src/Game/TuLuyen.php';
            break;
        case 'quest':
            $ym = 'src/Game/NhiemVu.php';
            break;
        case 'my_quests':
            $ym = 'src/Game/NhiemVuNguoiChoi.php';
            break;
        case 'quest_info':
            $ym = 'src/Game/ThongTinNhiemVu.php';
            break;
        case 'boss_info':
            $ym = 'src/Game/ThongTinTruongLao.php';
            break;
        case 'pill_info':
            $ym = 'src/Game/ThongTinThuoc.php';
            break;
		case 'medicine_info':
            $ym = 'src/Game/ThongTinDuocPham.php';
            break;
        case 'boss_battle':
            $ym = 'src/Game/ChienDauTruongLao.php';
            break;
        case 'pet':
            $ym = 'src/Game/SungVat.php';
            break;
        case 'skill_info':
            $ym = 'src/Game/ThongTinKyNang.php';
            break;
        case "system_equipment_info":
            $ym = 'src/Game/ThongTinTrangBiHeThong.php';
            break;
        case "breakthrough":
            $ym = 'src/Game/DotPha.php';
            break;
        case "arena":
            $ym = "src/Game/PhongThi.php";
            break;
        case "guild":
            $ym = "src/Game/BangHoi.php";
            break;
        case "guild_list":
            $ym = "src/Game/DanhSachBangHoi.php";
            break;
        case "exchange":
            $ym = "src/Game/DoiThuong.php";
            break;
        case "private_message":
            $ym = "src/Game/TinNhanRieng.php";
            break;
		case "shop":
            $ym = "src/Game/CuaHang.php";
            break;
		case "area_map":
            $ym = "src/Game/KhuVucBanDo.php";
			break;
		case "map":
            $ym = "dt/ditu.html";
			break;
		case "change_name":
            $ym = "npc/muban/gaiming.php";
			break;
		case "recharge_gm":
            $ym = "npc/muban/czbgm.php";
			break;
		case "talent":
            $ym = "src/Game/ThienPhu.php";
			break;
		case "equipment_set":
            $ym = "src/Game/BoTrangBi.php";
			break;
    }
    if (!isset($sid) || $sid=='' ){

        if ($cmd!='create_character' && $cmd!=='create_player'){
            header("refresh:1;url=index.php");
            exit();
        }
		 
         
		
    }else{
		 

         if ($cmd != 'pve' && $cmd!='pve_attack'){//Mở ra pve Logic, tăng thêm phán đoán thử nhìn một chút
		 
		     // $guaiwu = player\getguaiwu($gid,$dblj);
		     // $gwhp = $guaiwu->ghp ;
		     // if ( $gwhp <= 0 ){
             $sql = "delete from midguaiwu where sid='$sid'";//Xóa bỏ địa đồ nên người chơi đã bị công kích quái vật, nơi này hẳn là tại thêm cái phán đoán, không phải trực tiếp tiếp xúc liền xóa, không ok
             $dblj->exec($sql);//Quan bế kho số liệu
		    }
			
		if ($cmd != 'boss_battle' && $cmd!='boss_attack'){
			$sql = "delete from boss where sid='$sid'";
		    $dblj->exec($sql);}
		
		
        $player = \player\getplayer($sid,$dblj);
        if ($player->ispvp!=0){
            $pvper = \player\getplayer1($player->ispvp,$dblj);
            $pvpcmd = $encode->encode("cmd=pvp&uid=$pvper->uid&sid=$sid");
            $pvpcmd = "<a href='?cmd=$pvpcmd'>Đánh trả</a>";
            $pvpts = "$pvper->uname Công kích ngươi：$pvpcmd<br/>";
        }//8 Mở ra 8 Cái giai đoạn phát động đột phá
        if (\player\istupo($sid,$dblj) !=8 && $player->uexp >= $player->umaxexp){
            $tupocmd = $encode->encode("cmd=breakthrough&sid=$sid");//Phán đoán phát động
            $tupocmd = "<a href='?cmd=$tupocmd'><font color='#FF0000'>Đột phá</font></a>";
            $tpts =  "<strong style='background:#FFC100'><font color='#000000'>Đạt tu vi tối đa, cần Đột Phá nếu không sẽ không nhận thêm Kinh Nghiệm:$tupocmd<hr></font></strong>";
        }
        $nowdate = date('Y-m-d H:i:s');
        $second=floor((strtotime($nowdate)-strtotime($player->endtime))%1000);//Thu hoạch đổi mới khoảng cách
        if ($second>=900){
            echo '<meta charset="utf-8" content="width=device-width,user-scalable=no" name="viewport">';
            echo $player->uname."Offline quá lâu, mời Đăng Nhập lại";
            header("refresh:1;url=index.php");
            exit();
        }else{
            $sql = "update game1 set endtime='$nowdate',sfzx=1 WHERE sid='$sid'";
            $dblj->exec($sql);
        }
    }
}else{
    header("refresh:1;url=index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" content="width=device-width,user-scalable=no" name="viewport">
    <title>Tìm tiên ký</title>
    <link rel="stylesheet" href="css/gamecss.css">
</head>
<body>
<div class="main">
<?php
    if (!$ym==''){
        echo$tpts;
        if ($ym!="src/Game/ChienDauNguoiChoi.php"){
            echo $pvpts;
        }
        include "$ym";
    }?>
</div>
</body>

<!-- <script>//F12 Cấm dùng
    // debug Điều chỉnh thử lúc nhảy chuyển giao diện,F12 Bị cấm dùng, phối hợp xuống mặt
    // var element = new Image();
    // Object.defineProperty(element,'id',{get:function(){window.location.href="index.php"}});
    // console.log(element);
// </script>
 <script>//F12 Bị cấm dùng, phối hợp
      // setInterval(function() {
        // check();
      // }, 2000);
      // var check = function() {
        // function doCheck(a) {
          // if (('' + a / a)['length'] !== 1 || a % 20 === 0) {
            // (function() {}['constructor']('debugger')());
          // } else {
            // (function() {}['constructor']('debugger')());
          // }
          // doCheck(++a);
        // }
        // try {
          // doCheck(0);
        // } catch (err) {}
      // };
      // check();
	  	// document.onkeydown = function(){
    // if(window.event && window.event.keyCode == 123) {
        // alert("Dạng này liền không có ý nghĩa!");
        // event.keyCode=0;
        // event.returnValue=false;
    // }
    // if(window.event && window.event.keyCode == 13) {
        // window.event.keyCode = 505;
    // }
    // if(window.event && window.event.keyCode == 8) {
        // alert(str+"\nMời sử dụng Del Khóa tiến hành ký tự xóa bỏ thao tác！");
        // window.event.returnValue=false;
    // }
// }
  // </script>-->



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