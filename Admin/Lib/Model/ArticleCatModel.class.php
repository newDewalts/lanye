<?php
/**
 * 文章分类模型
 * @author xiaosibo
 */
class ArticleCatModel extends Model
{
	/**
	 * 自动验证
	 * @var array
	 */
	protected  $_validate = array(
		array('cat_name', 'require', '新闻分类名称不能为空!', Model::MUST_VALIDATE)
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
		$articleCatList = $this->order('orders DESC, cat_id ASC')->select();
		$Tree        = new Tree();
		$Tree->setTree($articleCatList, 'cat_id', 'pid', 'cat_name');
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
		$articleCatList = $this->order('orders DESC, cat_id ASC')->select();
		$Tree        = new Tree();
		$Tree->setTree($articleCatList, 'cat_id', 'pid', 'cat_name');
		
		// 注意 返回的数据中的level级会覆盖原始的level字段
		return $Tree->getFullOptions($layer, $root, $except);
	}
	
}
