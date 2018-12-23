<?php
/**
 * 新闻模型类
 * 
 * @author xiaosibo
 */
class NewsModel extends Model
{
	/**
	 * 通过年份分类获取新闻
	 * 
	 * @param int 			$year_id 		年份分类ID
	 * @param string     $field			        返回的字段 例如:   id,title,comtnt...
	 * @param int 			$num			获取的条数
	 * @param int 			$start			获取的开始位置
	 * @param boolean 	$cache			是否缓存
	 * @return array
	 */
	public function getNewsByYear($year_id, $field = '*', $num = 10, $start = 0, $cache = true)
	{
		$list = $this->field($field)
						  ->where(array('status' => 1, 'year_id' => intval($year_id)))
						  ->cache($cache)
						  ->order('orders DESC, id DESC')
						  ->limit($start, $num)
						  ->select();
		return $list;
	}
	
	/**
	 * 获取热点新闻
	 * 
	 * @param int 			$num  	数量
	 * @param string 	$field	返回的字段 	例如:   id,title,comtnt...
	 * @param boolean 	$cache	是否缓存
	 * @return array
	 */
	public function getHotNews($num = 10, $field = '*', $cache = true)
	{
		$list = $this->field($field)
						  ->where(array('status' => 1))
						  ->cache($cache)
						  ->order('hits DESC')
						  ->limit($num)
						  ->select();
		return $list;
	}
	
}