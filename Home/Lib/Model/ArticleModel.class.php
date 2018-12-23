<?php
/**
 * 文章模型类
 * 
 * @author xiaosibo
 */
class ArticleModel extends Model
{
	
	/**
	 * 通过分类获取新闻
	 * 
	 * @param array|string	$where 	查询条件 array('status' => 1, '条件2' => '..', ....) 
	 * @param string     		$field		返回的字段 	例如:   id,title,comtnt...
	 * @param int 					$num		获取的条数
	 * @param int 					$start		获取的开始位置
	 * @param boolean 			$cache		是否缓存
	 * @return array
	 */
	public function getArticles($where, $field = '*', $num = 10, $start = 0, $cache = false)
	{
		$list = $this->field($field)
						  ->where($where)
						  ->cache($cache)
						  ->order('orders DESC, id DESC')
						  ->limit($start, $num)
						  ->select();
		return $list;
	}
	
}