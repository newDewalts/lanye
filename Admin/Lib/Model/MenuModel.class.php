<?php
/**
 * 菜单模型
 * @author xiaosibo
 */
class MenuModel extends Model
{
	/**
	 * 自动验证
	 * @var array
	 */
	protected  $_validate = array(
		array('name', 'require', '菜单名称不能为空!', Model::MUST_VALIDATE),
		array('model', 'require', '菜单模块名不能为空!',	Model::MUST_VALIDATE)
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
		$menuList = $this->order('orders ASC, menu_id ASC')->select();
		$Tree     = new Tree();
		$Tree->setTree($menuList, 'menu_id', 'pid', 'name');
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
		$sql = 'SELECT a.*, count(b.menu_id) AS children FROM __TABLE__ AS a LEFT JOIN '.C('DB_PREFIX').'menu AS b ON a.menu_id=b.pid WHERE a.pid='.intval($pid).' GROUP BY a.menu_id ORDER BY  a.orders DESC, menu_id DESC';
		
		return $this->query($sql);
	}
	
}
?>