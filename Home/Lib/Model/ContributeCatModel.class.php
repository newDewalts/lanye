<?php
/**
 * 在线投稿分类选项模型类
 * 
 * @author xiaosibo
 */
class ContributeCatModel extends Model
{
	
	/**
	 * 获得所有子节点
	 *
	 * @param int $pid 节点id
	 * @return array
	 */
	public function getChildren($pid = 0, $cache = true)
	{
		return  $this->where(array('pid' => intval($pid)))
							->cache($cache)
							->order('orders DESC, cat_id DESC')
							->select();
	}
	
}