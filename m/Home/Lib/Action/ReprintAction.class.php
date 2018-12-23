<?php 
/**
 * ReprintAction
 * */

class ReprintAction extends CommonAction{

	public function index(){
		//期刊分类
		$cat_list = D('reprint_cat') -> where('pid = 0') -> order('orders ASC') -> select();
		import('ORG.Util.Page');

		$cat_id = I('get.cat_id');
		if($cat_id){
			$where['status'] = '1';
			$where['cat_id'] =$cat_id;
		}else{
			$where['status'] = '1';
		}
			$newArr =  D('reprint') -> where($where) -> order('addtime DESC') -> select();
			
			$count = D('reprint') -> where($where)->count();
			$page = new Page($count ,10);
			$limit = $page->firstRow . ',' . $page->listRows;
			$reprintArr = D('reprint') -> where($where) -> order('addtime DESC')->limit($limit)->select();
			$show  = $page->show();// 分页显示输出

		$this->assign('show',$show);
		$this->assign('cat_list',$cat_list);
		$this->assign('reprintArr',$reprintArr);
		$this->display();
	}
	
	public function detail(){
		
		$id = I('param.id','',trim);
	
		$detail = M('reprint')->cache(true)->where(array('id'=>$id))->find();
	
		$this->assign('detail',$detail);
		$this->display();
	}
}
?>