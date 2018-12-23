<?php
/**
 * 晋升控制器
 * 
 * @author 
 */
class JinshengAction extends CommonAction
{
	// 文章列表
	public function index()
	{
		import('@.ORG.Page'); // 导入分页类
		
		$map = $search = array();
		$title      = I('get.title', '', 'trim');
		$cat_id  = I('get.cat_id', 0, 'intval');
		
		if ($title) {
			$map['title']     = array('like', "%$title%");
			$search['title']  = $title;
		}
		if ($cat_id > 0) {
			$map['cat_id'] 	   = $cat_id;
			$search['cat_id']  = $cat_id;
		}

		$Model		= M('Jinsheng');
		$catModel = D('JinshengCat');

		
		$count = $Model->where($map)->count(); // 查询满足要求的总记录数 $map表示查询条件

		$Page  = new Page($count, '', $search);
		$articleList = $Model->where($map)
						  ->order('id DESC')
						  ->limit($Page->firstRow.','.$Page->listRows)
						  ->select();
		
		// 文章分类
		$articleCatOptions = $catModel->getFullOptions();
		$articleCatArr = array();
		foreach ($articleCatOptions as $val) {
			$articleCatArr[$val['cat_id']] = $val['cat_name'];
		}
		//dump($articleList);exit;
		$this->assign('search',   		 $search);
		$this->assign('articleCatOptions', 	 $articleCatOptions);
		$this->assign('articleList', 		 $articleList);
		$this->assign('articleCatArr',  $articleCatArr);
		$this->assign('pageShow', 	 $Page->show());
		$this->display();
	}
   
    // 添加文章
    public function add()
    {
    	if (IS_POST) {
    		$Model = D('Jinsheng');
    		// 创建数据
    		if ($Model->create()) {
    			// 插入数据
    			if ($Model->add()) {
    				$this->success('添加文章成功！', U('Jinsheng/index'));
    			} else {
    				$this->error('添加文章失败！');
    			}
    		} else {
    			$this->error($Model->getError());
    		}
    	} else {
    		// 文章分类
    		$this->assign('articleCatOptions', D('JinshengCat') ->getFullOptions());
    		$this->display('edit');
		}
    }
    
    // 编辑文章
    public function edit()
    {
    	if (IS_POST) {
    		$Model = D('Jinsheng');
    		// 创建数据
    		if ($Model->create()) {
    			// 保存数据
    			if ($Model->save() !== false) {
    				$this->success('修改文章成功！', I('post.forward_url', U('Jinsheng/index')));
    			} else {
    				$this->error('修改文章失败！');
    			}
    		} else {
    			$this->error($Model->getError());
    		}
    	} else {
    		
    		$id = I('get.id', 0, 'intval');
    		if ($id <= 0) {
    			$this->error('错误的请求');
    		}
    	
    		$article = M('Jinsheng')->find($id);
    		if (empty($article)) {
    			$this->error('文章不存在');
    		}
   
    		// 文章分类
    		$this->assign('articleCatOptions', D('JinshengCat') ->getFullOptions());
    		
    		$this->assign('article', $article);
    		$this->assign('forward_url', I('server.HTTP_REFERER', U('Jinsheng/index')));
    		$this->display();
    	}
    }
    
    // 删除文章
    // 删除文章
    public function delete()
    {
    	$id = I('get.id', 0, 'intval');
    	
    	if ($id <= 0 ) {
    		$this->error('错误的请求');
    	}
    	$Model   = M('Jinsheng');
    	$article = $Model->field('id, thumb')->find($id);
    	
    	if (empty($article)) {
    		$this->error('文章不存在');
    	}
    	if ($Model->delete($id)) {
    		// 删除附件
    		@unlink('./'.ltrim($article['thumb'], '/'));
    		$this->success('删除文章成功！');
    	} else {
    		$this->error('删除文章失败！');
    	}
    }
    
}





