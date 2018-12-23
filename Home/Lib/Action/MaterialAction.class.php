<?php
/**
 * 关于我们控制器
 * 
 * @author su
 */
 class MaterialAction extends CommonAction{
	public function __construct(){
		parent::__construct();
		$material_menu = M('article_cat') -> where(array('pid' => 42,'show_nav' => 1)) -> order('cat_id asc') -> select();
		$this -> assign('material_menu',$material_menu);
	}
	
	/**
	 * 学习资源
	 */
	public function index(){
		Load('extend');
		$bannerArr = M('ad') -> where('pos_id = 14 AND is_show = 1') -> order('orders ASC') -> find();
		$cat_id = '';
		//导航切换
		$mater_top_list = M('article_cat') -> field('cat_id,cat_name') -> where('pid = 42') -> order('orders asc') -> limit(5) -> select();
		foreach($mater_top_list as $k => $v){
			$cat_id .= $v['cat_id'].',';
			$menu[]['cat_name'] = $v['cat_name'];
			$mater_top_listArr[$k]['one'] = M('article') -> field('id,cat_id,title,thumb') -> where('cat_id = '.$v['cat_id']) -> order('id desc') -> limit(0,10) -> select();
			$mater_top_listArr[$k]['two'] = M('article') -> field('id,cat_id,title,summary,thumb') -> where('cat_id = '.$v['cat_id']) -> order('addtime desc') -> limit(11,4) -> select();
		}
		
		//分类文章
		$article_list = M('article_cat') -> field('cat_id,cat_name') -> where('pid = 42') -> order('orders asc') -> limit(5,6) -> select();
		foreach($article_list as $k => $v){
			$cat_id .= $v['cat_id'].',';
			$article_listArr[$k]['cat_id'] = $v['cat_id'];
			$article_listArr[$k]['cat_name'] = $v['cat_name'];
			$article_listArr[$k]['listArr'] = M('article') -> field('id,cat_id,title,summary,thumb') -> where('cat_id = '.$v['cat_id']) -> order('addtime desc') -> limit(6) -> select();
		}
		
		//热门资讯
		$cat_id = substr($cat_id,0,-1);
		$hot_where = "status = '1' AND cat_id IN(".$cat_id.")";
		$hot_article = M('article') -> field('id,cat_id,title') -> where($hot_where) -> order('hits desc') -> limit(10) -> select();
		
		//seo优化
		$seoInfo = M('article_cat')->where(array('cat_id'=>42))->find();
		//$this->assignSeoInfo($seoInfo['cat_name'], $seoInfo['keywords'], $seoInfo['description']);
		
		$this -> assign('menu',$menu);
		$this -> assign('bannerArr',$bannerArr);
		$this -> assign('mater_top_list',$mater_top_listArr);
		$this -> assign('article_list',$article_listArr);
		$this -> assign('hot_article',$hot_article);
		$this->assignSeoInfo('临床医学，公共卫生学，基础医学，防御医学，中医中药学，药学的学习资源-蓝译','医学学习资源，医学写作知识，医学最新资讯，蓝译','蓝译为您提供比较全面的临床医学，公共卫生学，基础医学，防御医学，中医中药学，药学的学习资源，为您的论文写作，职称晋升提供便利。');
		$this -> display();
	}
	
	public function mat_list(){
		// 导入分页类
    	import('@.ORG.Page'); 
		Load('extend');
		$cat_id = isset($_REQUEST['cat_id']) ? $_REQUEST['cat_id'] : '';
		if(empty($cat_id)){
			$this -> error('您查看的内容不存在！');
		}
		$cat_info = M('article_cat') -> where('cat_id = '.$cat_id) -> find();
		$where = 'cat_id = '.$cat_id . ' AND status = 1';
		$count = M('article')->where($where) -> count();
		
		//实例化分页类
		$Page  = new Page($count,20);
		$listArr = M('article') -> field('id,cat_id,title,addtime') -> where($where) -> order('id DESC') -> limit($Page->firstRow.','.$Page->listRows) -> select();
		
		//seo赋值
		$this->assignSeoInfo($cat_info['cat_name'], $cat_info['keywords'], $cat_info['description']);
		
		//分页赋值
		$this->assign('pages',$Page->show());
		$this -> assign('listArr',$listArr);
		$this -> cat_id = $cat_id;
		$this -> cat_name = $cat_info['cat_name'];
		$this -> display();
	}
	
	public function mat_detail(){
		
		$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : '';
		$cat_id = isset($_REQUEST['cat_id']) ? $_REQUEST['cat_id'] : '';
		if(empty($id)){
			$this -> error('您查看的文章不存在！');
		}
		M('article')->where('id='.$id)->setInc('hits');
		$cat_info = M('article_cat') -> field('cat_name') -> where('cat_id = '.$cat_id) -> find();
		$detail = M('article') -> where(array('id' => $id)) -> find();
		$on_title = M('article') -> where("cat_id=".$cat_id. " and id < ".$id) -> order('id desc') -> limit(1) -> find();
		
		$next_title = M('article') -> where("cat_id=".$cat_id. " and id > ".$id) -> order('id asc') -> limit(1) -> find();
		
		//seo赋值
		$this->assignSeoInfo($detail['title'], $detail['keywords'], $detail['description']);

		$this -> cat_id = $cat_id;
		$this -> assign('detail',$detail);
		$this -> assign('on_title',$on_title);
		$this -> assign('next_title',$next_title);
		$this -> cat_name = $cat_info['cat_name'];
		$this -> display();
	}
	
 }