<?php
/**
 * 文献分类控制器
 * 
 * @author 
 */
class LiteratureCatAction extends CommonAction 
{
	// 文章分类列表
	public function index()
	{
		$this->assign('articleCatList', D('LiteratureCat')->getFullOptions());
		$this->display();
	}
	
	// 添加文章分类
	public function add()
	{
		$Model = D('LiteratureCat');
		if (IS_POST) {
			
			if ($Model->create()) {	// 创建数据

				if ($Model->add()) { // 插入数据
					$this->success('添加文章分类成功！', U('LiteratureCat/index'));
				} else {
					$this->error('添加文章分类失败！');
				}
			} else {
				$this->error($Model->getError());
			}
		} else {
			$this->assign('pid', I('get.pid', 0, 'intval'));
			$this->assign('articleCatOptions', $Model->getFullOptions());
			$this->display('edit');
		}
	}
	
	// 编辑文章分类
	public function edit()
	{
		$cat_id = I('cat_id', 0, 'intval');
		//print $cat_id;
		if ($cat_id <= 0) {
			$this->error('错误的请求');
		}
		
		$Model = D('LiteratureCat');
		
		if (IS_POST) {

			if ($Model->create()) {	// 创建数据
				
				if ($Model->save() !== false) { // 插入数据
					$this->success('修改文章分类成功！', U('LiteratureCat/index'));
				} else {
					$this->error('修改文章分类失败！');
				}
			} else {
				$this->error($Model->getError());
			}
		} else {
			
			$articleCat = $Model->find($cat_id);
			//print_r($articleCat);
			if (empty($articleCat)) {
				$this->error('文章分类不存在！');
			}
			$this->assign('pid', $articleCat['pid']);
			$this->assign('articleCat', $articleCat);
			$this->assign('articleCatOptions', $Model->getFullOptions());
			$this->display();
		}
	}
	
	// 删除文章分类
	public function delete()
	{
		$cat_id = I('cat_id', 0, 'intval');
		
		if ($cat_id <= 0) {
			$this->error('错误的请求');
		}
		
		$Model = M('LiteratureCat');
		
		// 有子分类不能直接删除
		if ($Model->where(array('pid' => $cat_id))->count() > 0) {
			$this->error('此分类下有子分类，不能直接删除');
		}
		
		if ($Model->delete($cat_id)) {
			$this->success('删除文章分类成功！');
		} else {
			$this->error('删除文章分类失败！');
		}
	}

}