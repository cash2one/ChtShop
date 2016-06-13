<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
<title>发布产品</title>
<link rel="stylesheet" type="text/css" href="/mobile/app/b2b/Public/Home/css/common.css">
<link rel="stylesheet" type="text/css" href="/mobile/app/b2b/Public/Home/css/b2b.css">
<script src="/mobile/app/b2b/Public/Home/js/jquery-1.4.4.min.js"></script>
<script src="/mobile/app/b2b/Public/Home/js/jquery.cookie.js"></script>
<script>
$(document).ready(function() {
	
		var navi = navigator.userAgent;
	if(navi.indexOf("android")!=-1||navi.indexOf("ios")!=-1){
		$("header").hide();
		$(".box_main").css("top","0px");
	}
    
	$("input[name='username']").val($.cookie("username"));
	
	$("input[name='key']").val($.cookie("key"));
	
});
</script>


<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=1, minimum-scale=1.0, maximum-scale=1.0">
<meta charset="utf-8">
<style type="text/css">
header {
  width: 100%;
  height: 45px;
  background: #1b8b80;
  color: #fff;
  font-size: 1.1em;
  line-height: 45px;
  text-align:center;
}
header img {
  width: 25px;
  height: 25px;
  margin-top: 8px;
  padding: 0px 8px;
}
header a:first-child {
  display: block;
  position:absolute;
}
* {
  margin: 0;
  padding: 0;
}
#main{font-size:18px;}
form input{
	height:30px;
	color:#585858;
}
form select{
	height:26px;
}

form textarea{
	
}
</style>
<script type="text/javascript">
function Open_dialog1(){
    document.getElementById("img1").click();
   }    
function Open_dialog2(){
    document.getElementById("img2").click();
   }  
function Open_dialog3(){
    document.getElementById("img3").click();
   }  
   function Open_dialog4(){
    document.getElementById("img4").click();
   }   
   function Open_dialog5(){
    document.getElementById("img5").click();
   } 
   function Open_dialog6(){
    document.getElementById("img6").click();
   } 
function show_search(){
    document.getElementById("header_content_content").style.display="none";
      document.getElementById("search").style.display="block";	
	     
   }
  
function search_del(){
      document.getElementById("search").style.display="none";
	  document.getElementById("header_content_content").style.display="block";
   }	
function tab_show(i){
    var j;
	for(j=1;j<=4;j++){
		 if(i==j){
			 document.getElementById("content_"+j).className="on";
			 document.getElementById("content_detail_"+j).className="content_show";
			 }else{
				document.getElementById("content_"+j).className="off"; 
				document.getElementById("content_detail_"+j).className="content_hidden";
				 }			
		}	   
   } 
</script>
</head>

<body>
<div id="main">
 <header>
<a href="javaScript:window.history.back();"><img src="/mobile/app/b2b/Public/Home/img/xiangzuo.png"></a>发布商品
<!--<a href="/mobile/app/b2b/index.php/Home/Index/search"><img src="/mobile/app/b2b/Public/Home/img/sousuo.jpg"></a>-->
</header>
 <div id="box_main">
   <div class="main_content">
       <div class="buy_sale">
         <div class="on" id="content_1" onclick="tab_show(1)">卖
         </div>
         <div class="off" id="content_2" onclick="tab_show(2)">买
         </div>      
       </div>
       <div class="content_show" id="content_detail_1">
        <form action="<?php echo U('Index/post_save');?>" enctype="multipart/form-data" method="post">
          <ul class="content_ul">
           <li class="content_li">
            <div class="content_li_left">品牌</div>
            <div class="content_li_right"><input name="brand" placeholder="请输入品牌" style="border:none;width:100%" ></div>
           </li>
           <li class="content_li">
             <div class="content_li_left">品名</div>
            <div class="content_li_right"><input name="name" placeholder="请输入品名" style="border:none;width:100%"
            ></div>
           </li>
           <li class="content_li">
             <div class="content_li_left">年份</div>
             <div class="content_li_right"><input type="number" name="year"  style="border:none;background:#fbfbfb;"  min="1970" max="2020" value='2015'/></div>
           </li>
            <li class="content_li">
             <div class="content_li_left">单价</div>
             <div class="content_li_right"><input type="text" name="price" placeholder="请输入价格" style="border:none;width:40%;float:left;" ><div style="width:60%;float:left;text-align:right;color:#585858;" >是否详谈<select name="arrow_order" style="width:40%;border:none;background:none"><option value="1" >是</option><option value="0" selected="selected">否</option></select></div></div>
           </li>
            
           
            <li class="content_li">
             <div class="content_li_left">数量</div>
             <div class="content_li_right"><input type="text" placeholder="请输入重量" name="weight" style="border:none;width:60%;;float:left" ><select name="unit" style="border:none;width:25%;float:right;background:none;text-align:center"><option value="1" selected="selected" >&nbsp;克</option>><option value="2" >两</option><option value="3" >饼</option><option value="4" >盒</option><option value="5" >件</option><option value="6" >片</option><option value="7" >套</option><option value="12" >袋</option><option value="8" >提</option><option value="9" >砖</option><option value="10" >斤</option><option value="11" >公斤</option></select></div>
           </li>
           
            <li class="content_li">
             <div class="content_li_left"><span>货源所在地</span></div>
             <div class="content_li_right"><input type="text" placeholder="请输入所在地" name="address" style="border:none;width:100%;" ></div>
           </li>
             
           <li class="content_li">
             <div class="content_li_left">联系电话</div>
             <div class="content_li_right"><input type="tel" placeholder="请输入手机号码" name="phone" style="border:none;width:90%;" ></div>
           </li>
          </ul>
          <div class="content_detail">
           <textarea name="content" style="width:98%;height:100%;margin:0 auto;" placeholder="产品描述:建议包含产品的信息,如俗称，产地，重量，现货，期货."></textarea>
          </div>
          <div class="add_pic">
           <div class="add_pic_botton"><input type="file" id="img1" name="img1" style="display:none"/><input type="button" name="btn1" onclick="Open_dialog1()" style="background:url(/mobile/app/b2b/Public/Home/img/addpic.png);width:50px;height:50px;border:none"> </div>
            <input type="hidden" name="saleway" value="1">   
           <input type="hidden" name="username" value="">
           <input type="hidden" name="key" value="">     
          </div>
          <div class="post"><input type="submit" value="发布" style="width:100%;height:auto"></div>
          </form>
       </div>
       
       <div class="content_hidden" id="content_detail_2">
           <form action="<?php echo U('Index/post_save');?>" enctype="multipart/form-data" method="post">
          <ul class="content_ul">
           <li class="content_li">
            <div class="content_li_left">品牌</div>
            <div class="content_li_right"><input name="brand" placeholder="请输入品牌" style="border:none;width:100%" onblur="note_click1(this)" onclick="note_click1(this)"></div>
           </li>
           <li class="content_li">
             <div class="content_li_left">品名</div>
            <div class="content_li_right"><input name="name" placeholder="请输入品名" style="border:none;width:100%"
            onblur="note_click2(this)" onclick="note_click2(this)"></div>
           </li>
           <li class="content_li">
             <div class="content_li_left">年份</div>
            <div class="content_li_right"><input type="number" name="year"  style="border:none;background:#fbfbfb"  min="1970" max="2020" value='2015'/></div>
           </li>
           <li class="content_li">
             <div class="content_li_left">单价</div>
             <div class="content_li_right"><input type="text" name="price" placeholder="请输入价格" style="border:none;width:40%;float:left;" ><div style="width:60%;float:left;text-align:right" >是否详谈<select name="arrow_order" style="width:40%;border:none;background:none"><option value="1" >是</option><option value="0" selected="selected">否</option></select></div></div>
           </li>
            <li class="content_li">
             <div class="content_li_left">数量</div>
             <div class="content_li_right"><input type="text" placeholder="请输入重量" name="weight" style="border:none;width:60%;float:left" ><select name="unit" style="border:none;width:25%;float:right;background:none;text-align:center"><option value="1" selected="selected" >&nbsp;克</option>><option value="2" >两</option><option value="3" >饼</option><option value="4" >盒</option><option value="5" >件</option><option value="6" >片</option><option value="7" >套</option><option value="12" >袋</option><option value="8" >提</option><option value="9" >砖</option><option value="10" >斤</option><option value="11" >公斤</option></select></div>
           </li>
             <li class="content_li">
             <div class="content_li_left"><span>货源所在地</span></div>
             <div class="content_li_right"><input type="text" placeholder="请输入所在地" name="address" style="border:none;width:100%;" onblur="note_click3(this);" onclick="note_click3(this)"></div>
           </li>
           
           <li class="content_li">
             <div class="content_li_left">联系电话</div>
             <div class="content_li_right"><input type="text" placeholder="请输入手机号码" name="phone" style="border:none;width:90%;" onblur="note_click7(this);" onclick="note_click7(this)"></div>
           </li>
          </ul>
          <div class="content_detail">
           <textarea name="content" style="width:98%;height:100%;margin:0 auto;" placeholder="产品描述:建议包含产品的信息,如俗称，产地，重量，现货，期货."></textarea>
          </div>
          <div class="add_pic">
           <div class="add_pic_botton"><input type="file" id="img4" name="img1" style="display:none"/><input type="button" name="btn1" onclick="Open_dialog4()" style="background:url(/mobile/app/b2b/Public/Home/img/addpic.png);width:50px;height:50px;border:none"> </div>
           <div class="add_pic_botton"><input type="file" id="img5" name="img2" style="display:none"/><input type="button" name="btn1" onclick="Open_dialog5()" style="background:url(/mobile/app/b2b/Public/Home/img/addpic.png);width:50px;height:50px;border:none"></div>
           <div class="add_pic_botton"><input type="file" id="img6" name="img3" style="display:none"/><input type="button" name="btn1" onclick="Open_dialog6()" style="background:url(/mobile/app/b2b/Public/Home/img/addpic.png);width:50px;height:50px;border:none"></div> 
           <input type="hidden" name="saleway" value="2">  
           <input type="hidden" name="username" value="">   
           <input type="hidden" name="key" value="">     
          </div>
          <div class="post"><input type="submit" value="发布"  style="width:100%;height:auto"></div>
          </form>
       </div>
   </div>
 
 </div>
 

</div>
</body>

</html>