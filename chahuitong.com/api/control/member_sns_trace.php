<?php
/**
 * Created by PhpStorm.
 * User: Sgun
 * Date: 16/5/25
 * Time: 下午3:40
 */
class member_sns_traceControl extends mobileMemberSNSControl {

    public function __construct() {
        parent::__construct();
    }

    /**
     * 查询关注的动态列表
     */
    public function trace_listOp() {
        $tracelog_model = Model('sns_tracelog');
        $condition = array();
        $condition['trace_memberid'] = $this->master_id;
        $condition['trace_state'] = "0";
        $condition['trace_originalid'] = '0'; // 原创

        $file = 'trace_id,trace_originalid,trace_memberid,trace_membername,trace_memberavatar,trace_title,trace_image,trace_addtime,trace_state,trace_privacy,trace_commentcount,trace_likecount';

        $page = new Page();
        $page->setEachNum($this->page);
        $page->setStyle('admin');
        $trace_list = $tracelog_model->getTracelogList($condition, $page, $file);

        $page_count = $page->getTotalPage();

        output_json(1, array('list' => $this->_get_list_extend($trace_list)), 'SUCCESS', mobile_page($page_count));
    }

    /**
     * 一条SNS动态及其评论
     */
    public function trace_detailOp(){
        $id = intval(empty($_GET['id']) ? $_POST['id'] : $_GET['id']);
        if ($id <= 0) output_json(0, array(), '参数错误');

        //查询动态详细
        $tracelog_model = Model('sns_tracelog');
        $condition = array();
        $condition['trace_id'] = $id;
        $condition['trace_privacy'] = 0;
        $condition['trace_state'] = 0;
        $trace_info = $tracelog_model->getTracelogRow($condition);
        if (empty($trace_info)) output_json(0, array(), '动态已被删除');

        // 处理头像
        $trace_info['trace_memberavatar'] = getMemberAvatar($trace_info['trace_memberavatar']);

        // 图片信息
        $model_trace_image = Model('sns_albumpic');
        $image_list = $model_trace_image->where(array('item_id' => $id))->select();
        foreach ($image_list as $key=>$image) {
            $image_list[$key]['thumb_mid'] = snsThumb($image['ap_cover']);
            $image_list[$key]['thumb_max'] = snsThumb($image['ap_cover'], '1024');
        }
        $trace_info['trace_image_list'] = $image_list;
        $trace_info['trace_image'] = snsThumb($trace_info['trace_image']);;

        // 与主人的关系。0-游客(未登录);1-未关注;2-互相关注;3-自己;4-已关注
        $trace_info['relation'] = $this->_check_relation($trace_info['trace_memberid']);
        $trace_info['trace_addtime'] = date('Y.m.d H:i', $trace_info['trace_addtime']);
        // 处理@信息
        $trace_info['trace_title'] = str_replace("%siteurl%", "com.cht.user://".DS, $trace_info['trace_title']);
        $trace_info['trace_content'] = str_replace("%siteurl%", "com.cht.user://".DS, $trace_info['trace_content']);

        // 查询点赞状态
        $model_like = Model('sns_like');
        $like_info = $model_like->getLikeInfo(array(
            'like_memberid' => $this->member_info['member_id'],
            'like_originalid' => $trace_info['trace_id'],
            'like_originaltype' => 0,
            'like_state' => 0
        ));
        if (empty($like_info)) $trace_info['is_like'] = false;
        else $trace_info['is_like'] = true;

        // 查询评论列表
        $trace_info['comment_list'] = $this->_get_comment_list($id);

        output_json(1, $trace_info);
    }

    /**
     * 添加新动态
     */
    public function trace_addOp() {
        /**
         * 清除前一天冗余图片数据
         */
        $model_upload = Model('sns_albumpic');
        $upload_condition = array();
        $upload_condition['member_id']		= $this->member_info['member_id'];
        $upload_condition['ap_type']	    = 0;
        $upload_condition['item_id']		= 0;
        $upload_condition['upload_time']	= array('lt', time()-24*60*60);
        $model_upload->delete($upload_condition);
        unset($upload_condition);

        $obj_validate = new Validate();
        $validate_arr[] = array("input"=>$_POST['content'], "require"=>'true', "message"=>'输入内容不能空');
        $obj_validate -> validateparam = $validate_arr;
        $error = $obj_validate -> validate();
        if ($error != '') output_json(0, 0, $error);

        $tracelog_model = Model('sns_tracelog');
        $insert_arr = array();
        $insert_arr['trace_originalid'] = '0';
        $insert_arr['trace_originalmemberid'] = '0';
        $insert_arr['trace_memberid'] = $this->member_info['member_id'];
        $insert_arr['trace_membername'] = $this->member_info['member_name'];
        $insert_arr['trace_memberavatar'] = $this->member_info['member_avatar'];
        $insert_arr['trace_title'] = $_POST['content'];
        $insert_arr['trace_content'] = '';
        $insert_arr['trace_addtime'] = time();
        $insert_arr['trace_state'] = '0';
        $insert_arr['trace_privacy'] = intval($_POST["privacy"])>0?intval($_POST["privacy"]):0;
        $insert_arr['trace_commentcount'] = 0;
        $insert_arr['trace_copycount'] = 0;
        $result = $tracelog_model->tracelogAdd($insert_arr);
        if ($result) {
            /**
             * 更新闲置物品多图
             */
            $upload_condition = array();
            $upload_condition['member_id']  = $this->member_info['member_id'];
            $upload_condition['item_id']    = 0;
            $upload_condition['ap_type']    = 0;
//            $upload_array['upload_id_in']	= "'".implode("','", $_POST['goods_file_id'])."'";
            $model_upload->where($upload_condition)->update(array('item_id'=>$result));

            /**
             * 商品封面图片修改
             */
            if(!empty($_POST['image_id'])) {
                $image_info	= $model_upload->where(array('ap_id'=>intval($_POST['image_id'])))->find();
                $tracelog_model->tracelogEdit(array('trace_image'=>$image_info['ap_cover']), array('trace_id' => $result));
            }

            output_json(1, $result);
        } else {
            output_json(0, 0, '发表失败,请稍后重试');
        }
    }

    public function trace_image_uploadOp() {
        /**
         * 相册
         */
        $model = Model();
        $default_class = $model->table('sns_albumclass')->where(array('member_id'=>$this->member_info['member_id'], 'ap_type'=>0))->find();
        if(empty($default_class)){	// 验证时候存在买家秀相册，不存在添加。
            $default_class = array();
            $default_class['ac_name']		= Language::get("sns_trace");
            $default_class['member_id']		= $this->member_info['member_id'];
            $default_class['ac_des']		= Language::get('sns_trace_album_des');
            $default_class['ac_sort']		= '255';
            $default_class['is_default']	= 0;
            $default_class['ap_type']	    = 0;
            $default_class['upload_time']	= TIMESTAMP;
            $default_class['ac_id']			= $model->table('sns_albumclass')->insert($default_class);
        }

        /**
         * 上传图片
         */
        $upload = new UploadFile();
        $upload_dir = ATTACH_MALBUM.DS.$this->member_info['member_id'].DS;

        $upload->set('default_dir',$upload_dir.$upload->getSysSetPath());
        $thumb_width	= '640,1024';
        $thumb_height	= '2048,1024';
        $upload->set('max_size',C('image_max_filesize'));
        $upload->set('thumb_width', $thumb_width);
        $upload->set('thumb_height',$thumb_height);
        $upload->set('fprefix',$this->member_info['member_id']);
        $upload->set('thumb_ext', '_640,_1024');
        $result = $upload->upfile('image');
        if (!$result) output_json(0, 0, '上传失败');

        $img_path = $upload->getSysSetPath().$upload->file_name;
        list($width, $height, $type, $attr) = getimagesize(BASE_UPLOAD_PATH.DS.ATTACH_MALBUM.DS.$this->member_info['member_id'].DS.$img_path);

        $insert = array();
        $insert['ap_name']		= $img_path;
        $insert['ac_id']		= $default_class['ac_id'];
        $insert['ap_cover']		= $img_path;
        $insert['ap_size']		= intval($_FILES[trim($_POST['image'])]['size']);
        $insert['ap_spec']		= $width.'x'.$height;
        $insert['upload_time']	= TIMESTAMP;
        $insert['member_id']	= $this->member_info['member_id'];
        $insert['ap_type']		= 0;
        $insert['item_id']		= intval($_POST['item_id']);

        $result = $model->table('sns_albumpic')->insert($insert);
        if ($result) {
            output_json(1, $result);
        } else {
            output_json(0, $insert, '更新数据库失败');
        }

    }

    /**
     * 删除动态
     */
    public function trace_delOp(){
        $id = intval(empty($_GET['id']) ? $_POST['id'] : $_GET['id']);
        if ($id <= 0) output_json(0, array(), '参数错误');

        $tracelog_model = Model('sns_tracelog');
        //删除动态
        $condition = array();
        $condition['trace_id'] = $id;
        $condition['trace_memberid'] = $this->member_info['member_id'];
        $result = $tracelog_model->delTracelog($condition);
        if ($result){
            //修改该动态的转帖信息
            $tracelog_model->tracelogEdit(array('trace_originalstate'=>'1'),array('trace_originalid'=>"$id"));
            //删除对应的评论
            $comment_model = Model('sns_comment');
            $condition = array();
            $condition['comment_originalid'] = "$id";
            $condition['comment_originaltype'] = "0";
            $comment_model->delComment($condition);
            output_json(1, $result, '删除成功');
        } else {
            output_json(0, array(), '删除失败');
        }
    }

    /**
     * 评论列表
     */
    public function comment_listOp(){
        $id = intval(empty($_GET['id']) ? $_POST['id'] : $_GET['id']);
        if ($id <= 0) output_json(0, array(), '参数错误');

        //评价列表
        $comment_list = $this->_get_comment_list($id);
        $comment_model = Model('sns_comment');
        $page_count = $comment_model->gettotalpage();

        output_json(1, array('list' => $comment_list), 'SUCCESS', mobile_page($page_count));
    }

    /**
     * 添加评论
     */
    public function comment_addOp() {
        $id = intval(empty($_GET['id']) ? $_POST['id'] : $_GET['id']);
        if ($id <= 0) output_json(0, array(), '参数错误');

        $content = $_POST['content'];

        $obj_validate = new Validate();
        $validate_arr[] = array("input"=>$content, "require"=>"true","message"=>'评论不能空');
        $validate_arr[] = array("input"=>$content, "validator"=>'Length',"min"=>0,"max"=>140,"message"=>'评论不能超过140个中文字符');
        $obj_validate -> validateparam = $validate_arr;
        $error = $obj_validate->validate();
        if ($error != ''){
            output_json(0, array(), $error);
        }

        //查询原信息
        $model_trace = Model('sns_tracelog');
        $trace_info = $model_trace->getTracelogRow(array('trace_id'=>"{$id}",'trace_state'=>'0'));
        if (empty($trace_info)) output_json(0, array(), '动态已不存在');

        $comment_model = Model('sns_comment');
        $insert_arr = array();
        $insert_arr['comment_memberid'] = $this->member_info['member_id'];
        $insert_arr['comment_membername'] = $this->member_info['member_name'];
        $insert_arr['comment_memberavatar'] = $this->member_info['member_avatar'];
        $insert_arr['comment_originalid'] = $id;
        $insert_arr['comment_originaltype'] = 0;
        $insert_arr['comment_content'] = $content;
        $insert_arr['comment_addtime'] = time();
        $insert_arr['comment_ip'] = getIp();
        $insert_arr['comment_state'] = '0'; //正常
        $result = $comment_model->commentAdd($insert_arr);
        if ($result){
            $insert_arr['comment_id'] = $result;
            $insert_arr['comment_memberavatar'] = getMemberAvatarForID($this->member_info['member_id']);
            $insert_arr['comment_addtime'] = date('Y.m.d H:i', $insert_arr['comment_addtime']);

            // 发送消息
            if ($trace_info['trace_memberid'] != $this->member_info['member_id']) {
                $insert = array();
                $insert['member_id'] = $trace_info['trace_memberid'];
                $insert['to_member_name'] = $trace_info['trace_membername'];
                $insert['msg_content'] = $content;
                $insert['message_type'] = 4;
                $insert['item_id'] = $trace_info['trace_id'];
                $this->_send_msg($insert);
            }

            //更新动态统计信息
            $update_arr = array();
            $update_arr['trace_commentcount'] = array('sign'=>'increase','value'=>'1');
            if (intval($trace_info['trace_originalid']) == 0){
                $update_arr['trace_orgcommentcount'] = array('sign'=>'increase','value'=>'1');
            }
            $model_trace->tracelogEdit($update_arr,array('trace_id'=>"$id"));
            unset($update_arr);
            //更新所有转帖的原帖评论次数
            if (intval($trace_info['trace_originalid']) == 0){
                $model_trace->tracelogEdit(array('trace_orgcommentcount'=>$trace_info['trace_orgcommentcount']+1),array('trace_originalid'=>"$id"));
            }

            output_json(1, $insert_arr);
        }

        output_json(0, array(), '添加失败');
    }

    /**
     * 添加评论
     */
    public function comment_replyOp() {
        $id = intval(empty($_GET['id']) ? $_POST['id'] : $_GET['id']);
        if ($id <= 0) output_json(0, array(), '参数错误');

        $content = $_POST['content'];

        $obj_validate = new Validate();
        $validate_arr[] = array("input"=>$content, "require"=>"true","message"=>'评论不能空');
        $validate_arr[] = array("input"=>$content, "validator"=>'Length',"min"=>0,"max"=>140,"message"=>'评论不能超过140个中文字符');
        $obj_validate -> validateparam = $validate_arr;
        $error = $obj_validate->validate();
        if ($error != '') output_json(0, array(), $error);

        $comment_model = Model('sns_comment');
        $comment_info = $comment_model->getCommentRow(array('comment_id'=>"{$id}",'comment_state'=>'0'));
        if (empty($comment_info)) output_json(0, array(), '评论已删除');

        $model_member = Model('member');
        $member_info = $model_member->getMemberInfoByID($comment_info['comment_memberid'], 'member_id, member_name');

        $insert_arr = array();
        $insert_arr['comment_memberid'] = $this->member_info['member_id'];
        $insert_arr['comment_membername'] = $this->member_info['member_name'];
        $insert_arr['comment_memberavatar'] = $this->member_info['member_avatar'];
        $insert_arr['comment_originalid'] = $comment_info['comment_originalid'];
        $insert_arr['comment_originaltype'] = 0;
        $insert_arr['comment_content'] = $content;
        $insert_arr['comment_reply_id'] = $id;
        $insert_arr['comment_addtime'] = time();
        $insert_arr['comment_ip'] = getIp();
        $insert_arr['comment_state'] = '0'; //正常
        $result = $comment_model->commentAdd($insert_arr);
        if ($result){
            $insert_arr['comment_id'] = $result;
            $insert_arr['comment_memberavatar'] = getMemberAvatarForID($this->member_info['member_id']);
            $insert_arr['comment_addtime'] = date('Y.m.d H:i', $insert_arr['comment_addtime']);

            // 发送消息
            if ($member_info['member_id'] != $this->member_info['member_id']) {
                $insert = array();
                $insert['member_id'] = $member_info['member_id'];
                $insert['to_member_name'] = $member_info['member_name'];
                $insert['msg_content'] = $content;
                $insert['message_type'] = 4;
                $insert['item_id'] = $comment_info['comment_id'];
                $this->_send_msg($insert);
            }

            //更新动态统计信息
            $update_arr = array();
            $update_arr['trace_commentcount'] = array('sign'=>'increase','value'=>'1');
            if (intval($comment_info['trace_originalid']) == 0){
                $update_arr['trace_orgcommentcount'] = array('sign'=>'increase','value'=>'1');
            }
            $model_trace = Model('sns_tracelog');
            $model_trace->tracelogEdit($update_arr,array('trace_id'=> $comment_info['comment_originalid']));
            unset($update_arr);
            //更新所有转帖的原帖评论次数
            if (intval($comment_info['trace_originalid']) == 0){
                $model_trace->tracelogEdit(array('trace_orgcommentcount'=>$comment_info['trace_orgcommentcount']+1),array('trace_originalid'=>$comment_info['comment_originalid']));
            }

            output_json(1, $insert_arr);
        }

        output_json(0, array(), '添加失败');
    }

    /**
     * 删除评论
     */
    public function comment_delOp() {
        $id = intval(empty($_GET['id']) ? $_POST['id'] : $_GET['id']);
        if ($id <= 0) output_json(0, array(), '参数错误');

        //查询评论信息
        $comment_model = Model('sns_comment');
        $comment_info = $comment_model->getCommentRow(array('comment_id'=>$id,'comment_memberid'=>$this->member_info['member_id']));
        if (empty($comment_info)){
            output_json(0, $comment_info, '评论已不存在');
        }

        //删除评论
        $condition = array();
        $condition['comment_id'] = "$id";
        $result = $comment_model->delComment($condition);
        if ($result){
            //更新动态统计信息
            $tracelog_model = Model('sns_tracelog');
            $update_arr = array();
            $update_arr['trace_commentcount'] = array('sign'=>'decrease','value'=>'1');
            $tracelog_model->tracelogEdit($update_arr,array('trace_id'=>"{$comment_info['comment_originalid']}"));
            output_json(1, $result, 'SUCCESS');
        } else {
            output_json(0, $comment_info, '删除失败');
        }
    }

    /**
     * 点赞
     */
    public function like_addOp() {
        $id = intval(empty($_GET['id']) ? $_POST['id'] : $_GET['id']);
        if ($id <= 0) output_json(0, array(), '参数错误');
        $type = intval($_POST['type'])<=0 ? 0 : intval($_POST['type']);

        $model_comment = Model('sns_comment');
        $model_trace = Model('sns_tracelog');
        $original_info = array();
        if ($type == 2) {
            $original_info = $model_comment->getCommentRow(array('comment_id' => $id));
        } else if ($type == 0) {
            $original_info = $model_trace->getTracelogRow(array('trace_id' => $id));
        }
        if (empty($original_info)) output_json(0, array(), $type == 2 ? '原评论不存在' : '原动态不存在');

        $model_like = Model('sns_like');
        $like_info = $model_like->getLikeInfo(array(
            'like_originalid' => $id,
            'like_memberid' => $this->member_info['member_id'],
            'like_originaltype' => $type
        ));
        if (empty($like_info)) {
            $insert = array();
            $insert['like_memberid'] = $this->member_info['member_id'];
            $insert['like_membername'] = $this->member_info['member_name'];
            $insert['like_memberavatar'] = $this->member_info['member_avatar'];
            $insert['like_originalid'] = $id;
            $insert['like_originaltype'] = $type;
            $insert['like_addtime'] = time();
            $insert['like_ip'] = getIp();
            $insert['like_state'] = 0; //正常
            $result = $model_like->addLike($insert);

            if ($result && $like_info['like_memberid'] != $this->member_info['member_id']) {
                $params = array();
                $params['member_id'] = $type == 2 ? $original_info['comment_memberid'] : $original_info['trace_memberid'];
                $params['to_member_name'] = $type == 2 ? $original_info['comment_membername'] : $original_info['trace_membername'];
                $params['msg_content'] = '赞了你';
                $params['message_type'] = 4;
                $params['item_id'] = $type == 2 ? $original_info['comment_id'] : $original_info['trace_id'];
                $this->_send_msg($params);
            }
        } else {
            if ($like_info['like_state'] == 0) output_json(1, array(), '已经点过赞了');
            $result = $model_like->editLike(array('like_id' => $like_info['like_id']), array('like_state' => 0));
        }

        // 更改点赞数
        $action = array('sign'=>'increase','value'=>'1');
        if ($type == 0) {
            $model_trace = Model('sns_tracelog');
            $model_trace->tracelogEdit(array('trace_likecount' => $action),array('trace_id'=>$id));
        } elseif($type == 2) {
            $model_comment = Model('sns_comment');
            $model_comment->commentEdit(array('comment_likecount' => $action),array('comment_id'=>$id));
        }

        output_json(1, $result);
    }

    private function _get_comment_list($id) {

        // 查询评论列表
        $comment_model = Model('sns_comment');
        $condition = array();
        $condition['comment_originalid'] = $id;
        $condition['comment_originaltype'] = '0'; //原帖类型 0表示动态信息 1表示分享商品
        $condition['comment_state'] = "0"; //0表示正常，1表示屏蔽
        $condition['limit'] = $this->page;

        $comment_list = $comment_model->getCommentList($condition);
        if (!empty($comment_list)) {
            $model_member = Model('member');
            $model_like = Model('sns_like');

            foreach ($comment_list as $key => $value) {
                $member_info = $model_member->getMemberInfoByID($value['comment_memberid'], 'member_id, member_name, member_avatar');
                $value['comment_membername'] = $member_info['member_name'];
                $value['comment_memberavatar'] = getMemberAvatar($member_info['member_avatar']);
                $value['comment_addtime'] = date('Y.m.d H:i', $value['comment_addtime']);

                $condition = array();
                $condition['like_originalid'] = $value['comment_id'];
                $condition['like_memberid'] = $this->member_info['member_id'];
                $condition['like_originaltype'] = 2;
                $condition['like_state'] = 0;
                $like_info = $model_like->getLikeInfo($condition);
                if (empty($like_info)) $value['is_like'] = false;
                else $value['is_like'] = true;
                unset($condition['like_memberid']);
                $value['like_count'] = $model_like->countLike($condition);

                if ($value['comment_memberid'] == $this->member_info['member_id']) {
                    $value['relation'] = 1;
                } else {
                    $value['relation'] = 0;
                }

                if ($value['comment_reply_id'] > 0) {
                    $original_comment = $comment_model->getCommentRow(array('comment_id' => $value['comment_reply_id']), 'comment_id, comment_membername, comment_content');
                    $value['comment_reply'] = $original_comment;
                }

                $comment_list[$key] = $value;
            }
        }

        return $comment_list;
    }

    private function _send_msg($param) {
        $model_message = Model('message');
        $param['from_member_id'] = $this->member_info['member_id'];
        $param['from_member_name'] = $this->member_info['member_name'];
        $model_message->saveMessage($param);
    }

    private function _check_relation($mid) {
        if ($mid <= 0) {
            output_json(0, array(), '数据出错');
        }

        if ($mid == $this -> member_info['member_id']) {
            $relation = 3;
        } else {
            $relation = 1;

            $model_friend = Model('sns_friend');
            $condition_friend = array();
            $condition_friend['friend_frommid'] = $this -> member_info['member_id'];
            $condition_friend['friend_tomid'] = $mid;
            $friend_info = $model_friend->getFriendRow($condition_friend);
            if (!empty($friend_info) && $friend_info['friend_followstate'] == 2) {
                $relation = 2;
            } elseif ($friend_info['friend_followstate'] == 1) {
                $relation = 4;
            }
        }

        return $relation;
    }

}