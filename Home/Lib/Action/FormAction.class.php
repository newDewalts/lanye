<?php
/**
 * 留言板、投稿控制器
 * 
 * @author su
 */
class FormAction extends CommonAction{
	/**
	 * 留言板
	 */
	public function feedback(){
		if(IS_POST){
			//验证码判断
			if (session('verify') != md5($_POST['verify'])) {
				$REFERER = $this->_server('HTTP_REFERER');
				$this->error('验证码不正确',$REFERER);
			}
			$M = D("Feedback");
			$_POST['addtime'] = time();
			$_POST['status'] = '1';
			if($M->create()){
				if($M->add()){
					$this->success('留言成功，等待管理员查看！');
				}else{
					$this->success('留言失败。');
				}
			}else{
				$this->error($M->getError());
			}
		}
	}
	
	public function complain(){
		if(IS_POST){
			if(session('verify') != md5($_POST['verify'])){
				$REFERER = $this->_server('HTTP_REFERER');
				$this->error('验证码不正确',$REFERER);
			}
			$M = D("Feedback");
			$_POST['addtime'] = time();
			$_POST['status']  = '1';
			if($M->create()){
				if($M->add()){
					$this->success('感谢你的投诉与建议，我们会尽快处理或采纳。');
				}else{
					$this->success('提交失败，请按要求填写完整信息');
				}
			}else{
				$this->error($M->getError());
			}
		}
	}
	
	public function words(){
		if(IS_POST){
			if(session('verify') != md5($_POST['verify'])){
				$REFERER = $this->_server('HTTP_REFERER');
				$this->error('验证码不正确',$REFERER);
			}
			$M = D("Feedback");
			$_POST['addtime'] = time();
			$_POST['status']  = '1';
			if($M->create()){
				if($M->add()){
					$this->success('感谢你的留言，希望您能一如既往的支持我们！');
				}else{
					$this->success('提交失败，请按要求填写完整信息');
				}
			}else{
				$this->error($M->getError());
			}
		}
	}
	
	/**
	 * 投稿
	 */ 
	public function contribute(){
		if(IS_POST){
			//验证码判断
			if (session('verify') != md5($_POST['verify'])) {
				$REFERER = $this->_server('HTTP_REFERER');
				$this->error('验证码不正确',$REFERER);
			}
			$M = D("Contribute");
			$_POST['status'] = '0';
			if($M->create()){
				if($M->add()){
					$this->success('投稿成功，等待管理员查看！');
				}else{
					$this->success('投稿失败。');
				}
			}else{
				$this->error($M->getError());
			}
		}
	}
	
	/**
	 * 稿件附件上传
	 */
	public function upload(){
		import('@.ORG.UploadFile');
		$upload = new UploadFile();
		$upload->maxSize = 10*1024*1024;					//设置上传图片的大小
		$upload->allowExts = array('doc','xls','ppt','rar','zip','wps');	//设置上传图片的后缀
		$upload->uploadReplace = true;
		$upload->saveRule = 'uniqid';
		//完整的头像路径
		$path = './Uploads/attachment/';
		$upload->savePath = $path;
		if(!$upload->upload()) {
			echo $upload->getErrorMsg();
			exit;
		}else{						// 上传成功 获取上传文件信息
			$info =  $upload->getUploadFileInfo();
			echo $info['0']['savename'];
			exit;
		}
	}
}