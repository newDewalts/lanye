<?php
/**
 * 广告位置模型
 * @author xiaosibo
 */
class AdPosModel extends Model
{
	/**
	 * 自动验证
	 * @var array
	 */
	protected  $_validate = array(
		array('pos_title', 'require', '广告位置名称不能为空!', Model::MUST_VALIDATE)
	);
}
?>