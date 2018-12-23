<?php 
/**
 * ActinoAction
 * */

class ArticleAction extends CommonAction{
	public function index(){
		$this->redirect('service/lists');
	}
	
	public function lists(){
		
		//Company instruction
		$company_ins = M('news')->cache(true)->field('id,thumb,summary,title')->where(array('id'=>98))->find();		
		$this->assign('company_ins',$company_ins);
		
		$cat_id = I('param.cat_id',12,trim);
	
		$catInfo = M('article_cat')->field('cat_id,cat_name,keywords,description')->cache(true)->where(array('cat_id'=>$cat_id))->find();
		
		$catList = M('article_cat')->field('cat_id')->cache(true)->where(array('pid'=>$cat_id))->select();
		$str = '';
		foreach ($catList as $key => $value) {
			$str .= $value['cat_id'].',';
		}
		$str = substr($str,0,-1);
		$where['cat_id'] = $cat_id;
		$where['status'] = 1;
		
		//导入分页类
		import('ORG.Util.Page');
		$count       = M('article')->where($where)->count();			 
		//实例化分页类
		$Page        = new Page($count,6);
		$pageShow    = $Page->show();		
		
		$lists  = M('article')->cache(true)->field('id,title,summary,thumb')
							  ->where(array("cat_id in (".$str.")",'status'=>1))
							  ->limit($Page->firstRow.','.$Page->listRows)
							  ->order('orders desc')
							  ->select();
		$this->setAssign($catInfo['cat_name'],$catInfo['keywords'],$catInfo['description']);  
		$this->assign('catInfo',$catInfo);
		$this->assign('lists',$lists);
		$this->assign('pageShow',$pageShow);
		
		$this->display();
	}
	
	public function detail(){
		
		$id = I('param.id','',trim);
		
		$detail = M('article')->cache(true)->where(array('id'=>$id))->find();
		
		$detail['content'] = $this->addDomain($detail['content']);		
		
		$forward_url = $_SERVER['HTTP_REFERER'];
	
		$this->assign('forward_url',$forward_url);		
		$this->assign('detail',$detail);
	
		$this->display();
	}
}
?>