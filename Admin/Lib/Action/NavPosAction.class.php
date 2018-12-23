<?php
/**
 * 导航分类(位置)控制器
 * 
 * @author xiaosibo
 */
class NavPosAction extends CommonAction 
{
	// 导航位置列表
	public function index()
	{
		$this->assign('navPosList', M('Nav_pos')->order('id ASC')->select());
		$this->display();
	}
	
	// 添加导航位
	public function add()
	{
		if (IS_POST) {
			$Model = D('NavPos');
			// 创建数据
			if ($Model->create()) {
				// 插入数据
				if ($Model->add()) {
					$this->success('添加导航位置成功！', U('NavPos/index'));
				} else {
					$this->error('添加导航位置失败！');
				}
			} else {
				$this->error($Model->getError());
			}
		} else {
			$this->display('edit');
		}
	}
	
	// 修改导航位
	public function edit()
	{
		$id    = I('id', 0, 'intval');
		$Model = D('NavPos');
		
		if ($id <= 0) {
			$this->error('错误的请求');
		}
		
		if (IS_POST) {
			// 创建数据
			if ($Model->create()) {
				// 插入数据
				if ($Model->save() !== false) {
					$this->success('修改导航位置成功！', U('NavPos/index'));
				} else {
					$this->error('修改导航位置失败！');
				}
			} else {
				$this->error($Model->getError());
			}
		} else {
			$navPos = $Model->find($id);
			if (empty($navPos)) {
				$this->error('导航位置不存在');
			}
			$this->assign('navPos', $navPos);
			$this->display('edit');
		}
	}
	
	// 删除导航位
	public function delete()
	{
		$id    = I('get.id', 0, 'intval');
		if ($id <= 0) {
			$this->error('错误的请求');
		}
		
		// 导航位置下有导航设置，不能直接删除
		if (M('Nav')->where(array('pos' => $id))->count()) {
			$this->error('导航位置下存在导航设置，不能直接删除');
		}
		
		if (M('Nav_pos')->delete($id)) {
    		$this->success('删除导航位成功');
    	} else {
    		$this->error('删除导航位失败');
    	}
	}
}






