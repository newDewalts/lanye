<?php
/**
 * 网站在线留言控制器
 */
class OnlineAction extends CommonAction{
	public function _initialize(){
		parent::_initialize();
		// $cat_list = M('service_cat') -> field('cat_id,cat_name,pid') -> where('pid = 11') -> order('orders asc') -> select();
		$cat_list = M('service_cat') -> field('cat_id,cat_name,pid') -> where(array('pid'=>11, 'show_nav'=>1)) -> order('orders asc') -> select();
		$this -> assign('cat_list',$cat_list);
	}
	
    // 在线留言
    public function index(){
	
    	$this->display();
    } 

	// 在线留言
    public function online_add(){

    	if(IS_POST){
    		$M = M('feedback');

    		$data = $M->create();
    		$data['addtime'] = time();
    		$data['status'] = 1;

    		if($data){
    		   if($M->add($data)){
					$this->success('提交成功，等待管理员查看！');
				}else{
					$this->success('提交失败，请稍后操作。');
				}
    		}else{
    			
    		}
    		

    	}

    }
	

}