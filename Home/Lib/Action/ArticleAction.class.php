<?php
/**
 * 文章管理控制器
 * 
 * @author su
 */
class ArticleAction extends CommonAction{
	public function _initialize(){
		parent::_initialize();
		$this->assign('gaoliang','1');

		parent::assignSeoInfo('文章详情_蓝译');
	}
	
	/**
	 * 文章管理列表
	 */
	public function index(){
		// 导入分页类
    	import('@.ORG.Page'); 
		//导入扩展
		load('extend');
		
		$cat_id = I('get.cat_id');
		//条件
		if($cat_id){
			$where['cat_id'] = $cat_id;
			$where['status'] = 1;
		}else{
			$where = 'cat_id=46 or cat_id=84 and status=1';
		}
    	
		//符合条件的新闻总数
		$article_count = M('article')->where($where)->count();
		//echo $article_count;
		//实例化分页类
		$Page  = new Page($article_count,10);

		$article_list = M('article')->field('id,addtime,title,cat_id,summary')
								->where($where)
								->limit($Page->firstRow.','.$Page->listRows)
								->order('id desc')
								->select();

		//var_dump($article_list);
						
		//echo M()->getlastsql();
		//分页赋值
		$this->assign('pages',$Page->show());
		$this->assign('article_list',$article_list);
		$this->assignSeoInfo('文章列表_蓝译');
		//渲染模版
		$this->display();
	}
	
	/**
	 * 新闻详细
	 */
	public function detail(){
		
		$id = $this->_get('id');
		$article_info = M('article')->find($id);
		if(empty($article_info)){
			$this->_empty();
		}
		//相关阅读、
		// $relation = M('News')->field('id,title,cat_id,author,hits,addtime')
		// 						->where("id != {$id} and cat_id = {$news_info['cat_id']}")
		// 						->order('id desc')
		// 						->limit(10)
		// 						->select();
		// 点击量加1
    	//M('News')->where(array('id' => $id))->setInc('hits');
		//seo赋值
		$this-> assignSeoInfo($article_info['title'].'_蓝译', $article_info['keywords'], $article_info['description']);

		//上一条新闻
		$one_prev = M("article") -> where('id > '.$id.' and cat_id='.$article_info['cat_id']) ->order('id ASC') -> find();
		//下一条新闻
		$one_next = M("article") -> where('id < '.$id.' and cat_id='.$article_info['cat_id']) ->order('id desc') -> find();
		
		//赋值
		$this->assign('article_info',$article_info);
		// $this->assign('relation',$relation);
		$this->assign('one_prev',$one_prev);
		$this->assign('one_next',$one_next);
		//渲染模版
		$this->display();
	}
}