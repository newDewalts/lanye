<?php
/**
 * 文章管理控制器
 * 
 * @author su
 */
class StudyAction extends CommonAction{
	public function _initialize(){
		parent::_initialize();
	}
	
	/**
	 * 文章管理列表
	 */
	public function index(){
         load('extend');
        //SCI编译指导最新
        $article_list_sci_new = M('article')->field('id,addtime,title,cat_id,summary,thumb')->where('cat_id=47 and  status=1')->limit(7)->order('id desc')->select();
        $this->assign('article_list_sci_new',$article_list_sci_new);
        //dump($article_list_sci_new);
        //SCI编译指导热门
        $article_list_sci = M('article')->field('id,addtime,title,cat_id,summary')->where('cat_id=47 and hot=1 and  status=1')->limit(10)->order('orders desc,id desc')->select();
        $this->assign('article_list_sci',$article_list_sci);
        //dump($article_list_sci); 
        
        //写作指导最新
        $article_list_sci_xie = M('article')->field('id,addtime,title,cat_id,summary,thumb')->where('cat_id=84 and  status=1 ')->limit(7)->order('id desc')->select();
        $this->assign('article_list_sci_xie',$article_list_sci_xie);
        //dump($article_list_sci_new);
        //写作指导热门
        $article_list_sci_xie_hot = M('article')->field('id,addtime,title,cat_id,summary')->where('cat_id=84 and hot=1 and  status=1 ')->limit(10)->order('orders desc,id desc')->select();
        $this->assign('article_list_sci_xie_hot',$article_list_sci_xie_hot);
        //dump($article_list_sci); 
        
        //最新消息
        $news_list = M('News')->field('id,addtime,title,cat_id,summary,thumb,content')->where('cat_id=3 and status=1 ')->limit(12)->order('id desc')->select();
        $this->assign('news_list',$news_list);
        //dump($news_list);
        
        //首页Banner图
        $ad_study = M('ad')->field('id,link,ad_img')->where(array('pos_id'=>14,'is_show'=>1))->order('id desc')->select();
        //dump($ad_study);
        $this->assign('ad_study',$ad_study);

        //赋值seo信息
        $this->assignSeoInfo("学习资源");  
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
                $cat_id=$article_info['cat_id'];
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
		$this->assign('news_info',$article_info);
                $this->assign('cat_id',$cat_id);
                //dump($article_info);
		// $this->assign('relation',$relation);
		$this->assign('one_prev',$one_prev);
		$this->assign('one_next',$one_next);
		//渲染模版
		$this->display();
	}
        /**
         * 文章分类
         */
        public function cat(){
            // 导入分页类
                import('@.ORG.Page'); 
		//导入扩展
		load('extend');
		
		$cat_id = I('get.cat_id');
		//条件
		if($cat_id){
			$where['cat_id'] = $cat_id;
		}else{
			$where['cat_id'] = '47';
                        $cat_id=47;
		}
                $news_cat=M('article_cat')->where("cat_id={$cat_id}")->find();
                $this->assign('article_cat',$news_cat);
                $where['status'] = 1;
		//符合条件的新闻总数
		$count = M('article')->where($where)->count();
               
		//实例化分页类
		$Page  = new Page($count,10);

		$news_list = M('article')->field('id,addtime,title,cat_id,summary,thumb,content')
								->where($where)
								->limit($Page->firstRow.','.$Page->listRows)
								->order('id desc')
								->select();
						
                $Page->setConfig('theme', $this->pageTheme);
                //dump($news_list);
		//分页赋值
		$this->assign('pages',$Page->show());
		$this->assign('news_list',$news_list);
                $this->assign('cat_id',$cat_id);
		$this->assignSeoInfo('学习资源_蓝译');
		//渲染模版
		$this->display();
            
        }
        
}