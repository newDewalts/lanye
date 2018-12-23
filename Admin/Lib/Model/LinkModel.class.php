<?php
/**
 * 友情链接模型
 * @author xiaosibo
 */
class LinkModel extends Model
{
	/**
	 * 自动验证
	 * @var array
	 */
	protected  $_validate = array(
		array('name', 	'require', '友情链接名称不能为空!', 	Model::MUST_VALIDATE),
		array('link', 	'require', '友情链接url链接不能为空!', 	Model::MUST_VALIDATE),
	);
}
?>