<?php 
/*
 * This Action is public.
*/
class CommonAction extends Action{
	//_initialize();
	public function _initialize(){
		//if there are bugs, Error display format is UTF-8;
		header("Content-type:text/html;charset=utf-8");
		load('extend');
		//Home page banner images;
		$this->homePage();
		//web log banner
		$this->webLog();
		//Home page phone`s images
		$this->homePhone();
		//Six categories
		$this->sixType();
		//web two-dimensional code
		$this->twoDimensional();
		
		//service recommand
		//$this->service_re();
		
		//Moblie number
		//$this->webPhone();
                $this->assignConfig();
		$this->assign('url',C('url'));
		$this->assign('mUrl',C('mURL'));

	}
	protected function homePage(){
		$homeBanners = M('Ad')->cache(false)
							  ->field('name,link,ad_img')
							  ->where(array('is_show'=>1,'pos_id'=>6))
							  ->order('orders desc')
							  ->limit(3)->select();	
		//var_dump($homeBanners);die;
		$this->assign('homeBanners',$homeBanners);	
	}
	protected function webLog(){
		$webLog = M('Ad')->cache(true)
							  ->field('name,link,ad_img')
							  ->where(array('is_show'=>1,'pos_id'=>6))
							  ->order('orders desc')
							  ->find();
		$this->assign('webLog',$webLog);			
	}
	protected function homePhone(){
		$homePhone = M('Ad')->cache(true)
							  ->field('name,link,ad_img')
							  ->where(array('is_show'=>1,'pos_id'=>7))
							  ->order('orders desc')
							  ->find();

		$this->assign('homePhone',$homePhone);		
	}
	protected function sixType(){
		//fund application
		$fund_ap = M('service_cat')->cache(false)->field('cat_id,cat_name,thumb,description')->order("orders asc")->where(array('pid'=>11,'show_nav'=>1))->limit(6)->select();
		$str = '';
		foreach ($fund_ap as $key => $value) {
			$str .= $value['cat_id'].',';
		}
		$str = substr($str,0,-1);
		
		$where = "cat_id IN(".$str.")  AND status = 1";
		//导入分页类
		import('ORG.Util.Page');
		$count       = M('service')->where($where)->count();			
		//实例化分页类
		$Page        = new Page($count,5);
		$pageShow2   = $Page->show();		

		$service_list = M('service')->cache(false)->field('id,thumb,summary,title')->where($where)->limit($Page->firstRow.','.$Page->listRows)->order("orders asc")->select();

		$this->assign('service_list',$service_list);
		$this->assign('fund_ap',$fund_ap);
		$this->assign('pageShow2',$pageShow2);
	}
	
	protected function twoDimensional(){
		$twoDimensional = M('ad')->cache(true)->where(array('pos_id'=>8))->find();
		$this->assign('twoDimensional',$twoDimensional);
	}
	
	protected function service_re(){
		$service_re = M('service')->cache(true)->where(array('status'=>1))->order("rand()")->limit(4)->select();
		$this->assign('service_re',$service_re);
	}
	
	protected function webPhone(){
		$webMobile = M('sysconfig')->cache(true)->select();
		foreach($webMobile as $k => $v){
			$data[$v['name']] = $v['value'];
		}	
		$webMobile  = $data;	
		$webMobiles = explode("；",$webMobile['tel_s']);	
		
		$this->assign('webMolibe',$webMobile);
			
		$this->assign('webMobiles',$webMobiles);
	}	
	
	public function setAssign($title,$keywords,$description){
		$site['title']       = $title;
		$site['keywords']    = $keywords;
		$site['description'] = $description;
		$this->assign('site',$site);
	}

        public function addDomain($data){
		$regexp = "`<[img|IMG].*?src=[\'|\"](.*?[\.png|\.jpg|\.jpeg|\.GPEG|\.PNG|\.gif|\.GIF])[\'|\"].*?\/?>`";
		preg_match_all($regexp,$data,$matches);
		$url  = C('url');
                //如果图片路径已经包含了http:或者包含了https就不替换
		foreach($matches[1] as $key => $value){
                    if(stripos($value,"http:")===false&&stripos($value,"https:")===false){
                        $replace[$key] = $url . $value;
                    }else{
                        $replace[$key] =$value;
                    }
		}
                /*
		foreach($matches[1] as $key => $value){
			$replace[$key] = $url . $value;
		}
                 */
		$data = str_replace($matches[1], $replace ,$data);	
		return $data;		
	}
	// 验证码
    public function verify(){
        import("ORG.Util.Image");
        Image::buildImageVerify(4, 1, I('get.type', 'png'));
    }
     // 加载网站配置信息
    protected function assignConfig()
    {
    	$config  = S('site_config');
    	if (!$config) {
    		$tmpArr = M('Sysconfig')->select();
    		foreach ($tmpArr as $val) {
    			$config[$val['name']] = $val['value'];
    		}
    		S('site_config', $config);
    	}
    	//dump($config);
    	C('sConfig', $config);
    	// 将配置赋值到模板
    	$this->assign('sConfig', $config);
    }
}
?>