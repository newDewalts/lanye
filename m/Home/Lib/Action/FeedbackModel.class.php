<?php
/**
 * 客户反馈模型类
 * 
 * @author xiaosibo
 */
class FeedbackModel extends Model
{
	protected $_validate   =  array(
		array('fullname', 'require', '用户名必须填写', Model::MUST_VALIDATE,), 
		array('fullname', '', '用户名已经存在', 	Model::MUST_VALIDATE, 'unique',),
		
		array('phone', 'require', '手机号码必须填写', Model::MUST_VALIDATE),
		array('phone', '/^(0|86|17951)?(13[0-9]|15[012356789]|17[678]|18[0-9]|14[57])[0-9]{8}$/', '手机号码格式不正确', Model::MUST_VALIDATE, 'regex'),
	);

	protected $_auto = array (
		array('status', '1', Model::MODEL_INSERT),
		array('addtime', 'time', Model::MODEL_INSERT,'function'),
		array('ip','get_client_ip',Model::MODEL_INSERT,'function'),
		array('remark','来自手机端网站',Model::MODEL_INSERT,'string'),
	);
}
?>