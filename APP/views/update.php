<?php
//header("Content-type: text/html; charset=utf-8");


?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>修改管理员</title>
	
</head>
<body>
<h3>修改管理员</h3>
<form action="../usave" method="post">
用户名：<input type="text" name="name" value="<?php echo $data['name'];?>"/>
		<input type="hidden" name="id" value="<?php echo $data['id']?>"/><br/>
密码：<input type="password" name="password" value="<?php echo $data['password'];?>"/><br/>
等级：
超级管理员<input type="radio" name="level" value="0" <?php if($data['level']==0){?> checked="checked" <?php }?>/>&nbsp;&nbsp;&nbsp;&nbsp;
管理员<input type="radio" name="level" value="1" <?php if($data['level']==1){?> checked="checked" <?php }?>/>&nbsp;&nbsp;&nbsp;&nbsp;
普通用户<input type="radio" name="level" value="2" <?php if($data['level']==2){?> checked="checked" <?php }?>/>&nbsp;&nbsp;<br/>
<input type="submit" value="提交" />
</form>
</body>
</html>