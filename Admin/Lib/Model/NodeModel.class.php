<?php
/**
 * 节点模型
 * @author xiaosibo
 */
class NodeModel extends Model
{
	/**
	 * 自动验证
	 * @var array
	 */
	protected  $_validate = array(
		array('name', 	'require', '节点名称不能为空!', 	Model::MUST_VALIDATE),
		array('title', 	'require', '节点显示名称不能为空!', Model::MUST_VALIDATE)
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
		$nodeList = $this->order('orders DESC, id DESC')->select();
		$Tree     = new Tree();
		$Tree->setTree($nodeList, 'id', 'pid', 'name');
		
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
		$sql = 'SELECT a.*, count(b.id) AS children FROM __TABLE__ AS a LEFT JOIN '.C('DB_PREFIX').'node AS b ON a.id=b.pid WHERE a.pid='.intval($pid).' GROUP BY a.id ORDER BY a.orders DESC, a.id DESC';
	
		return $this->query($sql);
	}
	
	/**
	 * 获取节点树
	 * @param boolean $flag 是否包含不显示的节点
	 * @return array
	 */
	public function getNodeTree($flag = 0)
	{
		import("@.ORG.Tree");
		$where = array();
		if ($flag) {
			$where['status'] = 1;
		} 
		$nodeList = $this->where($where)->order('orders DESC, id ASC')->select();
		
		$Tree     = new Tree();
		$Tree->setTree($nodeList, 'id', 'pid', 'name');
		return $Tree->getFullTree();
	}

}








