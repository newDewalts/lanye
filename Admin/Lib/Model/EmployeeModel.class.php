<?php
/**
 * 员工管理模型
 * @author xiaosibo
 */
class EmployeeModel extends Model
{
	/**
	 * 自动验证
	 * @var array
	 */
	protected $_validate	=	array(
			array('fullname', 	'require', 	'员工名称必须填写', Model::MUST_VALIDATE),
			array('avatar', 	'require', 	'员工头像必须上传', Model::MUST_VALIDATE),
			array('identifier', 'require', 	'工号必须填写', Model::MUST_VALIDATE),
			array('identifier', '', 		'工号已经存在', Model::EXISTS_VALIDATE, 'unique'),
			array('department', 'require', 	'部门必须填写', Model::MUST_VALIDATE),
			array('position', 	'require', 	'职位必须填写', Model::MUST_VALIDATE)
	);
	
	/**
	 * 自动完成
	 * @var array
	 */
	protected $_auto		=	array(
			array('addtime',  'time', Model:: MODEL_INSERT, 'function')
	);
	
	
	
}