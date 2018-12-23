<?php
/**
 * 导航模型类
 * 
 * @author xiaosibo
 */
class NavModel extends Model
{
	/**
	 * 通过广告位获取广告
	 * 
	 * @param int 			$pos 		广告位ID
	 * @param string     $field		返回的字段 	例如:   id,title,comtnt...
	 * @param int 			$num		获取的条数
	 * @param int 			$start		获取的开始位置
	 * @param boolean 	$cache		是否缓存
	 * @return array
	 */
	public function getNavByPos($pos, $field = '*', $num = 10, $start = 0, $cache = true)
	{
		$list = $this->field($field)
						  ->where(array('is_show' => 1, 'pos' => intval($pos)))
						  ->cache($cache)
						  ->order('orders DESC, id DESC')
						  ->limit($start, $num)
						  ->select();
		return $list;
	}
	
}