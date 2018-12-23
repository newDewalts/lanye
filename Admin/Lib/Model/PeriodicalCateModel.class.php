<?php 
class PeriodicalCateModel extends Model{
	
	/**
	 * 自动验证
	 * @var：xu
	 */
	protected  $_validate = array(
		array('cat_name', 'require', '期刊分类名称不能为空!', Model::MUST_VALIDATE)
	);
	
	/**
	 * 获取分类树形结构数据
	 * 
	 * @param number $root 获取的顶级分类ID
	 * @param string $layer 获取的层级
	 * @return array
	 */
	public function getTree($root = 0, $layer = NULL)
	{
		import("@.ORG.Tree");
		$periodicalCateList = $this->order('orders DESC, cat_id ASC')->select();
		$Tree        = new Tree();
		$Tree->setTree($periodicalCateList, 'cat_id', 'pid', 'cat_name');
		return $Tree->getFullTree($root, $layer);
	}
	
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
		$periodicalCateList = $this->order('orders DESC, cat_id ASC')->select();
		$Tree        = new Tree();
		$Tree->setTree($periodicalCateList, 'cat_id', 'pid', 'cat_name');
		// 注意 返回的数据中的level级会覆盖原始的level字段
		return $Tree->getFullOptions($layer, $root, $except);
	}
}
?>