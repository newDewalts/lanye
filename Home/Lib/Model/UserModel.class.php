<?php
/**
 * 用户模型类
 * 
 * @author xiaosibo
 */
class UserModel extends Model
{
	/**
	 * 自动验证
	 * @var array
	 */
	protected $_validate      =    array(
			array('username', 'require', '用户名必须填写', Model::MUST_VALIDATE, 'regex', Model:: MODEL_INSERT), 
			array('username', '', '用户名已经存在', 	Model::MUST_VALIDATE, 'unique', Model:: MODEL_INSERT),
			
			array('email', 'require', '邮箱必须填写', Model::MUST_VALIDATE),
			array('email', 'email', '邮箱格式不正确', Model::MUST_VALIDATE),
			array('email', '', '邮箱已经存在', 	Model::MUST_VALIDATE, 'unique'),
			
			array('mobile', 'require', '手机号码必须填写', Model::MUST_VALIDATE),
			array('mobile', 'isMobile', '手机号码格式不正确', Model::MUST_VALIDATE, 'function'),
			
			array('password', 'require', '密码必须填写', Model::MUST_VALIDATE, 'regex', Model:: MODEL_INSERT),
			
	);
	
	/**
	 * 自动完成
	 * @var array
	 */
	/* protected $_auto		=	array(
		array('password',    	 'md5',  	self::MODEL_INSERT,   'function'),
		array('create_time', 	 'time', 		self::MODEL_INSERT, 'function'),
		array('last_login_time', 'time', self::MODEL_INSERT, 'function'),
		array('reg_ip', 'get_client_ip', self::MODEL_INSERT, 'function'),
		array('last_login_ip', 'get_client_ip', self::MODEL_INSERT, 'function')
	); */
	
	/**
	 * 用户登录
	 * 
	 * @param string $username
	 * @param string $password
	 */
	public function login($username, $password)
	{
		if (!$username || !$password) {
			return false;
		}
		$userInfo = $this->where(array('username' => $username,'role_id'=>4))->limit(1)->find();
		// 用户不存在或密码错误
		if (empty($userInfo) || ($userInfo['password'] != $password)) {
			return false;
		}
		return $userInfo;
	}
	
}