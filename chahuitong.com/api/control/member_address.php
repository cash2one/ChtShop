<?php
/**
 * 我的地址
 *
 *
 *
 *
 
 */

//use Shopnc\Tpl;

defined('InShopNC') or exit('Access Invalid!');

class member_addressControl extends mobileMemberControl {

	public function __construct() {
		parent::__construct();
	}

    /**
     * 地址列表
     */
    public function address_listOp() {
		$model_address = Model('address');
        $address_list = array();
        $address_list = $model_address->getAddressList(array('member_id'=>$this->member_info['member_id']));
        output_json(1, array('list' => $address_list), 'SUCCESS', mobile_page(0));
    }

    /**
     * 地址详细信息
     */
    public function address_infoOp() {
		$address_id = intval($_POST['address_id']);

		$model_address = Model('address');

        $condition = array();
        $condition['address_id'] = $address_id;
        $address_info = $model_address->getAddressInfo($condition);
        if(!empty($address_id) && $address_info['member_id'] == $this->member_info['member_id']) {
            output_data(array('address_info' => $address_info));
        } else {
            output_error('地址不存在');
        }
    }

    /**
     * 删除地址
     */
    public function address_delOp() {
		$address_id = intval($_POST['address_id']);

		$model_address = Model('address');

        $condition = array();
        $condition['address_id'] = $address_id;
        $condition['member_id'] = $this->member_info['member_id'];
        $delResult=$model_address->delAddress($condition);
        if($delResult){
            output_json(1,$delResult);
        }else {
            output_json(0, 0, "删除失败");
        }
    }

    /**
     * 新增地址
     */
    public function address_addOp() {
        $model_address = Model('address');

        $address_info = $this->_address_valid();

        /*修改已经设置为默认值*/
        if($address_info['is_default']=='1'){
            $default=array();
            $default['is_default']=0;
            $model_address->where("member_id='".$this->member_info['member_id']."' and is_default='1'")->update($default);
        }
        /**/

        $result = $model_address->addAddress($address_info);
        if($result) {
            output_json(1, $result);
        } else {
            output_json(0, 0, '添加失败');
        }
    }

    /**
     * 编辑地址
     */
    public function address_editOp() {
        $address_id = intval($_POST['address_id']);

        $model_address = Model('address');

        //验证地址是否为本人
        $address_info = $model_address->getOneAddress($address_id);
        if ($address_info['member_id'] != $this->member_info['member_id']) {
            output_error('参数错误');
        }

        $address_info = $this->_address_valid();

        $result = $model_address->editAddress($address_info, array('address_id' => $address_id));
        if($result) {
            output_data('1');
        } else {
            output_error('保存失败');
        }
    }

    /**
     * 验证地址数据
     */
    private function _address_valid() {
        $obj_validate = new Validate();
        $obj_validate->validateparam = array(
            array("input"=>$_POST["true_name"],"require"=>"true","message"=>'姓名不能为空'),
            array("input"=>$_POST["area_info"],"require"=>"true","message"=>'地区不能为空'),
            array("input"=>$_POST["address"],"require"=>"true","message"=>'地址不能为空'),
            array("input"=>$_POST['tel_phone'].$_POST['mob_phone'],'require'=>'true','message'=>'联系方式不能为空')
        );
        $error = $obj_validate->validate();
        if ($error != ''){
            output_error($error);
        }

        $data = array();
        $data['member_id'] = $this->member_info['member_id'];
        $data['true_name'] = $_POST['true_name'];
        $data['area_id'] = intval($_POST['area_id']);
        $data['city_id'] = intval($_POST['city_id']);
        $data['area_info'] = $_POST['area_info'];
        $data['address'] = $_POST['address'];
        $data['tel_phone'] = $_POST['tel_phone'];
        $data['mob_phone'] = $_POST['mob_phone'];
        $data['is_default']=isset($_POST['is_default'])&&($_POST['is_default']=='1')? 1:0;
        return $data;
    }

    /**
     * 地区列表
     */
    public function area_listOp() {
        $area_id = intval($_POST['area_id']);

        $model_area = Model('area');

        $condition = array();
        if($area_id > 0) {
            $condition['area_parent_id'] = $area_id;
        } else {
            $condition['area_deep'] = 1;
        }
        $area_list = $model_area->getAreaList($condition, 'area_id,area_name,area_parent_id,area_deep');
        if (empty($area_list)) output_json(1, array(), '暂无数据');
        else output_json(1, array('list' => $area_list), 'SUCCESS', mobile_page(0));
    }
	
	/**
     * 设置默认地址
     */
	 public function set_defaultOp() {
         $model_area = Model('address');
         $model_area->editAddress(array('is_default' => 0), array('is_default' => 1));

         $condition=array();
		 $condition['member_id'] = $this->member_info['member_id'];
		 $condition['address_id'] = intval($_POST['address_id']);
		 $result=$model_area->editAddress(array('is_default' => 1), $condition);
		 if($result){
             output_json(1, $result);
         } else {
             output_json(0, 0, '操作超时');
         }
    }

}
