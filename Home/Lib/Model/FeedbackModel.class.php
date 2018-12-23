<?php
/**
 * 客户反馈模型类
 * 
 * @author xiaosibo
 */
class FeedbackModel extends Model
{
	protected $_validate   =  array(
			array('fullname', 'require', '姓名必须填写',  Model::MUST_VALIDATE),
			/*array('content', 	'require', '反馈内容必须填写',  Model::MUST_VALIDATE),*/
			/*array('email','require','邮箱必须填写',Model::MUST_VALIDATE),*/
			/*array('phone','require','手机号必须填写',Model::MUST_VALIDATE),*/
	);

	protected $_auto = array (
			array('status', '1', Model:: MODEL_INSERT),
			array('addtime', 'time', Model:: MODEL_INSERT, 'function')
	);
	
}