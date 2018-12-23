<?php
/*
 * It is about periodical.
 * @author:xu
 */
load('extend'); 
class PeriodicalAction extends CommonAction
{     
	// 期刊列表
	public function index()
	{   
		
		import('@.ORG.Page'); // 导入分页类
		
		$map = $search = array();
		$pre_name      = I('get.pre_name', '', 'trim');              //期刊名称
		$cate_id       = I('get.cate_id', 0, 'intval');              //获取期刊分类编号
		$pre_issn      = I('get.pre_issn', 0, 'htmlspecialchars');   //获取期刊编号
		$pre_factor    = I('get.pre_factor', 0, 'double');           //获取期刊的影响因子
		$pre_language  = I('get.pre_language', '', 'trim');          //获取期刊的语言种类
		$pre_press     = I('get.pre_press', '', 'trim');             //获取期刊的出版社

		if ($pre_name) {
			$map['pre_name']        = array('like', "%$pre_name%");
			$search['pre_name']     = $pre_name;
		}
		if($cate_id>0){
			$map['cate_id']         = $cate_id;
			$search['cate_id']      = $cate_id;
		}
		if($pre_issn){
			$map['pre_issn']        = $pre_issn;
			$search['pre_issn']     = $pre_issn;
		}
		if($pre_factor){
			$map['pre_factor']      = $pre_factor;
			$search['pre_factor']   = $pre_factor;
		}
		if($pre_language){
			$map['pre_language']    = $pre_language;
			$search['pre_language'] = $pre_language;
		}
		if($pre_press){
			$map['pre_press']       = $pre_press;
			$search['pre_press']    = $pre_press;
		}
		

		$Model		= M('Periodical');
		$catModel = D('PeriodicalCate');
		$count = $Model->where($map)->count();         // 查询满足要求的总记录数 $map表示查询条件
		$Page  = new Page($count, '', $search);
		$periodicalList = $Model->where($map)
						  ->order('pre_id DESC')
						  ->limit($Page->firstRow.','.$Page->listRows)
						  ->select();
		// 期刊分类
		$periodicalCateOptions = $catModel->getFullOptions();
		$periodicalCateArr = array();
		foreach ($periodicalCateOptions as $val) {
			$periodicalCateArr[$val['cat_id']] = $val['cat_name'];
		}
		
		$this->assign('search',   		 $search);
		$this->assign('periodicalCateOptions', 	 $periodicalCateOptions);
		$this->assign('periodicalList', 		 $periodicalList);
		$this->assign('periodicalCateArr',  $periodicalCateArr);
		$this->assign('pageShow', 	 $Page->show());
		$this->display();
	}
   
    // 添加期刊
    public function add()
    {
    	if (IS_POST) {
    		$Model = D('Periodical');
    		// 创建数据
    		if ($Model->create()) {
    			// 插入数据
    			if ($Model->add()) {
    				$this->success('添加文章成功！', U('Periodical/index'));
    			} else {
    				$this->error('添加文章失败！');
    			}
    		} else {
    			$this->error($Model->getError());
    		}
    	} else {
    		// 期刊分类
    		$this->assign('periodicalCateOptions', D('PeriodicalCate') ->getFullOptions());
    		$this->display('edit');
		}
    }
    
    // 编辑期刊
    public function edit()
    {
    	if (IS_POST) {
    		$Model = D('Periodical');
    		// 创建数据
    		if ($Model->create()) {
    			// 保存数据
    			if ($Model->save() !== false) {
    				$this->success('修改期刊成功！', I('post.forward_url', U('Periodical/index')));
    			} else {
    				$this->error('修改期刊失败！');
    			}
    		} else {
    			$this->error($Model->getError());
    		}
    	} else {
    		
    		$pre_id = I('get.pre_id', 0, 'intval');
    		if ($pre_id <= 0) {
    			$this->error('错误的请求');
    		}
    	
    		$periodical = M('Periodical')->find($pre_id);
    		if (empty($periodical)) {
    			$this->error('期刊不存在');
    		}
   
    		// 期刊分类
    		$this->assign('periodicalCateOptions', D('PeriodicalCate') ->getFullOptions());
    		$this->assign('periodical', $periodical);
    		$this->assign('forward_url', I('server.HTTP_REFERER', U('Periodical/index')));
    		$this->display();
    	}
    }
    
    // 删除期刊
    public function delete()
    {
    	$pre_id = I('get.pre_id', 0, 'intval');
    	
    	if ($pre_id <= 0 ) {
    		$this->error('错误的请求');
    	}
    	$Model   = M('Periodical');
    	$periodical = $Model->field('pre_id, pre_image_thumb')->find($pre_id);
    	
    	if (empty($periodical)) {
    		$this->error('期刊不存在');
    	}
    	if ($Model->delete($pre_id)) {
    		// 删除附件  连同图片一起删除
    		@unlink('./'.ltrim($periodical['pre_image_thumb'], '/'));
    		$this->success('删除期刊成功！');
    	} else {
    		$this->error('删除期刊失败！');
    	}
    }
    
}

?>



