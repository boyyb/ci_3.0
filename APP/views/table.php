<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta name="keywords" content="jquery,ui,easy,easyui,web">
	<meta name="description" content="easyui help you build your web page easily!">
	<title>自动填写身份证号</title>
	<script type="text/javascript" src="/CI-3.0.6/Public/js/jquery-2.2.4.min.js"></script>
	<style type="text/css">
		#idnum td{
			width:40px;
		}
	</style>
	<script type="text/javascript">
		$(document).ready(function(){
			$('input').blur(function(){
				$.post(
						'data',
						{"name": $(this).val()},
						function(json){
							var json = eval("("+json+")");//json格式数据转换为json对象
							var idnum = json.idnum;
							var sex = json.sex == 1 ? 'man' : 'woman';
							$('#idnum td').not(':first').each(function(index,element){
								$(this).html(idnum.substr(index,1));
							});

							$('#'+sex).prop('checked','checked')
									.siblings().prop('checked',false);


						}
				);
			});
		});
	</script>
</head>
<body>
<h3>输入名字后自动显示身份证号码</h3>
<table border="1" width="800" cellpadding="0" cellspacing="0">
	<tr>
		<td>姓名</td>
		<td colspan="18"><input name="name" type="text" placeholder="bingo,yb,张三"/></td>
	</tr>
	<tr id="idnum">
		<td style="width:80px">身份证号</td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
	</tr>
	<tr>
		<td colspan="19">
			男<input type="checkbox" name="sex" value="1" id="man"/>&nbsp;&nbsp;
			女<input type="checkbox" name="sex" value="0" id="woman"/>
		</td>
	</tr>
</table>
</body>
</html>