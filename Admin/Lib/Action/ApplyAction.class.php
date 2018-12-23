<?php
/**
 * 论文服务在线申请控制器
 * 
 * @author xiaosibo
 */
class ApplyAction extends CommonAction
{
	// 反馈信息列表
	public function index()
	{
		import('@.ORG.Page'); // 导入分页类
		Load('extend');
		
		$map = $search = array();
		$username  = I('get.username', '', 'trim');
		$map['type'] = '1';
		if ($username) {
			$map['username']     = array('like', "%$username%");
			$search['username']  = $username;
		}
		
		$Model	= M('Apply');
		$count = $Model->where($map)->count(); // 查询满足要求的总记录数 $map表示查询条件
		$Page  = new Page($count, '', $search);
		
		$applyList = $Model->where($map)
						  					->order('add_time DESC')
						  					->limit($Page->firstRow.','.$Page->listRows)
						  					->select();
		$this->assign('search',  $search);
		$this->assign('applyList', $applyList);
		$this->assign('pageShow', $Page->show());
		$this->display();
	}
	
	public function keyans(){
		import('@.ORG.Page'); // 导入分页类
		Load('extend');
		
		$map = $search = array();
		$username  = I('get.username', '', 'trim');
		$map['type'] = '2';
		if ($username) {
			$map['username']     = array('like', "%$username%");
			$search['username']  = $username;
		}
		
		$Model	= M('Apply');
		$count = $Model->where($map)->count(); // 查询满足要求的总记录数 $map表示查询条件
		$Page  = new Page($count, '', $search);
		
		$applyList = $Model->where($map)
						  					->order('add_time DESC')
						  					->limit($Page->firstRow.','.$Page->listRows)
						  					->select();
		$this->assign('search',  $search);
		$this->assign('applyList', $applyList);
		$this->assign('pageShow', $Page->show());
		$this->display();
	}
   
	// 编辑反馈信息
	public function edit()
	{
		$id = I('get.id', 0, 'intval');
			
		if ($id <= 0 ) {
			$this->error('错误的请求');
		}
		
		$apply = M('Apply')->find($id);
		
		if (empty($apply) ) {
			$this->error('反馈信息不存在');
		}
		 M('Apply')->where('id='.$id)->save(array('status'=>'1'));
		$this->assign('apply', $apply);
		$this->assign('forward_url', I('server.HTTP_REFERER', U('Apply/index')));
		$this->display();
	}
    
    // 删除反馈信息
    public function delete()
    {
    	$id = I('get.id', 0, 'intval');
    	
    	if ($id <= 0 ) {
    		$this->error('错误的请求');
    	}
  
    	if (M('Apply')->delete($id)) {
    		$this->success('删除SCI论文服务在线申请成功！');
    	} else {
    		$this->error('删除SCI论文服务在线申请失败！');
    	}
    }
    
}