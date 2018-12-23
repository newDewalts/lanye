<?php
/**
 * 系统配置控制器
 * 
 * @author xiaosibo
 */
class SysconfigAction extends CommonAction 
{
	// 站点配置
	public function index()
	{	
		// 基础配置的type值为1
		// 验证码的type值为2
		$Model = M('Sysconfig');
	
		if (IS_POST) {
			$type = intval($_POST['type']);
			unset($_POST['type']);
			if ($type <= 0) {
				$this->error('错误的请求');
			}
			// 获取数据并保存配置
			$Model->addAll($this->format_data_insert($type), array(), true);
			$this->success('修改配置成功',  I('post.forward_url', U('Sysconfig/index')));
		} else {
			$type = I('get.type', '1', 'intval');
			if ($type <= 0) {
				$this->error('错误的请求');
			}
			$result = $Model->where(array('type' => $type))->select();
			$this->assign('config', $this->format_data_show($result));
			$this->assign('type', $type);
			$this->display();
		}
	}
	
	
	
	/**
	 * 将$_POST中的数据转换为插入数据库的二位数组
	 *
	 * @param  int $type 配置选项的类型
	 * @return array
	 */
	protected function format_data_insert($type)
	{
		$ret = array();
		foreach ($this->_post() as $key => $val) {
			$ret[] = array(
					'name'   => $key,
					'value'	 => trim($val),
					'type' 	 => intval($type)
			);
		}
		return $ret;
	}
	
	/**
	 * 将数据库取出的二维数组转换为一维数组
	 *
	 * @param  array $arr 从数据库取出的二维数组
	 * @return array
	 */
	protected function format_data_show($arr)
	{
		$ret = array();
	
		if (!is_array($arr)) {
			return false;
		}
	
		foreach ($arr as $val) {
			$ret[$val['name']] = $val['value'];
		}
	
		return $ret;
	}

 
  
}