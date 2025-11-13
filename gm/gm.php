<?php
error_reporting(0);
header("Content-type: text/html; charset=utf-8"); 
?>
<html>
<head>
<title>寻仙记后台工具</title>
<style>
  *{padding:0;margin:0}
  body{padding-left:20px;padding-top:20px}
  span{height;24px;line-height:24px;font-size:12px;min-width:100px;display:inline-block;text-align:justify;text-align-last:justify;margin-bottom:12px}
  select,input,button{height:24px;line-height:24px;font-size:12px;width:150px;display:inline-block}
  #maildesc{text-align:none;color:#ff0000;}
</style>
</head>
<body>
<div>
  <!--[if IE]>
  <div><font color='red'>本工具不支持IE,请更换其他浏览器 悟空源码网www.wkymw.com</font></div>
  <![endif]-->
  <div><span>后台校验码: </span><input type='password' value='' id='checknum'></div>
  <div><span>选区: </span><select id='qu'><option value='1'>寻仙一区</option></select></div>
  <div><span>游戏昵称: </span><input type='text' value='' id='uid' placeholder='请输入游戏名字/非账号'>
  <div><span>充值灵石: </span><input type="text" class="form-control" value='' id="chargenum" ><input type='button' value='充值' id='chargebtn'></div> 
  <div><span>充值极品灵石: </span><input type="text" class="form-control" value='' id="chargenum1" ><input type='button' value='充值' id='chargebtn1'></div> 
  <div><span>设置等级: </span><input type="text" class="form-control" value='' id="chargenum2" ><input type='button' value='设置' id='chargebtn2'></div> 
  <div><span>设置经验: </span><input type="text" class="form-control" value='' id="chargenum3" ><input type='button' value='设置' id='chargebtn3'></div> 
  <div><span>设置血量: </span><input type="text" class="form-control" value='' id="chargenum4" ><input type='button' value='设置' id='chargebtn4'></div> 
  <div><span>设置最大血量: </span><input type="text" class="form-control" value='' id="chargenum5" ><input type='button' value='设置' id='chargebtn5'></div> 
  <div><span>设置攻击: </span><input type="text" class="form-control" value='' id="chargenum6" ><input type='button' value='设置' id='chargebtn6'></div> 
  <div><span>设置防御: </span><input type="text" class="form-control" value='' id="chargenum7" ><input type='button' value='设置' id='chargebtn7'></div> 
 <hr/><br>
</div>
<script src='jquery-1.7.2.min.js'></script>
<script>
  var checknum='';
  var uid='';
  var qu=$('#qu').val();
  $('#checknum').change(function(){
	  checknum=$(this).val();
  });
  $('#uid').change(function(){
	  uid=$.trim($(this).val());
  });
  $('#qu').change(function(){
	  qu=$.trim($(this).val());
  });
  $('#addvipbtn').click(function(){
	  if(checknum==''){
		  alert('请输入后台校验码。');
		  return false;
	  }
	  if(uid==''){
		  alert('角色名不能为空。');
		  return false;
	  }
	  $.ajax({
		  url:'gmquery.php',
		  type:'post',
		  'data':{type:'addvip',checknum:checknum,uid:uid,qu:qu},
          'cache':false,
          'dataType':'json',
		  success:function(data){
			  console.log('data',data);
			  alert(data.info);
		  },
		  error:function(){
			  alert('操作失败');
		  }
	  });
  });
  $('#zhfhbtn').click(function(){
	  if(checknum==''){
		  alert('请输入后台校验码。');
		  return false;
	  }
	  if(uid==''){
		  alert('账号不能为空。');
		  return false;
	  }
	  $.ajax({
		  url:'gmquery.php',
		  type:'post',
		  'data':{type:'zhfh',checknum:checknum,uid:uid,qu:qu},
          'cache':false,
          'dataType':'json',
		  success:function(data){
			  console.log('data',data);
			  alert(data.info);
		  },
		  error:function(){
			  alert('操作失败');
		  }
	  });
  });
  $('#fhbtn').click(function(){
	  if(checknum==''){
		  alert('请输入后台校验码。');
		  return false;
	  }
	  if(uid==''){
		  alert('角色名不能为空。');
		  return false;
	  }
	  $.ajax({
		  url:'gmquery.php',
		  type:'post',
		  'data':{type:'fh',checknum:checknum,uid:uid,qu:qu},
          'cache':false,
          'dataType':'json',
		  success:function(data){
			  console.log('data',data);
			  alert(data.info);
		  },
		  error:function(){
			  alert('操作失败');
		  }
	  });
  });
  $('#zhjfbtn').click(function(){
	  if(checknum==''){
		  alert('请输入后台校验码。');
		  return false;
	  }
	  if(uid==''){
		  alert('角色名不能为空。');
		  return false;
	  }
	  $.ajax({
		  url:'gmquery.php',
		  type:'post',
		  'data':{type:'zhjf',checknum:checknum,uid:uid,qu:qu},
          'cache':false,
          'dataType':'json',
		  success:function(data){
			  console.log('data',data);
			  alert(data.info);
		  },
		  error:function(){
			  alert('操作失败');
		  }
	  });
  });
  $('#jfbtn').click(function(){
	  if(checknum==''){
		  alert('请输入后台校验码。');
		  return false;
	  }
	  if(uid==''){
		  alert('角色名不能为空。');
		  return false;
	  }
	  $.ajax({
		  url:'gmquery.php',
		  type:'post',
		  'data':{type:'jf',checknum:checknum,uid:uid,qu:qu},
          'cache':false,
          'dataType':'json',
		  success:function(data){
			  console.log('data',data);
			  alert(data.info);
		  },
		  error:function(){
			  alert('操作失败');
		  }
	  });
  });
  $('#jybtn').click(function(){
	  if(checknum==''){
		  alert('请输入后台校验码。');
		  return false;
	  }
	  if(uid==''){
		  alert('角色名不能为空。');
		  return false;
	  }
	  $.ajax({
		  url:'gmquery.php',
		  type:'post',
		  'data':{type:'jy',checknum:checknum,uid:uid,qu:qu},
          'cache':false,
          'dataType':'json',
		  success:function(data){
			  console.log('data',data);
			  alert(data.info);
		  },
		  error:function(){
			  alert('操作失败');
		  }
	  });
  });
  $('#jjbtn').click(function(){
	  if(checknum==''){
		  alert('请输入后台校验码。');
		  return false;
	  }
	  if(uid==''){
		  alert('角色名不能为空。');
		  return false;
	  }
	  $.ajax({
		  url:'gmquery.php',
		  type:'post',
		  'data':{type:'jj',checknum:checknum,uid:uid,qu:qu},
          'cache':false,
          'dataType':'json',
		  success:function(data){
			  console.log('data',data);
			  alert(data.info);
		  },
		  error:function(){
			  alert('操作失败');
		  }
	  });
  });
  $('#chargebtn').click(function(){
	  if(checknum==''){
		  alert('请输入后台校验码。');
		  return false;
	  }
	  if(uid==''){
		  alert('角色名不能为空。');
		  return false;
	  }
	  var chargenum=$('#chargenum').val();
	  $.ajax({
		  url:'gmquery.php',
		  type:'post',
		  'data':{type:'charge',checknum:checknum,uid:uid,num:chargenum,qu:qu},
          'cache':false,
          'dataType':'json',
		  success:function(data){
			  console.log('data',data);
			  alert(data.info);
		  },
		  error:function(){
			  alert('操作失败');
		  }
	  });
  });
  $('#chargebtn1').click(function(){
	  if(checknum==''){
		  alert('请输入后台校验码。');
		  return false;
	  }
	  if(uid==''){
		  alert('角色名不能为空。');
		  return false;
	  }
	  var chargenum1=$('#chargenum1').val();
	  $.ajax({
		  url:'gmquery.php',
		  type:'post',
		  'data':{type:'charge1',checknum:checknum,uid:uid,num:chargenum1,qu:qu},
          'cache':false,
          'dataType':'json',
		  success:function(data){
			  console.log('data',data);
			  alert(data.info);
		  },
		  error:function(){
			  alert('操作失败');
		  }
	  });
  });
  $('#chargebtn2').click(function(){
	  if(checknum==''){
		  alert('请输入后台校验码。');
		  return false;
	  }
	  if(uid==''){
		  alert('角色名不能为空。');
		  return false;
	  }
	  var chargenum1=$('#chargenum2').val();
	  $.ajax({
		  url:'gmquery.php',
		  type:'post',
		  'data':{type:'charge2',checknum:checknum,uid:uid,num:chargenum1,qu:qu},
          'cache':false,
          'dataType':'json',
		  success:function(data){
			  console.log('data',data);
			  alert(data.info);
		  },
		  error:function(){
			  alert('操作失败');
		  }
	  });
  });
  $('#chargebtn3').click(function(){
	  if(checknum==''){
		  alert('请输入后台校验码。');
		  return false;
	  }
	  if(uid==''){
		  alert('角色名不能为空。');
		  return false;
	  }
	  var chargenum1=$('#chargenum3').val();
	  $.ajax({
		  url:'gmquery.php',
		  type:'post',
		  'data':{type:'charge3',checknum:checknum,uid:uid,num:chargenum1,qu:qu},
          'cache':false,
          'dataType':'json',
		  success:function(data){
			  console.log('data',data);
			  alert(data.info);
		  },
		  error:function(){
			  alert('操作失败');
		  }
	  });
  });
  $('#chargebtn4').click(function(){
	  if(checknum==''){
		  alert('请输入后台校验码。');
		  return false;
	  }
	  if(uid==''){
		  alert('角色名不能为空。');
		  return false;
	  }
	  var chargenum1=$('#chargenum4').val();
	  $.ajax({
		  url:'gmquery.php',
		  type:'post',
		  'data':{type:'charge4',checknum:checknum,uid:uid,num:chargenum1,qu:qu},
          'cache':false,
          'dataType':'json',
		  success:function(data){
			  console.log('data',data);
			  alert(data.info);
		  },
		  error:function(){
			  alert('操作失败');
		  }
	  });
  });
  $('#chargebtn5').click(function(){
	  if(checknum==''){
		  alert('请输入后台校验码。');
		  return false;
	  }
	  if(uid==''){
		  alert('角色名不能为空。');
		  return false;
	  }
	  var chargenum1=$('#chargenum5').val();
	  $.ajax({
		  url:'gmquery.php',
		  type:'post',
		  'data':{type:'charge5',checknum:checknum,uid:uid,num:chargenum1,qu:qu},
          'cache':false,
          'dataType':'json',
		  success:function(data){
			  console.log('data',data);
			  alert(data.info);
		  },
		  error:function(){
			  alert('操作失败');
		  }
	  });
  });
  $('#chargebtn6').click(function(){
	  if(checknum==''){
		  alert('请输入后台校验码。');
		  return false;
	  }
	  if(uid==''){
		  alert('角色名不能为空。');
		  return false;
	  }
	  var chargenum1=$('#chargenum6').val();
	  $.ajax({
		  url:'gmquery.php',
		  type:'post',
		  'data':{type:'charge6',checknum:checknum,uid:uid,num:chargenum1,qu:qu},
          'cache':false,
          'dataType':'json',
		  success:function(data){
			  console.log('data',data);
			  alert(data.info);
		  },
		  error:function(){
			  alert('操作失败');
		  }
	  });
  });
  $('#chargebtn7').click(function(){
	  if(checknum==''){
		  alert('请输入后台校验码。');
		  return false;
	  }
	  if(uid==''){
		  alert('角色名不能为空。');
		  return false;
	  }
	  var chargenum1=$('#chargenum7').val();
	  $.ajax({
		  url:'gmquery.php',
		  type:'post',
		  'data':{type:'charge7',checknum:checknum,uid:uid,num:chargenum1,qu:qu},
          'cache':false,
          'dataType':'json',
		  success:function(data){
			  console.log('data',data);
			  alert(data.info);
		  },
		  error:function(){
			  alert('操作失败');
		  }
	  });
  });
  $('#mailid').live('change',function(){
	  console.log('test');
	  var desc=$('#mailid option:selected').data('desc');
	  $('#maildesc').html(desc);
  });
</script>
</body>
</html>