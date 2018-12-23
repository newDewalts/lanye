<?php

/**
 * 对树形结构数据的操作
 *
 * 0是根结点
 */
class Tree
{
	/**
	 * 存放节点值  		array('节点id' => '节点值', ...)
	 * @var array
	 */
    private $data   = array();
    
    /**
     * 存放子节点id 	array('节点id' => array('子节一id', '子节点二id', ...), ...)
     * @var array
     */
    private $child  = array(-1 => array());
    
    /**
     * 存放节点的层级 	array('节点id' =>'节点层级', ...)
     * @var array
     */
    private $layer  = array(0 => 0);
    
    /**
     * 存放父节点id   array('节点id' => '父节点id', ...)
     * @var array
     */
    private $parent = array();
    
    /**
     * 节点值得字段名称
     * @var string
     */
    private $value_field = '';
    
    /**
     * 构造函数
     *
     * @param mix $value
     */
    public function __construct($value = 'root')
    {
    	$this->setNode(0, -1, $value);
    }

    /**
     * 构造树
     *
     * @param array $nodes 结点数组
     * @param string $id_field 		节点id字段
     * @param string $parent_field	父节点id字段
     * @param string $value_field	节点值字段
     */
    public function setTree($nodes, $id_field, $parent_field, $value_field)
    {
        $this->value_field = $value_field;
        //print_r($this->value_field);    cate_name;
        //exit;
        foreach ($nodes as $node)
        {   
        	//   $id_field = 'cate_id'       $parent_field='pid'   $node为一个一维数组；
            $this->setNode($node[$id_field], $node[$parent_field], $node);
            //这段代码最主要的公用就是给child数组赋值。
        }
        //调用setLayer函数，利用上面得到的child数组，获取相关数据。
        $this->setLayer();
    }

    /**
     * 取得options
     *
     * @param int $layer	  获取的层级 例如 2表示值获取2层
     * @param int $root		  父节点id
     * @param string $except 需要排除的节点id(此id下的所有后代节点都会排除)
     * @param string $space  缩进的站位符
     * @return array (id=>value)
     */
    public function getOptions($layer = 0, $root = 0, $except = NULL, $space = '&nbsp;&nbsp;')
    {
        $options = array();
        $childs = $this->getChilds($root, $except);
        foreach ($childs as $id)
        {
            if ($id > 0 && ($layer <= 0 || $this->getLayer($id) <= $layer))
            {
                $options[$id] = $this->getLayer($id, $space) . htmlspecialchars($this->getValue($id));
            }
        }
        return $options;
    }
    
    /**
     * 取得options
     *
     * @param int $layer	  获取的层级 例如 2表示值获取2层
     * @param int $root		  父节点id
     * @param string $except 需要排除的节点id(此id下的所有后代节点都会排除)
     * @return array (id=>array(...), ...)
     */
    public function getFullOptions($layer = 0, $root = 0, $except = NULL)
    {
    	$options = array();
    	$childs  = $this->getChilds($root, $except);
    	foreach ($childs as $id)
    	{
    		if ($id > 0 && ($layer <= 0 || $this->getLayer($id) <= $layer))
    		{
    			$options[$id] = array_merge(
    					(array)$this->getFullValue($id),
    					array('level' => $this->getLayer($id))
    			);
    		}
    	}
    	return $options;
    }

    /**
     * 设置结点
     *
     * @param  mix $id     节点id
     * @param  mix $parent 父节点id
     * @param  mix $value  节点值
     * @return void
     */
    //传进来的值        $id = 'cate_id'  $parent = 'pid'  $value='$node'(传进来的是一个一维数组) 
    public function setNode($id, $parent, $value)
    {
        $parent = $parent ? $parent : 0;
        //print $parent;
        //print $id;
        //print_r($value);
        $this->data[$id] = $value;
        if (!isset($this->child[$id]))
        {
            $this->child[$id] = array();
        }

        if (isset($this->child[$parent]))
        {
        	//以级别“pid”作为数据分组，记录相应的数据编号
            $this->child[$parent][] = $id;
        }
        else
        {
            $this->child[$parent] = array($id);
        }
        //parent是一个数组
        $this->parent[$id] = $parent;
        //print_r($this->child);
        //print_r($this->parent);
    }

    /**
     * 计算layerr
     * @param int $root 节点id
     * @param void
     */
    public function setLayer($root = 0)
    {
        foreach ($this->child[$root] as $id)
        {   
        	//parent[$id]对应着cat_id的pid，也就是编号对应着等级编号  在期刊里面，parent[$id]的值为 0或者9;
            $this->layer[$id] = $this->layer[$this->parent[$id]] + 1;
            if ($this->child[$id]) $this->setLayer($id);
        }
        //print_r($this->layer);
        //exit;
    }

    /**
     * 先根遍历，不包括root
     *
     * @param array $tree
     * @param mix $root
     * @param mix $except 除外的结点，用于编辑结点时，上级不能选择自身及子结点
     */
    private function getList(&$tree, $root = 0, $except = NULL)
    {
        foreach ($this->child[$root] as $id)
        {
            if ($id == $except)
            {
                continue;
            }

            $tree[] = $id;

            if ($this->child[$id]) $this->getList($tree, $id, $except);
        }
    }

    /**
     * 获得节点的值
     * @param  int $id 节点id
     * @return mixd
     */
    public function getValue($id)
    {
        return $this->data[$id][$this->value_field];
    }
    
    /**
     * 获得节点的值
     * @param  int $id 节点id
     * @return mixd
     */
    public function getFullValue($id)
    {
    	return $this->data[$id];
    }

    /**
     * 获取节点的层级
     * 
     * @param int $id 节点id
     * @param string $space 缩进的站位符
     * @return string|int
     */
    public function getLayer($id, $space = false)
    {
        return $space ? str_repeat($space, $this->layer[$id]) : $this->layer[$id];
    }

    /**
     * 获取父节点
     * @param int $id  节点id
     * @return int 父节点id
     */
    public function getParent($id)
    {
        return $this->parent[$id];
    }

    /**
     * 取得祖先，不包括自身
     *
     * @param mix $id 节点id
     * @return array
     */
    public function getParents($id)
    {
        while ($this->parent[$id] != -1)
        {
            $id = $parent[$this->layer[$id]] = $this->parent[$id];
        }

        ksort($parent);
        reset($parent);

        return $parent;
    }

    /**
     * 获取子节点
     * 
     * @param int $id 节点id
     * @return array 包含子节点的数组
     */
    public function getChild($id)
    {
        return $this->child[$id];
    }

    /**
     * 取得子孙，包括自身，先根遍历
     *
     * @param int $id 节点id
     * @param int $except 需要排除的节点id
     * @return array
     */
    public function getChilds($id = 0, $except = NULL)
    {
        $child = array($id);
        $this->getList($child, $id, $except);
        unset($child[0]);
        return $child;
    }

    /**
     * 获取节点的树形结构数组
     * 
     * @param int $root  父节点id
     * @param int $layer 获取的层级 例如 2表示值获取2层
     * @return array
     * array(
     *     array('id' => '', 'value' => '', children => array(
     *         array('id' => '', 'value' => '', children => array()),
     *     ))
     * )
     */
    function getArrayList($root = 0, $layer = NULL)
    {
        $data = array();
        foreach ($this->child[$root] as $id)
        {
            if($layer && $this->layer[$this->parent[$id]] > $layer-1)
            {
                continue;
            }
            $data[] = array('id' => $id, 'value' => $this->getValue($id), 'children' => $this->child[$id] ? $this->getArrayList($id , $layer) : array());
        }
        return $data;
    }
    
    /**
     * 获取节点的树形结构数组
     *
     * @param int $root  父节点id
     * @param int $layer 获取的层级 例如 2表示值获取2层
     * @return array
     * array(
     *     array('id' => '', 'value' => '', children => array(
     *         array('id' => '', 'value' => '', children => array()),
     *     ))
     * )
     */
    function getFullTree($root = 0, $layer = NULL)
    {
    	$data = array();
    	foreach ($this->child[$root] as $id)
    	{
    		if($layer && $this->layer[$this->parent[$id]] > $layer-1)
    		{
    			continue;
    		}
    		
    		$value = $this->getFullValue($id);
    
    		if ($this->child[$id]) {
    			$value['children'] = $this->getFullTree($id , $layer);
    		} else {
    			$value['children'] = array();
    		}
    		$data[] = $value;
    	}
    	return $data;
    }

    /**
     * 取得csv格式数据
     *
     * @param int $root
     * @param mix $ext_field 辅助字段
     * @return array(
     *      array('辅助字段名','主字段名'), //如无辅助字段则无此元素
     *      array('辅助字段值','一级分类'), //如无辅助字段则无辅助字段值
     *      array('辅助字段值','一级分类'),
     *      array('辅助字段值','', '二级分类'),
     *      array('辅助字段值','', '', '三级分类'),
     * )
     */
    function getCSVData($root = 0, $ext_field = array())
    {
        $data = array();
        $main = $this->value_field; //用于显示树分级结果的字段
        $extra =array(); //辅助的字段
        if (!empty($ext_field))
        {
            if (is_array($ext_field))
            {
                $extra = $ext_field;
            }
            elseif (is_string($ext_field))
            {
                $extra = array($ext_field);
            }
        }
        $childs = $this->getChilds($root);
        array_values($extra) && $data[0] = array_values($extra);
        $main && $data[0] && array_push($data[0], $main);
        foreach ($childs as $id)
        {
            $row = array();
            $value = $this->data[$id];
            foreach ($extra as $field)
            {
                $row[] = $value[$field];
            }
            for ($i = 1; $i < $this->getLayer($id); $i++)
            {
                $row[] = '';
            }
            if ($main)
            {
                $row[] = $value[$main];
            }
            else
            {
                $row[] = $value;
            }
            $data[] = $row;
        }
        return $data;

    }
}

?>