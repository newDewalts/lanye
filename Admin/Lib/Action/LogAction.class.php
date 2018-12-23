<?php
/**
 * 后台登陆日志控制器
 * 
 * @author xiaosibo
 */
class LogAction extends CommonAction
{
	// 日志列表
	public function index()
	{
		import('@.ORG.Page'); // 导入分页类
		
		$Model = M('Log');
		$count = $Model->count();
		$Page  = new Page($count);
		
		$logList = $Model->order('time DESC')
								   ->limit($Page->firstRow.','.$Page->listRows)
								   ->select();

		$this->assign('logList',     		$logList);
		$this->assign('pageShow', 	$Page->show());
		$this->display();
	}

	// 单个删除日志
	public function del()
	{
		$id = I('get.id', 0, 'intval');
		if ($id <= 0) {
			$this->error('错误的请求');
		}
		
		if(M('Log')->delete($id)){
			$this->success('删除日志信息成功');
		} else {
			$this->error('删除日志信息失败');
		}
	}
	
    // 批量删除日志
    public function delete()
    {
    	$day = I('get.day', 0, 'intval');
    	
		if ($day == 1) {
			$time = time() - 2592000; 	// 一个月 60*60*24*30;
		} elseif($day == 2) {
			$time =  time() - 7776000; 	// 三个月60*60*24*90;
		} else {
			$this->error('错误的请求');
		}

		M('Log')->where("time < $time")->delete();
		
		$this->success('删除日志信息成功');
    }
    
}