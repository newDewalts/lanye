<?php
/**
 * 导航位置模型
 * @author xiaosibo
 */
class NavPosModel extends Model
{
	/**
	 * 自动验证
	 * @var array
	 */
	protected  $_validate = array(
		array('pos_title', 'require', '导航位置名称不能为空!', Model::MUST_VALIDATE)
	);
}
?>