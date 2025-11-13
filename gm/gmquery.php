<?php
error_reporting(0);
header("Content-type: text/html; charset=utf-8");
ini_set('date.timezone','Asia/Shanghai');
if($_POST){
	include 'config.php';
	$gmcode=trim($_POST['checknum']);
	if($gmcode!='www.aae.ink'){
		$return=array(
			'errcode'=>1,
			'info'=>'后台密码错误',
		);
		exit(json_encode($return));
	}
	$quid=trim($_POST['qu']);
	if($quid==''){
		$return=array(
			'errcode'=>1,
			'info'=>'区号错误',
		);
		exit(json_encode($return));
	}
	$qu=$quarr[$quid];
	if(!$qu['ip']){
		$return=array(
			'errcode'=>1,
			'info'=>'区配置不存在',
		);
		exit(json_encode($return));
	}
	$uid=trim($_POST['uid']);
	if($uid==''){
		$return=array(
			'errcode'=>1,
			'info'=>'角色ID错误',
		);
		exit(json_encode($return));
	}
	$srvid=$qu['srvid'];
	$act=$_POST['type'];
	switch($act){
		case 'charge':
			$num=intval($_POST['num']);
			if(!$num){
				$return=array(
					'errcode'=>1,
					'info'=>'充值数量错误',
				);
				exit(json_encode($return));
			}
            $conn = mysqli_connect($qu['ip'],$qu['user'],$qu['pswd']);
            #判断是否连接成功
            if(!$conn){
				$return=array(
					'errcode'=>1,
					'info'=>'数据库连接失败！',
				);
				exit(json_encode($return));
            }
            //选择数据库
            mysqli_select_db($conn,$qu['db']);
            //准备sql语句
			$sql="SELECT * FROM game1 WHERE uname = '{$uid}'";
			
            $obj = mysqli_query($conn,$sql);
            $row = mysqli_fetch_assoc($obj);
            if(count($row)==0){
			mysqli_close($conn);
				$return=array(
					'errcode'=>0,
					'info'=>'账号不存在！',
				);
				exit(json_encode($return));
            }else{
			    $sql="update game1 set uyxb=uyxb+'{$num}' where uname='{$uid}'";
			
            $obj = mysqli_query($conn,$sql);
			mysqli_close($conn);
			}
				$return=array(
					'errcode'=>0,
					'info'=>'充值成功！',
				);
				exit(json_encode($return));
			break;
		case 'charge1':
			$num=intval($_POST['num']);
			if(!$num){
				$return=array(
					'errcode'=>1,
					'info'=>'充值数量错误',
				);
				exit(json_encode($return));
			}
            $conn = mysqli_connect($qu['ip'],$qu['user'],$qu['pswd']);
            #判断是否连接成功
            if(!$conn){
				$return=array(
					'errcode'=>1,
					'info'=>'数据库连接失败！',
				);
				exit(json_encode($return));
            }
            //选择数据库
            mysqli_select_db($conn,$qu['db']);
            //准备sql语句
			$sql="SELECT * FROM game1 WHERE uname = '{$uid}'";
			
            $obj = mysqli_query($conn,$sql);
            $row = mysqli_fetch_assoc($obj);
            if(count($row)==0){
			mysqli_close($conn);
				$return=array(
					'errcode'=>0,
					'info'=>'账号不存在！',
				);
				exit(json_encode($return));
            }else{
			    $sql="update game1 set uczb=uczb+'{$num}' where uname='{$uid}'";
			
            $obj = mysqli_query($conn,$sql);
			mysqli_close($conn);
			}
				$return=array(
					'errcode'=>0,
					'info'=>'充值成功！',
				);
				exit(json_encode($return));
			break;
		case 'charge2':
			$num=intval($_POST['num']);
			if(!$num){
				$return=array(
					'errcode'=>1,
					'info'=>'充值数量错误',
				);
				exit(json_encode($return));
			}
            $conn = mysqli_connect($qu['ip'],$qu['user'],$qu['pswd']);
            #判断是否连接成功
            if(!$conn){
				$return=array(
					'errcode'=>1,
					'info'=>'数据库连接失败！',
				);
				exit(json_encode($return));
            }
            //选择数据库
            mysqli_select_db($conn,$qu['db']);
            //准备sql语句
			$sql="SELECT * FROM game1 WHERE uname = '{$uid}'";
			
            $obj = mysqli_query($conn,$sql);
            $row = mysqli_fetch_assoc($obj);
            if(count($row)==0){
			mysqli_close($conn);
				$return=array(
					'errcode'=>0,
					'info'=>'账号不存在！',
				);
				exit(json_encode($return));
            }else{
			    $sql="update game1 set ulv=ulv+'{$num}' where uname='{$uid}'";
			
            $obj = mysqli_query($conn,$sql);
			mysqli_close($conn);
			}
				$return=array(
					'errcode'=>0,
					'info'=>'充值成功！',
				);
				exit(json_encode($return));
			break;
		case 'charge3':
			$num=intval($_POST['num']);
			if(!$num){
				$return=array(
					'errcode'=>1,
					'info'=>'充值数量错误',
				);
				exit(json_encode($return));
			}
            $conn = mysqli_connect($qu['ip'],$qu['user'],$qu['pswd']);
            #判断是否连接成功
            if(!$conn){
				$return=array(
					'errcode'=>1,
					'info'=>'数据库连接失败！',
				);
				exit(json_encode($return));
            }
            //选择数据库
            mysqli_select_db($conn,$qu['db']);
            //准备sql语句
			$sql="SELECT * FROM game1 WHERE uname = '{$uid}'";
			
            $obj = mysqli_query($conn,$sql);
            $row = mysqli_fetch_assoc($obj);
            if(count($row)==0){
			mysqli_close($conn);
				$return=array(
					'errcode'=>0,
					'info'=>'账号不存在！',
				);
				exit(json_encode($return));
            }else{
			    $sql="update game1 set uexp=uexp+'{$num}' where uname='{$uid}'";
			
            $obj = mysqli_query($conn,$sql);
			mysqli_close($conn);
			}
				$return=array(
					'errcode'=>0,
					'info'=>'充值成功！',
				);
				exit(json_encode($return));
			break;
		case 'charge4':
			$num=intval($_POST['num']);
			if(!$num){
				$return=array(
					'errcode'=>1,
					'info'=>'充值数量错误',
				);
				exit(json_encode($return));
			}
            $conn = mysqli_connect($qu['ip'],$qu['user'],$qu['pswd']);
            #判断是否连接成功
            if(!$conn){
				$return=array(
					'errcode'=>1,
					'info'=>'数据库连接失败！',
				);
				exit(json_encode($return));
            }
            //选择数据库
            mysqli_select_db($conn,$qu['db']);
            //准备sql语句
			$sql="SELECT * FROM game1 WHERE uname = '{$uid}'";
			
            $obj = mysqli_query($conn,$sql);
            $row = mysqli_fetch_assoc($obj);
            if(count($row)==0){
			mysqli_close($conn);
				$return=array(
					'errcode'=>0,
					'info'=>'账号不存在！',
				);
				exit(json_encode($return));
            }else{
			    $sql="update game1 set uhp=uhp+'{$num}' where uname='{$uid}'";
			
            $obj = mysqli_query($conn,$sql);
			mysqli_close($conn);
			}
				$return=array(
					'errcode'=>0,
					'info'=>'充值成功！',
				);
				exit(json_encode($return));
			break;
		case 'charge5':
			$num=intval($_POST['num']);
			if(!$num){
				$return=array(
					'errcode'=>1,
					'info'=>'充值数量错误',
				);
				exit(json_encode($return));
			}
            $conn = mysqli_connect($qu['ip'],$qu['user'],$qu['pswd']);
            #判断是否连接成功
            if(!$conn){
				$return=array(
					'errcode'=>1,
					'info'=>'数据库连接失败！',
				);
				exit(json_encode($return));
            }
            //选择数据库
            mysqli_select_db($conn,$qu['db']);
            //准备sql语句
			$sql="SELECT * FROM game1 WHERE uname = '{$uid}'";
			
            $obj = mysqli_query($conn,$sql);
            $row = mysqli_fetch_assoc($obj);
            if(count($row)==0){
			mysqli_close($conn);
				$return=array(
					'errcode'=>0,
					'info'=>'账号不存在！',
				);
				exit(json_encode($return));
            }else{
			    $sql="update game1 set umaxhp=umaxhp+'{$num}' where uname='{$uid}'";
			
            $obj = mysqli_query($conn,$sql);
			mysqli_close($conn);
			}
				$return=array(
					'errcode'=>0,
					'info'=>'充值成功！',
				);
				exit(json_encode($return));
			break;
		case 'charge6':
			$num=intval($_POST['num']);
			if(!$num){
				$return=array(
					'errcode'=>1,
					'info'=>'充值数量错误',
				);
				exit(json_encode($return));
			}
            $conn = mysqli_connect($qu['ip'],$qu['user'],$qu['pswd']);
            #判断是否连接成功
            if(!$conn){
				$return=array(
					'errcode'=>1,
					'info'=>'数据库连接失败！',
				);
				exit(json_encode($return));
            }
            //选择数据库
            mysqli_select_db($conn,$qu['db']);
            //准备sql语句
			$sql="SELECT * FROM game1 WHERE uname = '{$uid}'";
			
            $obj = mysqli_query($conn,$sql);
            $row = mysqli_fetch_assoc($obj);
            if(count($row)==0){
			mysqli_close($conn);
				$return=array(
					'errcode'=>0,
					'info'=>'账号不存在！',
				);
				exit(json_encode($return));
            }else{
			    $sql="update game1 set ugj=ugj+'{$num}' where uname='{$uid}'";
			
            $obj = mysqli_query($conn,$sql);
			mysqli_close($conn);
			}
				$return=array(//平价 源码网 www.p j y mw.com
					'errcode'=>0,
					'info'=>'充值成功！',
				);
				exit(json_encode($return));
			break;
		case 'charge7':
			$num=intval($_POST['num']);
			if(!$num){
				$return=array(
					'errcode'=>1,
					'info'=>'充值数量错误',
				);
				exit(json_encode($return));
			}
            $conn = mysqli_connect($qu['ip'],$qu['user'],$qu['pswd']);
            #判断是否连接成功
            if(!$conn){
				$return=array(
					'errcode'=>1,
					'info'=>'数据库连接失败！',
				);
				exit(json_encode($return));
            }
            //选择数据库
            mysqli_select_db($conn,$qu['db']);
            //准备sql语句
			$sql="SELECT * FROM game1 WHERE uname = '{$uid}'";
			
            $obj = mysqli_query($conn,$sql);
            $row = mysqli_fetch_assoc($obj);
            if(count($row)==0){
			mysqli_close($conn);
				$return=array(
					'errcode'=>0,
					'info'=>'账号不存在！',
				);
				exit(json_encode($return));
            }else{
			    $sql="update game1 set ufy=ufy+'{$num}' where uname='{$uid}'";
			
            $obj = mysqli_query($conn,$sql);
			mysqli_close($conn);
			}
				$return=array(
					'errcode'=>0,
					'info'=>'充值成功！',
				);
				exit(json_encode($return));
			break;
		default:
			$return=array(
				'errcode'=>1,
				'info'=>'数据错误',
			);
			exit(json_encode($return));
			break;
	}
}else{
	$return=array(
		'errcode'=>1,
		'info'=>'提交错误',
	);
	exit(json_encode($return));
}