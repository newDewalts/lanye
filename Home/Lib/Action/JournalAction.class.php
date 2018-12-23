<?php
/**
 * 中文期刊
 * 
 * @author su
 */
 class JournalAction extends CommonAction{
 	// 暂时禁用该模块
 	public function _initialize(){
 		$this->error('页面不存在');
		//$this->display(U('Index/index'));
	}
	public function __construct(){
		parent::__construct();
		$menu = M('periodical_cate') -> where(array('pid' => 2,'is_show' => 1)) -> order('orders asc') -> select();
		$this -> assign('menu',$menu);
	}
	
	public function index(){
		
		// 导入分页类
    	import('@.ORG.Page'); 
		Load('extend');
		$cat_id = isset($_REQUEST['cat_id']) ? $_REQUEST['cat_id'] : '';
		$bannerArr = M('ad') -> where('pos_id = 11 AND is_show = 1') -> order('orders ASC') -> find();
		if(empty($cat_id)){
			foreach($this->menu as $key => $val){
				if($key >= '1')continue;
				$cat_id = $val['cat_id'];
			}
		}
		//当前栏目
		$m_cat = M('periodical_cate');
		//$cat_info = $m_cat -> field('cat_name') -> where('cat_id = '.$cat_id) -> find();
		$cat_info = $m_cat -> where('cat_id = '.$cat_id) -> find();
		
		$where = "pre_status = '1' AND cate_id = '$cat_id'";
		
		$count = M('periodical')->where($where) -> order('date_time DESC') -> count();
		
		//实例化分页类
		$Page  = new Page($count,20);
		$listArr = M('periodical') -> field('pre_id,pre_name,pre_image_thumb') -> where($where) -> order('date_time DESC') -> limit($Page->firstRow.','.$Page->listRows) -> select();
		
		//seo赋值
		$this->assignSeoInfo($cat_info['cat_name'].' - 中文期刊 ', $cat_info['keywords'], $cat_info['description']);
		
		//分页赋值
		$this -> cat_id = $cat_id;
		$this->assign('pages',$Page->show());
		$this -> assign('bannerArr',$bannerArr);
		$this -> assign('listArr',$listArr);
		$this -> assign('cat_name',$cat_info['cat_name']);
		$this -> display();
	}
	
	public function detail(){
		
		$id = $_REQUEST['id'];
		$m = M('periodical');
		$list_detial = $m -> where('pre_id = '.$id) -> find();
		
		//seo赋值
		$this->assignSeoInfo($list_detial['pre_name'], $list_detial['pre_keywords'], $list_detial['pre_desc']);
		
		$this -> assign('list_detial',$list_detial);
		$this -> display();
	}
	
	
	
 }