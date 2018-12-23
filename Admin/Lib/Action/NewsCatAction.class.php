<?php
/**
 * 新闻分类控制器
 * 
 * @author xiaosibo
 */
class NewsCatAction extends CommonAction 
{
	// 新闻分类列表
	public function index()
	{
		$this->assign('newsCatList', D('NewsCat')->getFullOptions());
		$this->display();
	}
	
	// 添加新闻分类
	public function add()
	{
		$Model = D('NewsCat');
		if (IS_POST) {
			
			if ($Model->create()) {	// 创建数据

				if ($Model->add()) { // 插入数据
					$this->success('添加新闻分类成功！', U('NewsCat/index'));
				} else {
					$this->error('添加新闻分类失败！');
				}
			} else {
				$this->error($Model->getError());
			}
		} else {
			$this->assign('pid', I('get.pid', 0, 'intval'));
			$this->assign('newsCatOptions', $Model->getFullOptions());
			$this->display('edit');
		}
	}
	
	// 编辑新闻分类
	public function edit()
	{
		$cat_id = I('cat_id', 0, 'intval');
		
		if ($cat_id <= 0) {
			$this->error('错误的请求');
		}
		
		$Model = D('NewsCat');
		
		if (IS_POST) {

			if ($Model->create()) {	// 创建数据
				
				if ($Model->save() !== false) { // 插入数据
					$this->success('修改新闻分类成功！', U('NewsCat/index'));
				} else {
					$this->error('修改新闻分类失败！');
				}
			} else {
				$this->error($Model->getError());
			}
		} else {
			
			$newsCat = $Model->find($cat_id);
			if (empty($newsCat)) {
				$this->error('新闻分类不存在！');
			}
			
			$this->assign('newsCat', $newsCat);
			$this->assign('pid', 	 $newsCat['pid']);
			$this->assign('newsCatOptions', $Model->getFullOptions());
			$this->display('edit');
		}
	}
	
	// 删除新闻分类
	public function delete()
	{
		$cat_id = I('cat_id', 0, 'intval');
		
		if ($cat_id <= 0) {
			$this->error('错误的请求');
		}
		
		$Model = M('NewsCat');
		
		// 有子分类不能直接删除
		if ($Model->where(array('pid' => $cat_id))->count() > 0) {
			$this->error('此分类下有子分类，不能直接删除');
		}
		
		if ($Model->delete($cat_id)) {
			$this->success('删除新闻分类成功！');
		} else {
			$this->error('删除新闻分类失败！');
		}
	}

}