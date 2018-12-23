<?php
/**
 * 导航控制器
 * 
 * @author xiaosibo
 */
class NavAction extends CommonAction 
{
	// 导航列表
	public function index()
	{	
		// 导入分页类
		import('@.ORG.Page'); 
		
		$map   = $search = array();
		$title = I('get.title', '', 'trim');
		$pos   = I('get.pos', 0, 'intval');
		
		if ($title) {
			$map['title']    = array('like', "%$title%");
			$search['title'] = $title;
		}
		if ($pos > 0) {
			$map['pos'] 	= $pos;
			$search['pos']  = $pos;
		}
	
		$Model = M('Nav');

		// 查询满足要求的总记录数 $map表示查询条件
		$count = $Model->where($map)->count(); 
		$Page  = new Page($count, '', $search);
		
		// 获取导航列表
		$navList = $Model->where($map)
						  ->order('id DESC')
						  ->limit($Page->firstRow.','.$Page->listRows)
						  ->select();
		// 获取导航位列表
		$navPosList = M('Nav_pos')->select();
		
		$navPosArr = array();
		foreach ($navPosList as $val) {
			$navPosArr[$val['id']] = $val['pos_title'];
		}
		
		$this->assign('search',   	 $search);
		$this->assign('navPosList',  $navPosList);
		$this->assign('navPosArr',   $navPosArr);
		$this->assign('navList', 	 $navList);
		$this->assign('pageShow',    $Page->show());
		$this->display();
	}
	
	// 添加导航
	public function add()
	{
		if (IS_POST) {
			$Model = D('Nav');
			// 创建数据
			if ($Model->create()) {
				// 插入数据
				if ($Model->add()) {
					$this->success('添加导航成功！', U('Nav/index'));
				} else {
					$this->error('添加导航失败！');
				}
			} else {
				$this->error($Model->getError());
			}
		} else {
			$navPos = M('nav_pos')->order('id ASC')->select();
			
			$this->assign('navPos', $navPos);
			$this->display('edit');
		}
	}

	// 编辑导航
	public function edit()
	{
		$id    = I('id', 0, 'intval');
		if ($id <= 0) {
			$this->error('错误的请求');
		}
		
		if (IS_POST) {	// 处理修改后数据
			
			$Model = D('Nav');
			if ($Model->create()) {	// 创建数据
				
				if ($Model->save() !== false) { // 插入数据
					$this->success('修改导航成功！', $_POST['forward_url'] ? $_POST['forward_url'] : U('Nav/index'));
				} else {
					$this->error('修改导航失败！');
				}
			} else {
				$this->error($Model->getError());
			}
		} else {
			// 显示修改页面
			$nav = M('Nav')->find($id);
			if (empty($nav)) {
				$this->error('导航不存在');
			}
			$navPos = M('nav_pos')->order('id ASC')->select();
			
			$this->assign('forward_url', $_SERVER['HTTP_REFERER'] ? $_SERVER['HTTP_REFERER'] : U('Nav/index'));
			$this->assign('nav',    $nav);
			$this->assign('navPos', $navPos);
			$this->display();
		}
			
	}
	
	// 删除导航
	public function delete()
	{
		$id = I('get.id', 0, 'intval');
		if ($id <= 0) {
			$this->error('错误的请求');
		}
		
		if (M('Nav')->delete($id)) {
			$this->success('删除导航成功！');
		} else {
			$this->error('删除导航失败！');
		}
	}
	
}