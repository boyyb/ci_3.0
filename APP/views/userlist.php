<?php
//header("Content-type: text/html; charset=utf-8");
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>用户信息</title>
	<style>
		#table{
			width:500px;
			border-top:1px green solid;
			border-left:1px green solid;
		}
		#table td,th{
			border-right:1px green solid;
			border-bottom:1px green solid;
		}
		#page a{
			color:black;
			text-decoration: none;
			border: 1px grey solid;
			margin-left: 7px;
			background: goldenrod;
		}
		#page a:hover{
			text-decoration: none;
			color:white;
			background:grey;
		}
		.current{
			margin-left:3px;
		}

	</style>
</head>
<body>


<h3>用户信息</h3>
<form action="/CI-3.0.6/user/search" method="get">
	姓名：<input type="text" name="search"/>
	<input type="submit" value="搜索"/>
</form>

<table  id="table" cellspacing="0" >
<tr>
	<th>ID</th>
	<th>姓名</th>
	<th>性别</th>
	<th>年龄</th>
</tr>
<?php foreach($arr as $v){?>
<tr>
	<td><?php echo $v['id'];?></td>
	<td><?php echo $v['name'];?></td>
	<td><?php echo $v['gender']==0 ? '男' : '女';?></td>
	<td><?php echo $v['age'];?></td>
</tr>
<?php }?>
<tr>
	<td colspan="4" id="page"><?php echo $pageStr;?></td>
</tr>
</table

</body>
</html>

