$(function(){
		var key = getcookie('key');
		if(key==''){
			location.href = 'login.html';
		}
		$.ajax({
			type:'post',
			url:ApiUrl+"/index.php?act=member_index",	
			data:{key:key},
			dataType:'json',
			//jsonp:'callback',
			success:function(result){
				checklogin(result.login);
				$('#username').html(result.datas.member_info.user_name);
				$('#point').html(result.datas.member_info.point);
				$('#predepoit').html(result.datas.member_info.predepoit);
				$('#avatar').attr("src",result.datas.member_info.avator);
				return false;
			}
		});
	//客户退出	
		
	 $(".tuichu").click(function(){
		 		alert('111');		 
		 })	
});