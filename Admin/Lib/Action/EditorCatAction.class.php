<?php
/**
 * 编辑分类控制器
 * @author xiaosibo
 */
class EditorCatAction extends CommonAction 
{
	// 编辑分类列表
	public function index()
	{
		$this->assign('catList', D('EditorCat')->getChildren());
		$this->display();
	}
   
	// 添加分类
	public function add()
	{
		$Model = D('EditorCat');
		if (IS_POST) {
			// 创建数据
			if ($Model->create()) {
				// 插入数据
				if ($Model->add()) {
					$this->success('添加分类成功！', U('EditorCat/index'));
				} else {
					$this->error('添加分类失败！');
				}
			} else {
				$this->error($Model->getError());
			}
			
		} else {
			$this->assign('pid', I('get.pid', 0, 'intval'));
			$this->assign('catOptions', $Model->getFullOptions());
			$this->display('edit');
		}
	}

	// 编辑分类
	public function edit()
	{
		$Model = D('EditorCat');
		 
		if (IS_POST) {
			// 创建数据
			if ($Model->create()) {
				// 保存修改
				if ($Model->save() !== false) {
					$this->success('修改分类成功！', U('EditorCat/index'));
				} else {
					$this->error('修改分类失败！');
				}
			} else {
				$this->error($Model->getError());
			}
		} else {
			
			$id = I('get.id', 0, 'intval');
			if ($id <= 0) {
				$this->error('错误的请求');
			}
			$editorCat  = $Model->find($id);
			if (empty($editorCat)) {
				$this->error('分类不存在');
			}
			$this->assign('editorCat', $editorCat);
			$this->assign('pid',  $editorCat['pid']);
			$this->assign('catOptions', $Model->getFullOptions());
			$this->display();
		}
		
	}
	
	// 删除分类
	public function delete()
	{
		$cat_id = I('get.id', 0, 'intval');
		if ($cat_id <= 0) {
			$this->error('错误的请求');
		}
		$Model = M('EditorCat');
		// 有子分类不能直接删除
		if ($Model->where(array('pid' => $cat_id))->count() > 0) {
			$this->error('此分类下有子分类，不能直接删除');
		}
		if ($Model->delete($cat_id)) {
			$this->success('删除分类成功');
		} else {
			$this->error('删除分类失败');
		}
	}
	
	// 获取子分类(用于ajax返回)
	public function getChildren()
	{
		$pid    = I('get.pid');
		$level  = I('get.level');
		$nextLevel = $level + 1;
		 
		if ($pid < 0) {
			exit();
		}
	
		// 获取所有子节点
		$children = D('EditorCat')->getChildren($pid);
		$str         = '';
		 
		foreach ($children as $child) {
			 
			$str .=  '<tr id="cat_id_'.$child['cat_id'].'" parent-id="'.$child['pid'].'"';
			 
			if ($child['children'] > 0) {
				$str .= ' is-load="0" status="close"><td style="padding-left:'.($nextLevel* 30).'px;"><a href="javascript:void(0);" onclick="getChildrenCategory(this, \''.U('EditorCat/getChildren').'\', '.$child['cat_id'].', '.$nextLevel.');" title="展开"><img src="/Admin/Tpl/Public/img/icon-plus.gif"/></a> ';
			} else {
				$str .= ' is-load="1" status="open"><td style="padding-left:'.($nextLevel* 30).'px;"><a href="javascript:void(0);" title="折叠"><img src="/Admin/Tpl/Public/img/icon-minus.gif"/></a> ';
			}
	
			$str .= '<span>'.$child['cat_name'].'</span>
					    <span style="color:#CCC">(id:'.$child['cat_id'].')</span></td>
						<td>'.$child['orders'].'</td><td><span class="tooltip-container">
    					<a href="'.U('EditorCat/add', array('pid' =>$child['cat_id'])).'" title="添加子分类"><i class="icon-plus"></i></a> &nbsp;
    					<a href="'.U('EditorCat/edit', array('id' =>$child['cat_id'])).'" title="编辑"><i class="icon-edit"></i></a> &nbsp;
    					<a href="'.U('EditorCat/delete', array('id' =>$child['cat_id'])).'" title="删除" onclick="return confirm_redirect(\'你确认删除此记录吗？\');"><i class="icon-trash"></i></a>
    					</span>
    					</td>
    					</tr>';
		}
		 
		echo $str;
		exit();
	}
}