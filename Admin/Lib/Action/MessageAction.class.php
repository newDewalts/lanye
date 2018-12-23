<?php
/**
 * SCI评估留言管理控制器
 * 
 * @author xiaosibo
 */
class MessageAction extends CommonAction
{
	// SCI评估留言列表
	public function index(){
	
		import('@.ORG.Page'); // 导入分页类
		Load('extend');
		
		$map = $search = array();
		$fullname  = I('get.name', '', 'trim');

		if ($fullname) {
			$map['name']     = array('like', "%$name%");
			$search['name']  = $fullname;
		}
		
		$Model	= M('Message');
		$count = $Model->where($map)->count(); // 查询满足要求的总记录数 $map表示查询条件
		$Page  = new Page($count, '', $search);
		
		$messageList = $Model->where($map)
						  					->order('addtime DESC')
						  					->limit($Page->firstRow.','.$Page->listRows)
						  					->select();	


		foreach($messageList as $key=>$val){

			$list[$key] = $val;
			$list[$key]['filename'] = $_SERVER['HTTP_HOST'].'/'. substr($val['filename'],2); 
		}
		
  		//dump($list);				
		$this->assign('search',  $search);
		$this->assign('messageList', $list);
		$this->assign('pageShow', $Page->show());
		$this->display();
	}


	//附件下载功能
	public function downFile(){

		$id = I('get.id');

		$mes_info = M('message')->where(array('id'=>$id))->find();

		$filename = $mes_info['filename'];

		$file  =  fopen($filename, "rb"); 
		$size = filesize($filename);
		
		$rand = rand(1,100);
		$name = date("Y-m-d",time()).$rand;

		//文件下载
		Header( "Content-type:  application/octet-stream "); 
		Header( "Accept-Ranges:  bytes "); 
		Header( "Content-Disposition:  attachment;  filename= {$name}.doc"); 

		$contents = "";
		while (!feof($file)) {
		 $contents .= fread($file,$size);	 //函数读取文件
		}
		echo $contents;
		fclose($file); 

	}



   
	// 编辑SCI评估留言信息
	public function edit()
	{
		if (IS_POST) {
			$Model = D('Message');
			if ($Model->create()) {
				
				if ($Model->save() !== false) {
					$this->success('修改评估信息成功', I('post.forward_url', U('Message/index')));
				} else {
					$this->error('修改评估信息失败');
				}
			} else {
				$this->error($Model->getError());
			}
		} else {
			$id = I('get.id', 0, 'intval');
				
			if ($id <= 0 ) {
				$this->error('错误的请求');
			}
			
			$Message = M('Message')->find($id);
			
			if (empty($Message) ) {
				$this->error('评估信息不存在');
			}
			$this->assign('Message', $Message);
			$this->assign('forward_url', I('server.HTTP_REFERER', U('Message/index')));
			$this->display();
		}
	}
    
    // 删除SCI评估留言信息
    public function delete()
    {
    	$id = I('get.id', 0, 'intval');
    	
    	if ($id <= 0 ) {
    		$this->error('错误的请求');
    	}
  
    	if (M('Message')->delete($id)) {
    		$this->success('删除SCI评估信息成功！');
    	} else {
    		$this->error('删除SCI评估信息失败！');
    	}
    }
    
}