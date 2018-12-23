<?php
// 首页控制器
class IndexAction extends CommonAction {
	public function _initialize(){
		parent::_initialize();
	}
    public function index(){
 		//首页banner图片
		$bannerArr = M('ad') -> where('pos_id = 16 AND is_show = 1') -> order('orders ASC') -> select();
                //dump($bannerArr);
		//新闻
		$newArr =  D('news') -> where('status = 1 AND show_index = 1 AND (cat_id=2 or cat_id=3) AND thumb != ""') -> order('addtime DESC') ->limit(4)-> select();
                //dump($newArr);

		//转载
		$reprintArr =  D('reprint') -> where('status = 1 AND show_index = 1') -> order('addtime DESC') ->limit(6)-> select();

		//编辑团队
		$editorArr = M('editor') ->field('id,name,avatar,summary')-> where('status = 1 and show_index=1')->order('orders asc')->limit('4') ->select();
               
                //在线留言
                $feedback = M('feedback')->where('status=1')->order('id desc')->limit('4')->select();

		$this -> assign('editorArr',$editorArr);
		$this -> assign('reprintArr',$reprintArr);
		$this -> assign('bannerArr',$bannerArr);
		$this -> assign('newArr',$newArr);
                $this -> assign('feedback',$feedback);

		$this -> display();

	}
	
	public function feedback($name,$mobile,$content){
		
		if(trim($name) == '' || trim($mobile) == '' || trim($content) == ''){
			$message = '请填写完整信息！';
		}
		$m = M('feedback');
		$data['fullname'] = $name;
		$data['phone'] = $mobile;
		$data['content'] = $content;
		$data['addtime'] = time();
		$data['status'] = '0';
		$result = $m -> add($data);
		if($result){
			echo json_encode(array('status' => 1, 'msg' => '留言成功！'));
		}else{
			echo json_encode(array('status' => 0, 'msg' => '留言失败，请重试'));
		}	
	}

	protected function serAdvan(){
		$serAdvan = M('service_cat')->cache(false)
									->field('cat_name,thumb')
									->where(array('cat_id'=>3))
									->find();
		$this->assign('serAdvan',$serAdvan);

		$serAdvanlists = M('service')->cache(false)
									 ->field('id,title,thumb,description,orders')
									 ->where(array('cat_id'=>3,'show_nav'=>1))
									 ->order('orders desc')
									 ->select();			 
		$this->assign('serAdvanlists',$serAdvanlists);
	}

	protected function newsInfo(){
		$newsInfo = M('news_cat')->cache(true)
								   ->field('cat_id,cat_name')
								   ->where(array('cat_id'=>2))
								   ->find();
								   
		$newsInfoLists = M('news')->cache(true)
									->field('id,title')
									->where(array('cat_id'=>2,'status'=>1))
									->order('orders desc')
									->limit(5)
									->select();
		$this->assign('newsInfo',$newsInfo);
		$this->assign('newsInfoLists',$newsInfoLists);
	}
	
	public function feedtel($mobile){
		if(trim($mobile) == ''){
			$message = '请输入电话号码！';
		}
		$m = M('feedback');
		$data['phone'] = $mobile;
		$data['addtime'] = time();
		$data['status'] = '0';
		$result = $m -> add($data);
		if($result){
			echo json_encode(array('status' => 1, 'msg' => '请稍候！'));
		}else{
			echo json_encode(array('status' => 0, 'msg' => '请重新输入号码'));
		}
	}
        
        public function phone_feedback(){
                $name = $_POST['name'];
                $phone = $_POST['phone'];
                $content = $_POST['content'];
                
		if(trim($name) == '' || trim($phone) == '' || trim($content) == ''){
			$this->success('请先填写信息！');
                        exit();
		}
                /*
		$m = M('feedback');
		$data['fullname'] = $name;
		$data['phone'] = $mobile;
		$data['content'] = $content;
		$data['addtime'] = time();
		$data['status'] = '0';
                 * 
                 */
                $m = M('message');
                $data['name'] = $name;
		$data['phone'] = $phone;
		$data['liuyan'] = $content;
		$data['addtime'] = date('Y-m-d H:i:s ');
		$data['status'] = '0';
                
		$result = $m -> add($data);
		if($result){
			$this->success('提交成功！');
		}else{
			$this->success('提交失败！');
		}	
	}
}