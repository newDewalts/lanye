<?php
/**
 * 新闻模块控制器
 * 
 * @author xiaosibo
 */
class NewsAction extends CommonAction
{
	// 新闻列表
	public function index()
	{
		import('@.ORG.Page'); // 导入分页类
		
		$map = $search = array();
		$title   = I('get.title', '', 'trim');
		$cat_id  = I('get.cat_id', 0, 'intval');
		$year_id = I('get.year_id', 0, 'intval');
		
		if ($title) {
			$map['title']     = array('like', "%$title%");
			$search['title']  = $title;
		}
		if ($cat_id > 0) {
			$map['cat_id'] 	   = $cat_id;
			$search['cat_id']  = $cat_id;
		}
		if ($year_id > 0) {
			$map['year_id']    = $year_id;
			$search['year_id'] = $year_id;
		}
		
		$Model    = M('News');
		$catModel = M('News_cat');

		$count = $Model->where($map)->count(); // 查询满足要求的总记录数 $map表示查询条件
		$Page  = new Page($count, '', $search);
		
		$newsList = $Model->where($map)
						  ->order('id DESC')
						  ->limit($Page->firstRow.','.$Page->listRows)
						  ->select();

		// 新闻行业分类
		$catIndustryList = $catModel->where(array('pid' => C('NEWS_INDUSTRY_CAT')))->order('orders DESC')->select();
		$catIndustryArr = array();
		foreach ($catIndustryList as $val) {
			$catIndustryArr[$val['cat_id']] = $val['cat_name'];
		}
		
		// 新闻年份分类
		$catYearList = $catModel->where(array('pid' => C('NEWS_YEAR_CAT')))->order('orders DESC')->select();
		$catYearArr = array();
		foreach ($catYearList as $val) {
			$catYearArr[$val['cat_id']] = $val['cat_name'];
		}
		
		$this->assign('search',   		 $search);
		$this->assign('catIndustryList', $catIndustryList);
		$this->assign('catYearList', 	 $catYearList);
		$this->assign('newsList', 		 $newsList);
		
		$this->assign('catIndustryArr',  $catIndustryArr);
		$this->assign('catYearArr',  	 $catYearArr);
		$this->assign('pageShow', 		 $Page->show());
		$this->display();
	}
   
    // 添加新闻
    public function add()
    {
    	if (IS_POST) {
    		$Model = D('News');
    		// 创建数据
    		if ($Model->create()) {
    			// 插入数据
    			if ($Model->add()) {
    				$this->success('添加新闻成功！', U('News/index'));
    			} else {
    				$this->error('添加新闻失败！');
    			}
    		} else {
    			$this->error($Model->getError());
    		}
    	} else {
    		
    		$catModel = M('News_cat');
    		// 行业分类
    		$catIndustryList = $catModel->where(array('pid' => C('NEWS_INDUSTRY_CAT')))->order('orders DESC, cat_id DESC')->select();
    		// 年份分类
    		$catYearList     = $catModel->where(array('pid' => C('NEWS_YEAR_CAT')))->order('orders DESC, cat_id DESC')->select();
    		
    		$this->assign('catIndustryList', $catIndustryList);
    		$this->assign('catYearList', 	 $catYearList);
    		$this->display('edit');
    	}
    }
    
    // 编辑新闻
    public function edit()
    {
    	if (IS_POST) {
    		$Model = D('News');
    		// 创建数据
    		if ($Model->create()) {
    			// 保存数据
    			if ($Model->save() !== false) {
    				$this->success('修改新闻成功！', I('post.forward_url', U('News/index')));
    			} else {
    				$this->error('修改新闻失败！');
    			}
    		} else {
    			$this->error($Model->getError());
    		}
    	} else {
    		
    		$id = I('get.id', 0, 'intval');
    		if ($id <= 0) {
    			$this->error('错误的请求');
    		}
    	
    		$news = M('News')->find($id);
    		if (empty($news)) {
    			$this->error('新闻不存在');
    		}
    		
    		$catModel = M('News_cat');
    		// 行业分类
    		$catIndustryList = $catModel->where(array('pid' => C('NEWS_INDUSTRY_CAT')))->order('orders DESC')->select();
    		// 年份分类
    		$catYearList     = $catModel->where(array('pid' => C('NEWS_YEAR_CAT')))->order('orders DESC')->select();
    		
    		$this->assign('catYearList', 	 $catYearList);
    		$this->assign('catIndustryList', $catIndustryList);
    		$this->assign('news', $news);
    		$this->assign('forward_url', I('server.HTTP_REFERER', U('News/index')));
    		$this->display();
    	}
    }
    
    // 删除新闻
    public function delete()
    {
    	$id = I('get.id', 0, 'intval');
    	
    	if ($id <= 0 ) {
    		$this->error('错误的请求');
    	}
    	$Model = M('News');
    	$news  = $Model->field('id, thumb')->find($id);
    	if (empty($news)) {
    		$this->error('新闻不存在');
    	}
    	
    	if ($Model->delete($id)) {
    		// 删除附件
    		@unlink('./'.ltrim($news['thumb'], '/'));
    		$this->success('删除新闻成功！');
    	} else {
    		$this->error('删除新闻失败！');
    	}
    }
    
}





