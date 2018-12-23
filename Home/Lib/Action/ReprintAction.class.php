<?php
/**
 * 转载控制器
 * 
 * @author D丶
 */
class ReprintAction extends CommonAction{
	public function _initialize(){
		parent::_initialize();
		$this->assign('gaoliang','1');
		parent::assignSeoInfo('文章转载_蓝译');
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
			$where['cat_id'] = '1';
		}
    	$where['status'] = 1;
		//符合条件的新闻总数
		$count = M('Reprint')->where($where)->count();
		//实例化分页类
		$Page  = new Page($count,10);

		$news_list = M('Reprint')->field('id,addtime,title,cat_id,summary')
								->where($where)
								->limit($Page->firstRow.','.$Page->listRows)
								->order('id desc')
								->select();

		//分页赋值
		$this->assign('pages',$Page->show());
		$this->assign('news_list',$news_list);
		$this->assignSeoInfo('文章转载_蓝译');

		$reprint_cat_li = D('reprint_cat')->where('pid=0')->select();
		$this->assign('reprint_cat_li',$reprint_cat_li);
		$this->assign('pid',122);
		//渲染模版
		$this->display();
	}
	
	/**
	 * 详细
	 */
	public function detail(){
		$id = $this->_get('id');
		$news_info = M('Reprint')->find($id);
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
    	M('Reprint')->where(array('id' => $id))->setInc('hits');
		//seo赋值
		$this->assignSeoInfo($news_info['title'].'_蓝译', $news_info['keywords'], $news_info['description']);

		//上一条新闻
		$one_prev = M("Reprint") -> where('id > '.$id.' and cat_id='.$news_info['cat_id']) ->order('id ASC') -> find();
		//下一条新闻
		$one_next = M("Reprint") -> where('id < '.$id.' and cat_id='.$news_info['cat_id']) ->order('id desc') -> find();
		
		$reprint_cat_li = D('reprint_cat')->where('pid=0')->select();

		//赋值
		$this->assign('news_info',$news_info);
		$this->assign('reprint_cat_li',$reprint_cat_li);
		// $this->assign('relation',$relation);
		$this->assign('one_prev',$one_prev);
		$this->assign('one_next',$one_next);
		$this->assign('pid',122);
		//渲染模版
		$this->display();
	}
}