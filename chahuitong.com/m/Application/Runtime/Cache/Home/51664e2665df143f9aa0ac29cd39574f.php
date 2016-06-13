<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
<meta charset="utf-8" />
<title>活动发布</title><meta name="keywords" content="茶汇通,资讯,信息">
<meta name="description" content="茶汇通资讯信息">
<meta content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport">
<link href="/wap/Public/Home/css/shequ/share.css" type="text/css" rel="stylesheet">
<link href="/wap/Public/Home/css/shequ/shequ.css" type="text/css" rel="stylesheet">
<link href="/wap/Public/Home/css/shequ/huodong.css" type="text/css" rel="stylesheet">
<script src="/wap/Public/Home/js/jquery.min.js"></script>
<script src="/wap/Public/Home/js/jquery.cookie.js"></script>
<script>

   $(document).ready(function(){
	   
	   var username=$.cookie("username");
	   
	   var key=$.cookie("key");
	   
	   $("input[name='btn']").click(function(){
		   
		   var i=$("input[name='image']").val();
		   
		   $("input[name='pic"+i+"']").click();	 
		   
		   
		   })
		   
		$(".file").change(function(){
			
		 var i=$("input[name='image']").val();			
		 //生成base64	
        var v = $(this).val();
        var reader = new FileReader();
        reader.readAsDataURL(this.files[0]);
        reader.onload = function(e){
            console.log(e.target.result);
            $('.picvalue'+i+'').val(e.target.result);
        };
		
		 // $(".imageshow1").show();
		
		var objUrl = getObjectURL(this.files[0]) ;
	    console.log("objUrl = "+objUrl) ;
     	if (objUrl) {
		  $(".imageshow"+i+"").attr("src", objUrl) ;
		  
		  $(".imageshow"+i+"").css("display","inline-block") ;

	     }
		 
		 $("input[name='image']").val(i*1+1*1);	
		 
       
	   });   
	   
	   
	   //建立一個可存取到該file的url
       function getObjectURL(file) {
	   var url = null ; 
	   if (window.createObjectURL!=undefined) { // basic
		url = window.createObjectURL(file) ;
	    } else if (window.URL!=undefined) { // mozilla(firefox)
		url = window.URL.createObjectURL(file) ;
	   } else if (window.webkitURL!=undefined) { // webkit or chrome
		url = window.webkitURL.createObjectURL(file) ;
	   }
    	return url ;
     }
	 
	 $(".submit").click(function(){
		 	  
		       var pic1=$("input[name='picvalue1']").val();
			  		  
		       var pic2=$("input[name='picvalue2']").val();
			  
			   var pic3=$("input[name='picvalue3']").val();
			   
			   var pic4=$("input[name='picvalue4']").val();

              var pic5=$("input[name='picvalue5']").val();
			  
			   var pic6=$("input[name='picvalue6']").val();
			   
			   var title=$("input[name='title']").val();
			   		   
			   var content=$(".content").val();

			  
		  $.ajax({
			  
			  url:"/wap/index.php/Home/Discuz/contentSave",
			  
			  dataType:"json",
			  
			  type:"post",
			  
			  data:{username:username,key:key,pic1:pic1,pic2:pic2,pic3:pic3,pic4:pic4,pic5:pic5,pic6:pic6,title:title,content:content},
			  
			  success:function(data){
				  
		      $(".showmsg").html(data.content);

             $(".showmsg").show();

             $("header").css("opacity","0.3");

             $(".mail").css("opacity","0.3");

             setTimeout(function(){

             $(".showmsg").hide();

             $("header").css("opacity","1");

             $(".mail").css("opacity","1");

        	
              },3000);
		
		     if(data.code==200){
				 
				 
			     window.location.href="/wap/index.php/Home/Discuz/index";	   
			   
			     }
				  
				  
				  
				  
				  }
			  
			  
			  
			  
			  
			  
			  })	  
			  		 
		 
		 })
	 
	 
	 
	   
	     
})



</script>
</head>
<body>
<header>
<a href="javaScript:window.history.back();"><img src="/wap/Public/Home/img/fanhui.png"></a>我要发布
<a href="#"><img src="/wap/Public/Home/img/home.png"></a>
</header>
<div class="mail">
<div class="table">
<form action="#" method="post">
<ul>
<li><label>微博主题</label><input type="text" value="" required name="title" placeholder="输入主题"></li>
</ul>
<textarea name="content" cols="" rows="" placeholder="输入您的心声......" class="content"></textarea><br>
<img style="display:none;width:30%;height:90px;clear:both;border:none" class="imageshow1" src="">
<img style="display:none;width:30%;height:90px;clear:both;border:none" class="imageshow2" src="">
<img style="display:none;width:30%;height:90px;clear:both;border:none" class="imageshow3" src="">
<img style="display:none;width:30%;height:90px;clear:both;border:none" class="imageshow4" src="">
<img style="display:none;width:30%;height:90px;clear:both;border:none" class="imageshow5" src="">
<img style="display:none;width:30%;height:90px;clear:both;border:none" class="imageshow6" src="">
<input type="file" name="pic1" value="" style="display:none" class="file">
<input type="hidden" name="picvalue1" value="" class="picvalue1">
<input type="hidden" name="picvalue2" value="" class="picvalue2">
<input type="hidden" name="picvalue3" value="" class="picvalue3">
<input type="hidden" name="picvalue4" value="" class="picvalue4">
<input type="hidden" name="picvalue5" value="" class="picvalue5">
<input type="hidden" name="picvalue6" value="" class="picvalue6">
<input type="file" name="pic2" value="" style="display:none" class="file">
<input type="file" name="pic3" value="" style="display:none" class="file">
<input type="file" name="pic4" value="" style="display:none" class="file">
<input type="file" name="pic5" value="" style="display:none" class="file">
<input type="file" name="pic6" value="" style="display:none" class="file">
<br>
<input type="button" name="btn"  value="+" style="clear:both"><br>
<input type="hidden" name="image" value="1">
<input type="hidden" name="username" value="">
<input type="hidden" name="key" value="">
<input type="button" class="submit" value="发布" style="width:90%;height:36px;margin:30px auto;background:#1b8b80;color:#fff;font-size:1.2em;border-radius:3px;border:none;letter-spacing:1em;">

</form>

</div>
</div>
<div class="showmsg" style="position: fixed; top: 40%; left: 0px; height: 30px; line-height: 30px; color: white; width: 100%; text-align: center; display: none; background: red;"></div>
</body>
</html>