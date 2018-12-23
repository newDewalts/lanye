<?php
/**
 * 网站服务文章分类控制器
 * 
 * @author xiaosibo
 */
class ServiceCatAction extends CommonAction 
{
	// 分类下显示列表页
	public function index()
	{
		$cat_id   = I('get.id', 0, 'intval');
		if ($cat_id <= 0 ) {
			$this->_empty();
		}
		
		$catModel = M('Service_cat');
		$Model 	  = M('Service');
		
		// 取出当前分类信息
		$nowCat = $catModel->cache(true)->find($cat_id);
		// 分类不存在
		if (empty($nowCat)) {
			$this->_empty();
		}
		
		// 取出当前分类的子分类
		$catList = $catModel->cache(true)
							->where(array('pid' => $nowCat['cat_id']))
							->order('orders DESC, cat_id DESC')->select();
	
		if (empty($catList)) {
			// 没有子分类则取当前分类
			$sList = $Model->cache(true)
							->where(array('status' => 1, 'cat_id' => $nowCat['cat_id']))
							->order('orders DESC, id DESC')->select();
			$nowCat['service_list'] = $sList;
			$hasChildren = false;
		} else {
			foreach ($catList as $key => $val) {
				// 获取分类下的服务文章
				$sList = $Model->cache(true)
								->where(array('status' => 1, 'cat_id' => $val['cat_id']))
								->order('orders DESC, id DESC')->select();
				$catList[$key]['service_list'] = $sList;
			}
			$hasChildren = true;
		}
	
		load('extend');
		
		// 左侧栏分类(取“网站服务分类->服务项目”分类的子分类, 固定ID为11)
		$subCat = $catModel->field('cat_id, cat_name')
								->where(array('pid' => 11))
								->cache(true)
								->order('orders DESC, cat_id DESC')
								->select();
		$this->assign('catList', $catList);
		$this->assign('subCat', $subCat);
		$this->assign('nowCat', $nowCat);
		// 注: 有子分类就循环子分类及其文章， 没有子分类则循环当前分类的文章
		$this->assign('hasChildren', $hasChildren);
		// 赋值seo信息
		$this->assignSeoInfo($nowCat['cat_name'], $nowCat['keywords'], $nowCat['description']);
		$this->display();
	}

	// 分类下面直接显示文章
    public function detail()
    {
		$cat_id  = I('get.id', 0, 'intval');
		
		if ($cat_id <= 0) {
			$this->_empty();
		}
		
		// 默认取此分类下的第一个显示
		$first = M('Service')->field('id')->cache(true)->where(array('cat_id' => $cat_id))->order('orders DESC, id DESC')->find();
		
		// 此分类下没有任何网站服务文章
		if (empty($first)) {
			$this->_empty();
		} else {
			// 跳转到网站服务文章详细页
			$this->redirect('Service/show', array('id' => $first['id']));
		}
    }
    
}