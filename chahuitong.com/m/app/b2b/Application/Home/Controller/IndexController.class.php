<?php
namespace Home\Controller;
use Think\Controller;

/**
 * 首页控制器
 * @autho: Leslie Deng 
 */
class IndexController extends Controller {
	
	public $session=array();
	
	/*客户登陆页面*/
	public function login(){
		
		$this->display();
		
		}	
	/*客户登陆验证*/	
	public function checklogin(){
		
		 /*if(($_POST['username']=='')||($_POST['password']=='')){
			 
			 	 $this->Error('用户名或密码不能为空',"/mobile/user.php"); 
			 }
		 
		 $data['user_name']=trim($_POST['username']);
		 $data['password']=md5(trim($_POST['password']));
		 $user=M("ecs_users");
		 $result=$user->where($data)->find();
		 if($result){			 
			  if($result['checkid']==0){
					  checkChashi()   = $result['user_id'];
                      $_SESSION['user_name'] = $result['user_name'];
                      $_SESSION['email']     = $result['email'];
					 // print_r($result);
				  
				    $this->Error("您暂时未申请加入茶市场,请先加入茶市",__APP__."/Home/index/joinin"); 
				  }else{	
				      // print_r($result);				  
					  $_SESSION['user_chashi']=$result['user_id'];
					  checkChashi()   = $result['user_id'];
                      $_SESSION['user_name'] = $result['user_name'];
                      $_SESSION['email']     = $result['email'];	
					 // print_r($_SESSION);				  
					  $this->success("您已经登陆到茶市，请稍等",__APP__."/Home/index/index");
					  }			 
			 }else{				 
			          $this->Error("用户名或者密码错误","/mobile/user.php");
				 	 }*/
		  			 
					 
		   $sessid=substr($_COOKIE['ECS_ID'],0,32);	

		   $sess=M('ecs_sessions');	
		   
		   $data=$sess->where("sesskey='".$sessid."'")->find();	
		   
	       if($data&&($data['userid']!=0)){
			   
			   $session=unserialize($data['data']);
			   $session['user_id']=$data['userid'];
			   $user=M('ecs_users');
			   $info=$user->where("user_id='".$session['user_id']."'")->find();
			   if($info['checkid']==1){		
			   
			        $_SESSION['user_chashi']=$session['user_id'];
							   
				    $this->success("您已经登陆到茶市，请稍等",__APP__."/Home/index/index");
				   }else{
					   
					 $this->Error("请您先申请加入查市","/mobile/user.php?act=join");   
					   
					   }
			   			   
	   			   }else{
					   
					$this->Error("请您先登陆","/mobile/user.php");   
					   
					   
					   }
					 
		}
		
	/*信息提交页面*/
	public function post(){
		if(!checkChashi()){			
			 $this->Error('您还未登陆或者申请加入茶市',"/mobile/user.php");
			}		
		$this->display();
		
		}	
		
	/*已登陆客户申请加入茶室*/
	public function joinin(){
		
		 $this->display();
	
		}		
	/*
	  *此方法用于跳转到客户端首页
	*/
	public function index(){
			if(!checkChashi()){			
			 $this->Error('您还未登陆或者申请加入茶市',"/mobile/user.php");
			}	
			
		$post=M("ecs_post");
		/*分页*/
		 $count=$post->count();
		 $Page= new \Think\Page($count,10);
		 $show= $Page->show();
		
		if(isset($_GET['order'])&&($_GET['order']==1)){
		$sql="select p.* ,d.content from ecs_post as p left join ecs_post_content as d on p.id=d.pid order by p.id desc limit ".$Page->firstRow.' , '.$Page->listRows;
		$gets=M();
		$all=$gets->query($sql);
		      }else{
		$sql="select p.* ,d.content from ecs_post as p left join ecs_post_content as d on p.id=d.pid order by p.id asc limit ".$Page->firstRow.' , '.$Page->listRows;
		$gets=M();	  
			$all=$gets->query($sql);	  
				  }
		//$sale=$post->order("id desc")->limit(10)->where("saleway=1")->select();
		//$buy=$post->order("id desc")->limit(10)->where("saleway=2")->select();
		$this->assign('page',$show);// 赋值分页输出
		$this->assign("all",$all);
		//$this->assign("sale",$sale);
		//$this->assign("buy",$buy);
		
		$this->display();
	}
	
	public function sale(){
			if(!checkChashi()){			
			 $this->Error('您还未登陆或者申请加入茶市',"/mobile/user.php");
			}	
		$post=M("ecs_post");
		/*分页*/
		 $count=$post->where("saleway='1'")->count();
		 $Page= new \Think\Page($count,10);
		 $show= $Page->show();
		if(isset($_GET['order'])&&($_GET['order']==1)){
			$sql="select p.* ,d.content from ecs_post as p left join ecs_post_content as d on p.id=d.pid where p.saleway='1' order by p.id desc limit ".$Page->firstRow.' , '.$Page->listRows;
		$gets=M();
		$sale=$gets->query($sql);
		      }else{
			$sql="select p.* ,d.content from ecs_post as p left join ecs_post_content as d on p.id=d.pid where p.saleway='1' order by p.id asc limit ".$Page->firstRow.' , '.$Page->listRows;
		$gets=M();	  
			$sale=$gets->query($sql);
				  }
		//$sale=$post->order("id desc")->limit(10)->where("saleway=1")->select();
		//$buy=$post->order("id desc")->limit(10)->where("saleway=2")->select();
		//$this->assign("all",$all);
		$this->assign('page',$show);
		$this->assign("all",$sale);
		//$this->assign("buy",$buy);
		
		$this->display();
	}
	
		public function buy(){
			if(!checkChashi()){			
			 $this->Error('您还未登陆或者申请加入茶市',"/mobile/user.php");
			}	
		$post=M("ecs_post");
		$count=$post->count();
		$Page= new \Think\Page($count,10);
		if(isset($_GET['order'])&&($_GET['order']==1)){
			$sql="select p.* ,d.content from ecs_post as p left join ecs_post_content as d on p.id=d.pid where p.saleway='2' order by p.id desc limit ".$Page->firstRow.' , '.$Page->listRows;
		$gets=M();	 
		$buy=$gets->query($sql);
		      }else{
			$sql="select p.* ,d.content from ecs_post as p left join ecs_post_content as d on p.id=d.pid where p.saleway='2' order by p.id asc limit ".$Page->firstRow.' , '.$Page->listRows;
		$gets=M();	 
		$buy=$gets->query($sql);	  
				  }
		//$sale=$post->order("id desc")->limit(10)->where("saleway=1")->select();
		//$buy=$post->order("id desc")->limit(10)->where("saleway=2")->select();
		//$this->assign("all",$all);
		$this->assign('page',$show);
		$this->assign("all",$buy);
		//$this->assign("buy",$buy);
		
		$this->display();
	}
	
	/*
	 * 信息入库
	 */
	public function post_save(){
		
		
		$post=M("ecs_post");
		/*
		if($_POST['name']==''){
			$this->Error('请输入品牌名',"post");
			
			}
			*/
		
		
		$result=$post->create();
			
			  $time=time();			  
			  $pic='';			  
			  $depic='';			
			  if(is_uploaded_file($_FILES['img1']['tmp_name'])){
				 // echo '12313123123123';
				  $name=$_FILES['img1']["name"];
				  $type=$_FILES['img1']["type"];//上传文件的类型 
                  $size=$_FILES['img1']["size"];//上传文件的大小
				  if($size>(8*1014*1024)){
					  $this->Error('请上传小于2M的图片',"index");					  
					  }
				  switch ($type){ 
                   case 'image/pjpeg':$okType=true; 
                     break; 
				   case 'image/jpg':$okType=true; 
                     break;
                   case 'image/jpeg':$okType=true; 
                     break; 
                   case 'image/gif':$okType=true; 
                    break; 
                   case 'image/png':$okType=true; 
                     break; 
                      } 

					 $imgtype=substr($_FILES['img1']['name'],-3);
					 
					 $newname=$time."_1.".$imgtype;
					 $pic=$time."_1.".$imgtype;
					 $depic.=$time."_1.".$imgtype.',';
					 
					 $result1=move_uploaded_file($_FILES['img1']["tmp_name"],'./Public/upload/'.$newname);	

				  }	
			  if(is_uploaded_file($_FILES['img2']['tmp_name'])){
				  
				  $name=$_FILES['img2']["name"];
				  $type=$_FILES['img2']["type"];//上传文件的类型 
                  $size=$_FILES['img2']["size"];//上传文件的大小
				  if($size>(8*1014*1024)){
					  $this->Error('请上传小于2M的图片',"index");					  
					  }
				  switch ($type){ 
                   case 'image/pjpeg':$okType=true; 
                     break; 
				   case 'image/jpg':$okType=true; 
                     break;	 
                   case 'image/jpeg':$okType=true; 
                     break; 
                   case 'image/gif':$okType=true; 
                    break; 
                   case 'image/png':$okType=true; 
                     break; 
                      } 
					 //$_FILES['img1']["type"]需要浏览器提供该信息的支持,客户端提交的请求无法提供会一直无法通过所有先注掉，文件类型在客户端判断
					//if($okType){
					 $imgtype=substr($_FILES['img2']['name'],-3);
					 
					 $newname=$time."_2.".$imgtype;
					 $depic.=$time."_2.".$imgtype.',';
					 
					 $result2=move_uploaded_file($_FILES['img2']["tmp_name"],'./Public/upload/'.$newname);	
						
						//}
				  }	
			   if(is_uploaded_file($_FILES['img3']['tmp_name'])){
				  
				  $name=$_FILES['img3']["name"];
				  $type=$_FILES['img3']["type"];//上传文件的类型 
                  $size=$_FILES['img3']["size"];//上传文件的大小
				  if($size>(8*1014*1024)){
					  $this->Error('请上传小于2M的图片',"index");					  
					  }
				  switch ($type){ 
                   case 'image/pjpeg':$okType=true; 
                     break; 
				    case 'image/jpg':$okType=true; 
                     break;	 
                   case 'image/jpeg':$okType=true; 
                     break; 
                   case 'image/gif':$okType=true; 
                    break; 
                   case 'image/png':$okType=true; 
                     break; 
                      } 
					//if($okType){
					 $imgtype=substr($_FILES['img3']['name'],-3);
					 
					 $newname=$time."_3.".$imgtype;
					 $depic.=$time."_3.".$imgtype;
					 
					$result3=move_uploaded_file($_FILES['img3']["tmp_name"],'./Public/upload/'.$newname);	
						
						//}
				  }	
				/* if(($result1==false)&&($result2==false)&&($result3==false)){
					 
					 $this->Error('图片上传失败请重新上传',"post");
					 } */
				if(isset($_POST['user_id'])&&is_numeric($_POST['user_id'])) {
			    $post->user_id=$_POST['user_id'];
			    //echo $post->user_id;
		        }else{
		     	$post->user_id=checkChashi();
			    }	 
				$post->pic=$pic;
				$post->addtime=date("Y-m-d H:i");
				$id=$post->add();  				
				$content=M("ecs_post_content");				
				$data['pid']=$id;
				$data['content']=$_POST['content'];
				$data['depic']=$depic;			
				$cid=$content->add($data);	
				
				if($id&&$cid){
					$this->success('新增成功', 'Index/index');
					//$this->redirect("Index/index");
					}

		}	
		
		/*
		 * 个人的发布产品
		 */
	public function myList(){
		   if(!checkChashi()){
			
			 $this->Error('您还未登陆或者申请加入茶市',"/mobile/user.php");
			}
		   $mypost=M('ecs_post');
		   $user_id=checkChashi();
		   $info=$mypost->where("user_id='".$user_id."'")->select();
		   //print_r($info);
		   $this->assign("data",$info);
		   $this->display();
		}	
		
	 /*java上传*/
	 public function java_save(){
		
		
		$post=M("ecs_post");
		/*
		if($_POST['name']==''){
			$this->Error('请输入品牌名',"post");
			
			}
			*/
		
		
		$result=$post->create();
			
			  $time=time();			  
			  $pic='';			  
			  $depic='';			
			  if(is_uploaded_file($_FILES['img1']['tmp_name'])){
				 // echo '12313123123123';
				  $name=$_FILES['img1']["name"];
				  $type=$_FILES['img1']["type"];//上传文件的类型 
                  $size=$_FILES['img1']["size"];//上传文件的大小
				  if($size>(8*1014*1024)){
					  $this->Error('请上传小于2M的图片',"index");					  
					  }
				  switch ($type){ 
                   case 'image/pjpeg':$okType=true; 
                     break; 
				   case 'image/jpg':$okType=true; 
                     break;
                   case 'image/jpeg':$okType=true; 
                     break; 
                   case 'image/gif':$okType=true; 
                    break; 
                   case 'image/png':$okType=true; 
                     break; 
                      } 

					 $imgtype=substr($_FILES['img1']['name'],-3);
					 
					 $newname=$time."_1.".$imgtype;
					 $pic=$time."_1.".$imgtype;
					 $depic.=$time."_1.".$imgtype.',';
					 
					 $result1=move_uploaded_file($_FILES['img1']["tmp_name"],'./Public/upload/'.$newname);	

				  }	
			  if(is_uploaded_file($_FILES['img2']['tmp_name'])){
				  
				  $name=$_FILES['img2']["name"];
				  $type=$_FILES['img2']["type"];//上传文件的类型 
                  $size=$_FILES['img2']["size"];//上传文件的大小
				  if($size>(8*1014*1024)){
					  $this->Error('请上传小于2M的图片',"index");					  
					  }
				  switch ($type){ 
                   case 'image/pjpeg':$okType=true; 
                     break; 
				   case 'image/jpg':$okType=true; 
                     break;	 
                   case 'image/jpeg':$okType=true; 
                     break; 
                   case 'image/gif':$okType=true; 
                    break; 
                   case 'image/png':$okType=true; 
                     break; 
                      } 
					 //$_FILES['img1']["type"]需要浏览器提供该信息的支持,客户端提交的请求无法提供会一直无法通过所有先注掉，文件类型在客户端判断
					//if($okType){
					 $imgtype=substr($_FILES['img2']['name'],-3);
					 
					 $newname=$time."_2.".$imgtype;
					 $depic.=$time."_2.".$imgtype.',';
					 
					 $result2=move_uploaded_file($_FILES['img2']["tmp_name"],'./Public/upload/'.$newname);	
						
						//}
				  }	
			   if(is_uploaded_file($_FILES['img3']['tmp_name'])){
				  
				  $name=$_FILES['img3']["name"];
				  $type=$_FILES['img3']["type"];//上传文件的类型 
                  $size=$_FILES['img3']["size"];//上传文件的大小
				  if($size>(8*1014*1024)){
					  $this->Error('请上传小于2M的图片',"index");					  
					  }
				  switch ($type){ 
                   case 'image/pjpeg':$okType=true; 
                     break; 
				    case 'image/jpg':$okType=true; 
                     break;	 
                   case 'image/jpeg':$okType=true; 
                     break; 
                   case 'image/gif':$okType=true; 
                    break; 
                   case 'image/png':$okType=true; 
                     break; 
                      } 
					//if($okType){
					 $imgtype=substr($_FILES['img3']['name'],-3);
					 
					 $newname=$time."_3.".$imgtype;
					 $depic.=$time."_3.".$imgtype;
					 
					$result3=move_uploaded_file($_FILES['img3']["tmp_name"],'./Public/upload/'.$newname);	
						
						//}
				  }	
				/* if(($result1==false)&&($result2==false)&&($result3==false)){
					 
					 $this->Error('图片上传失败请重新上传',"post");
					 } */
				if(isset($_POST['user_id'])&&is_numeric($_POST['user_id'])) {
			    $post->user_id=$_POST['user_id'];
			    //echo $post->user_id;
		        } 
				$post->pic=$pic;
				//$post->addtime=date("Y-m-d H:i");
				$id=$post->add();  				
				$content=M("ecs_post_content");				
				$data['pid']=$id;
				//$data['content']=$_POST['content'];
				$data['depic']=$depic;			
				$cid=$content->add($data);	
				if($id&&$cid){
					$this->success('新增成功', 'Index/index');
					//$this->redirect("Index/index");
					}
		}	
		
		
		/*
		 * 产品详情页
		 */
		 
	public function info(){
	    	
		if(!checkChashi()){
			
			 $this->Error('您还未登陆或者申请加入茶市',"/mobile/user.php");
			}
		 $id=isset($_GET['id'])&&is_numeric($_GET['id'])? $_GET['id']:1;
		 
		 
		 $post_content=M('');
		 
		 $sql="select c.id,c.addtime,c.brand,c.name,c.year,c.address,c.price,c.weight,c.unit,c.timeout,c.phone,c.saleway,d.depic,d.content from `ecs_post` as c left join `ecs_post_content` as d on c.id=d.pid where c.id='$id'";
		 
		 $detail=$post_content->query($sql);
		 
		 $detail=$detail[0];
		 
		// print_r($detail);
		 
		 if($detail['depic']!=''){
			 
			  $array=explode(',',$detail['depic']);
			 // print_r($array);
			  
			  if(isset($array[0])&&($array[0]!='')){
				  
				  $detail['img'][]=$array[0];
				  }
			  if(isset($array[1])&&($array[1]!='')){
				  
				  $detail['img'][]=$array[1];
				  }	 
			  if(isset($array[2])&&($array[2]!='')){
				  
				  $detail['img'][]=$array[2];
				  }		   		  
			 }
		//print_r($detail);	 
			 
		$this->assign('detail',$detail);	 
		$this->display();
		}	
		
		/*联系买卖人员*/
		
		function contact(){			
			if(!checkChashi()){			
			 $this->Error('您还未登陆或者申请加入茶市',"/mobile/user.php");
			}
			
			 $id=isset($_GET['id'])&&is_numeric($_GET['id'])? $_GET['id']:1;
			 
			 $post=M("ecs_post");
			 
			 $detail=$post->where("id=".$id)->find();
			 
			 $this->assign('detail',$detail);
			 
			 $this->assign('cid',checkChashi());
			 
			  $this->assign('fid',checkChashi());
             
			 $this->display(); 
			    		
			}
		/*保存客户买卖交易留言*/
		public function newssave(){
			
			if(!checkChashi()){			
			 $this->Error('您还未登陆或者申请加入茶市',"/mobile/user.php");
			}
			if($_POST['uid']==$_POST['cid']){				
				$this->Error('抱歉这是您自己产品不需要留言',__APP__."/Home/index/index");
										
				}
			
			 $data['title']=$_POST['title'];
			 
			 $data['content']=$_POST['content'];
			 
			 $data['uid']=$_POST['uid'];
			 
			 $data['cid']=$_POST['cid'];
			 
			 $data['pid']=$_POST['pid'];
			 $data['fid']=$_POST['fid'];
			 
			 $data['addtime']=date("Y-m-d H:i:s");
			 
			 $news=M("ecs_post_news");
			 
			 $result=$news->add($data);
			 
			 if($result){
				
				$this->success('提交成功',__APP__.'/Home/index/news'); 
				 
				 }else{
					 
					 $this->error('提交失败',__APP__.'/Home/index/info/id/'.'/'.$_POST['pid']);
					 
					 }
		
			}	
			/*个人接受到的新信息*/
		
	 public function news(){
		   if(!checkChashi()){
			
			 $this->Error('您还未登陆或者申请加入茶市',"/mobile/user.php");
			}
		 
		 $uid=checkChashi();		 
		 $news=M('');
		 
		 /*$sql="select cid,pid,sum(isRead) as readed,count(*) as total from ecs_post_news where uid ='".checkChashi()."' group by pid";*/
		 
		 $sql="select cid,pid,sum(isRead) as readed,count(*) as total from ecs_post_news where uid ='".checkChashi()."' or cid='".checkChashi()."' group by pid";
		 
		 $newslist= $news->query($sql);
	 
		  //print_r($newslist);
		  
		  $this->assign('own',checkChashi());
		 
		  $this->assign('newslist',$newslist);
		  
		  $this->assign('httpinfo', $_SERVER['HTTP_USER_AGENT']);
	 
		  $this->display();		
		 
		 }	
		 
		/*查看某个产品的不同客户的留言*/ 
		
		 function newslist(){

			$cid=isset($_GET['cid'])&& is_numeric($_GET['cid'])? intval($_GET['cid']):1;
			$pid=isset($_GET['pid'])&& is_numeric($_GET['pid'])? intval($_GET['pid']):1;
			 
			$news=M("ecs_post_news");
			$uid=checkChashi();
			
			$newslist=$news->where("pid='$pid' and (cid='$cid' or cid='$uid') ")->order("id asc")->limit(10)->select();
			
			$post=M('ecs_post');
			
			$postinfo=$post->where("id='$pid'")->find();
			
			//print_r($postinfo);
			
			$this->assign('cid',$cid);
			
			$this->assign('own',checkChashi());
			
			$this->assign('pid',$pid);
			
			$this->assign('uid',$postinfo['user_id']);
			
			$this->assign('newslist',$newslist);
			
			$this->display();
		 
			 }
		/*消息页面详细内容*/	
		
		public  function newsdetail(){
			
			 $id=isset($_GET['id'])&& is_numeric($_GET['id'])? intval($_GET['id']):1;
			 		 
			 
			 $news=M("ecs_post_news");
			 
			 $data['isRead']=1;
			 
			 $news->where("id=$id")->save($data);
			 
			 $info=$news->where("id=$id")->find();
			 
			 $this->assign('own',checkChashi());
			 
			 $this->assign('info',$info);
			 
			 $this->display();
		
			
			} 
			
	   /*回复个人消息*/	
	   public  function reply(){
		   
		   if(!checkChashi()){			
			 $this->Error('您还未登陆或者申请加入茶市',"/mobile/user.php");
			}
			
			 $pid=isset($_GET['pid'])&&is_numeric($_GET['pid'])? $_GET['pid']:1;
			 
			 $fid=isset($_GET['fid'])&&is_numeric($_GET['fid'])? $_GET['fid']:1;
			 
			 $news=M("ecs_post_news");
			 
			 $detail=$news->where("id=".$fid)->find();
			 
			 $this->assign('detail',$detail);

		 	 $this->assign('pid',$pid);
			 
			 $this->assign('fid',$fid);
			 
			 $this->assign('uid',checkChashi());
             
			 $this->display(); 
   
		   
		   }	
			
	
		
		/*
		 * 删除个人发布的产品
		 */
		public function delete(){
			if(!checkChashi()){
			
			 $this->Error('您还未登陆或者申请加入茶市',"/mobile/user.php");
			}
			$id=$_GET["id"];
		    $post=M('ecs_post');
		    $post_content=M('ecs_post_content');
		    $result=$post->where("id='$id'")->delete();		  
		    if($result!=false){
				//$post_content->where("pid=$id")->delete();
				echo 1;		    	
		    }else{
		    		echo -1;
		    }
		}
		
	public function search(){
		
		if(!checkChashi()){
			
			 $this->Error('您还未登陆或者申请加入茶市',"/mobile/user.php");
			}
		
		$this->display();
		
		}	
    public function find(){
		
		if(!checkChashi()){
			
			 $this->Error('您还未登陆或者申请加入茶市',"/mobile/user.php");
			}
		
		$key=trim($_POST['key']);
		
		$search=M();
		
		$sql="select c.* from `ecs_post` as c left join `ecs_post_content` as d on c.id=d.pid where c.name like '%$key%' or c.brand like '%$key%' or d.content like '%$key%' ";
		
		$result=$search->query($sql);
		
		$this->assign('data',$result);
		
		$this->display();
		
		
		
		}		
		
	public function api(){	   
	   
	       $cookie=addslashes($_POST['cookie']);
		 
		   $sessid=substr($cookie,0,32);	

		   $sess=M('ecs_sessions');	
		   
		   $data=$sess->where("sesskey='".$sessid."'")->find();	
		   
	       if($data&&($data['userid']!=0)){
			   
			   $session=unserialize($data['data']);
			   $session['user_id']=$data['userid'];
			   $user=M('ecs_users');
			   $info=$user->where("user_id='".$session['user_id']."'")->find();
			   
			   echo json_encode($info);
			  			   			   
	   		} else {					   
				echo "";   					   
			}   
	   
	   }	
	  
	 public function homeapi(){
		 
		  $saleway=isset($_POST['saleway'])&&is_numeric($_POST['saleway'])?$_POST['saleway']:0;
		  
		  $page=isset($_POST['page'])&&is_numeric($_POST['page'])?$_POST['page']:1;
		  
		  $sort=isset($_POST['sort'])&&is_numeric($_POST['sort'])?$_POST['sort']:1;
		  
		  $post=M("ecs_post");
		  
		  $where='';
		  
		  if($saleway==1){
			  $where="saleway='1'";
			  }elseif($saleway==2){
				  
			 $where="saleway='2'";	  
			 }elseif($saleway==0){
				 
			$where="saleway='2' or saleway='1'"; 
				 }
		  if($sort==1){
			  $order="order by id asc ";
			  }elseif($saleway==2){
				  
			  $order="order by id desc ";  
			 }	 
		  $count=$post->where($where)->count();	
		  
		  $sql="select p.* ,d.depic,d.content from ecs_post as p left join ecs_post_content as d on p.id=d.pid where $where $order  limit ".(($page-1)*10).",10";
		  
		  $m=M();
		  
		 $data=$m->query($sql);
		 
		 $array=array();
		 
		 $array['total']=$count;
		 $array['data']=$data;
		 
		 echo json_encode($array);
	 		 
		 }  
		 			
	public function myListapi(){
		
		
		   $cookie=addslashes($_POST['cookie']);
		 
		   $sessid=substr($cookie,0,32);	

		   $sess=M('ecs_sessions');	
		   
		   $data=$sess->where("sesskey='".$sessid."'")->find();	
		   
	       if($data&&($data['userid']!=0)){
			   
			   $session=unserialize($data['data']);
			   $session['user_id']=$data['userid'];
			   
			   $sql="select p.*,d.depic,d.content from ecs_post as p left join ecs_post_content as d on p.id=d.pid where user_id='".$session['user_id']."'";
		  
		       $m=M();
		  
		       $data=$m->query($sql);
			   
			   echo json_encode($data);
			  	   		   					   
			}   
		
		}
		
	/*个人信息列表api*/
	
	public function newapi(){
		
		 $userid=isset($_POST['userid'])&&is_numeric($_POST['userid'])?$_POST['userid']:1;
		
		 $news=M('');
		 
		 /*$sql="select cid,pid,sum(isRead) as readed,count(*) as total from ecs_post_news where uid ='".checkChashi()."' group by pid";*/
		 
		 $sql="select cid,pid,sum(isRead) as readed,count(*) as total from ecs_post_news where uid ='".$userid."' or cid='".$userid."' group by pid";
		 
		 $newslist= $news->query($sql);
		 
		 $array=array();
		 
		 $post=M('ecs_post');
		 
		 foreach($newslist as $v){
			 
			 $info=$post->where("id='".$v['pid']."'")->find();
			 
			 $v['pic']=$info['pic'];
			 
			 $array[]=$v;
			 
			 }
		 
		 
		 echo json_encode($array);
		
		
		}	
		
		public function deleteapi(){
			
			$id=isset($_POST["id"])&&is_numeric($_POST['id'])?$_POST['id']:1;
		    $post=M('ecs_post');
		    $post_content=M('ecs_post_content');
		    $result=$post->where("id='$id'")->delete();		  
		    if($result!=false){
				//$post_content->where("pid=$id")->delete();
				echo 1;		    	
		    }else{
		    		echo 0;
		    }
		}
	
		 function newslistapi(){

			$cid=isset($_POST['cid'])&& is_numeric($_POST['cid'])? intval($_POST['cid']):1;
			$pid=isset($_POST['id'])&& is_numeric($_POST['id'])? intval($_POST['id']):1;
			$userid=isset($_POST['userid'])&& is_numeric($_POST['userid'])? intval($_POST['userid']):1;
			 
			$news=M("ecs_post_news");
			
			$uid=$userid;
			
			$newslist=$news->where("pid='$pid' and (cid='$cid' or cid='$uid') ")->order("id asc")->limit(10)->select();
			
			echo json_encode($newslist);
		
		 
			 }	
		
		
	/*保存客户买卖交易留言*/
		public function newssaveapi(){
			
			/**/
			$id=isset($_POST['id'])&&is_numeric($_POST['id'])?$_POST['id']:1;
			
			$post=M("ecs_post");
			
			$info=$post->where("id='$id'")->find();		
			
			$userid=$info['user_id'];	
		
			
			 $data['title']=$_POST['title'];
			 
			 $data['content']=$_POST['content'];
			 
			 $data['uid']=$userid;
			 
			 $data['cid']=$_POST['userid'];
			 
			 $data['pid']=$_POST['id'];
			 
			 $data['fid']=$_POST['userid'];
			 
			 $data['addtime']=date("Y-m-d H:i:s");
			 
			 $news=M("ecs_post_news");
			 
			 $result=$news->add($data);
			 
			 if($result){
				
				echo 1;
				 
				 }else{
					 
					 echo 0;
					 
					 }
		
			}	
			
	public function testtest(){
		
	      	$id=351;
			
			$post=M("ecs_post");
			
			$info=$post->where("id='$id'")->find();	
		
		   print_r($info);
		
		}		
		
	public function uploadImage() {
		$filename = date("YmdHis");
		$file = fopen('./Public/upload/' . $filename . ".jpg", "w");
		$data = base64_decode($_POST['img']);
		fwrite($file, $data);
		fclose($file);
		
		echo $_POST['img'];
	}	
		
		
		
		
}
