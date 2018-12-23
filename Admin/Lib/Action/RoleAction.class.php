<?php
/**
 * 角色模块
 */
class RoleAction extends CommonAction
{
	// 角色列表
	public function index()
	{
		$roleList = M('Role')->order('id ASC')->select();
		$this->assign('roleList', $roleList);
		$this->display();
	}
  
	// 添加角色
	public function add()
	{
		if (!IS_POST) {
			// 显示添加页面
			$this->display('edit');
		} else {
			$Model = D('Role');
			// 创建数据
			if ($Model->create()) {
				// 插入数据
				if ($Model->add()) {
					$this->success('添加角色成功！', U('Role/index'));
				} else {
					$this->error('添加角色失败！');
				}
			} else {
				$this->error($Model->getError());
			}
		}
	}

	// 编辑角色信息
	public function edit()
	{
		$Model = D('Role');
		
		if (!IS_POST) {
			$id = I('get.id', 0, 'intval');
			if ($id <= 0) {
				$this->error('错误的请求');
			}
			$role = $Model->find($id);
			if (empty($role)) {
				$this->error('角色不存在');
			}
			$this->assign('role', $role);
			$this->display();
		} else {
			// 创建数据
			if ($Model->create()) {
				// 修改数据
				if ($Model->save()) {
					$this->success('修改角色成功！', U('Role/index'));
				} else {
					$this->error('修改角色失败！');
				}
			} else {
				$this->error($Model->getError());
			}
		}
	}

	// 角色授权
	public function access()
	{
		if (!IS_POST) {
			$role_id = I('get.role_id', 0, 'intval');
			if ($role_id <= 0) {
				$this->error('错误的请求');
			}
			// 取得角色的已有权限
			$accessList = M('Access')->where(array('role_id' => $role_id))->getField('node_id', true);
			
			$this->assign('role_id',  $role_id);
			$this->assign('accessList', $accessList);
			// 取出所有节点
			$this->assign('nodeTree', D('Node')->getNodeTree());
			$this->display();
		} else {
			$access  = I('post.access');
			$role_id = I('post.role_id', 0, 'intval');
			
			if ($role_id <= 0) {
				$this->error('错误的请求');
			}
			
			$access_arr = array();
			
			foreach ($access as $val) {
				$tmp = explode('_', $val);
				$access_arr[]   = array(
						'role_id' =>$role_id,
						'node_id' =>$tmp[0],
						'level' =>$tmp[1]
				);
			}
			$Model = M('Access');
			
			// 清空对应角色的旧权限
			$Model->where(array('role_id' => $role_id))->delete();
			
			// 添加用户权限
			if ($Model->addAll($access_arr)) {
				$this->success('添加权限成功');
			} else {
				$this->error('添加权限失败');
			}			
		}

	}
	
	// 删除角色
	public function delete()
	{
		$id = I('get.id', 0, 'intval');
		if ($id <= 0) {
			$this->error('错误的请求');
		}
		
		// 角色下存在用户，不能直接删除
		if (M('role_user')->where(array('role_id' => $id))->count()) {
			$this->error('此角色下存在用户，不能直接删除');
		}
		
		if (M('role')->delete($id)) {
    		$this->success('删除角色成功');
    	} else {
    		$this->error('删除角色失败');
    	}
	}
	
}


