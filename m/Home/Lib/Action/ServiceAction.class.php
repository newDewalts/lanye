<?php
/**
 * 服务项目控制器
 */
class ServiceAction extends CommonAction{
	protected $pid = '11';

	public function _initialize(){
		parent::_initialize();
	}
	

    //  服务优势
    public function index(){

    	$cat_id = trim($_GET['cat_id']);
    	
   
      $service_li= M("Service")->where(array('cat_id'=>$cat_id,'status'=>'1'))->field("id,title,content")->order("orders desc")->select();
      $id = trim($_GET['id']);
      if(empty($id)){
        $id = $service_li[0]['id'];
        $_GET['id'] = $id ;
      }

      $info= M("Service")->where(array('id'=>$id,'status'=>'1'))->field("id,title,content,cat_id")->find();
      
      //查分类名
      $cat_name= M("Service_cat")->where(array('cat_id'=>$info['cat_id']))->field("cat_name")->find();
      $service_li= M("Service")->where(array('cat_id'=>$info['cat_id'],'status'=>'1'))->field("id,title,content")->order("orders desc")->select();
      foreach($service_li as $key=>$val){
          $service_li[$key]['content']=$this->addDomain($service_li[$key]['content']);
      }
      //dump($service_li);
      $this->setAssign("{$cat_name['cat_name']}");
      $this ->assign('cat_name',$cat_name);
      $this ->assign('info',$info);
  		$this -> assign('service_li',$service_li);
    	$this->display();
    } 

}