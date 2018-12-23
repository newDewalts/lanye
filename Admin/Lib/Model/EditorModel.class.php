<?php
/**
 * 编辑管理模型
 * @author xiaosibo
 */
class EditorModel extends Model
{
	/**
	 * 自动验证
	 * @var array
	 */
	protected $_validate	=	array(
			array('name', 	'require', 	'编辑名称必须填写', Model::MUST_VALIDATE),
			array('cat_id', 	'require', 	'分类必须选择', Model::MUST_VALIDATE),
			array('avatar', 	'require', 	'编辑头像必须上传', Model::MUST_VALIDATE)
	);
	
	/**
	 * 自动完成
	 * @var array
	 */
	protected $_auto		=	array(
			array('addtime',  'time', Model:: MODEL_INSERT, 'function')
	);

}