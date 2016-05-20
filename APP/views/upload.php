<?php
//header("Content-type: text/html; charset=utf-8");
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>upload</title>
	
</head>
<body>
<form action=" psave" method="post" enctype="multipart/form-data">
	<input type="file" name="userfile"/>
	<input type="submit" value="提交"/>
</form>
<?php if(isset($info)){ ?>
<p style="color:red"><?php echo $info;?></p>
<?php }?>

</body>
</html>