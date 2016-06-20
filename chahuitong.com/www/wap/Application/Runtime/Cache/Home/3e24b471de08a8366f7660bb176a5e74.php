<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
<meta charset="utf-8" />
<title>茶汇通资讯</title>
<meta name="keywords" content="茶汇通,普洱,普洱茶">
<meta name="description" content="茶汇通普洱饼茶">
<meta content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport">
<!--分享css-->

<!--css-->
<link href="/wap/Public/Home/css/sharehome.css" type="text/css" rel="stylesheet">
<link href="/wap/Public/Home/css/zixunshare.css" type="text/css" rel="stylesheet">
<link href="/wap/Public/Home/css/zixun.css" type="text/css" rel="stylesheet">
<script src="/wap/Public/Home/js/jquery.min.js"></script>
<script>
  $(document).ready(function(){
	  
 /*初始化*/	  	
   function init(){
    $.ajax({
				    url:"/wap/index.php/Home/News/newsapi",
					type:"post",
					dataType:"json",
					data:{id:89},
					success: function(data){						
						  if(data.code=200){	
						  
						    $(".list ul").html('');
							
							$("input[name='page']").val(1)
						  
						    for(var i=0;i<data.content.length;i++){
								
								   if(i==0){	
			$(".new").attr("id",data.content[i].article_id)	;					   							   
			var html='<h4 id="'+data.content[i].article_id+'"><a href="#"><span style="width:40%;overflow:hidden">'+data.content[0].article_title+'</span><time>'+data.content[0].article_publish_time+'<img src="/wap/Public/Home/img/share.png"></time></a></h4><p>'+data.content[0].article_abstract+'</p>';									   
									   $(".new").html(html);
									   									   
									   }else{
			var html='<li id="'+data.content[i].article_id+'"><div class="text"><h4><a href="#">'+data.content[i].article_title+'</a><time>'+data.content[i].article_publish_time+'</time></h4><p>'+data.content[i].article_abstract+'</p></div><img src="/data/upload/cms/article/'+data.content[i].article_image.path+'/'+data.content[i].article_image.name+'"></li>';				 
			                         $(".list ul").append(html);						   										   										   
										   }							
								
								}
						//js事件
						 $("nav a").click(nav);
						 
						 jQuery(window).scroll(sliderdown);
						 
						 	
						 $(".list li").click(showDetail);			
						  
						 $(".new").click(showDetail);		
						   					 
							  
							  }else{
								  
							alert("this is error");
								  }					
						}				   
				   
				   })
  
   }
   init();
  /*点击显示*/  
	 function nav(){	
	  
	      $("nav a").removeClass("on");
		  
		  $(this).addClass("on"); 
		  	  
		  var id=$(this).attr("id");	
		  
		  $("input[name='cat']").val(id);
		  	  
		  if(id!=80){		  
			   $.ajax({
				    url:"/wap/index.php/Home/News/newsapi",
					type:"post",
					dataType:"json",
					data:{id:id},
					success: function(data){						
						  if(data.code=200){	
						  
						    $(".list ul").html('');
							
							$("input[name='page']").val(1)
						  
						    for(var i=0;i<data.content.length;i++){
								
								   if(i==0){	
			 $(".new").attr("id",data.content[i].article_id)	;				   							   
			var html='<h4 id="'+data.content[i].article_id+'"><a href="#" style="width:75%;"><span style="width:50%;overflow:hidden">'+data.content[0].article_title+'</span><time>'+data.content[0].article_publish_time+'<img src="/wap/Public/Home/img/share.png"></time></a></h4><p>'+data.content[0].article_abstract+'</p>';									   
									   $(".new").html(html);
									   
									  // $(".new p").click(detailShow(111))
									   
									   }else{
			var html='<li id="'+data.content[i].article_id+'"><div class="text"><h4><a href="#">'+data.content[i].article_title+'</a><time>'+data.content[i].article_publish_time+'</time></h4><p>'+data.content[i].article_abstract+'</p></div><img src="/data/upload/cms/article/'+data.content[i].article_image.path+'/'+data.content[i].article_image.name+'"></li>';	
			 
			                         $(".list ul").append(html);
									    $(".new").click(showDetail);							   
										   
										   
										   }							
								
								}
								
							$(".list li").click(showDetail);	
						  
						   					 
							  
							  }else{
								  
							alert("this is error");
								  }					
						}				   
				   
				   })
			  		  
			  }  
		  
		  }	  
		  
	/*下滑显示特效*/	
	
	  function sliderdown(){
		  
		if(parseInt(jQuery(document).scrollTop())>=parseInt(jQuery(document).height())-parseInt(jQuery(window).height())){
			
			var page=$("input[name='page']").val();
			
			var cat=$("input[name='cat']").val();
			
			//alert(page)
			
			$.ajax({
				
				url:"/wap/index.php/Home/News/showMoreApi",
				
				type:"post",
				
				dataType:"json",
				
				data:{id:cat,page:page},
				
				success:function(data){
					
					if(data.code==200){
					
					$("input[name='page']").val(parseInt(page)+parseInt(1));
					
					 for(var i=0;i<data.content.length;i++){
								
			var html='<li id="'+data.content[i].article_id+'"><div class="text"><h4><a href="#">'+data.content[i].article_title+'</a><time>'+data.content[i].article_publish_time+'</time></h4><p>'+data.content[i].article_abstract+'</p></div><img src="/data/upload/cms/article/'+data.content[i].article_image.path+'/'+data.content[i].article_image.name+'"></li>';	
			 
			                         $(".list ul").append(html);
									  					   										   
										   }
										 $(".list li").click(showDetail);	  
										  $(".new").click(showDetail);	 												
				         	}else{
								
								
							    $(".notice").html(data.content);
								
								$(".notice").show();
								
								setTimeout(function(){
									
									$(".notice").hide();
									
									},3000)
							}
					
					
					
					}		
				
				})
			
			
			
		  }
			
        };
		
		/*详细页面*/
		
		function showDetail(){
			
			var id=$(this).attr("id");
			
			$.ajax({
				
				url:"/wap/index.php/Home/News/newsDetailApi",
				type:"post",
				dataType:"json",
				data:{article_id:id},
				success: function(data){
					
					if(data.code==200){
						
						$(".title").html(data.content.article_title);
						
						$(".content").html(data.content.article_content);
						
					
						
						$(".top").show();
						
						$(".detail").slideDown("6000"); 
						
						$(".list").css("opacity","0");
						
						$("#close").click(clickclose);
						
						$(window).scrollTop(0);
						
						var nav=document.getElementById('nav');
	                  window.onscroll=function(){
		              var scrollTop=document.body.scrollTop||document.documentElement.scrollTop;
		                 if(scrollTop<50){
		            	    nav.style.position='fixed';
		           	    nav.style.top=50-scrollTop+'px';
		                   }else{
			              nav.style.top="0px";
		                   }
	                   }
						
						}
						
						/*图片处理,添加大勐海网站图片*/
						
						opertionimage()					
						
						/*end 图片处理*/
					
					
					
					
					}			
				
				})
						
			}
			
	  function clickclose(){
		  
		   
		               $(".top").hide();
						
						$(".detail").slideUp("6000"); 
						
						$(".list").css("opacity","1");
	  
		  
		  }		
		
		  
	 function opertionimage(){
		 
		          var host="http://www.damenghai.com";
		                 $(".content img").each(function(){
                        
						  if(($(this).attr("src").indexOf("120.24.208.42")!=-1)||($(this).attr("src").indexOf("/uploads/allimg")!=-1)){
				
							 var imgsrc=host+$(this).attr("src");
			               $(this).attr("src",imgsrc); 
						    $(this).css("width","97%");							  
							  }else{
							$(this).css("width","97%");	  
								  }
			                 
		                   })
			 
		 }	  
		  
		  
	  
	  })
</script>
</head>
<body>
<header id="header">
<a href="http://www.chahuitong.com/wap"><img src="/wap/Public/Home/img/fanhui.png"></a>资讯<a href="http://www.chahuitong.com/wap"><img src="/wap/Public/Home/img/home.png"></a>
</header>
<header>
<nav>
<a href="/mobile/app/b2b/index.php/News/Index/Home" id="80"><img src="/wap/Public/Home/img/santou.png">山头</a>
<a class="on" href="#" id="89">茶事</a>
<a href="#" id="92">公开课</a>
<input type="hidden" name="page" value="1">
<input type="hidden" name="cat" value="89">
</nav>
<p><a href="#"><img src="/wap/Public/Home/img/zixuntop02.png"></a></p>
<div class="new">
<h4><a href="#" >2015年中国茶行业发展趋势分析</a><time>6th.July<img src="/wap/Public/Home/img/share02.png"></time></h4>
<p>当前，我国茶叶产量、国内销售、茶叶出口都处于历史最好的水平。主要得益于地方政府资金支持。茶叶企业改革不断深入，新的资本进入，茶叶新技术在茶叶生产中得到......</p>
</div></header>
<div class="list">
<ul>

</ul>
</div>
<div class="top" style="opacity: 0.5; position: fixed; top: 0px; right: 0px; width: 100%; height: 40px;z-index: 900; background:#000;display:none"></div>
<div class="detail" style="position:absolute;top:0px;margin-top:40px;left:0px;width:100%;display:none;background:white;z-index:999;overflow:scroll">
<div id="nav" class="head" style="position:fixed;top:50px;"><img id="close" src="/wap/Public/Home/img/close.png"><span class="pic"><img src="/wap/Public/Home/img/sharenews.png"><!--<img src="/wap/Public/Home/img/xin.png">--></span>
</div>

<div class="title" style="overflow:scroll;background:#FFF;padding-top:45px;"></div>

<div class="content" style="overflow:scroll;background:#FFF;padding-top:30px;"></div>

</div>
<div class="notice" style="display:none;position:fixed;top:40%;height:30px;background:#F00;color:white;text-align:center;width:100%;line-height:30px"></div>
</body>
</html>