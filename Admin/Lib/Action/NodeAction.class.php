<?php
/**
 * 节点控制器
 * @author xiaosibo
 */
class NodeAction extends CommonAction 
{
	// 节点列表
	public function index()
	{
		//$this->assign('nodeList', D('Node')->getNodeTree());
		
		$this->assign('nodeList', D('Node')->getChildren());
		$this->display();
	}
   
	// 添加节点
	public function add()
	{
		$Model = D('Node');
		if (!IS_POST) {
			$this->assign('pid', 	  I('get.pid', 0, 'intval'));
			$this->assign('nodeOptions', $Model->getFullOptions());
			$this->display('edit');
		} else {
			// 创建数据
			if ($Model->create()) {
				// 插入数据
				if ($Model->add()) {
					$this->success('添加节点成功！', U('Node/index'));
				} else {
					$this->error('添加节点失败！');
				}
			} else {
				$this->error($Model->getError());
			}
		}
	}

	// 编辑节点
	public function edit()
	{
		$Model = D('Node');
		 
		if (!IS_POST) {
			$id = I('get.id', 0, 'intval');
			if ($id <= 0) {
				$this->error('错误的请求');
			}
			$node  = $Model->find($id);
			 
			if (empty($node)) {
				$this->error('节点不存在');
			}
			
			$this->assign('node', $node);
			$this->assign('pid',  $node['pid']);
			$this->assign('nodeOptions', $Model->getFullOptions());
			$this->display();
		} else {
			// 创建数据
			if ($Model->create()) {
				// 保存修改
				if ($Model->save() !== false) {
					$this->success('修改节点成功！', U('Node/index'));
				} else {
					$this->error('修改节点失败！');
				}
			} else {
				$this->error($Model->getError());
			}
		}
	}
	
	// 删除节点
	public function delete()
	{
		$id = I('get.id', 0, 'intval');
		if ($id <= 0) {
			$this->error('错误的请求');
		}
		
		if (M('Node')->delete($id)) {
			// 删除节点对应的权限
			M('access')->where(array('node_id' => $id))->delete();
			$this->success('删除节点成功');
		} else {
			$this->error('删除节点失败');
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
		$children = D('Node')->getChildren($pid);
		$str      = '';
		 
		foreach ($children as $val) {
			 
			$str .=  '<tr id="cat_id_'.$val['id'].'" parent-id="'.$val['pid'].'"';
			 
			if ($val['children'] > 0) {
				$str .= ' is-load="0" status="close"><td style="padding-left:'.($nextLevel* 25).'px;"><a href="javascript:void(0);" onclick="getChildrenCategory(this, \''.U('Node/getChildren').'\', '.$val['id'].', '.$nextLevel.');" title="展开"><img src="/Admin/Tpl/Public/img/icon-plus.gif"/></a> ';
			} else {
				$str .= ' is-load="1" status="open"><td style="padding-left:'.($nextLevel* 25).'px;"><a href="javascript:void(0);" title="折叠"><img src="/Admin/Tpl/Public/img/icon-minus.gif"/></a> ';
			}
	
			$str .= $val['title'].'</td><td>';
	
			if ($val['status'] == 1) {
				$str .= '<span class="color-green">启用</span>';
			} else {
				$str .= '<span class="color-red">禁用</span>';
			}
	
			$str .= '</td><td>'.$val['orders'].'</td><td><span class="tooltip-container">
    					<a href="'.U('Node/add', array('pid' =>$val['id'])).'" title="添加子节点"><i class="icon-plus"></i></a> &nbsp;&nbsp;
    					<a href="'.U('Node/edit', array('id' =>$val['id'])).'" title="编辑"><i class="icon-edit"></i></a> &nbsp;&nbsp;';
			
			if ($val['children'] <= 0) {
				$str .= '<a href="'.U('Node/delete', array('id' =>$val['id'])).'" title="删除" onclick="return confirm_redirect(\'你确认删除此记录吗？\');"><i class="icon-trash"></i></a>';
			} 

    		$str .=	'</span></td></tr>';
		}
		 
		echo $str;
		exit();
	}
}