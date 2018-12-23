<?php

/**
 * 在线投稿控制器
 * 
 * @author su
 */
class ContributeAction extends CommonAction {

	public function index() {
		if (IS_POST) {
			//IP校验
			$ip = get_client_ip();

			$check = S(md5(get_client_ip()));
			if ($check) {
				$this->error('频繁操作，请1小时之后再重新投稿');
			} else {
				//缓存信息

				$M = D("Contribute");
				$_POST['status'] = '0';


				if (!isEmail($_POST['email'])) {
					if (isMobile($_POST['email'])) {
						$_POST['mobile'] = $_POST['email'];
						unset($_POST['email']);
					} else {
						$this->error("请输入有效的手机号码");
					}
				}

				if ($M->create()) {
					if ($M->add()) {
						S(md5(get_client_ip()), true, 3600);
						$this->success('投稿成功，等待管理员查看！');
					} else {
						$this->success('投稿失败。');
					}
				} else {

					$this->error($M->getError());
				}
			}
		} else {
			$this->assignSeoInfo("在线投稿","在线投稿","在线投稿");
			$this->display();
		}
	}

	/**
	 * 稿件附件上传
	 */
	public function upload() {
		import('ORG.Net.UploadFile');
		$upload = new UploadFile();
		$upload->maxSize = 10 * 1024 * 1024;	 //设置上传图片的大小
		$upload->allowExts = array('docx', 'doc', 'xls', 'ppt', 'rar', 'zip', 'wps'); //设置上传图片的后缀
		$upload->uploadReplace = true;
		$upload->saveRule = 'uniqid';
		//完整的头像路径
		$path = './Uploads/attachment/';
		$upload->savePath = $path;
		if (!$upload->upload()) {
			echo json_encode($upload->getErrorMsg());
			exit;
		} else {	  // 上传成功 获取上传文件信息
			$info = $upload->getUploadFileInfo();
			echo json_encode($info['0']['savename']);
			exit;
		}
	}

}
