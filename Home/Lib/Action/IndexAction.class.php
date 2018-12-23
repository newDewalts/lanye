<?php
/**
 * 首页控制器
 * 
 * @author su
 */
class IndexAction extends CommonAction {
	public function _initialize(){
		parent::_initialize();
		//导航高亮
		$this->gaoliang = '0';
		parent::assignSeoInfo();
	}
	
	/**
	 * 首页信息
	 */
    public function index(){
		//加载第三方类库
		Load('extend');
		//高亮
		$this->isHome = '1';
		
		//首页banner图片
		$bannerArr = M('ad') -> where('pos_id = 8 AND is_show = 1') -> order('orders ASC') -> select();
		
		//服务项目6条 取中文论文服务
		$server_list = M('service_cat')->field('cat_id,cat_name,description,thumb')->where(array('pid'=>11,'show_nav'=>1))->order('orders ASC')->limit(8)->select();
		//dump($server_list);exit;
		//dump($service_info);exit;
		//客户反馈3条
		// $appraisal  = M('Feedback')->field('fullname,content')
		// 						->where('status=1')
		// 						->cache(true)
		// 						->limit(3)
		// 						->select();
		
		// 首页服务优势
		$serv = M('service_cat') -> where(array('pid'=>3,'show_nav'=>1)) -> order('orders desc') -> limit(4) -> select();
		foreach($serv as $key => $val){
			$serv_info[] = M('service') -> field('id,cat_id,title') -> where(array('cat_id'=>$val['cat_id'])) -> find();
			$serv_info[$key]['cat_name'] = $val['cat_name'];
			$serv_info[$key]['thumb'] = $val['thumb'];
			$serv_info[$key]['description'] = $val['description'];
		}
		
		//编辑团队
		$count = M('editor')->where(array('status'=>1,'show_index'=>1))->count();
		$num = $count%4;
		$edit_list = M('editor')->where(array('status'=>1,'show_index'=>1))->limit(3)->order('orders desc')->select();
		//dump($edit_list);

		//关于我们68  210*231
		//$about_info = M('article_cat')->field('cat_id,description,thumb')->where(array('cat_id'=>11))->select();
	
		//hot新闻
		//$news_hot = M('news')->field('id,title,summary,thumb')->where("cat_id=1 or cat_id=2")->order('hits desc')->find();
		//新闻中心
		$news_list = M('news')->field('id,title,addtime,thumb,content')->where("(cat_id=2 or cat_id=3) and show_index=1 and status=1   ")->limit(6)->order('addtime desc')->select();
                //$aaa=M('news')->getLastSql();
                //dump($aaa);
                //dump($news_list);
		// 文章
		//$article_list = M('article')->field('id, title, addtime,description')->where(array('status'=>1,'headline'=>1))->order('addtime desc')->limit(4)->select();

		// 转载
		//$reprint_list = D('reprint')->field('id, title, addtime,summary')->where(array('status'=>1,'show_index'=>1))->order('orders asc')->limit(6)->select();
                
                //SCI编译指导最新
                $article_list_sci_new = M('article')->field('id,addtime,title,cat_id,summary,thumb,content')->where('cat_id=47 and status=1')->limit(6)->order('id desc')->select();
                $this->assign('article_list_sci_new',$article_list_sci_new);
                //写作指导最新
                $article_list_sci_xie = M('article')->field('id,addtime,title,cat_id,summary,thumb,content')->where('cat_id=84 and  status=1')->limit(6)->order('id desc')->select();
                $this->assign('article_list_sci_xie',$article_list_sci_xie);
                //在线留言
                $feedback = M('feedback')->where('status=1')->order('id desc')->select();
                $feedback_data=array_chunk($feedback,2);
                $this ->assign('feedback_data',$feedback_data);

		//赋值
		//$this->assign('reprint_list',$reprint_list);
		$this -> assign('bannerArr',$bannerArr);
		$this -> assign('server_list',$server_list);
		$this -> assign('serv',$serv_info);
		$this -> assign('edit_list',$edit_list);
		//$this -> assign('about_info',$about_info);
		//$this -> assign('news_hot',$news_hot);
		$this -> assign('news_list',$news_list);
		//$this -> assign('article_list', $article_list);
		//渲染模版
		$this -> display();
    }

    /**
	 * SCI评估留言
	 */
    public function messages(){

    	import('ORG.Net.UploadFile');

    	$uploadname = date('Ym',time()); 	//附件保存文件名

    	$upload = new UploadFile();// 实例化上传类
    	$upload->maxSize  = 52428800 ;// 设置附件上传大小
		$upload->allowExts  = array('jpg', 'gif', 'png', 'jpeg','doc','docx');// 设置附件上传类型
		$upload->savePath =  './Uploads/Messages/'.$uploadname.'/';// 设置附件上传目录
		if(!$upload->upload()) {
			// 上传错误提示错误信息
			$this->error($upload->getErrorMsg());
		 }else{
		 	// 上传成功 获取上传文件信息
			$info =  $upload->getUploadFileInfo();
		 }
    	//保存表单数据
    	$m = M('message'); 	//实例化messages对象
    	$data = $m->create();
    	$data['filename'] = $info[0]['savepath'].$info[0]['savename'];	//保存上传的附件路径 
    	//dump($data);die;
    	if($m->add($data)){

    		$this->success('提交成功！');
    	}else{

    		$this->error('提交失败！');
    	}


    }

	
	
	/**
	 * 在线留言
	 */
	public function online_add(){
		if(IS_POST){
			$M = M("feedback");
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
				$this->error($M->getError());
			}
		}

	}


	



}