<?php
/**
 * 网站服务优势控制器
 */
class ServiceAdvantAction extends CommonAction{
	protected $pid = '3';

	public function _initialize(){
		parent::_initialize();
	}
	

    //  服务优势
    public function index(){

		 $cat_list = M('service_cat') -> field('cat_id,cat_name,pid') -> where(array('pid'=>$this->pid, 'show_nav'=>1)) -> order('orders desc') -> select();

    	$cat_id = trim($_GET['cat_id']);
    	
    	if(empty($cat_id)){
    		$cat_id = $cat_list[0]['cat_id'];
    	}
    		$service_info = M("Service")->where(array('cat_id'=>$cat_id,'status'=>'1'))->field("id,title,content")->order("orders desc")->find();
                $service_info['content']=$this->addDomain($service_info['content']);
      $this ->assign('cat_list',$cat_list);
  		$this -> assign('service_info',$service_info);
                $this->setAssign("{$service_info['title']}");
                //dump($service_info);
    	$this->display();
    } 
	
	
    /**
   * 服务优势
   */
  public function service_advant(){


    $id = $_GET['sid'];

    //获取服务优势信息
    $service_info = M("service")->filed('id,title,content')->where(array('id'=>$id,'status'=>1))->find();

    $this->assign('service_info',$service_info);

    $this->display();

  }




}