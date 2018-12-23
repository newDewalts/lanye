<?php
/**
 * 在线留言管理控制器
 * 
 * @author xiaosibo
 */
class FeedbackAction extends CommonAction
{
	// 反馈信息列表
	public function index(){
		import('@.ORG.Page'); // 导入分页类
		Load('extend');
		
		$map = $search = array();
		$fullname  = I('get.fullname', '', 'trim');

		if ($fullname) {
			$map['fullname']     = array('like', "%$fullname%");
			$search['fullname']  = $fullname;
		}
		
		$Model	= M('Feedback');
		$count = $Model->where($map)->count(); // 查询满足要求的总记录数 $map表示查询条件
		$Page  = new Page($count, '', $search);
		
		$feedbackList = $Model->where($map)
						  					->order('addtime DESC')
						  					->limit($Page->firstRow.','.$Page->listRows)
						  					->select();

		$this->assign('search',  $search);
		$this->assign('feedbackList', $feedbackList);
		$this->assign('pageShow', $Page->show());
		$this->display();
	}
        function add(){
            if(IS_POST) {
                $Model = D('Feedback');
                $_POST['addtime']=time();
                if ($Model->create()) {

                        if ($Model->add() !== false) {
                                $this->success('修改反馈信息成功', I('post.forward_url', U('Feedback/index')));
                        } else {
                                $this->error('修改反馈信息失败');
                        }
                } else {
                        $this->error($Model->getError());
                }
            }else{
                $this->display();
            }
        }
	// 编辑反馈信息
	public function edit()
	{
		if (IS_POST) {
			$Model = D('Feedback');
			if ($Model->create()) {
				
				if ($Model->save() !== false) {
					$this->success('修改反馈信息成功', I('post.forward_url', U('Feedback/index')));
				} else {
					$this->error('修改反馈信息失败');
				}
			} else {
				$this->error($Model->getError());
			}
		} else {
			$id = I('get.id', 0, 'intval');
				
			if ($id <= 0 ) {
				$this->error('错误的请求');
			}
			
			$feedback = M('Feedback')->find($id);
			
			if (empty($feedback) ) {
				$this->error('反馈信息不存在');
			}
			$this->assign('feedback', $feedback);
			$this->assign('forward_url', I('server.HTTP_REFERER', U('Feedback/index')));
			$this->display();
		}
	}
    
    // 删除反馈信息
    public function delete()
    {
    	$id = I('get.id', 0, 'intval');
    	
    	if ($id <= 0 ) {
    		$this->error('错误的请求');
    	}
  
    	if (M('Feedback')->delete($id)) {
    		$this->success('删除反馈信息成功！');
    	} else {
    		$this->error('删除反馈信息失败！');
    	}
    }

       public function daochu_lesson(){

       
        $franch_account =M('Feedback')->order('addtime desc')->select();
        $data = array();
        //重组需要的字段
        foreach($franch_account as $key=>$value){
            if(!empty($value)){
               
                $data[$key]['fullname'] = $value['fullname'];
                $data[$key]['content'] = $value['content'];
                $data[$key]['addtime'] = date('Y-m-d H:i:s',$value['addtime']);
            }
        }
        //重组字段名称
        foreach($franch_account as $k => $v){
            
             if($k == 'fullname'){
                $headArr[] = '姓名';
            }
            if($k == 'content'){
                $headArr[] = '内容';
            }
            
            if($k == 'addtime'){
                $headArr[] = '添加时间';
            }
        }
        //输出文件名称
        $this->ExportExcel($data, $headArr, '在线留言');
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