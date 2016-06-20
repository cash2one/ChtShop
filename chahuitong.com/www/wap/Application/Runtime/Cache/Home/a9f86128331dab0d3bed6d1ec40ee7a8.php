<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>订单列表</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no">
    <link rel="stylesheet" type="text/css" href="/wap/Public/Home/css/reset.css">
    <link rel="stylesheet" type="text/css" href="/wap/Public/Home/css/main.css">
	<link rel="stylesheet" type="text/css" href="/wap/Public/Home/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="/wap/Public/Home/css/member.css">
    <link href="/wap/Public/Home/css/class.css" type="text/css" rel="stylesheet">
    <link href="/wap/Public/Home/css/dingdan.css" type="text/css" rel="stylesheet">
</head>
<body>
     <header>
     <a href="javascript:history.go(-1)"><img src="/wap/Public/Home/img/fanhui.png"></a>订单中心
     <a href="/wap/index.php/Home/Index/index"><img src="/wap/Public/Home/img/home.png"></a>
     </header>
      <input type="hidden" name="order_status" id="order_status" value="">
     <div id="nav">
       <a href="#" class="on" id="all" >全部</a><a href="#" id="unpaid">待付款</a><a href="#" id="paid">待发货</a><a href="#" id="receive">待收货</a><a href="#" id="uncomment">待评价</a>
     </div>
    <div class="order-list-wp" id="order-list"></div>
    <script type="text/html" id="order-list-tmpl">
        <div class="order-list">
            <%if (order_group_list.length >0){%>
                <ul>
                    <%for(var i = 0;i<order_group_list.length;i++){
                        var orderlist = order_group_list[i].order_list;
                    %>
                        <li class="<%if(order_group_list[i].pay_amount){%>green-order-skin<%}else{%>gray-order-skin<%}%> <%if(i>0){%>mt10<%}%>">
                            <div class="order-ltlt">
                                <p>
                                    下单时间：
                                   <%=$getLocalTime(order_group_list[i].add_time)%>
                                </p>
                            </div>
                            <% for(var j = 0;j<orderlist.length;j++){
                                var order_goods = orderlist[j].extend_order_goods;
                            %>
                                <div class="order-lcnt">
                                    <div class="order-lcnt-shop">
                                        <p>店铺名称：<%=orderlist[j].store_name%></p>
                                        <p>订单编号：<%=orderlist[j].order_sn%></p>
                                    </div>
                                    <div class="order-shop-pd">
                                        <%for (var k = 0;k<order_goods.length;k++){%>
                                        <a class="order-ldetail clearfix <%if(k>0){%>bd-t-de<%}%>" href="<%=WapSiteUrl%>/index.php/Home/Index/goods?goods_id=<%=order_goods[k].goods_id%>">
                                            <span class="order-pdpic">
                                                <img src="<%=order_goods[k].goods_image_url%>"/>
                                            </span>
                                            <div class="order-pdinfor">
                                                <p><%=order_goods[k].goods_name%></p>
                                                <p>
                                                    单价：<span class="clr-d94">￥<%=order_goods[k].goods_price%></span>
                                                </p>
                                                 <p>
                                                    商品数目：<%=order_goods[k].goods_num%>
                                                </p>
                                            </div>
                                        </a>
                                        <%}%>
                                    </div>
                                    <div class="order-shop-total">
                                        <p>运费：<span class="clr-d94">￥<%=orderlist[j].shipping_fee%></span></p>
                                        <p class="clr-c07">合计：￥<%=orderlist[j].order_amount%> </p>
                                        <p class="mt5">
                                            <%
                                                var stateClass ="ot-finish";
                                                var orderstate = orderlist[j].order_state;
                                                if(orderstate == 20 || orderstate == 30 || orderstate == 40){
                                                    stateClass = stateClass;
                                                }else if(orderstate == 0) {
                                                    stateClass = "ot-cancel";
                                                }else {
                                                    stateClass = "ot-nofinish";
                                                }
                                            %>
                                            <span class="<%=stateClass%>"><%=orderlist[j].state_desc%></span>
                                        </p>
                                        <p class="mt5">
                                            <%if(orderlist[j].if_receive){%>
                                            <a href="javascript:void(0)" order_id="<%=orderlist[j].order_id%>" class="sure-order">确认订单</a>
                                            <%}%>
                                             <%if(orderlist[j].if_cancel){%>
                                            <a href="javascript:void(0)" order_id="<%=orderlist[j].order_id%>" class="cancel-order">取消订单</a>
                                            <%}%>
                                            <%if(orderlist[j].if_deliver){%>
                                            <a href="javascript:void(0)" order_id="<%=orderlist[j].order_id%>" class="viewdelivery-order">查看物流</a>
                                            <%}%>
                                        </p>
                                    </div>
                                </div>
                            <%}%>
                            <%if(order_group_list[i].pay_amount && order_group_list[i].pay_amount>0 &&
                            payment_list.length > 0) {%>
                            <%for(var p = 0;p < payment_list.length;p++){%>
                            <a href="<%=ApiUrl %>/index.php?act=member_payment&op=pay&key=<%=key %>&pay_sn=<%=order_group_list[i].pay_sn %>&payment_code=<%=payment_list[p].payment_code%>"
                               class="l-btn-login check-payment"><%=payment_list[p].payment_name%>（￥<%=
                                p2f(order_group_list[i].pay_amount) %>）</a><br>
                            <%}}%>
                        </li>
                    <%}%>
                </ul>
                <div class="pagination mt10">
                    <a href="javascript:void(0);" class="pre-page <%if(curpage <=1 ){%>disabled<%}%>">上一页</a>
                    <a href="javascript:void(0);" has_more="<%if (hasmore){%>true<%}else{%>false<%}%>"  class="next-page <%if (!hasmore){%>disabled<%}%>">下一页</a>
                </div>
            <%}else {%>
                <div class="no-record">
                    暂无记录
                </div>
            <%}%>
        </div>
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
    <script type="text/javascript" src="/wap/Public/Home/js/zepto.min.js"></script>
    <script type="text/javascript" src="/wap/Public/Home/js/template.js"></script>
    <script type="text/javascript" src="/wap/Public/Home/js/config.js"></script>
    <script type="text/javascript" src="/wap/Public/Home/js/common.js"></script>
	<script type="text/javascript" src="/wap/Public/Home/js/simple-plugin.js"></script>
    <script type="text/javascript" src="/wap/Public/Home/js/tmpl/common-top.js"></script>
    <script type="text/javascript" src="/wap/Public/Home/js/tmpl/order_list1.js"></script>
</body>
</html>