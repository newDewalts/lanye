<?php
/**
 * 基金频道
 * 
 * @author su
 */
 class FundAction extends CommonAction{
	public function __construct(){
		parent::__construct();
		$material_menu = M('article_cat') -> where(array('pid' => 42,'show_nav' => 1)) -> order('cat_id asc') -> select();
		$this -> assign('material_menu',$material_menu);
	}
	
	public function index(){
		
		// 导入分页类
    	import('@.ORG.Page'); 
		Load('extend');
		/*$where = "pre_status = '1'";
		
		$count = M('periodical')->where($where) -> order('date_time DESC') -> count();
		
		//实例化分页类
		$Page  = new Page($count,30);
		//分页链接
		//$Page->url = 'list-';
		
		$listArr = M('periodical') -> field('pre_id,pre_name,pre_image_thumb') -> where($where) -> order('date_time DESC') -> limit($Page->firstRow.','.$Page->listRows) -> select();
		*/
		//分页赋值
		//$this->assign('pages',$Page->show());
		//$this -> assign('listArr',$listArr);
		$this -> display();
	}
	
	public function detail(){
		
		$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : '';
		if(empty($id)){
			$this -> error('您查看的文章不存在！');
		}
		$detail = M('periodical') -> where(array('pre_id' => $id)) -> find();
		
		
		//dump($news_detail);exit;
		$this -> assign('detail',$detail);
		$this -> display();
	}
	
	
	
 }