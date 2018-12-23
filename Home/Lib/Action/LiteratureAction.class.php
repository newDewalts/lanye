<?php
/**
 * 文献频道
 * 
 * @author su
 */
 class LiteratureAction extends CommonAction{
	public function __construct(){
		parent::__construct();
		$menu = M('literature_cat') -> where(array('pid' => 0)) -> order('cat_id asc') -> select();

		$this -> assign('menu',$menu);
	}
	
	/**
	 * 关于我们
	 */
	public function index(){
		
		// 导入分页类
    	import('@.ORG.Page'); 
		Load('extend');
		$cat_id = isset($_REQUEST['cat_id']) ? $_REQUEST['cat_id'] : '1';
		$style = isset($_REQUEST['style']) ? $_REQUEST['style'] : '';
		$bannerArr = M('ad') -> where('pos_id = 12 AND is_show = 1') -> order('orders ASC') -> find();
		//当前栏目
		$m_cat = M('literature_cat');
		$cat_info = $m_cat -> where('cat_id = '.$cat_id) -> find();
		//当前栏目下的所有分类
		$sort_list = $m_cat -> field('cat_id,cat_name,pid') -> where('pid = '.$cat_id) -> order('orders asc') -> select();
		
		foreach($sort_list as $val){
			$listStr .= $val['cat_id'].',';
		}
		$listStr = substr($listStr,0,-1);
		
		$where = "status = '1'";
		if(!empty($style)){
			$where .= ' and cat_id IN('.$style.')';
		}else{
			$where .= ' and cat_id IN('.$listStr.')';
		}
		
		$count = M('literature')->where($where) -> count();
		//echo $count;exit;
		//实例化分页类
		$Page  = new Page($count,20);
		$listArr = M('literature') -> field('id,cat_id,title,addtime') -> where($where) -> order('addtime DESC') -> limit($Page->firstRow.','.$Page->listRows) -> select();
		//dump($listArr);exit;
		//seo赋值
		$this->assignSeoInfo($cat_info['cat_name'].' - 文献频道 ', $cat_info['keywords'], $cat_info['description']);
		
		//分页赋值
		$this -> cat_id = $cat_id;
		$this->assign('pages',$Page->show());
		$this -> assign('bannerArr',$bannerArr);
		$this -> assign('listArr',$listArr);
		$this -> assign('cat_name',$cat_info['cat_name']);
		$this -> assign('sort_list',$sort_list);
		$this -> display();
	}
	
	public function show(){
		Load('extend');
		$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : '';
		$cat_id = isset($_REQUEST['cat_id']) ? $_REQUEST['cat_id'] : '';
		$pid = isset($_REQUEST['pid']) ? $_REQUEST['pid'] : '';
		if(empty($id)){
			$this -> error('您查看的文章不存在！');
		}
		$info = M('literature') -> where(array('id' => $id)) -> find();
		
		$m_cat = M('literature_cat');
		$cat_info = $m_cat -> field('cat_name') -> where('cat_id = '.$cat_id) -> find();
		
		$on_title = M('literature') -> where("id < ".$id) -> order('id desc') -> limit(1) -> find();
		$next_title = M('literature') -> where("id > ".$id) -> order('id asc') -> limit(1) -> find();
		//seo赋值
		$this->assignSeoInfo($info['title'], $info['keywords'], $info['description']);
		
		$this -> assign('info',$info);
		$this -> assign('on_title',$on_title);
		$this -> assign('next_title',$next_title);
		$this -> assign('cat_name',$cat_info['cat_name']);
		$this -> assign('cat_id',$pid);
		$this -> display();
	}
	
	public function detail(){
		Load('extend');
		$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : '';
		$cat_id = isset($_REQUEST['cat_id']) ? $_REQUEST['cat_id'] : '';
		$pid = isset($_REQUEST['pid']) ? $_REQUEST['pid'] : '';
		if(empty($id)){
			$this -> error('您查看的文章不存在！');
		}
		$info = M('literature') -> where(array('id' => $id)) -> find();
		
		$m_cat = M('literature_cat');
		$cat_info = $m_cat -> field('cat_name') -> where('cat_id = '.$cat_id) -> find();
		
		$on_title = M('literature') -> where("id < ".$id) -> order('id desc') -> limit(1) -> find();
		$next_title = M('literature') -> where("id > ".$id) -> order('id asc') -> limit(1) -> find();
		//seo赋值
		$this->assignSeoInfo($info['title'], $info['keywords'], $info['description']);
		
		$this -> assign('info',$info);
		$this -> assign('on_title',$on_title);
		$this -> assign('next_title',$next_title);
		$this -> assign('cat_name',$cat_info['cat_name']);
		$this -> assign('cat_id',$pid);
		$this -> display();
	}
	
	public function search(){
		Load('extend');
		$title = $this->_post('title');
		$author = $this->_post('author');
		$included = $this->_post('included');
		$author_company = $this->_post('author_company');
		$min_year = $this->_post('min_year');
		$max_year = $this->_post('max_year');
		if($title){
			$where['title'] = array('LIKE','%'.$title.'%');
		}
		if($pre_issn){
			$where['author'] = array('LIKE','%'.$author.'%');
		}
		if($pre_cn){
			$where['included'] = array('LIKE','%'.$included.'%');
		}
		if($pre_area){
			$where['author_company'] = array('LIKE','%'.$author_company.'%');
		}
		if($min_year){
			$where['year'][] = array('egt',$min_year);
		}
		if($min_year){
			$where['year'][] = array('elt',$min_year);
		}
		$search_count = M('literature')->where($where)->count();
		import('@.ORG.Page');
		$Page  = new Page($search_count,6);
		
		foreach ( $_REQUEST as $key => $val ) {
			if (! is_array ( $val )) {
				$Page->parameter .= "$key=" . urlencode ( $val ) . "&";
			}
		}
		$pageShow = $Page->show(); 
		$search_info = M('literature')->where($where)->limit($Page->firstRow.','.$Page->listRows)->select();
		//dump($search_info);exit;
		$this->assign('search_info',$search_info);
		$this->assign('pages',$pageShow);
		$this->assign('count',$search_count);
		$this->assignSeoInfo('文献_搜索结果');
		$this->display();
	}
	
	
	
 }