<?php
/**
 * 编辑分类模型
 * @author xiaosibo
 */
class EditorCatModel extends Model
{
	/**
	 * 自动验证
	 * @var array
	 */
	protected  $_validate = array(
		array('cat_name', 'require', '分类名称不能为空!', 	Model::MUST_VALIDATE)
	);
	
	/**
	 * 返回菜单树形结构的二维数组
	 *
	 * @param int $layer 	获取的层级 例如 2表示值获取2层
	 * @param int $root  	父节点id
	 * @param int $except 	需要排除的节点id(此id下的所有后代节点都会排除)
	 * @return array
	 */
	public function getFullOptions($layer = 0, $root = 0, $except = NULL)
	{
		import("@.ORG.Tree");
		$catList = $this->order('orders DESC, cat_id ASC')->select();
		$Tree    = new Tree();
		$Tree->setTree($catList, 'cat_id', 'pid', 'cat_name');
		
		// 注意 返回的数据中的level级会覆盖原始的level字段
		return $Tree->getFullOptions($layer, $root, $except);
	}

	/**
	 * 获得所有子节点
	 *
	 * @param int $pid 节点id
	 * @return array
	 */
	public function getChildren($pid = 0)
	{
		$sql = 'SELECT a.*, count(b.cat_id) AS children FROM __TABLE__ AS a LEFT JOIN __TABLE__ AS b ON a.cat_id=b.pid WHERE a.pid='.intval($pid).' GROUP BY a.cat_id ORDER BY a.orders DESC, a.cat_id ASC';
	
		return $this->query($sql);
	}
	
}
