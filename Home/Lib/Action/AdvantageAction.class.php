<?php
/**
 * 服务优势控制器
 * 
 * @author su
 */
class AdvantageAction extends CommonAction{
	
	/*public function _initialize(){
		parent::_initialize();
		//导航高亮
		$this->assign('gaoliang','3');
	}*/
	
	public function index(){
		
		$cat_id = isset($_REQUEST['cat_id']) ? $_REQUEST['cat_id'] : '45';
		$m_cat = M('service_cat');
		$cat_info = $m_cat -> field('cat_name') -> where('cat_id = '.$cat_id) -> find();
		$bannerArr = M('ad') -> where('pos_id = 10 AND is_show = 1') -> order('orders ASC') -> find();
		//编辑团队
		if($cat_id == '50'){
			$this -> cat_id = $cat_id;
			$this -> editor();
			exit;
		}
		$m = M('service');
		$where = 'cat_id = '.$cat_id .' and status = 1';
		$result = $m -> where($where) -> order('addtime desc') -> limit(1) -> find();

		//seo赋值
		$this->assignSeoInfo($result['title'], $result['keywords'], $result['description']);
		
		$this -> cat_id = $cat_id;
		$this -> cat_name = $cat_info['cat_name'];
		$this -> assign('result',$result);
		$this -> assign('bannerArr',$bannerArr);
		$this->display();
	}
	
	//编辑团队
	public function editor(){
		// 导入分页类
    	import('@.ORG.Page'); 
		Load('extend');
		//编辑分类
		$editor = M('editor_cat') -> field('cat_id,cat_name,pid') -> where('pid = 1') -> select();

		//编辑列表
		$style = isset($_REQUEST['style']) ? $_REQUEST['style'] : '';
		$cat_id = isset($_REQUEST['cat_id']) ? $_REQUEST['cat_id'] : '';
		if(!empty($cat_id)){
			$this -> cat_id = $cat_id;
		}
		$arr = M('editor_cat') -> where('pid = 0') -> select();

		$where = 'status = 1';
		if(!empty($style)){
			$where .= ' and cat_id = '.$style;
		}
		$count = M('editor')->where($where) -> count();
		$Page  = new Page($count,5);
		$listArr = M('editor') -> where($where) -> limit($Page->firstRow.','.$Page->listRows) -> select();
		
		//seo赋值
		if ( !empty($style) ) {
		    $seoInfo = M('editor_cat')->where(array('cat_id'=>$style))->find();
		}else {
		    $seoInfo = M('service_cat')->where(array('cat_id'=>$cat_id))->find();
		}
		
		$this->assignSeoInfo($seoInfo['cat_name'], $seoInfo['keywords'], $seoInfo['description']);

		$this -> assign('editor',$editor);
		$this -> assign('listArr',$listArr);
		$this -> assign('pages',$Page->show());
		$this -> cat_id = $this -> cat_id;
		$this -> cat_name = $cat_info['cat_name'];
		//$this->assignSeoInfo('编辑团队');
		$this -> display('editor');
	}
	
}