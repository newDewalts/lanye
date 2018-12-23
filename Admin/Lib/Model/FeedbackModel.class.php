<?php
/**
 * 客户反馈模型
 * @author xiaosibo
 */
class FeedbackModel extends Model
{
	/**
	 * 自动验证
	 * @var array
	 */
	public $_validate	=	array(
			array('fullname', 	'require', 	'姓名必须选择'),
			array('content', 	'require', 	'反馈内容必须选择')
	);

	
}