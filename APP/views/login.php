<?php
header("Content-type: text/html; charset=utf-8");
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>login</title>
	<style>
		#code{  cursor:pointer;  }
	</style>
	<!--<script src="<?php /*echo base_url('/Public/js/jquery-1.8.3.min.js')*/?>"></script>-->
	<script src="/CI-3.0.6/Public/js/jquery-1.8.3.min.js"></script>
	<!--<script typet="text/javascript" src="http://libs.baidu.com/jquery/1.9.1/jquery.min.js"></script>-->
	<link rel="stylesheet" type="text/css" href="/CI-3.0.6/Public/jquery-easyui-1.4.5/themes/default/easyui.css">
	<link rel="stylesheet" type="text/css" href="/CI-3.0.6/Public/jquery-easyui-1.4.5/themes/icon.css">
	<link rel="stylesheet" type="text/css" href="/CI-3.0.6/Public/jquery-easyui-1.4.5/demo/demo.css">
	<script type="text/javascript" src="/CI-3.0.6/Public/jquery-easyui-1.4.5/jquery.min.js"></script>
	<script type="text/javascript" src="/CI-3.0.6/Public/jquery-easyui-1.4.5/jquery.easyui.min.js"></script>
	<script>
		$(document).ready(function(){
			$('#win').window('open').window({
				collapsible:true,
				minimizable:false,
				maximizable:false
			});
			$('#name').blur(function(){
				//ajax请求用户数据
				$.post(
						'notice',
						{name:$(this).val()},
						function(msg){
							$('#msg').html(msg);
						}
				);
			});
			$('.easyui-linkbutton').click(function(){
				$('#form').submit();
			});
			//输入框被选中时的效果
			$('#name').focus(function(){
				$(this).css('borderColor','blue');
			});
			$('#name').focusout(function(){
				$(this).attr('style','');
			});
		});
	</script>
</head>
<body style="height:100%;width:100%;overflow:hidden;border:none;">
<h3 style="text-align:center">用户登录</h3><hr/>
<div id="win" class="easyui-window" title="Login" style="width:400px;height:200px;">
	<form action="login" method="post" id="form">
		用户名：<input type="text" name="name" id="name"/><span id="msg" style="color:red"></span><br/>
		密码：<input type="password" name="password" id="password"/><br/>
		验证码：<input type="text" name="vcode" id="vcode"/>
		<img src="http://localhost/CI-3.0.6/user/vcode" onclick=this.src='http://localhost/CI-3.0.6/user/vcode?a='+Math.random()
			 id='code' title="点击刷新"/><br/>
		<input type="submit" value="登录" />
		<div style="padding:5px;text-align:center;">
			<a href="#" class="easyui-linkbutton" icon="icon-ok">登陆</a>
			<!--<a href="#" class="easyui-linkbutton" icon="icon-cancel">Cancel</a>-->
		</div>
	</form>
</div>
</body>
</html>