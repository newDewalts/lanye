<?php
/**
 * 网站服务文章模型
 * @author xiaosibo
 */
class ServiceModel extends Model
{
	/**
	 * 自动验证
	 * @var array
	 */
	public $_validate	=	array(
			array('cat_id', 	'require', 	'服务文章分类必须选择'),
			array('title', 		'require', 	'服务文章标题必须选择')
	);
	
	/**
	 * 自动完成
	 * @var array
	 */
	public $_auto		=	array(
			array('addtime',  'strtotime', self::MODEL_BOTH, 'function')
	);
	
	
	
}