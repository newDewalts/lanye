<?php
/**
 * 关于我们控制器
 * 
 * @author su
 */
 class AboutAction extends CommonAction{
	public function _initialize(){
		parent::_initialize();
		$about_menu = M('article_cat') -> where(array('pid' => 11,'show_nav' => 1)) -> order('cat_id asc') -> select();
		$this -> assign('about_menu',$about_menu);
		parent::assignSeoInfo('关于我们_蓝译');
	}
	
	/**
	 * 关于我们
	 */
	public function index(){
		
		$cat_id = isset($_REQUEST['cat_id']) ? $_REQUEST['cat_id'] : '36';
		$m = M('article');
		$where = 'cat_id = '.$cat_id;
		$result = $m -> where($where) -> find();

		//seo赋值
		$seoInfo = M('article_cat')->where(array('cat_id'=>$cat_id,'status'=>1))->find();
		$this->assignSeoInfo($seoInfo['cat_name'].'_蓝译', $seoInfo['keywords'], $seoInfo['description']);
		
		$this -> cat_id = $cat_id;
		$this -> assign('result',$result);
		$this->assign('pid',12);
		$this->display();
	}
	


	/**
	 * 联系我们
	 */
	public function contact(){
			

	//	$time = date('Y-m-d H:i:s',time());
	//	echo $time;
		$cat_id = isset($_REQUEST['cat_id']) ? $_REQUEST['cat_id'] : 41;

		$contact_info = M('article')->where(array('cat_id'=>$cat_id,'status'=>1))->find();

		//dump($contact_info);die;
		$this->assign('contact_info',$contact_info);
		$this->assign('pid',12);
		$this->display();
	}

	/**
	 * 支付方式
	 */
	public function paymethod(){
			

	//	$time = date('Y-m-d H:i:s',time());
	//	echo $time;
		$cat_id = isset($_REQUEST['cat_id']) ? $_REQUEST['cat_id'] : 40;

		$contact_info = M('article')->where(array('cat_id'=>$cat_id,'status'=>1))->find();

		//dump($contact_info);die;
		$this->assign('contact_info',$contact_info);
		$this->assign('pid',12);
		$this->display();
	}

	public function join(){
			

	//	$time = date('Y-m-d H:i:s',time());
	//	echo $time;
		$cat_id = isset($_REQUEST['cat_id']) ? $_REQUEST['cat_id'] : 40;

		$contact_info = M('article')->where(array('cat_id'=>$cat_id,'status'=>1))->find();

		//dump($contact_info);die;
		$this->assign('contact_info',$contact_info);
		$this->assignSeoInfo('加入我们_蓝译');
		$this->assign('pid',12);
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
		$this->assignSeoInfo('员工识别_蓝译');
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


	public function tousu(){

	
		$cat_id = isset($_REQUEST['cat_id']) ? $_REQUEST['cat_id'] : 126;

		$contact_info = M('article')->where(array('cat_id'=>$cat_id,'status'=>1))->find();

		//dump($contact_info);die;
		$this->assign('contact_info',$contact_info);
		$this->assignSeoInfo('投诉与建议_蓝译');
		$this->assign('pid',12);
		$this->display();
	}
}