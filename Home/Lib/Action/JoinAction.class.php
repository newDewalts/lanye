<?php 
/*
 * It is about Join;
 * @author:xu
 */
class JoinAction extends CommonAction{
	public function _initialize(){
		parent::_initialize();
		//导航高亮
		$this->assign('gaoliang','6');
	}
	
	public function index(){
	    $boolean     = false;
	    //设置大类的初始名称
	    $index_name  = '';
		//所有数据均存储在$data中
		$data        = array();
		//首页需要的数据存储在$index_array数组中
		$index_data  = array();
		//下级分类的编号数组
		$list_num    = array();
		//获取上级分类的所有信息
		$pre_array   = M('Article_cat')->cache()->where('cat_id = 14')->find();
		
		$index_name  = $pre_array['cat_name'];  

		//获取所有下级分类的信息
		$join_lists  = M('Article_cat')->cache()->where('pid = 14')->order('cat_id desc')->select();
		foreach($join_lists as $k => $v){
			$list_num[]             = $v['cat_id'];
			$v['pre_name']          = $pre_array['cat_name'];
			$data[$v['cat_id']]     = $v;
		}
		//指向前端传递符合条件的值
		if(IS_REQUEST){
			$cat_id         = I('request.id',0,'intval');
			if($cat_id <= 0){
				$this->_emtpy();
			}
			//这样做的目的是能够确保网站安全
			foreach($list_num as $key => $value){
				if($cat_id  == $value){
					$index_data         = M('Article')->cache()->where(array('cat_id' => $cat_id))->order('id desc')->limit(1)->select();
					
					//seo
					$seo    = M('Article_cat')->cache()->where(array('cat_id'=>$cat_id))->find();
					$this->assignSeoInfo($seo['cat_name'],$seo['keywords'],$seo['description']);
					
					$boolean= true;
					foreach($index_data as $k => $v){
						$index_data     = $v;
					}
					$index_data['num']  = $cat_id;
					$this->assign('cat_id',$cat_id);
					$this->assign('index_data',$index_data);
				}
			}
			if(!$boolean){
				$this->_empty();
			}
		}
		
		
		$this->assign('index_name',$index_name);
		$this->assign('data',$data);
		$this->display();
	}
	
}
?>