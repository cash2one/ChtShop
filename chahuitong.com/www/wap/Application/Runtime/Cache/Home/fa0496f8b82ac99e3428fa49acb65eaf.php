<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
<meta charset="utf-8" />
<title>活动详情</title><meta name="keywords" content="茶汇通,普洱,普洱茶,茶">
<meta name="description" content="茶汇通">
<meta content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport">
<link href="/wap/Public/Home/css/shequ/details.css" type="text/css" rel="stylesheet">
<link href="/wap/Public/Home/css/shequ/share.css" type="text/css" rel="stylesheet">
<link href="/wap/Public/Home/css/shequ/shequ.css" type="text/css" rel="stylesheet">
<script src="/wap/Public/Home/js/jquery.min.js"></script>
<script src="/wap/Public/Home/js/jquery.cookie.js"></script>
<script src="/wap/Public/Home/js/TouchSlide.js"></script>
<script>
$(document).ready(function(){
	
 var active_id=<?php echo ($active["active_id"]); ?>;
 	
 var imgs=new Array();
 
 var string='<?php echo ($active["pics"]); ?>';
 
 imgs=string.split(",");
 
 if(imgs.length==0){
	 
	 imgs=["1.jpg","2.jpg","3.jpg"];
	  
	 }
for(var i=0;i<imgs.length;i++){
	
  $("#pics").append('<li><a href="#"><img src="/data/upload/qunzi/'+imgs[i]+'"  /></a></li>');
  
 
    }
	
	
 TouchSlide({ 
	slideCell:"#focus",
	titCell:".hd ul", //开启自动分页 autoPage:true ，此时设置 titCell 为导航元素包裹层
	mainCell:".bd ul", 
	effect:"left", 
	autoPlay:true,//自动播放
	autoPage:true, //自动分页
	switchLoad:"_src" //切换加载，真实图片路径为"_src" 
});	

   $("nav a").click(function(){
	   	   
	   $(".form").show();
   
	   })
	
	
	$("input[name='telphone']").change(function(){
		
		var username=$.cookie("username");
		
		var key=$.cookie("key");
		
		var telphone=$("input[name='telphone']").val();
		
		$.ajax({
			
			url:"/wap/index.php/Home/Discuz/join_active_api",
			
			type:"post",
			
			dataType:"json",
			
			data:{username:username,key:key,active_id:active_id,telphone:telphone},
			
			success:function(data){
				
				$(".form").hide();
				
				if(data.code==200){
					
			 $(".showmsg").html(data.content);

            $(".showmsg").show();

            $(".xiangqing").css("opacity","0.3");

            $(".top").css("opacity","0.3");

            setTimeout(function(){

             $(".showmsg").hide();

             $(".mail").css("opacity","1");

            $(".focus").css("opacity","1");
          
           },3000)		
					}else{
						
				$(".showmsg").html(data.content);

            $(".showmsg").show();

            $(".xiangqing").css("opacity","0.3");

            $(".top").css("opacity","0.3");

            setTimeout(function(){

             $(".showmsg").hide();

             $(".mail").css("opacity","1");

            $(".focus").css("opacity","1");
          
           },3000)	;				
						}
							
				}
					
			
			
			})
		
		
		
		
		
		
		})
	
	
	
	
	
	
})
</script>
</head>
<body>
<header>
<a href="#"><img src="/wap/Public/Home/img/fanhui.png"></a><?php echo ($active["active_title"]); ?>
<a href="#"><img src="/wap/Public/Home/img/home.png"></a>
</header>
<div id="focus" class="focus">
<div class="hd">
<ul></ul>
</div>
<div class="bd">
<ul id="pics">

</ul>
</div>
</div>
<div class="mail">
<div class="title">
<h5 class="active_title"><?php echo ($active["title"]); ?></h5>
<p class="location"><?php echo ($active["location"]); ?></p>
</div>
<div class="xiao">￥<?php echo ($active["free"]); ?></div>
<h5 id="huodong" class="open">活动详情<div></div></h5>
<div class="xiang" id="xiang">
<ul>
<li><label><mark></mark>行程天数：</label><?php echo ($active["last_time"]); ?>天</li>
<li><label><mark></mark>行程时间：</label><?php echo ($active["join_time"]); ?>~2015-09-05</li>
<li><label><mark></mark>淘茶宣言：</label><span class="xuanyan">布朗山的优质自然与生态条件，汲取其精华，为茶友提供品味醇正的普洱茶。</span></li>
</ul>
<div class="content">
  <?php echo ($active["content"]); ?>
</div>
</div>
</div>
<nav>
￥<?php echo ($active["free"]); ?><a href="#">立即加入<img src="/wap/Public/Home/img/shop.png"></a>
</nav>
<div class="showmsg" style="position: fixed; top: 40%; left: 0px; height: 30px; line-height: 30px; color: white; width: 100%; text-align: center; display: none; background: red;"></div>
<div class="form" style="position: fixed; top: 40%; left: 0px; height: 30px; line-height: 30px; color: white; width: 100%; text-align: center; display: none; background: white;"><input name="telphone" placeholder="请输入手机号码" type="text" style="border:1px solid #999;color:#666" value=""></div>
</body>
</html>