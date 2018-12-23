<?php
/**
 * 网站服务文章模块控制器
 * 
 * @author xiaosibo
 */
class ServiceAction extends CommonAction
{
	// 服务文章列表
	public function index()
	{
		import('@.ORG.Page'); // 导入分页类
		
		$map = $search = array();
		$title   = I('get.title', '', 'trim');
		$cat_id  = I('get.cat_id', 0, 'intval');
		
		if ($title) {
			$map['title']     = array('like', "%$title%");
			$search['title']  = $title;
		}
		if ($cat_id > 0) {
			$map['cat_id'] 	   = $cat_id;
			$search['cat_id']  = $cat_id;
		}
		
		$Model		= M('Service');
		$catModel = D('ServiceCat');

		$count = $Model->where($map)->count(); // 查询满足要求的总记录数 $map表示查询条件
		$Page  = new Page($count, '', $search);
		
		$serviceList = $Model->where($map)
						  ->order('addtime DESC')
						  ->limit($Page->firstRow.','.$Page->listRows)
						  ->select();
		
		// 分类选项
		$serviceCatOptions = $catModel->getFullOptions();
		
		$serviceCatArr = array();
		foreach ($serviceCatOptions as $val) {
			$serviceCatArr[$val['cat_id']] = $val['cat_name'];
		}
		
		$this->assign('search',						$search);
		$this->assign('serviceCatOptions',		$serviceCatOptions);
		$this->assign('serviceList',				$serviceList);
		
		$this->assign('serviceCatArr',  	 $serviceCatArr);
		$this->assign('pageShow', 		 $Page->show());
		$this->display();
	}
   
    // 添加服务文章
    public function add()
    {
    	if (IS_POST) {
    		$Model = D('Service');
    		// 创建数据
    		if ($Model->create()) {
    			// 插入数据
    			if ($Model->add()) {
    				$this->success('添加服务文章成功！', U('Service/index'));
    			} else {
    				$this->error('添加服务文章失败！');
    			}
    		} else {
    			$this->error($Model->getError());
    		}
    	} else {
    		// 服务分类
    		$this->assign('serviceCatOptions', D('ServiceCat') ->getFullOptions());
    		$this->display('edit');
    	}
    }
    
    // 编辑服务文章
    public function edit()
    {
    	if (IS_POST) {
    		$Model = D('Service');
    		// 创建数据
    		if ($Model->create()) {
    			// 保存数据
    			if ($Model->save() !== false) {
    				$this->success('修改服务文章成功！', I('post.forward_url', U('Service/index')));
    			} else {
    				$this->error('修改服务文章失败！');
    			}
    		} else {
    			$this->error($Model->getError());
    		}
    	} else {
    		
    		$id = I('get.id', 0, 'intval');
    		if ($id <= 0) {
    			$this->error('错误的请求');
    		}
    	
    		$service = M('Service')->find($id);
    		if (empty($service)) {
    			$this->error('服务文章不存在');
    		}
   
    		// 服务分类
    		$this->assign('serviceCatOptions', D('ServiceCat') ->getFullOptions());

    		$this->assign('service',  $service);
    		$this->assign('forward_url', I('server.HTTP_REFERER', U('Service/index')));
    		$this->display();
    	}
    }
    
	// 删除服务文章
    public function delete()
    {
    	$id = I('get.id', 0, 'intval');
    	
    	if ($id <= 0 ) {
    		$this->error('错误的请求');
    	}
    	$Model = M('Service');
    	$service = $Model->field('id, thumb')->find($id);
    	 
    	if (empty($service)) {
    		$this->error('服务文章不存在');
    	}
    	
    	if ($Model->delete($id)) {
    		// 删除附件
    		@unlink('./'.ltrim($service['thumb'], '/'));
    		
    		$this->success('删除服务文章成功！');
    	} else {
    		$this->error('删除服务文章失败！');
    	}
    }
    
}
