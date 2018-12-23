<?php 
/*
 * register
 */
class FeedbackAction extends CommonAction{
	public function _initialize(){
		parent::_initialize();
	}

	public function index(){
		
		//Company instruction
		
		
		//导入分页类
		import('ORG.Util.Page');
		$count       = M('feedback')->count();			 
		//实例化分页类
		$Page        = new Page($count,6);
		$pageShow    = $Page->show();		
		$lists  = M('feedback')->cache(true)->field('fullname,content')
							  ->where('status = 1')
							  ->limit($Page->firstRow.','.$Page->listRows)
							  ->order('addtime')
							  ->select();
		$this->assign('lists',$lists);
		$this->assign('pageShow',$pageShow);
		
		$this->display();
	}

	
}
?>