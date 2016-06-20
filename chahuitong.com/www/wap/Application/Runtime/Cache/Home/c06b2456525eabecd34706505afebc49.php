<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>商品列表</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<meta name="format-detection" content="telephone=no">
	<link rel="stylesheet" type="text/css" href="/wap/Public/Home/css/reset.css">
    <link rel="stylesheet" type="text/css" href="/wap/Public/Home/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="/wap/Public/Home/css/main.css">
    <link rel="stylesheet" type="text/css" href="/wap/Public/Home/css/brand.css">
    <link rel="stylesheet" type="text/css" href="/wap/Public/Home/css/class.css">
	<link rel="stylesheet" type="text/css" href="/wap/Public/Home/css/child.css">
</head>
<body id="home-320">
	<header>
<a href="javascript:history.go(-1)"><img src="/wap/Public/Home/img/fanhui.png"></a> 搜索结果    
<a href="/wap/index.php/Home/Index/index"><img src="/wap/Public/Home/img/home.png"></a>
</header>
		<div class="content">
		<div class="product-filter">
			<a href="javascript:void(0);" class="clearfix current keyorder" key="4">
				<span class="pf-newpd-icon f-icon fleft"></span>
				<span class="pf-title">新品</span>
			</a>
			<a href="javascript:;" class="clearfix keyorder" key='3'>
				<span class="pf-price-icon  desc f-icon fleft"></span>
				<span class="pf-title">价格</span>
			</a>
			<a href="javascript:;" class="clearfix keyorder" key='1'>
				<span class="pf-sales-icon f-icon fleft"></span>
				<span class="pf-title">销量</span>
			</a>
			<a href="javascript:;" class="clearfix keyorder" key='2'>
				<span class="pf-popularity-icon f-icon fleft"></span>
				<span class="pf-title">人气</span>
			</a>
		</div>
		<div class="product-cnt">
			<div id="product_list"></div>
			<div class="pagination mt10">
				<a href="javascript:void(0);" class="pre-page disabled">上一页</a>
				<select name="page_list" style="padding: 7px 4px;  vertical-align: top;">

				</select>
				<a href="javascript:void(0);" class="next-page ">下一页</a>
			</div>
		</div>
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
	<input type="hidden" name="key" value="4">
	<input type="hidden" name="order" value="1">
	<input type="hidden" name="page" value="10">
	<input type="hidden" name="curpage" value="1">
	<input type="hidden" name="hasmore">
	<input type="hidden" name="gc_id" value="">
	<input type="hidden" name="keyword">
</body>
<script type="text/html" id="home_body">
	<% if(goods_list.length >0){%>
		<ul class="product-list">
			<%for(i=0;i<goods_list.length;i++){%>
			<li class="pdlist-item" goods_id="<%=goods_list[i].goods_id;%>">
				<a href="goods?goods_id=<%=goods_list[i].goods_id;%>" class="pdlist-item-wrap clearfix">
					<span class="pdlist-iw-imgwp">
						<img src="<%=goods_list[i].goods_image_url;%>"/>
					</span>
					<div class="pdlist-iw-cnt">
						<p class="pdlist-iwc-pdname">
							<%=goods_list[i].goods_name;%>
						</p>
						<p class="pdlist-iwc-pdprice">
							￥<%=goods_list[i].goods_price;%>

						<% if (goods_list[i].is_virtual == '1') { %>
							<span class="product-status bg-virtual">虚拟兑换</span>
						<% } else { %>
							<% if (goods_list[i].is_presell == '1') { %>
							<span class="product-status bg-presell">预售</span>
							<% } %>
							<% if (goods_list[i].is_fcode == '1') { %>
							<span class="product-status bg-fcode">F码优先</span>
							<% } %>
						<% } %>

							<%
								if(goods_list[i].group_flag){
							%>
								<span class="product-status bg-yf8">抢购</span>
							<%
								}
								if(goods_list[i].xianshi_flag){
							%>
								<span class="product-status bg-blue">限时折扣</span>
							<%
								}
							%>
						</p>
						<p class="pdlist-iwc-pdcomment  clearfix">
							<span class="evaluation_good_swp mr5 fleft" style="margin-top:-5px;">
							<%
								for(var s = 1;s<=5;s++){ if (s<=goods_list[i].evaluation_good_star) {
							%>
								<span class="evaluation-star fleft"></span>
							<%
								} else {
							%>
								<span class="evaluation-star-gray fleft"></span>
							<%
								} }
							%>
							</span>
							<span class="fleft">
								(<%=goods_list[i].evaluation_count;%>人)
							</span>
						</p>
					</div>
				</a>
			</li>
			<%}%>
		</ul>
	<%
	   }else {
	%>
		<div class="no-record">
            暂无记录
        </div>
	<%
	   }
	%>
</script>
<script type="text/javascript" src="/wap/Public/Home/js/jquery.min.js"></script>
<script type="text/javascript" src="/wap/Public/Home/js/config.js"></script>
<script type="text/javascript" src="/wap/Public/Home/js/zepto.min.js"></script>
<script type="text/javascript" src="/wap/Public/Home/js/touch.js"></script>
<script type="text/javascript" src="/wap/Public/Home/js/template.js"></script>
<script type="text/javascript" src="/wap/Public/Home/js/common.js"></script>
<script type="text/javascript" src="/wap/Public/Home/js/tmpl/common-top.js"></script>
<script type="text/javascript" src="/wap/Public/Home/js/tmpl/product_list_default.js"></script>

</html>