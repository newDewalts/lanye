<?php
/**
 * 在线投稿模型类
 * 
 */
class ContributeModel extends Model
{
	/**
	 * 自动验证
	 * @var array
	 */
	protected  $_validate	=	array(
			array('realname', 		'require', 		'真实姓名必须填写', 		Model::MUST_VALIDATE),
			array('mobile', 			'require', 		'手机号码必须填写', 		Model::MUST_VALIDATE),
			//array('mobile', 			'isMobile', 		'手机号格式不正确', 		Model::MUST_VALIDATE,  	'function'),
			//array('email', 			'require', 		'邮箱必须填写', 			Model::MUST_VALIDATE),
			//array('email', 			'email', 			'邮箱格式不正确', 		Model::MUST_VALIDATE),
			//array('grade', 			'require', 		'期刊级别必须选择', 		Model::MUST_VALIDATE),
			//array('service_type', 'require', 		'服务类型必须选择', 		Model::MUST_VALIDATE),
			//array('attach', 			'require', 		'上传文章必须选择', 		Model::MUST_VALIDATE),
			//array('title', 				'require', 		'文章题目必须填写', 		Model::MUST_VALIDATE),
			//array('subject', 		'require', 		'发表科目必须选择', 		Model::MUST_VALIDATE),
			//array('purpose', 		'require', 		'投稿目的必须选择', 		Model::MUST_VALIDATE)
	);
	
	/**
	 * 自动完成
	 * @var array
	 */
	protected $_auto = array (
			array('addtime', 'time',  Model:: MODEL_INSERT,  'function')
	);
	
	
}