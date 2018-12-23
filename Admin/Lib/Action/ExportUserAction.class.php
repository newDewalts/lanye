<?php
/**
 * 导出用户资料控制器
 * 
 * @author xiaosibo
 */
class ExportUserAction extends CommonAction
{
	/**
	 * 存放生成的.xls文件目录
	 * 
	 * @var string
	 */
	private $exportPath = 'Uploads/export/';
	
	public function index()
	{
		$this->display();
	}
	
	// 生成Excel文件
	public function createExcelFile()
	{
		/*
		 * 当用户数据很多的时候需要分段进行存放到文件中
		 */
		$num   = 100;  // 每个文件获取的用户记录数
		$page  = I('get.page', 1, 'intval');
		$start = ($page-1) * $num;
		
		vendor('PHPExcel.PHPExcel');
		
		$objPHPExcel = new PHPExcel();
		
		// 第一行信息
		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A1', '用户ID')
					->setCellValue('B1', '用户名')
					->setCellValue('C1', '昵称')
					->setCellValue('D1', '性别')
					->setCellValue('E1', '手机')
					->setCellValue('F1', '电话')
					->setCellValue('G1', '邮箱');
		
		// 第一行字体加粗
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('D1')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('E1')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('F1')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('G1')->getFont()->setBold(true);
		
		// 设置宽度
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(8);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
		
		// 取出用户信息 (只取出"注册用户"角色, 固定ID为4)
		$userList = M('User')->where(array('role_id' => 4 ))
							->field('user_id, username, nickname, sex, email, phone, mobile')
							->order('user_id ASC')->limit($start, $num)->select();
		
		if (!empty($userList)) {
			
			$index = 2; // 从第二行开始
			foreach ($userList as $user) {
			
				if ($user['sex'] == 1) {
					$user['sex'] = '男';
				} elseif ($user['sex'] == 2) {
					$user['sex'] = '女';
				} else {
					$user['sex'] = '保密';
				}
			
				// 添加数据行
				$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A'.$index, $user['user_id'])
				->setCellValue('B'.$index, $user['username'])
				->setCellValue('C'.$index, $user['nickname'])
				->setCellValue('D'.$index, $user['sex'])
				->setCellValue('E'.$index, $user['mobile'])
				->setCellValue('F'.$index, $user['phone'])
				->setCellValue('G'.$index, $user['email']);
			
				// 修改内容为数值的框默认align="right"
				$objPHPExcel->getActiveSheet()
				->getStyle('A'.$index)
				->getAlignment()
				->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
					
				$objPHPExcel->getActiveSheet()
				->getStyle('E'.$index)
				->getAlignment()
				->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
				$index++;
			}
			// 工作薄标题
			$objPHPExcel->getActiveSheet()->setTitle('用户信息');
			// 设置焦点框
			$objPHPExcel->setActiveSheetIndex(0);
	
			// 检测目录是否存在
			if (!is_dir($this->exportPath)) {
				mkdir($this->exportPath, 0777, true);
			}
			
			// 文件名
			$file = date('YmdHis').'_'.$page.'.xls';
			
			/*
			 直接输出到浏览器
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename='.$name);
			header('Cache-Control: max-age=0');
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
			$objWriter->save('php://output');
			*/
			
			// 保存到文件
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
			$objWriter->save($this->exportPath.$file);
			
			$this->assign('file', $file);
			$this->assign('nextPage', $page+1);
		}
		
		$hasMore = true;
		
		// 没有数据或这次的数据不够$num量, 证明数据已经取完了
		if (empty($userList) || count($userList) < $num) {
			$hasMore = false;
		}
		
		$this->assign('hasMore', $hasMore);
		$this->display();
	}

	// 下载页
   	public function download()
   	{
   		$fileArr = scandir($this->exportPath);

   		$files = array();
   		foreach ($fileArr as $file) {
   			if ($file == '.' || $file == '..') continue;
   			// thinkphp模板不能循环一维数组，此处组合成二位数组
   			$files[] = array('file' => $this->exportPath.$file);
   		}
   		$this->assign('files', $files);
   		$this->display();
   	}
   	
   	// 清空生成的Excel文件
   	public function clean()
   	{
   		$fileArr = scandir($this->exportPath);
   		foreach ($fileArr as $file) {
   			if ($file == '.' || $file == '..') continue;
			@unlink($this->exportPath.$file);
   		}
   		$this->success('清空成功');
   	}

}





