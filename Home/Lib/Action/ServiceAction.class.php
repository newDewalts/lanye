<?php
/**
 * 网站服务文章控制器
 */
class ServiceAction extends CommonAction{
	protected $pid = '11';

	public function _initialize(){
		parent::_initialize();
		// $cat_list = M('service_cat') -> field('cat_id,cat_name,pid') -> where('pid = 11') -> order('orders asc') -> select();
		$cat_list = M('service_cat') -> field('cat_id,cat_name,pid') -> where(array('pid'=>11, 'show_nav'=>1)) -> order('orders asc') -> select();
		$this -> assign('cat_list',$cat_list);
	}
	
    //  服务项目
    public function index(){

		$cat_list = M('service_cat') -> field('cat_id,cat_name,pid') -> where(array('pid'=>11, 'show_nav'=>1)) -> order('orders ASC') -> select();
    	$cat_id = trim($_GET['cat_id']);
    	$id = trim($_GET['id']);

    	if(empty($cat_id)){
    		$cat_id = $cat_list[0]['cat_id'];
    	}
 	  
    	//服务项目
    	if(empty($id)){
    		$service_info = M("Service")->where(array('cat_id'=>$cat_id,'status'=>'1'))->field("id,title,content")->order("orders desc")->find();
    	}else{
    	    $service_info = M("Service")->where(array('id'=>$id,'status'=>'1'))->field("id,title,content")->order("orders desc")->find();
         // echo M()->getlastsql();
    	}
    
    	$service_cat = M('service_cat')->field('cat_id,cat_name')->where(array('pid'=>11,'show_nav'=>1))->order('orders ASC')->select();
    	foreach($service_cat as $k=>$val){
    		$arr = M('service')->field('id,cat_id,title')->where(array('cat_id'=>$val['cat_id'],'status'=>1))->select();
    		$service_list[$k] = $val;
    		$service_list[$k]['info'] = $arr;
    	}
    	//echo '<pre>';
    	//dump($service_list);
    
    parent::assignSeoInfo('服务项目_蓝译');
		$this->assign('service_list',$service_list);
		$this->assign('service_info',$service_info);
    $this->assign('pid',$this->pid);
     $this->assign('cid',$cat_id);
		$this -> cat_id = $cat_id;
    	$this->display();
    } 
	
	// public function detail(){
	// 	Load('extend');
	// 	$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : '';
	// 	$cat_id = isset($_REQUEST['cat_id']) ? $_REQUEST['cat_id'] : '';
	// 	$result = M('service') -> where('id = '.$id) -> find();
	
	// 	//seo赋值
	// 	$this->assignSeoInfo($result['title'], $result['keywords'], $result['description']);
		
	// 	$this -> assign('result',$result);
	// 	$this -> cat_id = $cat_id;
	// 	$this -> display();
	// }


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

  public function test(){

    echo '22222';
  }


}