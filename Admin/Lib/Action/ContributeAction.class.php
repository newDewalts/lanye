<?php
/**
 * 在线投稿控制器
 * 
 * @author xiaosibo
 */
class ContributeAction extends CommonAction
{
	// 在线投稿列表
	public function index()
	{
		import('@.ORG.Page'); // 导入分页类
		
		$map = $search = array();
		$realname = I('get.realname', 	'', 	'trim');
		$subject  	= I('get.subject', 	'', 'trim');

		if ($realname) {
			$map['realname']     = array('like', "%$realname%");
			$search['realname']  = $realname;
		}
		if ($subject) {
			$map['subject']     = array('like', "%$subject%");
			$search['subject']  = $subject;
		}
		
		$Model	= M('Contribute');
		$count = $Model->where($map)->count(); // 查询满足要求的总记录数 $map表示查询条件
		$Page  = new Page($count, '', $search);
		
		$contributeList = $Model->where($map)
						  ->order('addtime DESC')
						  ->limit($Page->firstRow.','.$Page->listRows)
						  ->select();
						  
		$userModel = M('User');
		foreach ($contributeList as $key => $val) {
			if ($val['user_id'] > 0) {
				// 循环中读取数据库注意效率
				$username = $userModel->where(array('user_id' => $val['user_id']))->getField('username');
			} else {
				$username = '游客';
			}
			$contributeList[$key]['username'] = $username;
		}
		
		$this->assign('search', $search);
		$this->assign('contributeList', $contributeList);
		$this->assign('pageShow', $Page->show());
		$this->display();
	}
   
	// 查看投稿详情
	public function detail()
	{
		$id = I('get.id', 0, 'intval');
		 
		if ($id <= 0 ) {
			$this->error('错误的请求');
		}
		
		$Model       = M('Contribute');
		$contribute = $Model->find($id);
		
		if (empty($contribute)) {
			$this->error('在线投稿不存在');
		}
		
		if ($contribute['user_id'] > 0) {
			$contribute['username'] = $Model->where(array('user_id' => $val['user_id']))->getField('username');
		} else {
			$contribute['username'] = '游客';
		}

		// 修改查看状态
		$Model->save(array('id' => $id, 'status' => 1));
		
		$this->assign('forward_url', I('server.HTTP_REFERER', U('Contribute/index')));
		$this->assign('contribute', $contribute);
		$this->display();
	}

    // 删除在线投稿
    public function delete()
    {
    	$id = I('get.id', 0, 'intval');
		 
		if ($id <= 0 ) {
			$this->error('错误的请求');
		}
		
		$Model       = M('Contribute');
		$contribute = $Model->find($id);
	
		if (empty($contribute)) {
			$this->error('在线投稿不存在');
		}

    	if ($Model->delete($id)) {
    		// 删除附件
    		@unlink($contribute['attach']);
    		
    		$this->success('删除在线投稿成功！');
    	} else {
    		$this->error('删除在线投稿失败！');
    	}
    }

       public function daochu_lesson(){

       
        $franch_account =M('Contribute')->order('addtime desc')->select();
        $data = array();
        //重组需要的字段
        foreach($franch_account as $key=>$value){
            if(!empty($value)){
             
                $data[$key]['realname'] = $value['realname'];
                $data[$key]['mobile'] = $value['mobile'];
                $data[$key]['grade'] = $value['grade'];
                $data[$key]['addtime'] = date('Y-m-d H:i:s',$value['addtime']);
            }
        }
        //重组字段名称
        foreach($franch_account as $k => $v){
           
             if($k == 'realname'){
                $headArr[] = '真实姓名';
            }
            if($k == 'mobile'){
                $headArr[] = '手机/电话';
            }
            if($k == 'grade'){
                $headArr[] = '期刊级别';
            }
            if($k == 'addtime'){
                $headArr[] = '添加时间';
            }
        }
        //输出文件名称
        $this->ExportExcel($data, $headArr, '在线投稿');
    }



     public function exportExcel($data=array(),$title=array(),$filename='report')
        {
            header("Content-type:application/octet-stream");
            header("Accept-Ranges:bytes");
            header("Content-type:application/vnd.ms-excel");  
            header("Content-Disposition:attachment;filename=".$filename.".xls");
            header("Pragma: no-cache");
            header("Expires: 0");
            //导出xls 开始
            if (!empty($title)){
                foreach ($title as $k => $v) {
                    $title[$k]=iconv("UTF-8", "GB2312",$v);
                }
                $title= implode("\t", $title);
                echo "$title\n";
            }
            if (!empty($data)){
                foreach($data as $key=>$val){
                    foreach ($val as $ck => $cv) {
                        $data[$key][$ck]=iconv("UTF-8", "GB2312", $cv);
                    }
                    $data[$key]=implode("\t", $data[$key]);
                    
                }
                echo implode("\n",$data);
            }
            }
    
    
}