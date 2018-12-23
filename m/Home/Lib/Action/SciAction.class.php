<?php
/**
 * SCi影响因子查询
 * 
 * @author 
 */
class SciAction extends CommonAction{
	public function _initialize(){
		parent::_initialize();
		$this->assign('gaoliang','1');
	}

	public function index(){
		$search_name = $_POST['search_name'];
		$cat_select2 = $_POST['cat_select2'];
		$search_if1= $_POST['search_if1'];
		$search_if2 = $_POST['search_if2'];
		$order_select= $_POST['order_select'];

		$where=[];
		if($search_name){
			$where['name'] = ['like',"%$search_name%"];
		}

		if($cat_select2){
			$where['cat_id'] = $cat_select2;
		}

		if($search_if1 && !$search_if2){
			$where['if'] =['gt',$search_if1];
		}else if($search_if2 && !$search_if1){
			$where['if'] =['lt',$search_if2];
		}else if($search_if1 && $search_if2){
			$where['if'] =[['gt',$search_if1],['lt',$search_if2]];
		}

		if($order_select){
			if($order_select == 'article_num_b'){
				$order = 'article_num desc';
			}else if($order_select == 'article_num_s'){
				$order = 'article_num asc';
			}else if($order_select == 'medSci_b'){
				$order = '(medSci+0) desc';
			}else if($order_select == 'medSci_s'){
				$order = '(medSci+0) asc';
			}else if($order_select == 'if_b'){
				$order = '(`if`+0) desc';
			}else if($order_select == 'if_s'){
				$order = '(`if`+0) asc';
			} 
		}else{
			$order = 'article_num desc';
		}

		$cat_top = M('Impact_cat')->where(['pid'=>0,'status'=>1])->select();
		$this->assign('cat_top',$cat_top);
		
		$id = $_GET['id'];
		$impact = M('Impact');
		if($id){
			// 详情
			$detail=$impact->where("id={$id}")->find();
			$CiteScore_num = $detail['CiteScore_num'];
			$CiteScore_num_list = explode("/",$CiteScore_num);
			foreach ($CiteScore_num_list as $key => $value) {
				if(!$value){
					$CiteScore_num_list[$key]='null';
				}
			}

			$detail['CiteScore_num'] = $CiteScore_num_list;

			$this->assign('detail',$detail);
		}else{
			$impact_list = $impact->where($where)->order($order)->limit(30)->select();
			$this->assign('impact_list',$impact_list);
		}
                $this->setAssign('SCI期刊智能查询系统','SCI期刊智能查询系统','SCI期刊智能查询系统');
		$this->display();
	}
	
	//查询二级分类
	public function ajaxCat(){
		$id = $_POST['id'];
		$Model = D('Impact_cat');
		$cat_list = $Model->where(['pid'=>$id,'status'=>1])->select();
		echo json_encode($cat_list);
	}
}