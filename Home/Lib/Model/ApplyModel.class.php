<?php
/**
 * 在线投稿模型类
 * 
 * @author su
 */
class ApplyModel extends Model
{
	/**
	 * 自动验证
	 * @var array
	 */
	protected  $_validate	=	array(
			array('username', 		'require', 		'作者姓名必须填写', 		Model::MUST_VALIDATE),
			array('phone', 			'require', 		'手机号码必须填写', 		Model::MUST_VALIDATE),
			array('phone', 			'isMobile', 		'手机号格式不正确', 		Model::MUST_VALIDATE,  	'function'),
			array('email', 			'require', 		'邮箱必须填写', 			Model::MUST_VALIDATE),
			array('email', 			'email', 			'邮箱格式不正确', 		Model::MUST_VALIDATE),
			array('qq', 			'require', 		'qq必须填写', 			Model::MUST_VALIDATE),
	);
	
	/**
	 * 自动完成
	 * @var array
	 */
	protected $_auto = array (
			array('add_time', 'time',  Model:: MODEL_INSERT,  'function')
	);
	
	
}