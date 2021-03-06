<?php
/**
 * 站内信
 *
 *
 *
 *

 */

//use Shopnc\Tpl;

defined('InShopNC') or exit('Access Invalid!');

class member_messageControl extends mobileMemberControl {

    private $model_message;

    private $obj_page;

    public function __construct() {
        parent::__construct();
        $this->model_message = Model('message');
        $this->obj_page = new Page();
        $this->obj_page->setEachNum($this->page);
        $this->obj_page->setStyle('admin');
    }

    /**
     * 收到(普通)站内信列表
     *
     * @param
     * @return
     */
    public function message_listOp() {
        $type = intval(empty($_POST['type']) ? $_GET['type'] : $_POST['type']);

        $condition = array();
        $condition['message_type'] = $type <= 0 ? 0 : $type;
        if ($type == 1) {
            $condition['from_member_id'] = 0;
            $condition['to_member_id'] = $this->member_info['member_id'];
            $condition['no_del_member_id'] = $this->member_info['member_id'];
        } else {
            $condition['to_member_id_common'] = $this->member_info['member_id'];
            $condition['no_message_state'] = '2';
        }

        $message_list = $this->model_message->listMessage($condition, $this->obj_page);
        if (!empty($message_list) && is_array($message_list)) {
            $model_member = Model('member');
            foreach ($message_list as $key=>$value) {
                // 消息打开状态
                $value['message_open'] = '0';
                if ($value['read_member_id']) {
                    $read_list = explode(',', $value['read_member_id']);
                    if (in_array($this->member_info['member_id'], $read_list)) {
                        $value['message_open'] = '1';
                    }
                }

                // 用户与动态信息
                $member_info = $model_member->getMemberInfoByID($value['from_member_id'], 'member_avatar');
                $value['from_member_avatar'] = getMemberAvatar($member_info['member_avatar']);
                if ($value['message_type'] > 3 && $value['message_parent_id'] > 0) {
                    $model_trace = Model('sns_tracelog');
                    $trace_info = $model_trace->getTracelogRow(array(
                        'trace_id' => $value['message_parent_id'], 'trace_state'=>'0'),
                        'trace_id,trace_image,trace_title'
                    );
                    if (!empty($trace_info)) {
                        foreach ($trace_info as $k_t=>$v_t) {
                            $trace_info[$key]['trace_image'] = snsThumb($v_t['trace_image'], 240);
                        }
                        $value['trace_info'] = $trace_info;
                    }
                }

                // 日期整理
                $time = time() - $value['message_time'];
                if ($time >= 3600 * 24) {
                    $value['message_time'] = date("Y.m.d H:i", $value['message_time']);
                } elseif($time > 3600) {
                    $value['message_time'] = (int)($time / 3600) . '小时前';
                } else {
                    $value['message_time'] = (int)($time / 60) . '分钟前';
                }

                $message_list[$key] = $value;
            }
        }

        output_json(1, $message_list);
    }

    /**
     * 系统站内信列表
     * 
     */
    public function system_msgOp() {
        $condition = array(
            'from_member_id' => '0',
            'message_type' => '1',
            'to_member_id' => $this->member_info['member_id'],
            'no_del_member_id' => $this->member_info['member_id']
        );
        $message_list = $this->model_message->listMessage($condition, $this->obj_page);
        if (!empty($message_list) && is_array($message_list)) {
            foreach ($message_list as $key=>$value) {
                $value['message_open'] = '0';
                if ($value['read_member_id']) {
                    $read_list = explode(',', $value['read_member_id']);
                    if (in_array($this->member_info['member_id'], $read_list)) {
                        $value['message_open'] = '1';
                    }
                }
                $message_list[$key] = $value;
            }
        }

        output_json(1, $message_list);
    }

    /**
     * 站内信保存操作
     *
     * @param
     * @return
     */
    public function send_msgOp() {
        //查询会员是否允许发送站内信
        if (!$this->_allowSendMessage()){
            output_json(0, array(), Language::get('error_message_noallow'));
        }

        $obj_validate = new Validate();
        $obj_validate->validateparam = array(
            array("input"=>$_POST["to_member_name"],"require"=>"true","message"=>Language::get('error_message_receiver_null')),
            array("input"=>$_POST["msg_content"],"require"=>"true","message"=>Language::get('error_message_content_null')),
        );
        $error = $obj_validate->validate();
        if ($error != '') output_json(0, array(), $error);

        $msg_content = trim($_POST['msg_content']);
        $member_name_arr = explode(',',$_POST['to_member_name']);
        if (in_array($this->member_info['member_name'],$member_name_arr)){
            unset($member_name_arr[array_search($this->member_info['member_name'],$member_name_arr)]);
        }

        //查询有效会员
        $member_model = Model('member');
        $member_list = $member_model->getMemberList(array('member_name'=>array('in', $member_name_arr)));
        if (!empty($member_list)){
            $model_message	= Model('message');
            foreach ($member_list as $k=>$v){
                $insert_arr = array();
                $insert_arr['from_member_id'] = $this->member_info['member_id'];
                $insert_arr['from_member_name'] = $this->member_info['member_name'];
                $insert_arr['member_id'] = $v['member_id'];
                $insert_arr['to_member_name'] = $v['member_name'];
                $insert_arr['msg_content'] = $msg_content;
                $insert_arr['message_type'] = intval($_POST['msg_type']);
                $result = $model_message->saveMessage($insert_arr);
                output_json(1, $result);
            }
        } else {
            output_json(0, array(), Language::get('error_message_receiver_null'));
        }

    }

    /**
     * 统计未读消息
     */
    public function new_countOp() {
        $count = array();
        $model_message = Model('message');
        $count_new_msg = $model_message->countNewMessage($this->member_info['member_id']);
        if ($count_new_msg > 0) {
            $count['count_new_msg']  =$count_new_msg;
            // 新的粉丝
            $new_fans = $this->_receivedMsgNewCount(3);
            if ($new_fans > 0) {
                $count['new_fans'] = $new_fans;
            }
            // 评论和赞
            $new_comment = $this->_receivedMsgNewCount(4);
            if ($new_comment > 0) {
                $count['new_comment'] = $new_comment;
            }
            // @我
            $new_at = $this->_receivedMsgNewCount(5);
            if ($new_at > 0) {
                $count['new_at'] = $new_at;
            }
            // 系统消息
            $newsystem = $this->_receivedSystemNewNum();
            if ($newsystem > 0) {
                $count['new_system'] = $newsystem;
            }
            output_json(1, $count);
        } else {
            output_json(0, array(), '没有新消息');
        }
    }

    /**
     * 私信未读条数
     *
     * @return int
     */
    private function _receivedMsgNewCount($type) {
        $model_message	= Model('message');
        $condition = array();
        $condition['message_type'] = $type;
        $condition['to_member_id_common'] = $this->member_info['member_id'];
        $condition['no_message_state'] = '2';
        $condition['message_open_common'] = '0';
        $countnum = $model_message->countMessage($condition);
        return $countnum;
    }

    /**
     * 统计系统站内信未读条数
     *
     * @return int
     */
    private function _receivedSystemNewNum(){
        $message_model = Model('message');
        $condition = array();
        $condition['message_type'] = '1';//系统消息
        $condition['to_member_id'] = $this->member_info['member_id'];
        $condition['no_del_member_id'] = $this->member_info['member_id'];
        $condition['no_read_member_id'] = $this->member_info['member_id'];
        $countnum = $message_model->countMessage($condition);
        return $countnum;
    }

    /**
     * 查询会员是否允许发送站内信
     *
     * @return bool
     */
    private function _allowSendMessage(){
        $member_info = Model('member')->getMemberInfoByID($this->member_info['member_id'],'is_allowtalk');
        if ($member_info['is_allowtalk'] == '1'){
            return true;
        }else{
            return false;
        }
    }
}
