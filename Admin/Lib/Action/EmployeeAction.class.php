<?php
/**
 * 员工管理控制器
 * 
 * @author xiaosibo
 */
class EmployeeAction extends CommonAction
{
	// 员工列表
	public function index()
	{
		import('@.ORG.Page'); // 导入分页类
		
		$map = $search = array();
		$fullname  = I('get.fullname', '', 'trim');
		$identifier  = I('get.identifier', '', 'trim');

		if ($fullname) {
			$map['fullname']     = array('like', "%$fullname%");
			$search['fullname']  = $fullname;
		}
		if ($identifier) {
			$map['identifier']     = array('like', "%$identifier%");
			$search['identifier']  = $identifier;
		}
		
		$Model	= M('Employee');
		$count = $Model->where($map)->count(); // 查询满足要求的总记录数 $map表示查询条件
		$Page  = new Page($count, '', $search);
		
		$employeeList = $Model->where($map)
						  ->order('addtime DESC')
						  ->limit($Page->firstRow.','.$Page->listRows)
						  ->select();

		$this->assign('search',  $search);
		$this->assign('employeeList', $employeeList);
		$this->assign('pageShow', 	 $Page->show());
		$this->display();
	}
   
    // 添加员工
    public function add()
    {
    	if (IS_POST) {
    		$Model = D('Employee');
    		// 创建数据
    		if ($Model->create()) {
    			// 插入数据
    			if ($Model->add()) {
    				$this->success('添加员工成功！', U('Employee/index'));
    			} else {
    				$this->error('添加员工失败！');
    			}
    		} else {
    			$this->error($Model->getError());
    		}
    	} else {
    		$this->display('edit');
		}
    }
    
    // 编辑员工
    public function edit()
    {
    	if (IS_POST) {
    		$Model = D('Employee');
    		// 创建数据
    		if ($Model->create()) {
    			// 保存数据
    			if ($Model->save() !== false) {
    				$this->success('修改员工成功！', I('post.forward_url', U('Employee/index')));
    			} else {
    				$this->error('修改员工失败！');
    			}
    		} else {
    			$this->error($Model->getError());
    		}
    	} else {
    		
    		$id = I('get.id', 0, 'intval');
    		if ($id <= 0) {
    			$this->error('错误的请求');
    		}
    		$employee = M('Employee')->find($id);
    		if (empty($employee)) {
    			$this->error('员工不存在');
    		}
    		$this->assign('employee', $employee);
    		$this->assign('forward_url', I('server.HTTP_REFERER', U('Employee/index')));
    		$this->display();
    	}
    }
    
    // 删除员工
    public function delete()
    {
    	$id = I('get.id', 0, 'intval');
    	
    	if ($id <= 0 ) {
    		$this->error('错误的请求');
    	}

    	$Model	= M('Employee');
    	$employee = $Model->find($id);
    	
    	if (empty($employee)) {
    		$this->error('员工不存在');
    	}

    	if ($Model->delete($id)) {
    		// 删除图片
    		@unlink('./'.ltrim($employee['avatar'], '/'));
    		@unlink('./'.ltrim($employee['photo'], '/'));
    		
    		$this->success('删除员工成功！');
    	} else {
    		$this->error('删除员工失败！');
    	}
    }
    
    
     public function exportExcel($data=array(),$title=array(),$filename='report'){
        //phpinfo();
        //exit();
        import("ORG.Util.PHPExcel");
        import("ORG.Util.PHPExcel.Writer.Excel5");
        import("ORG.Util.PHPExcel.IOFactory.php");
        
        $data=M('employee')->field('identifier,fullname,position,department,phone,email')->where('status=1')->select();
        //创建PHPExcel对象，注意，不能少了\
        $objPHPExcel = new \PHPExcel();
        $objProps = $objPHPExcel->getProperties();
        $objPHPExcel->getActiveSheet()->getDefaultColumnDimension()->setWidth(20);
        $objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(20);
        
        $date = date("Y_m_d", time());
        $fileName .= "员工_{$date}.xls";
        $headArr = array('编号','姓名','职务','部门','电话','邮箱');
        //$data[0]['num']=1;
        //$data[0]['name']=2;
         //设置表头
        $key = 0;
        //print_r($headArr);exit;
        foreach($headArr as $v){
            //注意，不能少了。将列数字转换为字母\
            $colum = \PHPExcel_Cell::stringFromColumnIndex($key);
            $objPHPExcel->setActiveSheetIndex(0) ->setCellValue($colum.'1', $v);
            $key += 1;
        }
        $column = 2;
        $objActSheet = $objPHPExcel->getActiveSheet();
        foreach ($data as $key => $rows) { //行写入
            $span = 0;
            foreach($rows as $keyName=>$value){// 列写入
                $j = \PHPExcel_Cell::stringFromColumnIndex($span);
                $objActSheet->setCellValue($j.$column, $value);
                $span++;
            }
            $column++;
        }
        $fileName = iconv("utf-8", "gb2312", $fileName);
        $objPHPExcel->setActiveSheetIndex(0);
        header('Content-Type: application/vnd.ms-excel');
        header("Content-Disposition: attachment;filename=\"$fileName\"");
        header('Cache-Control: max-age=0');
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output'); //文件通过浏览器下载
        $objPHPExcel->Destroy();
        exit;
        
    }    
    
}





