<?php
/**
 * 编辑控制器
 * 
 * @author su
 */
 class EditorsAction extends CommonAction{
	public function index(){
		$this->redirect('editors/lists');
	}
	
	/**
	 * 编辑
	 */
	public function lists(){
		$editorArr = M('editor') ->field('id,name,avatar,summary')-> where('status = 1 and show_index=1')->order('orders asc')-> select();

		$this -> assign('editorArr',$editorArr);
		$this->display();
	}
	
	public function detail(){
		$id = I('get.id');
		$where['id']=$id;
		$editor = M('editor')-> where($where)->find();
	
		$this->assign('editor',$editor);
		$this->display();
	}
	
	
 }