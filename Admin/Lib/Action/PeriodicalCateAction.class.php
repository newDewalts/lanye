<?php 
/*
 * It is about periodicalcat;
 * @author:xu
 */
class PeriodicalCateAction extends CommonAction 
{
	//期刊分类列表
	public function index()
	{   
		$this->assign('periodicalCateList', D('PeriodicalCate')->getFullOptions());
		$this->display();
	}
	
	// 添加期刊分类
	public function add()
	{
		$Model = D('PeriodicalCate');

		if (IS_POST) {
			
			if ($Model->create()) {	// 创建数据

				if ($Model->add()) { // 插入数据
					$this->success('添加期刊分类成功！', U('PeriodicalCate/index'));
				} else {
					$this->error('添加期刊分类失败！');
				}
			} else {
				$this->error($Model->getError());
			}
		} else {
			$this->assign('pid', I('get.pid', 0, 'intval'));
			$this->assign('periodicalCateOptions', $Model->getFullOptions());
			$this->display('edit');
		}
	}
	
	// 编辑期刊分类
	public function edit()
	{
		$cat_id = I('cat_id', 0, 'intval');
		if ($cat_id <= 0) {
			$this->error('错误的请求');
		}
		
		$Model = D('PeriodicalCate');

		if (IS_POST) {

			if ($Model->create()) {	// 创建数据
				
				if ($Model->save() !== false) { // 插入数据
					$this->success('修改期刊分类成功！', U('PeriodicalCate/index'));
				} else {
					$this->error('修改期刊分类失败！');
				}
			} else {
				$this->error($Model->getError());
			}
		} else {
			
			$periodicalCate = $Model->find($cat_id);
			
			if (empty($periodicalCate)) {
				$this->error('期刊分类不存在！');
			}
			$this->assign('pid', $periodicalCate['pid']);
			$this->assign('periodicalCate', $periodicalCate);
			$this->assign('periodicalCateOptions', $Model->getFullOptions());
			$this->display();
		}
	}
	
	// 删除期刊分类
	public function delete()
	{
		$cat_id = I('cat_id', 0, 'intval');
		
		if ($cat_id <= 0) {
			$this->error('错误的请求');
		}
		
		$Model = M('PeriodicalCate');
		
		// 有子分类不能直接删除
		if ($Model->where(array('pid' => $cat_id))->count() > 0) {
			$this->error('此分类下有子分类，不能直接删除');
		}
		
		if ($Model->delete($cat_id)) {
			$this->success('删除期刊分类成功！');
		} else {
			$this->error('删除期刊分类失败！');
		}
	}

}
?>