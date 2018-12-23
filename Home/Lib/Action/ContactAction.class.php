<?php 
/*
 * 联系我们控制器
 * @author:xu
 */
class ContactAction extends CommonAction{
	public function _initialize(){
		parent::_initialize();
		//导航高亮
		$this->assign('gaoliang','9');
	}
	public function index(){
			

		$cat_id = isset($_REQUEST['cat_id']) ? $_REQUEST['cat_id'] : 41;

		$contact_info = M('article')->where(array('cat_id'=>$cat_id,'status'=>1))->find();

		//dump($contact_info);die;
		$this->assign('contact_info',$contact_info);
		$this->assign('pid',13);
		$this->display();
	}


	


}
?>