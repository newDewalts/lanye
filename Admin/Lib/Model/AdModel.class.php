<?php
/**
 * 广告模型
 * @author xiaosibo
 */
class AdModel extends Model
{
	/**
	 * 自动验证
	 * @var array
	 */
	protected  $_validate = array(
		array('pos_id', 'require', '广告位置不能为空!', 	Model::MUST_VALIDATE),
		array('name', 	'require', '广告名称不能为空!', 	Model::MUST_VALIDATE),
		array('ad_img', 	'require', '广告图片不能为空!', 	Model::MUST_VALIDATE)
	);
}
?>