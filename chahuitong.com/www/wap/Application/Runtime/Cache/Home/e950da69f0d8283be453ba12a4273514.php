<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>地址列表</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no">
    <link rel="stylesheet" type="text/css" href="/wap/Public/Home/css/reset.css">
    <link rel="stylesheet" type="text/css" href="/wap/Public/Home/css/main.css">
	<link rel="stylesheet" type="text/css" href="/wap/Public/Home/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="/wap/Public/Home/css/class.css">
    <link rel="stylesheet" type="text/css" href="/wap/Public/Home/css/shopcart.css">
    <style>
   .address ul{text-align:left;padding-bottom:60px;}
   .address ul li{background:#fff;padding:10px 4% 0px 4%;margin-bottom:12px;border-top:1px solid #b5b5b5;border-bottom:1px solid #b5b5b5;}
   .address ul li:first-child{border-top:none;}
   .address ul li h4{color:#898989;font-weight:500;line-height:40px;}
   .address ul li h4 span{margin-right:15%;}
   .address ul li h5{color:#ccc;font-size:0.9em;font-weight:500;border-bottom:1px solid #dcdddd;padding-bottom:10px;}
   .input_p{color:#b5b5b5;margin:10px 0;}
   .input_p .box{margin-right:5px;}
   .input_p span{float:right;margin:0 10px;}
   .input_p img{width:12px;margin-right:6px;vertical-align:middle;}
   .add_address{background:#1b8b80;position:fixed;left:15%;bottom:80px;color:#fff;width:70%;height:45px;border:none;font-size:1.2em;z-index:2;line-height:45px}
   .box1 {
  float: left;
  width: 23px;
  height: 23px;
  position: relative;
  border-radius: 18px;
  border: 1px solid #999;
  background:none;
  background-size: 100% 100%;
}
  .box {
  float: left;
  width: 23px;
  height: 23px;
  position: relative;
  border-radius: 18px;
  border: 1px solid #999;
  background:#1b8b80;
  background-size: 100% 100%;
}
 .box label:after {
  content: '';
  width: 9px;
  height: 5px;
  position: absolute;
  top: 6px;
  left: 6px;
  border: 2px solid #fcfff4;
  border-top: none;
  border-right: none;
  background: transparent;
  filter: progid:DXImageTransform.Microsoft.Alpha(Opacity=0);
  opacity:1;
  -moz-transform: rotate(-45deg);
  -ms-transform: rotate(-45deg);
  -webkit-transform: rotate(-45deg);
  transform: rotate(-45deg);
  color:#FFF;
}
</style>
</head>
<body>
   <header>
   <a href="javascript:history.go(-1)"><img src="/wap/Public/Home/img/fanhui.png"></a>收货地址
   <a href="/wap/index.php/Home/Index/index"><img src="/wap/Public/Home/img/home.png"></a>
  </header>
    <div class="address-list address" id="address_list"></div>
    <script>
var _hmt = _hmt || [];
(function() {
  var hm = document.createElement("script");
  hm.src = "//hm.baidu.com/hm.js?9a15ea23e7316c631085bb3ef722599a";
  var s = document.getElementsByTagName("script")[0]; 
  s.parentNode.insertBefore(hm, s);
})();
</script>
   
    <script type="text/html" id="saddress_list">
     <%if(address_list.length>0){%>
		<ul>
		<%for(var i=0;i<address_list.length;i++){%>
            <li>
                
                    <h4><span><%=address_list[i].true_name %></span><%=address_list[i].mob_phone %></h4>
                    <span class="madrt-type fright"></span>
                    <h5><%=address_list[i].area_info %>&nbsp;<%=address_list[i].address %></h5>
                <div class="input_p">
                    
					<%if(address_list[i].is_default==1){%>
					<div class="box">
					<input type="hidden" class="default" id="a<%i%>" value="<%=address_list[i].address_id%>"><label for="a<%i%>"></label>              </div>
					<%}else{%>
					<div class="box1">
					<input type="hidden" class="undefault"  id="a<%i%>" value="<%=address_list[i].address_id%>"><label for="a<%i%>"></label>           </div>  
					<%}%>
					
                    <p class="madrc-opera">
						<span><a href="/wap/index.php/Home/Index/address_edit?address_id=<%=address_list[i].address_id %>"><img src="/wap/Public/Home/img/edit.png">编辑</a></span>&nbsp;
                        <span><a href="javascript:;" address_id="<%=address_list[i].address_id %>" class="deladdress"><img src="/wap/Public/Home/img/delete.png">删除</a></span>
                    </p>
                </div>
            </li>
		<%}%>
        </ul>
        <%}else{%>
            <div class="no-record">
                暂无记录
            </div>
        <%}%>
		<a class="add_address mt10" href="/wap/index.php/Home/Index/add_address">添加新地址</a>
	</script>    
    <script type="text/javascript" src="/wap/Public/Home/js/config.js"></script>
    <script type="text/javascript" src="/wap/Public/Home/js/zepto.min.js"></script>
    <script type="text/javascript" src="/wap/Public/Home/js/template.js"></script>
    <script type="text/javascript" src="/wap/Public/Home/js/common.js"></script>
    <script type="text/javascript" src="/wap/Public/Home/js/tmpl/common-top.js"></script>
    <script type="text/javascript" src="/wap/Public/Home/js/tmpl/address_list.js"></script>
    <script type="text/javascript">//客户端去头部
			if(navigator.userAgent.indexOf("android")!=-1||navigator.userAgent.indexOf("ios")!=-1){
		       $("#header").hide();	
	           }
    </script>
</body>
</html>