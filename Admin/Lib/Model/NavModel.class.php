<?php
/**
 * 导航模型
 * @author xiaosibo
 */
class NavModel extends Model
{
	/**
	 * 自动验证
	 * @var array
	 */
	protected  $_validate = array(
		array('pos', 	'require', '导航位置不能为空!', Model::MUST_VALIDATE),
		array('title', 	'require', '导航标题不能为空!', Model::MUST_VALIDATE),
		array('url', 	'require', '导航url不能为空!', 	Model::MUST_VALIDATE)
	);
}
?>