<?php
/**
 * 公司新闻控制器
 * 
 * @author su
 */
class NewsAction extends CommonAction{
	public function _initialize(){
		parent::_initialize();
		$this->assign('gaoliang','1');
	}
	
	/**
	 * 公司新闻列表
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
		}else{
			$where['cat_id'] = '2';
                        $cat_id=2;
		}
                $news_cat=M('news_cat')->where("cat_id={$cat_id}")->find();
                $this->assign('news_cat',$news_cat);
                $where['status'] = 1;
                //获取分类新闻分类
                $news_cat_list=M('news_cat')->order('orders asc')->select();
                $this->assign('news_cat_list',$news_cat_list);
                //dump($news_cat_list);
		//符合条件的新闻总数
		$count = M('News')->where($where)->count();
               
		//实例化分页类
		$Page  = new Page($count,10);

		$news_list = M('News')->field('id,addtime,title,cat_id,summary,thumb,content')
								->where($where)
								->limit($Page->firstRow.','.$Page->listRows)
								->order('id desc')
								->select();
						
                $Page->setConfig('theme', $this->pageTheme);
                //dump($news_list);
		//分页赋值
		$this->assign('pages',$Page->show());
		$this->assign('news_list',$news_list);
		$this->assignSeoInfo('公司新闻_蓝译');
		//渲染模版
		$this->display();
	}
	
	/**
	 * 新闻详细
	 */
	public function detail(){
		$id = $this->_get('id');
		$news_info = M('News')->find($id);
                //dump($news_info);
                //获取分类新闻分类
                $news_cat_list=M('news_cat')->order('orders asc')->select();
                $this->assign('news_cat_list',$news_cat_list);
		if(empty($news_info)){
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
		$this->assignSeoInfo($news_info['title'].'_蓝译', $news_info['keywords'], $news_info['description']);
                $cat_id =$news_info['cat_id'];
		//上一条新闻
		$one_prev = M("News") -> where('id > '.$id.' and cat_id='.$news_info['cat_id']) ->order('id ASC') -> find();
		//下一条新闻
		$one_next = M("News") -> where('id < '.$id.' and cat_id='.$news_info['cat_id']) ->order('id desc') -> find();
		
                $news_cat=M('news_cat')->where("cat_id={$cat_id}")->find();
                $this->assign('news_cat',$news_cat);
		//赋值
		$this->assign('news_info',$news_info);
                
		// $this->assign('relation',$relation);
		$this->assign('one_prev',$one_prev);
		$this->assign('one_next',$one_next);
		//渲染模版
		$this->display();
	}
}