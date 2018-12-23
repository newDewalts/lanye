<?php
/**
 * 晋升政策
 * 
 * @author su
 */
 class JinshengAction extends CommonAction{
	public function __construct(){
		parent::__construct();
		//所有城市cat_id
		$jisheng_cat = M('jinsheng_cat') -> where(array('pid' => 0)) -> order('orders asc') -> select();
		$str = '';
		foreach($jisheng_cat as $key => $val){
			$str .= $val['cat_id'].',';
		}
		$this->str = substr($str,0,-1);
		$this -> assign('jisheng_cat',$jisheng_cat);
	}
	
	/**
	 * 关于我们
	 */
	public function index(){
		// 导入分页类
    	import('@.ORG.Page'); 
		Load('extend');
		$js_cat_id = isset($_REQUEST['js_cat_id']) ? $_REQUEST['js_cat_id'] : '';
		//所有城市cat_id
		$where = 'cat_id IN('.$this->str.')';
		
		$bannerArr = M('ad') -> where('pos_id = 13 AND is_show = 1') -> order('orders ASC') -> find();
		if(!empty($js_cat_id)){
			$where = 'cat_id = '.$js_cat_id;
			$js_cat_id_info = M('jinsheng_cat') -> where(array('cat_id' => $js_cat_id)) -> find();
			$this->assignSeoInfo($js_cat_id_info['cat_name'], $js_cat_id_info['keywords'], $js_cat_id_info['description']);
			$dingwei = $js_cat_id_info['cat_name'];
		}else{
			//$this->assignSeoInfo("晋升政策 - 全部 - ");
			$dataSeo['title']       = "最新(2016)各省份医生中高级职称晋升政策,评职称时间,职称评定时间";
			$dataSeo['keywords']    = "职称晋升政策,医生晋升政策,职称晋升时间,职称晋升";
			$dataSeo['description'] = "达晋为您收集全国各省市医生中高级职位晋升政策,以及职位晋升时间.达晋愿与您一道关注医生职位晋升政策以及职位晋升时间,同时在论文方面助力各位医者的顺利晋级中高级职称.";
			$this->assignSeoInfo($dataSeo['title'], $dataSeo['keywords'], $dataSeo['description']);
			$dingwei = '全部';
		}
		
		
		$count = M('jinsheng')->where($where) -> count();
		//实例化分页类
		$Page  = new Page($count,30);
		$jisheng_info = M('jinsheng') -> field('id,cat_id,title,addtime') -> where($where) -> order('addtime desc') -> limit($Page->firstRow.','.$Page->listRows) -> select();
		
		//热门资讯
		$hot_where = "status = '1' AND cat_id IN(".$this->str.")";
		$hot_article = M('jinsheng') -> field('id,cat_id,title') -> where($hot_where) -> order('hits desc') -> limit(10) -> select();
		
		//分页赋值
		$this->assign('pages',$Page->show());
		$this -> assign('bannerArr',$bannerArr);
		$this -> assign('jisheng_info',$jisheng_info);
		$this -> assign('hot_article',$hot_article);
		$this -> assign('dingwei',$dingwei);
		
		$this -> display();
	}
	
	public function detail(){
		Load('extend');
		$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : '';
		if(empty($id)){
			$this -> error('您查看的文章不存在！');
		}
		$detail = M('jinsheng') -> where(array('id' => $id)) -> find();
		M('jinsheng')->where('id='.$id)->setInc('hits');
		//热门资讯
		$hot_where = "status = '1' AND cat_id IN(".$this->str.")";
		$hot_article = M('jinsheng') -> field('id,cat_id,title') -> where($hot_where) -> order('hits desc') -> limit(10) -> select();
		
		//seo赋值
		$this->assignSeoInfo($detail['title'], $detail['keywords'], $detail['description']);

		$this -> assign('detail',$detail);
		$this -> assign('hot_article',$hot_article);
		$this -> display();
	}
	
	
	
 }