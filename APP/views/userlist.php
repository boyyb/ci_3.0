<?php
//header("Content-type: text/html; charset=utf-8");
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>用户信息</title>
	<link type="text/css" href="/CI_3.0.6/Public/css/style.css" rel="stylesheet"/>
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
<form id="form" method="get" action="/CI_3.0.6/user/search">
	<div class="search">
		<input class="search_input" id="search_input" name="search" placeholder="请输入搜索姓名" type="text">
		<input class="search_btn" id="search_btn" type="submit" value="">
	</div>
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

