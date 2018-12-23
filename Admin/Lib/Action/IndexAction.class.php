<?php
/**
 * 后台首页控制器
 * 
 * @author xiaosibo
 */
class IndexAction extends CommonAction 
{
	// 后台主页面
    public function index()
    {
    	$this->assign('menu', $this->getMenu());
		$this->display();
    }
    
    /**
     * 获取后台导航菜单
     * @return array
     */
    protected function getMenu()
    {
		$superAdmin = session(C('ADMIN_AUTH_KEY'));
		
		/*
         * $access 			存放所有权限数组
         * $accessModels 	存放所有有权限的模块数组
         * $menu 				存放导航菜单数组
         * $topMenuIds 	存放一级菜单的id
		 */
		$access = $accessModels = $menu =  $topMenuIds  =  array();
		$menuModel  = M('Menu');
		
		foreach ((array)$_SESSION['_ACCESS_LIST']['ADMIN'] as  $key => $val) {
			$accessModels[] = $key;
			$access[$key]    = array_keys($val);
		}
		
		// 获取一级菜单
		$topMenuList = $menuModel->where('pid=0 AND status=1')
		                                   			->order('orders DESC, menu_id ASC')
										   			->select();
		
		// 获取有权限的一级导航
		foreach ($topMenuList as $topMenu) {
			if (in_array(strtoupper($topMenu['model']), $accessModels) || $superAdmin) {
				$menu[$topMenu['menu_id']] = $topMenu;
				$topMenuIds[] = $topMenu['menu_id'];
			}
		}
		
		// 获取二级菜单
		$map = array();
		$map['pid']	   = array('in', $topMenuIds);
		$map['status'] = 1;
		$subMenuList  = $menuModel->where($map)
													->order('orders DESC, menu_id ASC')
													->select();
		
		// 将有权限的二级菜单整合到一级菜单中
		foreach ($subMenuList as $subMenu) {
		
			// 有权限的模块
			if (in_array(strtoupper($subMenu['model']), $accessModels) || $superAdmin) {
				 
				// 没有action 则默认为index
				if (!$subMenu['action']) {
					$subMenu['action'] = 'index';
				}
				 
				// 取得有权限模块下有权限的方法
				/*
				 $accessActions = $_SESSION['_ACCESS_LIST']['ADMIN'][strtoupper($subMenu['model'])];
				$accessActions = array_keys($accessActions);
				*/
				$accessActions = isset($access[strtoupper($subMenu['model'])]) ? $access[strtoupper($subMenu['model'])] : array();
				 
				if (in_array(strtoupper($subMenu['action']), $accessActions) || $superAdmin) {
					$menu[$subMenu['pid']]['sub_menu'][] = $subMenu;
				}
			}
		
		}
		
		foreach ($menu as $key => $val) {
			// 如果一级菜单中没有子菜单，则删除不显示
			if (empty($val['sub_menu'])) {
				unset($menu[$key]);
			}
		}
		
		return $menu;
    }
    
    // 后台首页主体 查看系统信息
    public function main()
    {
    	$info = array(
    			'操作系统'	 		=>	PHP_OS,
    			'运行环境'			=>	$_SERVER["SERVER_SOFTWARE"],
    			'PHP运行方式'		=>	php_sapi_name(),
    		//	'ThinkPHP版本'	=>	THINK_VERSION.' [ <a href="http://thinkphp.cn" target="_blank">查看最新版本</a> ]',
    			'上传附件限制'		=>	ini_get('upload_max_filesize'),
    			'执行时间限制'		=>	ini_get('max_execution_time').'秒',
    			'服务器时间'		=>	date("Y年n月j日 H:i:s"),
    			'北京时间'			=>	gmdate("Y年n月j日 H:i:s",time()+8*3600),
    			'服务器域名/IP'	=>	$_SERVER['SERVER_NAME'].' [ '.gethostbyname($_SERVER['SERVER_NAME']).' ]',
    			'剩余空间'			=>	round((@disk_free_space(".")/(1024*1024)),2).'M',
    			'register_globals'		=>	get_cfg_var("register_globals")=="1" ? "ON" : "OFF",
    			'magic_quotes_gpc'		=>	(1===get_magic_quotes_gpc())?'YES':'NO',
    			'magic_quotes_runtime'	=>	(1===get_magic_quotes_runtime())?'YES':'NO',
    	);
    	$this->assign('info', $info);
    	$this->display();
    }
    
    // 修改资料
    public function profile() 
    {
    	if (IS_POST) {
    		$data = array();
    		$data['nickname'] = I('post.nickname');
    		$data['email']       = I('post.email');
    		$data['user_id']    = session('user_info.user_id');
    		
    		$data['mobile']     = $_POST['mobile'];
    		$data['phone']     = $_POST['phone'];
 
    		if (empty($data['email'])) {
    			$this->error('邮箱必须填写');
    		}
    		if (!preg_match('/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/i', $data['email'])) {
    			$this->error('邮箱格式不正确');
    		}
    		
    		if (empty($data['mobile'])) {
    			$this->error('手机必须填写');
    		}
    		if (!isMobile($data['mobile'])) {
    			$this->error('手机格式不正确');
    		}
    		
    		if (M('User')->save($data) !== false) {
    			$this->success('修改资料成功');
    		} else {
    			$this->error('修改资料失败');
    		}
    	} else {
    		$this->assign('userInfo',  M('User')->find(session('user_info.user_id')));
    		$this->display();
    	}
    }
    
    // 修改密码
    public function password()
    {
    	if (IS_POST) {
    		$oldpassword	= I('post.oldpassword');
    		$password	  	= I('post.password');
    		$repassword     = I('post.repassword');
    		
    		if ($password != $repassword) {
    			$this->error('两次密码不一致');
    		}
    		$Model  = M('User');
    		$userId = session('user_info.user_id');
    		$md5OldPassword = $Model->where(array('user_id' => $userId))->getField('password');;
    		
    		if (md5($oldpassword) != $md5OldPassword) {
    			$this->error('旧密码不正确');
    		}
    		
    		$data = array();
    		$data['user_id']    = $userId;
    		$data['password'] = md5($password);
    		
    		if ($Model->save($data)) {
    			session_destroy();
    			$this->success('修改密码成功, 请重新登录', U('Public/login'));
    		} else {
    			$this->error('修改密码失败');
    		}
    	} else {
    		$this->display();
    	}
    }
    
    // 清除缓存(清空整个Runtime目录)
    public function clearCache()
    {
    	// 后台
    	delete_dir(RUNTIME_PATH);

    	// 前台
    	delete_dir('./Home/Runtime');
    	 
    	// 清空模板缓存目录
    	//delete_dir(CACHE_PATH);
    	// 清空数据目录
    	//delete_dir(DATA_PATH);
    	// 清空数据缓存目录
    	//delete_dir(TEMP_PATH);
    	//if(is_file(RUNTIME_PATH.'~runtime.php')){
    	//	unlink(RUNTIME_PATH.'~runtime.php');
    	//}
    
	
    	//$this->success('更新缓存成功', I('get.forward', U('Index/main')));
    	
    	// 因为跳转回生成  Runtime/Cache目录，
    	// 导致再次运行不能生成其他目录(比如Logs)
    	// 如果开启debug导致日志记录到其他位置
    	
    	exit('<div style="background:#fff; height:98%;padding: 20px 0 0 20px;">清除缓存成功!</div>');
    }

}