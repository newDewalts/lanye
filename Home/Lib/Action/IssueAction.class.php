<?php
/**
 * 关于我们控制器
 * 
 * @author su
 */
 class IssueAction extends CommonAction{
	/*public function _initialize(){
		parent::_initialize();
		//导航高亮
		$this->assign('gaoliang','1');
	}*/
	
	/**
	 * 关于我们
	 */
	public function index(){
	
		$cat_id = isset($_REQUEST['cat_id']) ? $_REQUEST['cat_id'] : '32';
		$m = M('service');
		$where = 'cat_id = '.$cat_id .' and status = 1';
		$result = $m -> where($where) -> order('addtime desc') -> limit(1) -> find();
		
		$this -> cat_id = $cat_id;
		$this -> assign('result',$result);
		$this->display();
	}
	
	
 }