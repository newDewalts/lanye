<?php
/**
 * 编辑控制器
 * 
 * @author su
 */
 class EditorsAction extends CommonAction{
	public function _initialize(){
		parent::_initialize();
		//导航高亮
		$this->assign('gaoliang','1');
		parent::assignSeoInfo('编辑团队_蓝译');
	}
	
	/**
	 * 编辑
	 */
	public function index(){
		// 导入分页类
    	import('@.ORG.Page'); 
		Load('extend');
		
		$style = isset($_REQUEST['style']) ? $_REQUEST['style'] : '';
		$arr = M('editor_cat') -> where('pid = 0') -> select();
		$editArr = '';
		if($arr){
			foreach($arr as $key => $val){
				$editArr[$key] = M('editor_cat') -> field('cat_id,cat_name') -> where(array('pid' => $val['cat_id'])) -> select();
			}
		}
		$where = 'status = 1 and show_index=1';
		if(!empty($style)){
			$where .= ' and cat_id = '.$style;
		}
		
		$count = M('editor')->where($where) -> count();
		$Page  = new Page($count,8);
		$Page->setConfig('theme', $this->pageTheme);
		$listArr = M('editor') -> where($where) -> limit($Page->firstRow.','.$Page->listRows) -> select();
		//print_r($Page->show());exit;
		$this -> assign('listArr',$listArr);
		$this->assign('pages',$Page->show());
		//$this -> assign('editArr',$editArr);
		$this->assign('pid',14);
		$this->display();
	}

	//详情页
	public function detail(){

		$id = I('get.id');

		$edit_info = M('editor')->field('id,name,introduction,summary,avatar')->where(array('id'=>$id))->find();
		
		//上一页
		$front= M('editor')->where("id<".$id.' AND status = 1 and show_index=1 ')->order('id desc')->limit('1')->find();
       
        //下一页
        $after= M('editor')->where("id>".$id.' AND status = 1 and show_index=1')->order('id asc')->limit('1')->find();
     
     
        $this->assign('front',$front);
        $this->assign('after',$after);
		$this->assign('edit_info',$edit_info);
		$this->assign('pid',14);
		$this->display();

	}
	
	
 }