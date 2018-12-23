<?php
/**
 * 新闻模型
 * @author xiaosibo
 */
class NewsModel extends Model
{
	/**
	 * 自动验证
	 * @var array
	 */
	public $_validate	=	array(
			array('cat_id', 	'require', 	'新闻行业分类必须选择'),
			array('year_id', 	'require', 	'新闻年份必须选择'),
			array('title', 		'require', 	'新闻标题必须选择')
	);
	
	/**
	 * 自动完成
	 * @var array
	 */
	public $_auto		=	array(
			array('addtime',  'strtotime', self::MODEL_BOTH, 'function')
	);
	
	
	
}