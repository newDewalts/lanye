<?php
/**
 * 学习资源控制器
 * 
 * @author su
 */

class UserAction extends CommonAction{
	public function _initialize(){
		parent::_initialize();
		$this->assign('gaoliang',10);
	}
	public function index(){
		//$user_id = session('user_id');
		//判断是否登录
		$user_id = $this->is_login();
		$user_info = M('User')->find($user_id);
		//获取个人动态
		$member_dynamic = M('member_log')->where("user_id={$user_id}")->order('id desc')->select();
		$this->assignSeoInfo('会员中心');
		$this->assign('user_info',$user_info);
		$this->assign('member_dynamic',$member_dynamic);
		$this->assign('action_',1);
		$this->display();
	}
	
	/**
	 * 会员登录
	 */
	public function login(){
		if(IS_POST){
			$username = trim($_POST['username']);
			$password = trim($_POST['password']);
			if($username == ''){
				$this -> error('用户名不能为空');
			}
			if($password == ''){
				$this -> error('密码不能为空');
			}
			
			//$userInfo  = D('User')->login($username, md5($password));
			$userInfo = M('user') -> where(array('username' => $username,'role_id'=>4)) -> limit(1) -> find();
			
			if(!$userInfo){
				$this -> error('该用户不存在');
			}elseif ($userInfo['status'] == 0) {
				$this->error('账号已被锁定');
			}else{
				$pas = $userInfo['password'];
				if($pas != md5($password)){
					$this -> error('密码错误');
				}
			}
			
			// 登录成功,设置session信息
			$this->setLoginedSession($userInfo);
			// 设置cookie
			if($_POST['cookie']=='on'){
				cookie('auth', authcode($username."\t".md5($password)),3600*12);
			}else{
				cookie('auth', authcode($username."\t".md5($password)));
			}
			// 修改最后登录信息
			$data = array();
			$data['last_login_time'] = time();
			$data['last_login_ip']     =get_client_ip();
			$data['user_id']     		= $userInfo['user_id'];
			M('User')->save($data);
			
			$this->success('登陆成功',U('User/index'));
				
			
			
		}else{
			$this->display();
		}
	}
	
	public function register(){
		if(IS_POST){
			//验证码判断
			if (session('verify') != md5($_POST['code'])) {
				$this->error('验证码不正确');
			}
			$password = $_POST['password'];
			$repassword = isset($_POST['repassword']) ? $_POST['repassword'] : '';
			if(empty($repassword)){
				$this -> error('确认密码必须填写');
			}
			if($password != $repassword){
				$this -> error('两次密码不一致');
			}
			$data = D('User')->create();
			if($data){
				$data['password'] 		= md5($data['password']);
				$data['create_time'] 		= time();
				$data['last_login_time'] = time();
				$data['reg_ip'] 				= get_client_ip();
				$data['last_login_ip'] 	= get_client_ip();
				$data['status'] 				= 1;
				$data['login_count'] 		= 1;
				$data['role_id'] 				= C('REGISTER_USER_ROLE_ID');
				if ($insert_id = D('User')->add($data)) {
					$userInfo = M('User')->find($insert_id);
					// 添加用户角色
					M('Role_user')->add(array('role_id'=>C('REGISTER_USER_ROLE_ID'), 'user_id' => $insert_id));
					// 设置cookie
					cookie('auth', authcode($data['username']."\t".$data['password']));
					//设置session
					$this->setLoginedSession($userInfo);
					$this->member_action($insert_id,'在本网站注册了用户信息。');
					
					$this->success('登陆成功',U('User/index'));
					
				} else {
					$this->error('注册失败');
				}
			}else{
				$this->error('注册失败');
			}
		}else{
			$this -> display();
		}
		
	}
	
	public function index2(){
		$this -> display();
	}
	
	public function verify(){
		import('ORG.Util.Image');
        Image::buildImageVerify(4,1,png,60,30);
	}
	
	/**
	 * 修改资料
	 */
	public function profile()
	{
		if (IS_POST) {
			$data = array();
			$data['nickname'] = trim($_POST['nickname']);
			$data['email'] 		= trim($_POST['email']);
			$data['mobile'] 		= trim($_POST['mobile']);
			$data['phone'] 		= trim($_POST['phone']);
			$data['user_id'] 	= session('user_id');
			$data['zip_code'] 	= trim($_POST['zip_code']);
			$data['address'] 	= trim($_POST['address']);
			
			if (D('User')->save($data) !== false) {
				$this->member_action($data['user_id'],'修改了用户信息。');
				$this->success('修改资料成功');
			} else {
				$this->error('修改资料失败');
			}
		}
	}
	
	/**
	 * 修改密码
	 */
	public function password(){
		if(IS_POST){
			$oldpassword 	= 	$_POST['oldpassword'];
			$password 		= 	$_POST['password'];
			$repassword 	= 	$_POST['repassword'];
			
			if (!$oldpassword) {
				$this->error('请填写旧密码');
			}
			if (!$password) {
				$this->error('请填写新密码');
			}
			if (!$repassword) {
				$this->error('请填写确认新密码');
			}
			if ($password != $repassword) {
				$this->error('两次新密码不一致');
			}
			$Model = M('User');
			$originalPassword= $Model->where(array('user_id' => session('user_id')))
													 ->getField('password');
			if (md5($oldpassword) != $originalPassword) {
				$this->error('旧密码错误');
			}
			$data = array();
			$data['user_id'] 	= session('user_id');
			$data['password'] = md5($password);
			if ($Model->save($data) !== false) {
				cookie('auth', null);
				session('user_id', null);
				session('username', null);
				$this->success('修改密码成功,请重新登录', U('User/login'));
			} else {
				$this->error('修改密码失败');
			}
		}else{
			//判断是否登录
			$user_id = $this->is_login();
			$this->assignSeoInfo('修改密码');
			$this->assign('user_info', M('User')->limit(1)->find($user_id));
			$this->assign('action_',2);
			$this->display();
		}
	}
	
	/**
	 * 忘记密码 
	 */
	public function forgot_pwd(){
		if(IS_POST){
			$email = $this->_post('email');
			$username = $this->_post('username');
			//查找用户是否存在
			$user_info = M('User')->where("username='{$username}' and email='{$email}'")->find();
			if(empty($user_info)){
				$this->error('不存在该用户或该用户的注册邮箱不对。');
			}
			$user_id = $user_info['user_id'];
			//获取随机数[a-zA-Z0-9]
			$pattern = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLOMNOPQRSTUVWXYZ1234567890';
			for($i=0;$i<6;$i++){
				$key .= $pattern{mt_rand(0,35)};    //生成php随机数
			}
			$html = "尊敬的 {$username}：<br/>
感谢您对辑文编辑的信任，您的新密码为{$key}，请保护好您的账号。<br/>
如有任何疑问，欢迎随时与我们联系，我们将竭诚为您服务！<br/>
&nbsp;&nbsp;&nbsp;&nbsp;欢迎继续关注辑文编辑！<br/>
&nbsp;&nbsp;&nbsp;&nbsp;祝：<br/>
&nbsp;&nbsp;&nbsp;&nbsp;工作学习顺利， 生活愉快！---【辑文编辑】";
			//邮件发送
			$retrun = sendMail($email,'密码找回',$html);
			if($retrun==1){
				//修改密码
				M('User')->where('user_id='.$user_id)->save(array('password'=>md5($key)));
				$this->success('密码找回成功，请登录邮箱查看。',U('/member'));
			}else{
				$this->success('邮件发送失败，请联系管理员，稍后操作。');
			}
		}else{
			$this->display();
		}
	}
	
	/**
	 * 上传头像
	 */
	public function uploadImg(){
		import('@.ORG.UploadFile');
		$upload = new UploadFile();						// 实例化上传类
		$upload->maxSize = 1*1024*1024;					//设置上传图片的大小
		$upload->allowExts = array('jpg','png','gif');	//设置上传图片的后缀
		$upload->uploadReplace = true;					//同名则替换
		$upload->saveRule = 'uniqid';					//设置上传头像命名规则(临时图片),修改了UploadFile上传类
		//完整的头像路径
		$path = './Uploads/Avatar/';
		$upload->savePath = $path;
		if(!$upload->upload()) {						// 上传错误提示错误信息
			$this->ajaxReturn('',$upload->getErrorMsg(),0,'json');
		}else{						// 上传成功 获取上传文件信息
			$info =  $upload->getUploadFileInfo();
			$temp_size = getimagesize($path.$info['0']['savename']);
			if($temp_size[0] < 150 || $temp_size[1] < 150){//判断宽和高是否符合头像要求
				$this->ajaxReturn(0,'图片宽或高不得小于150px！',0,'json');
			}
			$data['picName'] = $info['0']['savename'];
			$data['status'] = 1;
			$data['url'] = __ROOT__.'/Uploads/Avatar/'.$data['picName'];
			$data['info'] = $info;
			$this->ajaxReturn($data,'json');
		}
	}
	
	/**
	 * 裁剪并保存用户头像
	 */
	public function cropImg(){
		//图片裁剪数据
		$params = $this->_post();						//裁剪参数
		if(!isset($params) && empty($params)){
			return;
		}
		
		//头像目录地址
		$path = './Uploads/Avatar/';
		//要保存的图片
		$real_path = $path.$params['picName'];
		//临时图片地址
		$pic_path = $path.$params['picName'];
		import('@.ORG.ThinkImage.ThinkImage');
		$Image = new ThinkImage(THINKIMAGE_GD); 
		//裁剪原图
		$Image->open($pic_path)->crop($params['w'],$params['h'],$params['x'],$params['y'])->save($real_path);
		//生成缩略图
		$Image->open($real_path)->thumb(150,150, 1)->save($path.'150_'.$params['picName']);
		$Image->open($real_path)->thumb(100,100, 1)->save($path.'100_'.$params['picName']);
		//$Image->open($real_path)->thumb(60,60, 1)->save($path.'60_'.$params['picName']);
		$avatar_info = M('User')->where('user_id='.session('user_id'))->save(array('avatar'=>$path.'150_'.$params['picName']));
		$this->success('上传头像成功');
	}

	public function system_avatar(){
		$user_id = $_SESSION['user_id'];
		$id = $this->_get('id');
		switch ($id){
			case 1;
				$avatar = '/Public/images/avatar_1.jpg';
				break;
			case 2;
				$avatar = '/Public/images/avatar_2.jpg';
				break;
			case 3;
				$avatar = '/Public/images/avatar_3.jpg';
				break;
			case 4;
				$avatar = '/Public/images/avatar_4.jpg';
				break;
		}
		
		$avatar_info = M('User')->where('user_id='.$user_id)->save(array('avatar'=>$avatar));
		if($avatar_info!==false){
			$this->success('头像选择成功。');
		}else{
			$this->success('头像选择失败，请稍后操作。');
		}
	}
	
	/**
	 * 退出
	 */
	public function logout(){
		cookie('auth', null);
		session('user_id', null);
		session('username', null);
		$this->success('退出成功',U('User/login'));
	}
	
	/**
	 * 判断是否有登录
	 */
	public function is_login(){
		$user_id = session('user_id');
		if(empty($user_id)){
			$this->redirect('login');
		}else{
			return $user_id;
		}
	}
}