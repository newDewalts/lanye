<?php
/**
 * 角色模型
 * @author xiaosibo
 */
class RoleModel extends Model
{
	/**
	 * 自动验证
	 * @var array
	 */
	protected  $_validate = array(
		array('name', 'require', '角色名称不能为空!', Model::MUST_VALIDATE)
	);
}
?>