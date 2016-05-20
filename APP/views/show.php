<?php
//header("Content-type: text/html; charset=utf-8");
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>管理员信息</title>
	<style>
		#table{
			border-top:1px green solid;
			border-left:1px green solid;
		}
		#table td,th{
			border-right:1px green solid;
			border-bottom:1px green solid;
		} 
	</style>
</head>
<body>


<h3>管理员信息</h3>
<table  id="table" cellspacing="0" >
<tr>
	<th>ID</th>
	<th>姓名</th>
	<th>密码</th>
	<th>等级</th>
	<th>操作</th>
</tr>
<?php foreach($data as $v){?>
<tr>
	<td><?php echo $v['id'];?></td>
	<td><?php echo $v['name'];?></td>
	<td><?php echo $v['password'];?></td>
	<td><?php echo $v['level'];?></td>
	<td>
		<a href="del/<?php echo $v['id'];?>">删除</a>  |  
		<a href="update/<?php echo $v['id'];?>">修改</a>
	</td>
</tr>
<?php }?>
</table
</body>
</html>