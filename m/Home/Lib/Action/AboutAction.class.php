<?php
/**
 * 关于我们控制器
 */
class AboutAction extends CommonAction{

	public function _initialize(){
		parent::_initialize();
	}
	

    //  关于我们列表页
    public function index(){
      $cat_id = I('get.cat_id');
      if(!$cat_id){
        $cat_id = '36';
        $_GET['cat_id'] = '36';
      }

      $info = M('article')->where(array('cat_id'=>$cat_id,'status'=>1))->find();
      $info['content']= $this->addDomain($info['content']);
      $this -> assign('info',$info);
      $this->setAssign("{$info['title']}");
      $this->display();
    }
    
    	/**
	 * 员工识别
	 */
	public function identify(){
		if(IS_POST){
			$fullname = $this->_post('fullname');
			$identifier = $this->_post('identifier');
			$employee = M('Employee')->where(array('fullname'=>$fullname,'identifier'=>$identifier))->find();
			if($employee){
				$this->assign('employee',$employee);
			}else{
				$this->assign('error','不存在该员工信息或者该员工信息还没有入库。');
			}
		}
		//赋值seo信息
		$this->setAssign('员工识别_蓝译');
		$this->assign('identify','1');
		$this->assign('pid',12);
		$this->display();
	}


	/**
	 * 员工识别
	 */
	public function employee(){
			
		$fullname = I('post.fullname');		//姓名
		$Identifier = I('post.identifier'); //工号
		
	
		if(!empty($fullname)){
			$ployee_info = M('employee')->where(array('fullname'=>$fullname))->find();
			
		}else if(!empty($Identifier)){
			$ployee_info = M('employee')->where(array('identifier'=>$Identifier))->find();	
		}
		
		//echo M()->getlastsql();
		//dump($ployee_info);
		$this->assign('ployee_info',$ployee_info);
		$this->assign('pid',12);
		$this->display();
	}
    
}