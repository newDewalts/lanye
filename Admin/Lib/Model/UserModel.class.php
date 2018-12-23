<?php
/**
 * 用户模型
 * @author xiaosibo
 */
class UserModel extends Model
{
	/**
	 * 自动验证
	 * @var array
	 */
	public $_validate	=	array(
			array('role_id', 	'require', 	'用户角色必须'),
			array('username', 	'require', 	'用户名称必须'),
			array('email', 		'require', 	'邮箱必须'),
			array('email', 		'email', 	'邮箱格式不正确'),
			array('password', 	'require', 	'密码必须', 		self::MUST_VALIDATE, 	'regex',   	self::MODEL_INSERT),
			array('repassword', 'password', '两次密码不一致', 	self::MUST_VALIDATE, 	'confirm', 	self::MODEL_INSERT),
			array('username', 	'',  		'帐号已经存在', 	self::EXISTS_VALIDATE, 	'unique', 	self::MODEL_INSERT),
			array('email', 		'',  		'邮箱已经存在', 	self::EXISTS_VALIDATE, 	'unique'),
			
			//array('mobile', 		'require',  		'手机号码必须'),
			//array('mobile', 		'isMobile',  	'手机号码格式不正确', 	self::EXISTS_VALIDATE, 	'function')
	);
	
	/**
	 * 自动完成
	 * @var array
	 */
	protected $_auto		=	array(
			array('password',    	 'md5',  	self::MODEL_INSERT,     'function'),
			array('create_time', 	 'time', 	self::MODEL_INSERT,     'function'),
			array('last_login_time', 'time',    self::MODEL_INSERT,     'function')
	);
	
	
}