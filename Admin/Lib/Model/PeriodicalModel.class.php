<?php
/**
 * 期刊模型类
 * @author：xu
 */
class PeriodicalModel extends Model
{
	/**
	 * 自动验证
	 * @var array
	 */
	public $_validate	=	array(
			array('cat_id', 	'require', 	'期刊分类编号必须选择'),
			array('pre_name', 	'require', 	'期刊名称必须选择')
	);
	
	/**
	 * 自动完成
	 * @var array
	 */
	public $_auto		=	array(
			array('date_time',  'strtotime', self::MODEL_BOTH, 'function'),
			array('per_create_date', 'strtotime', self::MODEL_BOTH, 'function')
	);
}
?>