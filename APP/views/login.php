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
	<script src="http://127.0.0.1/CI-3.0.6/Public/js/jquery-1.8.3.min.js"></script>
	<!--<script typet="text/javascript" src="http://libs.baidu.com/jquery/1.9.1/jquery.min.js"></script>-->
	<script>
		$(document).ready(function(){
			$('#code').click(function(){
				$(this).attr('src',"http://localhost/CI-3.0.6/user/vcode/"+Math.random());
			});
			$('#name').blur(function(){
				$.post(
						url:'notice.php',
						data:{name:$(this).value()},
						function(msg){

						}
				);
			})


		});
	</script>
	<script>
		$(document){}
	</script>
</head>
<body>
<p><p>
<h3 style="text-align:center">用户登录</h3><hr/>
<form action="checklogin" method="post">
用户名：<input type="text" name="name" id="name"/><span id="msg" style="color:red"></span><br/>
密码：<input type="password" name="password" id="password"/><br/>
验证码：<input type="text" name="vcode" id="vcode"/>
	<img src="http://localhost/CI-3.0.6/user/vcode" id="code"  title="点击刷新"/><br/>
<input type="submit" value="登录" />
</form>
<?php if(isset($userinfo)) {?>
	<p style="color:red"><?php echo @$userinfo;?></p>
<?php }?>
<?php if(isset($codeinfo)) {?>
	<p style="color:red"><?php echo @$codeinfo;?></p>
<?php }?>
</body>
</html>