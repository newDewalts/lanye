<?php
/**
 * 编辑管理控制器
 * 
 * @author xiaosibo
 */
class EditorAction extends CommonAction
{
	// 编辑列表
	public function index()
	{
		import('@.ORG.Page'); // 导入分页类
		
		$map = $search = array();
		$name = trim(I('get.name'));
		$cat_id = I('get.cat_id', 0, 'intval');
		
		if ($name) {
			$map['name']    = array('like', "%$name%");
			$search['name'] = $name;
		}
		if ($cat_id > 0) {
			$map['cat_id']    = $cat_id;
			$search['cat_id'] = $cat_id;
		}
		
		$Model	= M('Editor');
		$count = $Model->where($map)->count(); // 查询满足要求的总记录数 $map表示查询条件
		$Page  = new Page($count, '', $search);
		
		$editorList = $Model->where($map)
						 		 		->order('addtime DESC')
						  				->limit($Page->firstRow.','.$Page->listRows)
						 		 		->select();
		// 取固定分类ID为1
		$catList      = D('EditorCat')->getFullOptions(0, 1);
		$catListArr = array();
		foreach ($catList as $val) {
			$catListArr[$val['cat_id']] = $val['cat_name'];
		}
		
		$this->assign('search',  $search);
		$this->assign('editorList', $editorList);
		$this->assign('catListArr', $catListArr);
		$this->assign('catList', $catList);
		$this->assign('pageShow', $Page->show());
		$this->display();
	}
   
    // 添加编辑
    public function add()
    {
    	if (IS_POST) {
    		$Model = D('Editor');
    		// 创建数据
    		if ($Model->create()) {
    			// 插入数据
    			if ($Model->add()) {
    				$this->success('添加编辑成功！', U('Editor/index'));
    			} else {
    				$this->error('添加编辑失败！');
    			}
    		} else {
    			$this->error($Model->getError());
    		}
    	} else {
    		//固定分类ID为1
    		$this->assign('catOptions', D('EditorCat')->getChildren(1));
    		$this->display('edit');
		}
    }
    
    // 修改编辑
    public function edit()
    {
    	if (IS_POST) {
    		$Model = D('Editor');
    		// 创建数据
    		if ($Model->create()) {
    			// 保存数据
    			if ($Model->save() !== false) {
    				$this->success('修改编辑成功！', I('post.forward_url', U('Editor/index')));
    			} else {
    				$this->error('修改编辑失败！');
    			}
    		} else {
    			$this->error($Model->getError());
    		}
    	} else {
    		
    		$id = I('get.id', 0, 'intval');
    		if ($id <= 0) {
    			$this->error('错误的请求');
    		}
    		$editor = M('Editor')->find($id);
    		if (empty($editor)) {
    			$this->error('编辑不存在');
    		}
    		$this->assign('editor', $editor);
    		$this->assign('catOptions', D('EditorCat')->getChildren(1));
    		$this->assign('forward_url', I('server.HTTP_REFERER', U('Editor/index')));
    		$this->display();
    	}
    }
    
    // 删除编辑
    public function delete()
    {
    	$id = I('get.id', 0, 'intval');
    	
    	if ($id <= 0 ) {
    		$this->error('错误的请求');
    	}
    	$Model	= M('Editor');
    	$editor = $Model->find($id);
    	if (empty($editor)) {
    		$this->error('编辑不存在');
    	}
    	if ($Model->delete($id)) {
    		// 删除图片
    		@unlink('./'.ltrim($editor['avatar'], '/'));
    		$this->success('删除编辑成功！');
    	} else {
    		$this->error('删除编辑失败！');
    	}
    }
    
}





