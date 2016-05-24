<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>新闻列表</title>
    <link type="text/css" href="/CI-3.0.6/Public/css/style.css" rel="stylesheet"/>
    <style>
        table{ border:0;border-collapse:collapse;width:640px;}
        tr{ border:1px solid #333;}
        th{ font:bold 12px/17px Arial;border:1px solid #333;}
        td{ font:normal 12px/17px Arial;border:1px solid #333;}
        th.num{width:30px;}
        th.v{width:200px}
        .parent{ /* 折叠行样式*/
            color:#fff;cursor:pointer;
            background: url('/CI-3.0.6/Public/pic/up.jpg') center right no-repeat lightslategrey;
            background-size:32px 32px;
        }
        .selected{
            background: url('/CI-3.0.6/Public/pic/down.jpg') center right no-repeat dimgray;
            background-size:32px 32px;
        }
    </style>
    <!--   引入jQuery -->
    <script src="/CI-3.0.6/Public/js/jquery-2.2.4.min.js" type="text/javascript"></script>
    <script type="text/javascript">
        $(function(){
            $('tr.parent').click(function(){   // 获取所谓的父行并触发点击事件
                $(this).toggleClass("selected")   // 给parent类添加或删除selected类
                       .siblings('.child_'+this.id) //获得对应类名的兄弟节点(需要被隐藏的行)
                       .toggle();  // 隐藏/显示所谓的子行，toggle()方法切换元素的可见状态。
                
            });
            $('#search_btn').click(function(){
                $('#form').attr('action','nlist')
                          .attr('method','post')
                          .submit();
            });
        })
    </script>
</head>
<body>
<a href="add">添加</a>
<form id="form">
    <div class="search">
        <input class="search_input" id="search_input" name="search" placeholder="请输入搜索标题或内容" type="text">
        <input class="search_btn" id="search_btn" type="button">
    </div>
</form>
<form id="form" action="nlist" method="get">
    <div class="search">
        <input class="search_input" id="search_input1" name="search_time" placeholder="请输入搜索日期(xxxx-xx-xx)" type="text">
        <input class="search_btn" id="search_btn1" type="submit" value="">
    </div>
</form>
<table>
    <tr><th class="num">序号</th>
        <th class="v">标题</th>
        <th class="v">内容</th>
        <th class="v">发布时间</th>
    </tr>
    <?php foreach($ddata as $key => $value){?>
        <tr class="parent" id="row_<?php echo $key;?>">
             <td colspan="4"><?php echo $key;?></td>
        </tr>
        <?php foreach($value as $k=>$v){?>
            <tr class="child_row_<?php echo $key;?>">
                <td><?php echo $k+1;?></td>
                <td><?php echo $v['title'];?></td>
                <td><?php echo $v['content'];?></td>
                <td><?php echo date('Y-m-d H:i:s',$v['createtime']);?></td>
            </tr>
    <?php }}?>
    <?php foreach($mdata as $key => $value){?>
        <tr class="parent <?php if($flag==0){ ?>selected<?php }?>" id="row_<?php echo $key;?>">
            <td colspan="4"><?php echo $key;?></td>
        </tr>
        <?php foreach($value as $k=>$v){?>
            <tr class="child_row_<?php echo $key;?>" <?php if($flag==0){ ?>style="display:none;"<?php }?>>
                <td><?php echo $k+1;?></td>
                <td><?php echo $v['title'];?></td>
                <td><?php echo $v['content'];?></td>
                <td><?php echo date('Y-m-d H:i:s',$v['createtime']);?></td>
            </tr>
        <?php }}?>
</table>
</body>
</html>