<?php
/**
 * 广告位控制器
 * 
 * @author xiaosibo
 */
class AdPosAction extends CommonAction 
{
	// 广告位列表
	public function index()
	{	
		$adPosList = M('Ad_pos')->order('pos_id DESC')->select();
		$this->assign('adPosList', $adPosList);
		$this->display();
	}
	
	// 添加广告位
	public function add()
	{
		if (IS_POST) {
			$Model = D('AdPos');
			
			if ($Model->create()) {	// 创建数据

				if ($Model->add()) { // 插入数据	
					$this->success('添加广告位置成功！', U('AdPos/index'));
				} else {
					$this->error('添加广告位置失败！');
				}
			} else {
				$this->error($Model->getError());
			}
		} else {
			$this->display('edit');
		}
	}
	
	// 编辑广告位
	public function edit()
	{
		$id = I('pos_id', 0, 'intval');
		if ($id <= 0) {
			$this->error('错误的请求');
		}
		
		if (IS_POST) {
			$Model = D('AdPos');
			
			if ($Model->create()) {	// 创建数据
				
				if ($Model->save() !== false) { // 插入数据
					$this->success('修改导航位置成功！', U('AdPos/index'));
				} else {
					$this->error('修改导航位置失败！');
				}
			} else {
				$this->error($Model->getError());
			}
		} else {
			
			$adPos = M('Ad_pos')->find($id);
			if (empty($adPos)) {
				$this->error('广告位置不存在');
			}
			$this->assign('adPos', $adPos);
			$this->display('edit');
		}
	}
	
	// 删除广告位
	public function delete()
	{
		$id = I('pos_id', 0, 'intval');
		if ($id <= 0) {
			$this->error('错误的请求');
		}
		
		// 广告位下有广告，不能直接删除
		$has_ads = M('Ad')->where(array('pos_id' => $id))->count();
		
		if ($has_ads > 0) {
			$this->error('广告位下存在广告，不能直接删除');
		}
		
		if (M('Ad_pos')->delete($id)) {
			$this->success('删除广告位置成功！');
		} else {
			$this->error('删除广告位置失败！');
		}
	}

}