<?php
/**
 * 用户控制器
 * 
 * @author xiaosibo
 */
class UserAction extends CommonAction
{
	/**
	 * 角色模型
	 * @var Model
	 */
	protected $roleModel;
	
	/**
	 * 用户模型
	 * @var User
	 */
	protected $Model;
	
	// 初始化
	public function _initialize()
	{
		parent::_initialize();
		
		$this->Model 	 = D('User');
		$this->roleModel = D('Role');
	}
	
	// 用户列表
	public function index()
	{
		import('@.ORG.Page'); // 导入分页类
		
		$map = $search = array();
		$username = I('get.username', '', 'trim');
		$role_id  = I('get.role_id', 0, 'intval');
		
		if ($username) {
			$map['username']    = array('like', "%$username%");
			$search['username'] = $username;
		}
		if ($role_id > 0) {
			$map['role_id'] 	= $role_id;
			$search['role_id']  = $role_id;
		}

		$count = $this->Model->where($map)->count(); // 查询满足要求的总记录数 $map表示查询条件
		$Page  = new Page($count, '', $search);
		
		$userList = $this->Model->where($map)
							    ->order('create_time DESC')
								->limit($Page->firstRow.','.$Page->listRows)
								->select();

		// 获取角色列表
		$roleList = $this->roleModel->where('status=1')->select();
		
		$roleArr = array();
		foreach ($roleList as $val) {
			$roleArr[$val['id']] = $val['name'];
		}
		
		$this->assign('search',   $search);
		$this->assign('roleList', $roleList);
		$this->assign('roleArr',  $roleArr);
		$this->assign('userList', $userList);
		$this->assign('pageShow', $Page->show());
		$this->display();
	}
   
    // 添加用户
    public function add()
    {
    	if (!IS_POST) {
    		$roleList = $this->roleModel->where('status=1')->select();
    		
    		$this->assign('forward_url', U('User/index'));
    		$this->assign('roleList', $roleList);
    		$this->display('edit');
    	} else {
    		// 创建数据
    		if ($data = $this->Model->create()) {
    			// 插入数据
    			if ($insert_id = $this->Model->add()) {
    				
    				// 添加用户角色
    				M('Role_user')->add(array('role_id'=>$data['role_id'], 'user_id' => $insert_id));
    				
    				$this->success('添加用户成功！', U('User/index'));
    			} else {
    				$this->error('添加用户失败！');
    			}
    		} else {
    			$this->error($this->Model->getError());
    		}	
    	}
    }
    
    // 编辑用户
    public function edit()
    {
    	if (!IS_POST) {
    		$user_id = I('get.user_id', 0, 'intval');
    		if ($user_id <= 0) {
    			$this->error('错误的请求');
    		}
    		$user = $this->Model->find($user_id);
    		if (empty($user)) {
    			$this->error('用户不存在');
    		}
   
    		$roleList = $this->roleModel->where('status=1')->select();
    		
    		$this->assign('forward_url', $_SERVER['HTTP_REFERER'] ? $_SERVER['HTTP_REFERER'] : U('User/index'));
    		$this->assign('user',     $user);
    		$this->assign('roleList', $roleList);
    		$this->display();
    	} else {
    		// 创建数据
    		if ($data = $this->Model->create()) {
    			
    			$password = I('post.password');
    			
    			if (!empty($password)) {
    				if (strlen($password) < 6) {
    					$this->error('密码不少于6位');
    				}
    				if ($password != I('post.repassword')) {
    					$this->error('两次密码不一至');
    				}
    				$data['password'] = md5($password);
    			} else {
    				unset($data['password']);
    			}
    			
    			// 保存数据
    			if ($this->Model->save($data) !== false) {
    				
    				// 更新用户角色表中的信息
    				M('Role_user')->where(array('user_id' => $data['user_id']))
    								      ->save(array('role_id' => $data['role_id']));
    				
    				
    				$this->success('修改用户成功！', $_POST['forward_url'] ? $_POST['forward_url'] : U('User/index'));
    			} else {
    				$this->error('修改用户失败！');
    			}
    		} else {
    			$this->error($this->Model->getError());
    		}
    	}
    }
    
    // 删除用户
    public function delete()
    {
    	$user_id = I('get.user_id', 0, 'intval');
    	
    	if ($user_id <= 0 ) {
    		$this->error('错误的请求');
    	}
    	if ($user_id == 1) {
    		$this->error('超级管理员，不能被删除');
    	}
    	
    	if ($this->Model->delete($user_id)) {
    		// 删除用户角色
    		M('role_user')->where(array('user_id' => $user_id))->delete();
    		$this->success('删除用户成功！');
    	} else {
    		$this->error('删除用户失败！');
    	}
    }
    
}





