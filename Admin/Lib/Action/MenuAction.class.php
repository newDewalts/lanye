<?php
/**
 * 菜单管理控制器
 * 
 * @author xiaosibo
 */
class MenuAction extends CommonAction
{
	// 菜单列表
	public function index()
	{
		$this->assign('menuOptions', D('Menu')->getChildren());
		$this->display();
	}
    
    // 添加菜单
    public function add()
    {
    	$Model = D('Menu');
    	
    	if (!IS_POST) {
    		$this->assign('pid', 		 I('get.pid', 0, 'intval'));
    		$this->assign('menuOptions', $Model->getFullOptions());
    		$this->display('edit');
    	} else {
    		// 创建数据
    		if ($Model->create()) {
    			// 插入数据
    			if ($Model->add()) {
    				$this->success('添加菜单成功！', U('Menu/index'));
    			} else {
    				$this->error('添加菜单失败！');
    			}
    		} else {
    			$this->error($Model->getError());
    		}
    	}
    }
    
    // 编辑菜单
    public function edit()
    {
    	$Model = D('Menu');
    	
    	if (!IS_POST) {
    		$menu_id = I('get.menu_id', 0, 'intval');
    		if ($menu_id <= 0) {
    			$this->error('错误的请求');
    		}
    		$menu  = $Model->find($menu_id);
    		 
    		if (empty($menu)) {
    			$this->error('菜单不存在');
    		}
    		 
    		$this->assign('menu', $menu);
    		$this->assign('pid',  $menu['pid']);
    		$this->assign('menuOptions', $Model->getFullOptions());
    		$this->display();
    	} else {
    		// 创建数据
    		if ($data = $Model->create()) {
    			// 保存修改
    			if ($Model->save() !== false) {
    				$this->success('修改菜单成功！', U('Menu/edit', array('menu_id'=>$data['menu_id'])));
    			} else {
    				$this->error('修改菜单失败！');
    			}
    		} else {
    			$this->error($Model->getError());
    		}
    	}
    }
    
    // 删除菜单
    public function delete()
    {
    	$menu_id = I('get.menu_id', 0, 'intval');
    	if ($menu_id <= 0) {
    		$this->error('错误的请求');
    	}
    	
    	$Model = M('Menu');
    	
    	// 检测是否存在子类
    	$has_child = $Model->where(array('pid' => $menu_id))->count();
    	
    	if ($has_child > 0) {
    		$this->error('此分类下存在子分类，不能直接删除');
    	}
    	
    	if ($Model->delete($menu_id)) {
    		$this->success('删除成功');
    	} else {
    		$this->error('删除失败');
    	}
    	
    }
    
    // 获取子分类(用于ajax返回)
    public function getChildren()
    {
    	$pid       = I('get.pid');
    	$level     = I('get.level');
    	$nextLevel = $level + 1;
    	
    	if ($pid < 0) {
    		exit();
    	}
    	
    	// 获取所有子节点
    	$children = D('Menu')->getChildren($pid);
    	$str      = '';
    	
    	foreach ($children as $val) {
    	
    		$str .=  '<tr id="cat_id_'.$val['menu_id'].'" parent-id="'.$val['pid'].'"';
    	
    		if ($val['children'] > 0) {
    			$str .= ' is-load="0" status="close"><td style="padding-left:'.($nextLevel* 25).'px;"><a href="javascript:void(0);" onclick="getChildrenCategory(this, \''.U('Menu/getChildren').'\', '.$val['menu_id'].', '.$nextLevel.');" title="展开"><img src="/Admin/Tpl/Public/img/icon-plus.gif"/></a> ';
    		} else {
    			$str .= ' is-load="1" status="open"><td style="padding-left:'.($nextLevel* 25).'px;"><a href="javascript:void(0);" title="折叠"><img src="/Admin/Tpl/Public/img/icon-minus.gif"/></a> ';
    		}
    		
    		$str .= $val['name'].'</td><td>';
    		
    		if ($val['status'] == 1) {
    			$str .= '<span class="color-green">启用</span>';
    		} else {
    			$str .= '<span class="color-red">禁用</span>';
    		}

    		$str .= '</td><td>'.$val['orders'].'</td><td><span class="tooltip-container">
    					<a href="'.U('Menu/add', array('pid' =>$val['menu_id'])).'" title="添加子菜单"><i class="icon-plus"></i></a> &nbsp;
    					<a href="'.U('Menu/edit', array('menu_id' =>$val['menu_id'])).'" title="编辑"><i class="icon-edit"></i></a> &nbsp;
    					<a href="'.U('Menu/delete', array('menu_id' =>$val['menu_id'])).'" title="删除" onclick="return confirm_redirect(\'你确认删除此记录吗？\');"><i class="icon-trash"></i></a>
    					</span>
    					</td>
    					</tr>';
    	}
    	
    	echo $str;
    	exit();
    }
    
}