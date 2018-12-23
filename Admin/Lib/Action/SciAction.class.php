<?php
/**
 * SCI影响因子管理
 * 
 * @author xiaosibo
 */
class SciAction extends CommonAction
{
	// sci列表
	public function index()
	{
		import('@.ORG.Page'); // 导入分页类
		
		$map = $search = array();
		$title   = I('get.title', '', 'trim');
		$cat_id  = I('get.cat_id', 0, 'intval');
		
		if ($title) {
			$map['name']     = array('like', "%$title%");
			$search['name']  = $title;
		}
		if ($cat_id > 0) {
			$map['cat_id'] 	   = $cat_id;
			$search['cat_id']  = $cat_id;
		}
		

		$Model		= M('Impact');
		$count = $Model->where($map)->count(); // 查询满足要求的总记录数 $map表示查询条件
		$Page  = new Page($count, '', $search);
		
		$impactList = $Model->where($map)
						  ->order('addtime DESC')
						  ->limit($Page->firstRow.','.$Page->listRows)
						  ->select();

		// 分类选项
		foreach ($impactList as $key => $value) {
			$cat_list = M("Impact_cat")->field('pid,name')->where('id='.$value['cat_id'])->find();
			$pid_list = M("Impact_cat")->field('name')->where('id='.$cat_list['pid'])->find();
			$impactList[$key]['cat_id']=$pid_list['name'].'—'.$cat_list['name'];
		}

		
		$this->assign('search',	$search);
		$this->assign('impactList',	$impactList);
		
   			//分类
    	$menu_cat =M("Impact_cat")->where('pid !=0')->select();
    	$this->assign('menu_cat', $menu_cat);

		$this->assign('pageShow',$Page->show());
		$this->display();
	}
              
    // 添加sci
    public function add()
    {
    	if (IS_POST) {
    		$_POST['addtime']=time();
    		$Model = D('Impact');

    		// 创建数据
                
    		if ($Model->create()) {
    			// 插入数据
    			if ($Model->add()) {
    				$this->success('添加sci成功！', U('Sci/index'));
    			} else {
    				$this->error('添加sci失败！');
    			}
              
    		} else {
    			$this->error($Model->getError());
    		}
         
    	} else {
    		//分类
    		$menu_cat =M("Impact_cat")->where('pid =0')->select();

            $sci_Impact['cat_id'][1] = '0';
            $this->assign('sci', $sci_Impact);

    		$this->assign('menu_cat', $menu_cat);
    		$this->display('edit');
    	}
    }
    
    // 编辑sci
    public function edit()
    {
    	if (IS_POST) {
    		$Model = D('Impact');
    		// 创建数据
    		if ($Model->create()) {
    			// 保存数据
    			if ($Model->save() !== false) {
    				$this->success('修改sci成功！', I('post.forward_url', U('Sci/index')));
    			} else {
    				$this->error('修改sci失败！');
    			}
    		} else {
    			$this->error($Model->getError());
    		}
    	} else {
    		
    		$id = I('get.id', 0, 'intval');
    		if ($id <= 0) {
    			$this->error('错误的请求');
    		}
    	
    		$sci_Impact = M('Impact')->find($id);
    		if (empty($sci_Impact)) {
    			$this->error('sci不存在');
    		}   			

            // $sci_Impact['cat_id'] 
            $top_cat = M("Impact_cat")->find($sci_Impact['cat_id']);
            $sci_Impact['cat_id'] = [$top_cat['pid'],$sci_Impact['cat_id']];

   			//分类
    		$menu_cat =M("Impact_cat")->where('pid =0')->select();
    		$this->assign('menu_cat', $menu_cat);

    		$this->assign('sci',  $sci_Impact);
    		$this->assign('forward_url', I('server.HTTP_REFERER', U('Service/index')));
    		$this->display();
    	}
    }
    
	// 删除sci
    public function delete()
    {
    	$id = I('get.id', 0, 'intval');
    	
    	if ($id <= 0 ) {
    		$this->error('错误的请求');
    	}
    	$Model = M('Impact');
    	$Impact = $Model->field('id')->find($id);
    	 
    	if (empty($Impact)) {
    		$this->error('sci不存在');
    	}
    	
    	if ($Model->delete($id)) {
    		$this->success('删除sci成功！');
    	} else {
    		$this->error('删除sci失败！');
    	}
    }
    

    public function cat()
    {

		import('@.ORG.Page'); // 导入分页类
		
		$Model	= M('Impact_cat');

		$count = $Model->where()->count(); // 查询满足要求的总记录数 $map表示查询条件
		$Page  = new Page($count, '', $search);
		
		$catList = $Model->where($map)
						  ->order('concat(`path`,`id`) asc')
						  ->limit($Page->firstRow.','.$Page->listRows)
						  ->select();

		$this->assign('catList',$catList);
		$this->assign('pageShow', $Page->show());
		$this->display();
    }

    // 添加sci
    public function addCat()
    {
    	if (IS_POST) {
    		$Model = D('Impact_cat');

    		if(!$_POST['pid']){
    			$_POST['path']='0,';
    		}else{
    			$_POST['path']='0,'.$_POST['pid'].',';
    		}
    		// 创建数据
    		if ($Model->create()) {
    			// 插入数据
    			if ($Model->add()) {
    				$this->success('添加Sci分类成功！', U('Sci/cat'));
    			} else {
    				$this->error('添加Sci分类失败！');
    			}
    		} else {
    			$this->error($Model->getError());
    		}
    		
    		
    	} else {
    		// 服务分类
    		$menu_cat =M("Impact_cat")->where('pid =0')->select();

    		$this->assign('menu_cat', $menu_cat);
    		$this->display('editCat');
    	}
    }

    public function editCat()
    {
    	if (IS_POST) {
    		if(!$_POST['pid']){
    			$_POST['path']='0,';
    		}else{
    			$_POST['path']='0,'.$_POST['pid'];
    		}

    		$Model = D('Impact_cat');
    		// 创建数据
    		if ($Model->create()) {
    			// 保存数据
    			if ($Model->save() !== false) {
    				$this->success('修改Sci分类成功！', U('Sci/cat'));
    			} else {
    				$this->error('修改Sci分类失败！');
    			}
    		} else {
    			$this->error($Model->getError());
    		}
    	} else {
    		
    		$id = I('get.id', 0, 'intval');
    		if ($id <= 0) {
    			$this->error('错误的请求');
    		}
    	
    		$cat = M('Impact_cat')->find($id);
    		if (empty($cat)) {
    			$this->error('Sci分类不存在');
    		}
   
    		
    		$menu_cat =M("Impact_cat")->where('pid =0')->select();

    		$this->assign('menu_cat', $menu_cat);
    		$this->assign('cat',  $cat);
    	
    		$this->display();
    	}
    }

    public function deleteCat()
    {
    	$id = I('get.id', 0, 'intval');
    	
    	if ($id <= 0 ) {
    		$this->error('错误的请求');
    	}
    	$Model = M('Impact_cat');
    	$service = $Model->find($id);
    	 
    	if (empty($service)) {
    		$this->error('Sci分类不存在');
    	}
    	
    	if ($Model->delete($id)) {   		    		
    		$this->success('删除sci分类成功！');
    	} else {
    		$this->error('删除sci分类失败！');
    	}
    }

    //查询二级分类
    public function ajaxCat(){
        $id = $_POST['id'];
        $Model = D('Impact_cat');
        $cat_list = $Model->where(['pid'=>$id,'status'=>1])->select();
        echo json_encode($cat_list);
    }
}
