<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>茶市————茶汇通</title>
<meta name="keywords" content="茶汇通,普洱,普洱茶">
<meta name="description" content="茶汇通普洱饼茶">
<meta content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport">
<link href="/mobile/app/b2b/Public/Home/css/share.css" type="text/css" rel="stylesheet">
<link href="/mobile/app/b2b/Public/Home/css/chashi.css" type="text/css" rel="stylesheet">
<style>
body{background:#f3f3f3;}
</style>
</head>
<body>
<header id="header">
<a href="javaScript:window.history.back();"><img src="/mobile/app/b2b/Public/Home/img/fanhui.png"></a>茶市<a href="http://www.chahuitong.com/wap"><img src="/mobile/app/b2b/Public/Home/img/home.png"></a>
</header>
<header>
<nav>
<a class="on" href="/mobile/app/b2b/index.php/Home/Index/brand">行情</a>
<a href="/mobile/app/b2b/index.php/Home/Index/sale">出售</a>
<a href="/mobile/app/b2b/index.php/Home/Index/buy">求购</a>
<a href="/mobile/app/b2b/index.php/Home/Index/myList">发布</a>
</nav>
</header>
<div class="hq">
<ul class="mingxi">
    <?php if(is_array($goods)): $i = 0; $__LIST__ = $goods;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><li><a href="<?php echo ($v["goods_link"]); ?>">
            <ul class="lister ">
                <li><div><img src="/mobile/app/b2b/Public/Home/img/hq01.png"></div>
                    <div><p><?php echo ($v["brand_name"]); ?></p><p>品名</p></div>
                    <div><p><?php echo ($v["year"]); ?></p><p>报价时间</p></div></li>
                <li><div><img src="/mobile/app/b2b/Public/Home/img/hq02.png"></div>
                    <div><p><?php echo ($v["unit"]); ?></p><p>单位</p></div>
                    <div><p><?php echo ($v["price"]); ?></p><p>参考价格</p></div></li>
            </ul>
            </a>
        </li><?php endforeach; endif; else: echo "" ;endif; ?>
</ul>
</div>
<script>
var _hmt = _hmt || [];
(function() {
  var hm = document.createElement("script");
  hm.src = "//hm.baidu.com/hm.js?9a15ea23e7316c631085bb3ef722599a";
  var s = document.getElementsByTagName("script")[0]; 
  s.parentNode.insertBefore(hm, s);
})();
</script>

</body></html>