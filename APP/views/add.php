<?php
//header("Content-type: text/html; charset=utf-8");
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>添加管理员</title>
	
</head>
<body>
<p><p>
<h3>添加管理员</h3>
<form action=" save" method="post">
用户名：<input type="text" name="name"/><br/>
密码：<input type="password" name="password"/><br/>
等级：
超级管理员<input type="radio" name="level" value="0"/>&nbsp;&nbsp;&nbsp;&nbsp;
管理员<input type="radio" name="level" value="1"/>&nbsp;&nbsp;&nbsp;&nbsp;
普通用户<input type="radio" name="level" value="2" checked="checked"/>&nbsp;&nbsp;<br/>
<input type="submit" value="提交" />
</form>
</body>
</html>