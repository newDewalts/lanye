<?php
/**
 * 网站服务分类控制器
 * 
 * @author xiaosibo
 */
class ServiceCatAction extends CommonAction 
{
	// 网站服务分类列表
	public function index()
	{
		$this->assign('serviceCatList', D('ServiceCat')->getFullOptions());
		$this->display();
	}
	
	// 添加网站服务分类
	public function add()
	{
		$Model = D('ServiceCat');
		
		if (IS_POST) {
			
			if ($Model->create()) {	// 创建数据

				if ($Model->add()) { // 插入数据
					$this->success('添加网站服务分类成功！', U('ServiceCat/index'));
				} else {
					$this->error('添加网站服务分类失败！');
				}
			} else {
				$this->error($Model->getError());
			}
		} else {
			$this->assign('pid', I('get.pid', 0, 'intval'));
			$this->assign('serviceCatOptions', $Model->getFullOptions());
			$this->display('edit');
		}
	}
	
	// 编辑网站服务分类
	public function edit()
	{
		$cat_id = I('cat_id', 0, 'intval');
		
		if ($cat_id <= 0) {
			$this->error('错误的请求');
		}
		
		$Model = D('ServiceCat');
		
		if (IS_POST) {

			if ($Model->create()) {	// 创建数据
				
				if ($Model->save() !== false) { // 插入数据
					$this->success('修改网站服务分类成功！', U('ServiceCat/index'));
				} else {
					$this->error('修改网站服务分类失败！');
				}
			} else {
				$this->error($Model->getError());
			}
		} else {
			
			$serviceCat = $Model->find($cat_id);
			if (empty($serviceCat)) {
				$this->error('新闻分类不存在！');
			}
			
			$this->assign('serviceCat', $serviceCat);
			$this->assign('pid', $serviceCat['pid']);
			$this->assign('serviceCatOptions', $Model->getFullOptions());
			$this->display('edit');
		}
	}
	
	// 删除网站服务分类
	public function delete()
	{
		$cat_id = I('cat_id', 0, 'intval');
		
		if ($cat_id <= 0) {
			$this->error('错误的请求');
		}
		
		$Model = M('ServiceCat');
		
		// 有子分类不能直接删除
		if ($Model->where(array('pid' => $cat_id))->count() > 0) {
			$this->error('此分类下有子分类，不能直接删除');
		}
		
		if ($Model->delete($cat_id)) {
			$this->success('删除网站服务分类成功！');
		} else {
			$this->error('删除网站服务分类失败！');
		}
	}

}