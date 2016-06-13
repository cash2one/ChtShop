<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
<meta charset="utf-8" />
<title>茶汇通</title>
<meta name="keywords" content="茶汇通,普洱,普洱茶">
<meta name="description" content="茶汇通普洱饼茶">
<meta content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport">
<link href="/wap/Public/Home/css/sharehome.css" type="text/css" rel="stylesheet">
<link href="/wap/Public/Home/css/home.css" type="text/css" rel="stylesheet">
<script src="/wap/Public/Home/js/jquery.min.js"></script>
<script src="/wap/Public/Home/js/TouchSlide.js"></script>
<script>
$(document).ready(function() {	
	$(".score").each(function(){		
		var goods_id=$(this).attr("id");	
		//alert(goods_id);	
		$.ajax({
			
			url:"/wap/index.php/Home/Index/homeapi",
			type:"post",
			dataType:"json",
			data:{goods_id:goods_id},
			success:function(data){			
				  if(data.code=="200"){					  
					  $("#"+data.goods_id).find("mark").html(data.content)
					  }else{
						  alert(data.content)
						  }
				
				}				
			})	
		
		
		})
			
	$(".score").click(function(){
		
		 var goods_id=$(this).attr("id");
		 
		 $.ajax({
			 
			 url:"/wap/index.php/Home/Index/homedianzanapi",
			 
			 type:"post",
			 
			 dataType:"json",
			 
			 data:{goods_id:goods_id},
			 
			 success: function(data){
				 				 
				 }
			 
			 		 
			 })
		
		
		})    
});
</script>
<script src="/wap/Public/Home/js/home.js"></script>
<style>
#app{width:100%;text-align:left;position:fixed;bottom:0;background:rgba(0,0,0,0.6);display:none;color:#fff;}
#logo{width:12%;float:left;margin:3px 3%;}
#app div{width:50%;float:left;font-size:0.8em;line-height:30px;margin-top:10px;}
#app a{display:block;width:20%;float:right;margin-right:30px;margin-top:10px;background:#1b8b80;text-align:center;color:#fff;line-height:30px;}
#close{width:20px;position:absolute;top:0;right:3px;}
</style>
</head>
<body>
<header><img src="/wap/Public/Home/img/logo02.png"></header>
<div id="focus" class="focus">
<div class="hd">
<ul>
</ul>
</div>
<div class="bd">
<ul>
<?php if(is_array($pics)): $i = 0; $__LIST__ = $pics;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$value): $mod = ($i % 2 );++$i;?><li><a href="<?php echo ($value["link"]); ?>"><img src="<?php echo ($value["image"]); ?>"  /></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
</ul>
</div>
</div>
<div id="nav">
<div class="navL"><a href="/mobile/app/b2b/index.php/Home/index/sale"><img src="/wap/Public/Home/img/chashi.png"><p>茶市</p></a></div>
<div class="navR"><a href="/wap/index.php/Home/discuz"><img src="/wap/Public/Home/img/bbs.png"><p>社区</p></a></div>
<div class="navL" style="border-bottom: 1px solid #acabab;"><a href="/wap/index.php/Home/news"><img src="/wap/Public/Home/img/zixun.png"><p>资讯</p></a></div>
<div class="navR"><a href="/wap/index.php/Home/index/brandLoad"><img src="/wap/Public/Home/img/shopping.png"><p>商城</p></a></div>
<div id="user"><a href="/wap/index.php/Home/Index/member">个人中心</a></div>
</div>
<div class="list">
<ul>
<?php if(is_array($xianshigoods)): $i = 0; $__LIST__ = $xianshigoods;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><li>
<div class="pic"><a href="/wap/index.php/Home/Index/goods?goods_id=<?php echo ($v["goods_id"]); ?>"><img src="/data/upload/shop/store/goods/<?php echo ($v["store_id"]); ?>/<?php echo ($v["goods_image"]); ?>"></a></div>
<div name="text" class="text"><h5><a href="/wap/index.php/Home/Index/goods?goods_id=<?php echo ($v["goods_id"]); ?>"><?php echo (subtext($v["goods_name"],11)); ?></a><span class="score" id="<?php echo ($v["goods_id"]); ?>"><img src="/wap/Public/Home/img/xin01.png"><mark>5454</mark></span></h5>
<p><?php echo ($v["xianshi_explain"]); ?></p>
<div class="shop">￥<?php echo ($v["xianshi_price"]); ?><span><a href="/wap/index.php/Home/Index/goods?goods_id=<?php echo ($v["goods_id"]); ?>">查看详情</a></span></div>
</div>
</li><?php endforeach; endif; else: echo "" ;endif; ?>
</ul>
</div>
<div id="imagehide" style="display:none">
</div>
<div id="app">
<img id="logo" src="/wap/Public/Home/img/logo.jpg">
<div><p>茶汇通-茶品 茶市 茶事 茶百科</p></div>
<a href="http://a.app.qq.com/o/simple.jsp?pkgname=com.damenghai.chahuitong">下载APP</a>
<img id="close" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB4AAAAeCAYAAAA7MK6iAAABBElEQVRIS7XXXRKEIAgAYDjptifbOik7trpDBgikvmTTzzeUiCIREfzajojv2l9yIKIPAGzl5cjgpThHG7wDwIuFOD3yHgWAAwtIRMtwEUXcTngVrqHnp+ajaGbkFnqDZ0U+QkX4Ke5BVTiLe1ETjuIRdAh78Sjqgkd4BnXDGl5T8Zx7azsQkZ/zbL30L3ms3qVPMvwRNxqKuAnCJFMuhdAs/C9tLNxwYYl+agltfgh3w9LorWKqpLpgK2WyhWUIe/I0g5uwBzVGu/nPVTiCZnARzqBR/AY/QSN4v/Tp8zQ8I3lxvtibhnrwtrydjo7wspNYhpp4t4VJ/9NoSeV7p2WoFPkX2aMLV14y0BkAAAAASUVORK5CYII=">
</div>
<script>
var cookies = document.cookie;
var app = document.getElementById('app');
var closes = document.getElementById('close');
if(cookies.search(/close/i)>0){
	app.style.display = 'none';
}else{
	app.style.display = 'block';
}
closes.onclick = function(){
	app.style.display = 'none';
	setcookie('zhuangtai','close',12);
}
function setcookie(name,value,days){
	var cookie = name + "=" + value;
	if(typeof days === "number"){
		cookie += ";max-age=" + days*60*60;
	}
	document.cookie = cookie;
}
</script>
<script>
var _hmt = _hmt || [];
(function() {
  var hm = document.createElement("script");
  hm.src = "//hm.baidu.com/hm.js?9a15ea23e7316c631085bb3ef722599a";
  var s = document.getElementsByTagName("script")[0]; 
  s.parentNode.insertBefore(hm, s);
})();
</script>
</body>
</html>