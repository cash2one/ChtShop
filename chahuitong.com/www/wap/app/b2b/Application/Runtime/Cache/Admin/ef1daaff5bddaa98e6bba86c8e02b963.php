<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>客户服务管理后台-店员角色</title>
<link rel="stylesheet" type="text/css" href="/myCustomer/Public/Admin/css/admin.css" />
<script type="text/javascript" src="/myCustomer/Public/Admin/js/jquery-1.4.4.min.js"></script>
</head>
<style type="text/css">
.col_two{
	display:inline-block;
	border:1px solid #fbaa01;
	background-color:#fbaa01;
	color:white;
	padding:5px;
}
</style>
<body>
<div class="menu">
<ul>
<li>
<a href="<?php echo U('Admin/index');?>" class="col_one">管理员</a>
</li>
<li>
<a href="<?php echo U('Actor/index');?>" class="col_two">角色</a>
</li>
<li>
<a href="<?php echo U('Company/index');?>" class="col_three">公司</a>
</li>
<li>
<a href="<?php echo U('Customer/index');?>" class="col_four">客户-流程</a>
</li>
<li>
<a href="<?php echo U('Music/update_f');?>" class="col_five">音乐管理</a>
</li>
<li>
<a href="<?php echo U('Index/direct');?>">生成首页</a>
</li>
<li>
<a style="cursor:pointer" class="out">退出</a>
</li>
</ul>
</div>
<script type="text/javascript">
$(function(){
	$(".out").click(function(){
		window.location.href="<?php echo U('Index/out');?>";
	})
})
</script>
<div class="admin_box">
<table>
<tr>
<td colspan="6"><a href="<?php echo U('Actor/add_d');?>">添加店员角色</a></td>
</tr>
<tr>
<td>编号</td>
<td>姓名</td>
<td>电话</td>
<td>角色</td>
<td>操作</td>
</tr>
<?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
<td><?php echo ($vo["id"]); ?></td>
<td><?php echo ($vo["name"]); ?></td>
<td><?php echo ($vo["telphone"]); ?></td>
<td><?php echo ($vo["user_type"]); ?></td>
<td>
<a href="<?php echo U('Actor/update_d?id='.$vo[id].'');?>">编辑</a>
<a href="<?php echo U('Actor/delete?id='.$vo[id].'');?>">删除</a>
</td>
</tr><?php endforeach; endif; else: echo "" ;endif; ?>

</table>
</div>
</body>
</html>