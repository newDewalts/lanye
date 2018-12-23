<?php
/* 
 * It is about Periodical;
 * @author:xu
 */
class PeriodicalAction extends CommonAction{
	public function _initialize(){
		parent::_initialize();
		//导航高亮
		$this->assign('gaoliang','5');
	}
	
	public function index(){
		//导入第三方类库Page类
		import('@.ORG.Page');
		$count          = M('Periodical')->count();
		//实例化分页类
		$Page           = new Page($count);
		$Page->url = 'periodicals/p/';
		$pageShow       = $Page->show();
		$periodicalList = M('Periodical')->cache()->order('pre_id desc')->limit($Page->firstRow.','.$Page->listRows)->select();    
		$this->assign('pageShow',$pageShow);
		$this->assign('periodicalList',$periodicalList);
		//赋值seo信息
		$this->assignSeoInfo('中文期刊');
		$this->display();
	}
	public function lists(){
		if(IS_REQUEST){
			//导入第三方类库Page类
			import('@.ORG.Page');
			//通过get或者request均可获得url传递过来的值。
			$cate_id     = I('request.id',0,'intval');
			if($cate_id < 0){
				$this->_empty();
			}
			
			//获取下级分类的相关值
			$cate_arr    = M('Periodical_cate')->cache()->where(array('cat_id' => $cate_id))->find();
			//获取上级分类的相关值
			$per_arr     = M('Periodical_cate')->cache()->where(array('cat_id' => $cate_arr['pid']))->find();
			if(empty($cate_arr) && empty($per_arr)){
				$this->_empty();
			}
				
			$periodicals = M('Periodical')->cache()->where(array('cate_id' => $cate_id))->order('pre_id desc')->select();
			$count       = count($periodicals);
			//实例化分页类
			$Page        = new Page($count);
			$Page->url   = 'periodicals/'.$cate_id.'/';
			$pageShow    = $Page->show();
			
			$periodicals = M('Periodical')->cache()->where(array('cate_id' => $cate_id))->order('pre_id desc')->limit($Page->firstRow.','.$Page->listRows)->select();
			
			$this->assign('cate_id',$cate_id);
			$this->assign('cate_arr',$cate_arr);
			$this->assign('per_name',$per_arr['cat_name']);
		    $this->assign('periodicals',$periodicals);
			$this->assign('pageShow',$pageShow);
			//赋值seo信息
			$this->assignSeoInfo($cate_arr['cat_name'],$cate_arr['keywords'],$cate_arr['description']);
		}else{
			$this->_empty();
		}
		$this->display();
	}
	public function template(){
		Load('extend');
		if(IS_REQUEST){
			//通过get或者request均可获取url传递过来的值
			$pre_id      = I('request.id',0,'intval');
			if($pre_id < 0){
				$this->_empty();
			}
			//获取对应期刊的详细内容
			$pre_array   = M('Periodical')->cache()->where(array('pre_id' => $pre_id))->find();
			if(empty($pre_array)){
				$this->_empty();
			}
			$cate_id     = $pre_array['cate_id'];
			$data        = array();
			$data['origin']       = '辑文官网';
			$data['journal']      = $pre_array['pre_journal'];        //期刊是16开还是32开
			$data['factor']       = $pre_array['pre_factor'];         //期刊的影响因子
			$data['issn']         = $pre_array['pre_issn'];           //期刊的国际编号
		    $data['cn']           = $pre_array['pre_cn'];             //期刊的国内编号
		    $data['hits']         = $pre_array['hits'];               //期刊被点击次数
		    $data['language']     = $pre_arrry['pre_language'];       //期刊的语言种类
		    $data['image']        = $pre_array['pre_image_thumb'];    //期刊的封页图片
		    $data['addtime']      = $pre_array['date_time'];          //期刊的添加时间
		    $data['keywords']     = $pre_array['pre_keywords'];       //期刊的关键字
		    $data['description']  = $pre_array['pre_description'];    //期刊的描述
		    $data['parameter']    = $pre_array['pre_paremeter'];      //期刊的参数描述
		    $data['contents']     = $pre_array['pre_contents'];       //期刊的内容描述
			$data['quote']        = $pre_array['pre_quote'];          //期刊被引用的次数
			$data['manage']       = $pre_array['pre_manage'];         //期刊的主管单位
			$data['press']        = $pre_array['pre_press'];          //期刊的出版单位
			$data['area']         = $pre_array['pre_area'];           //期刊的出版地
			
			$data['name']         = $pre_array['pre_name'];           //期刊的名称 
			$data['id']           = $pre_array['pre_id'];             //期刊在数据库中的编号
			
			$data['cate_name']    = $pre_array['cate_name'];          //期刊的上级分类名称
			$data['cate_id']      = $pre_array['pre_type'];           //期刊上级分类的编号			$cate_array  = M('Periodical_cate')->cache()->where(array('cat_id' => $pre_array['pre_type']))->find();
			$data['cat_id']       = $cate_array['pid'];               //期刊顶级分类的编号
			$data['cat_name']     = $cate_array['cat_name'];          //期刊的顶级分类名称【期刊不处在三级分类目录下】
			
			if($cate_array['pid']>0){
				$cate_array       = M('Periodical_cat')->cache()->where(array('cat_id' => $cate_array['pid']))->find();
				$data['pre_id']   = $cate_array['pid'];                //期刊顶级分类的编号 
				$data['pre_name'] = $cate_array['cat_name'];           //期刊顶级分类名称【若是期刊处在三级分类目录下】
			}
			$this->assign('data',$data);
			$this->assign('cate_id',$cate_id);
			//赋值seo信息
			$this->assignSeoInfo($data['name'],$data['keywords'],$data['description']);
			
			$temp     = M('Article_cat')->cache()->where(array('pid'=>21))->order('cat_id desc')->select();
			foreach($temp as $k => $v){
				$temp_arr = M('Article')->cache()->where(array('cat_id'=>$v['cat_id']))->order('id desc')->select();
				foreach($temp_arr as $key => $value){
					$all_info[$value['id']] = $value['title'];
					$all_num[$value['id']]  = $value['id'];
				}
				unset($temp_arr);
			}
			shuffle($all_num);
			$rand_arr = array_slice($all_num,0,10);
			for($i=0;$i<count($rand_arr);$i++){
				$rand_dat[$rand_arr[$i]]['title'] = $all_info[$rand_arr[$i]];
				$rand_dat[$rand_arr[$i]]['id']    = $rand_arr[$i];
			}
            $this->assign('rand_dat',$rand_dat);
		}else{
			$this->_empty();
		}
		$this->display();
	}
	
	/**
	 * 期刊高级搜索
	 */
	public function search(){
		$type = I('param.type');
		$where = array();
		if($type=='index'){
			$key = I('param.key');
			$lm = I('param.lm');
			if(empty($key) || empty($lm)){
				$this->error('请填写完整搜索信息。');
			}
			$where[$lm] = array('like','%'.$key.'%');
		}else{
			$pre_name = I('param.pre_name');
			$pre_issn = I('param.pre_issn');
			$pre_area = I('param.pre_area');
			$pre_factor_min = I('param.pre_factor_min');
			$pre_factor_max = I('param.pre_factor_max');
			$orders = I('param.orders');
			if($orders=='asc'){
				$orders = 'pre_factor asc';
			}else{
				$orders = 'pre_factor desc';
			}
			if(!empty($pre_name)){
				$where['pre_name'] = array('like','%'.$pre_name.'%');
			}
			if(!empty($pre_issn)){
				$where['pre_issn'] = array('like','%'.$pre_issn.'%');
			}
			if(!empty($pre_area)){
				$where['pre_area'] = array('like','%'.$pre_area.'%');
			}
			if (!empty($pre_factor_min) || !empty($pre_factor_max)){
				if (!empty($pre_factor_min)){
					$where['pre_factor'][] = array("gt",$pre_factor_min);
				}
				if (!empty($pre_factor_max)){
					$where['pre_factor'][] = array("lt",$pre_factor_max);
				}
			}
		}
		$search_count = M('Periodical')->where($where)->count();
		import('@.ORG.Page');
		$Page  = new Page($search_count);
		if($_REQUEST['p']){
			unset($_REQUEST['p']);
		}
		foreach ( $_REQUEST as $key => $val ) {
			if (! is_array ( $val )) {
				$Page->parameter .= "$key=" . urlencode ( $val ) . "&";
			}
		}
		$pageShow       = $Page->show(); 
		$search_info = M('Periodical')->where($where)->order($orders)->limit($Page->firstRow.','.$Page->listRows)->select();
		$this->assign('search_info',$search_info);
		$this->assign('pageShow',$pageShow);
		$this->display();
	}
}
?>