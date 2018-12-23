<?php 
/*
 * It is about Knowledge;
 * @author:xu
 */
class KnowledgeAction extends CommonAction{
	public function _initialize(){
		parent::_initialize();
		//导航高亮
		$this->assign('gaoliang','8');
	}
	public function index(){
		$boolean       = false;
		//顶级分类的名称
		$class_name    = '';
		//获取顶级分类的相关信息
		$class_array   = array();
		//获取下级分类的信息
		$pre_array     = array();
		//下级分类的名称
		$pre_name      = '';
		//获取单个分类的所有文章
		$cat_array     = array();
		//获取所有分类的下的内容,以三维数组的形式存储
		//$all_array     = array();
		//获取所有分类的编号
		$lists_num     = array();
		//导入第三方类
		import('@.ORG.Page');
		
		$class_array   = M('Article_cat')->cache()->where(array('cat_id' => 21))->find();
		$class_name    = $class_array['cat_name'];
		
		//获取所有的数据
		$pre_array     = M('Article_cat')->cache()->where(array('pid' => 21))->order('cat_id asc')->select();
		foreach($pre_array as $k => $v){
			$lists_num[] = $v['cat_id'];
		//	$cat_array = M('Article')->cache()->where(array('cat_id'=>$v['cat_id']))->select();
		//	foreach($cat_array as $key => $value){
		//		$all_array[$v['cat_id']][] = $value;
		//	}
		}
		//获取url传递过来的cat_id对应的值的数据
		if(IS_REQUEST){
			$cat_id     = I('request.id',0,'intval');
			if($cat_id <= 0){
				$this->_empty();
			}
			foreach($lists_num as $k => $v){
				if($cat_id  == $v){
					$boolean= true; 
				}
			}
			//若是没有该分类的编号，值通过url传进来后，直接跳到错误页面
			if(!$boolean){
				$this->_empty();
			}
	        //seo
	        $seo    = M('Article_cat')->cache()->where(array('cat_id'=>$cat_id))->find();
	        $this->assignSeoInfo($seo['cat_name'],$seo['keywords'],$seo['description']);
			
			$count  = M('Article')->cache()->where(array('cat_id'=>$cat_id))->count();
			$Page       = new Page($count);
			//设置分页url
			$Page->url  = 'articles-'.$cat_id.'-';
			$pageShow   = $Page->show();	
			$cat_array  = M('Article')->cache()->where(array('cat_id'=>$cat_id))->order('id desc')->limit($Page->firstRow.','.$Page->listRows)->select();	
			foreach($pre_array as $key => $vo){
				if($cat_id == $vo['cat_id']){
					$pre_name = $vo['cat_name'];
				}
			}
			$this->assign('pageShow',$pageShow);
			$this->assign('cat_array',$cat_array);
			$this->assign('cat_id',$cat_id);
			$this->assign('pre_name',$pre_name);
		}
		//$this->assign('pre_array',$pre_array);
		$this->assign('class_name',$class_name);
		$this->display();
	}
	public function detail(){
		//导入第三方类库
		Load('extend');
		//获取顶级类的相关信息
		$class_array= array();
		//获取单个下级分类的相关信息；
		$pre_array  = array();
		//获取顶级类的名称
		$class_name = '';
		//获取对应的下级分类的名称
		$pre_name   = '';
		//获取所有下级分离信息
		$cat_array  = array();
		//随机取出10个数据
		$rand_array = array();
		//获取单个的数据
		$one_array  = array();
		//获取所有的数据
		$all_array  = array();
		//下级分类的编号
		$cat_id     = 0;
		//记录一条信息
		$id_array   = array();
        
		$num        = array();
		
		
		//判断是否有值从url中传递过来
		if(IS_REQUEST){
			//对传过来的值进行过滤
			$id     = I('request.id',0,'intval');
			if($id <= 0){
				$this->_empty();
			}
			//获取对应ID的所有内容
			$id_array  = M('Article')->where(array('id'=>$id))->find();
			if(empty($id_array)){
				$this->_empty();
			}
			M('Article')->where(array('id' => $id))->setInc('hits');
			$cat_id = $id_array['cat_id'];
			
			$this->assignSeoInfo($id_array['title'],$id_array['keywords'],$id_array['description']);
			
			//获取下级分类与顶级分类的名称
			$pre_array     = M('Article_cat')->cache()->where(array('cat_id'=>$cat_id))->find();
			$pre_name      = $pre_array['cat_name'];
			//$this->assignSeoInfo($pre_array['cat_name'],$pre_array['keywords'],$pre_array['description']);
			$class_array   = M('Article_cat')->cache()->where(array('cat_id'=>$pre_array['pid']))->find();
			$class_name    = $class_array['cat_name'];
	
			//这个地方的取值方式有些不合理可能需要重新整理
			//获取的是所有的数据，此时获取的数据没有顺序可言
			$cat_array     = M('Article_cat')->cache()->where(array('pid'=>$pre_array['pid']))->select();
			foreach($cat_array as $k => $v){
				$one_array = M('Article')->cache()->where(array('cat_id'=>$v['cat_id']))->order('id asc')->select();
				foreach($one_array as $key => $value){
					$all_array[] = $value; 
				}
			}

			//获取前十个随机数据
			$num           = range(0,(count($all_array)-1));
			shuffle($num);
			$num           = array_slice($num,0,10);
			for($i=0;$i<count($num);$i++){
				$rand_array[$i] = $all_array[$num[$i]];
			}
			
			
			$this->assign('class_name',$class_name);
			$this->assign('id_array',$id_array);
			$this->assign('cat_id',$cat_id);
			$this->assign('pre_name',$pre_name);
			$this->assign('rand_array',$rand_array);
		}
		$this->display();
	}
	public function all(){
		header("Content-Type:text/html;charset=UTF-8");
		//导入第三方类库
		import('@.ORG.Page');
		//记录数据的类型
		$cat_array = array();
		//记录单条数据
		$one_array = array();
		//记录所有的数据
		$all_array = array();
		//顶级分类数组
		$class_array = array();
		//顶级分类的名称
		$class_name = '';
		
        $where = array();
		
		$cat_array     = M('Article_cat')->cache()->where(array('pid'=>'21'))->select();
		foreach($cat_array as $k => $v){
			$one_array = M('Article')->cache()->where(array('cat_id' => $v['cat_id']))->order('id asc')->select();
			foreach($one_array as $key => $value){
				$all_array[] = $value;
			}		
		}
		
		$class_array  = M('Article_cat')->cache()->where(array('cat_id' => '21'))->find();
		$class_name   = $class_array['cat_name'];
		$this->assignSeoInfo($class_array['cat_name'],$class_name['keywords'],$class_name['description']);
		
		$Page       = new Page(count($all_array));
		//设置分页url
		$Page->url  = 'articles-'.'p'.'-';
		$pageShow   = $Page->show();
		$where['cat_id'] = array(array('egt',22),array('elt',29));
		$cat_array  = M('Article')->cache()->where($where)->order('id desc')->limit($Page->firstRow.','.$Page->listRows)->select();
		
		$this->assign('cat_array',$cat_array);
		$this->assign('pageShow',$pageShow);
		$this->assign('class_name',$class_name);
		$this->display();
	}
}
?>