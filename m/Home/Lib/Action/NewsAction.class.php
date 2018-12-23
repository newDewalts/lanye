<?php 
/**
 * NewsAction
 * */

class NewsAction extends CommonAction{
	public function index(){
		$this->redirect('News/lists');
	}
	
	public function lists(){
		import('ORG.Util.Page');
		//$newArr =  D('news') -> where('status = 1 AND (cat_id = 2 and cat_id = 3 )  ') -> order('addtime DESC') -> select();
		$cat_id =  I('param.cat_id','',trim);
                //dump($cat_id);
                $where=array();
                $where['status']=1;
                if($cat_id){
                     $where['cat_id']=$cat_id;
                     $news_cat=M('news_cat')->where("cat_id={$cat_id}")->find();
                     //dump($news_cat);
                     $this->assign('news_cat',$news_cat);
                }else{
                    //$where['cat_id'] = array( 'eq',array('2','3'),'or');
                    $where['cat_id'] = array(2,3,'or') ;
                }
                
		$count = D('news') -> where($where)->count();
		$page = new Page($count ,10);
		$limit = $page->firstRow . ',' . $page->listRows;
		$newArr = D('news') -> where($where) -> order('addtime DESC')->limit($limit)->select();
                $aa=D('news')->getLastSql();
                //dump($aa);
		$show  = $page->show();// 分页显示输出

		$this->assign('show',$show);
		$this->assign('newArr',$newArr);
		$this->display();
	}

	public function lists2(){
		import('ORG.Util.Page');
		$newArr =  D('news') -> where('status = 1 AND cat_id = 1 AND thumb != ""') -> order('addtime DESC') -> select();
		
		$count = D('news') -> where('status = 1 AND cat_id = 1 AND thumb != ""')->count();
		$page = new Page($count ,10);
		$limit = $page->firstRow . ',' . $page->listRows;
		$newArr = D('news') -> where('status = 1 AND cat_id = 1 AND thumb != ""') -> order('addtime DESC')->limit($limit)->select();
		$show  = $page->show();// 分页显示输出

		$this->assign('show',$show);
		$this->assign('newArr',$newArr);
		$this->display();
	}

	public function lists3(){
		import('ORG.Util.Page');
		$newArr =  D('article') -> where('status = 1 AND thumb != ""') -> order('addtime DESC') -> select();
		
		$count = D('article') -> where('status = 1  AND thumb != ""')->count();
		$page = new Page($count ,10);
		$limit = $page->firstRow . ',' . $page->listRows;
		$newArr = D('article') -> where('status = 1  AND thumb != ""') -> order('addtime DESC')->limit($limit)->select();
		$show  = $page->show();// 分页显示输出

		$this->assign('show',$show);
		$this->assign('newArr',$newArr);
		$this->display();
	}
	
	public function detail(){
		
		$id = I('param.id','',trim);
	
		$detail = M('news')->cache(true)->where(array('id'=>$id))->find();
                $news_cat=M('news_cat')->where("cat_id={$detail['cat_id']}")->find();
                //dump($news_cat);
                $detail['content']= $this->addDomain($detail['content']);
                //dump($detail['content']);
		$this->assign('detail',$detail);
		$this->assign('news_cat',$news_cat);
                $this->setAssign($detail['title'],$detail['keywords'],$detail['description']);
                
                //上一条新闻
		$one_prev = M("news") -> where('id > '.$id.' and cat_id='.$detail['cat_id']) ->order('id ASC') -> find();
		//下一条新闻
		$one_next = M("news") -> where('id < '.$id.' and cat_id='.$detail['cat_id']) ->order('id desc') -> find();
                $this->assign('one_prev',$one_prev);
		$this->assign('one_next',$one_next);
                
		$this->display();
	}

	public function detail2(){
		
		$id = I('param.id','',trim);
	
		$detail = M('news')->cache(true)->where(array('id'=>$id))->find();
	
		$this->assign('detail',$detail);
		
		$this->display();
	}

	public function article(){
		
		$id = I('param.id','',trim);
	
		$detail = M('article')->cache(true)->where(array('id'=>$id))->find();
	
		$this->assign('detail',$detail);
		
		$this->display();
	}
}
?>