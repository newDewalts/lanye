<?php
/**
 * 前台公用控制器
 * 
 * @author su
 */
class CommonAction extends Action 
{
	// 初始化ServiceCat
    public function _initialize(){
		// 用户没有登录(session中没有用户数据),  cookie中存在则用cookie数据登录
    	if (!session('user_id') && cookie('auth')) {
    		// 从cookie中解密得到 用户名与密码
    		list($username, $password) = explode("\t", authcode(cookie('auth'), 'DECODE'));
    		$userInfo = D('User')->login($username, $password);
    		if ($userInfo) {
    			// 登录成功,设置session信息
    			$this->setLoginedSession($userInfo);
    			// 重新设置cookie
    			cookie('auth', authcode($userInfo['username']."\t".$userInfo['password']),3600*12);
    			// 修改最后登录信息
    			$data = array();
    			$data['last_login_time'] = time();
    			$data['last_login_ip']     =get_client_ip();
    			$data['user_id']     		= $userInfo['user_id'];
    			M('User')->save($data);
    		}
    	}
		//获取url的后缀
		$html = substr(strrchr($_SERVER['PHP_SELF'], '.'), 1);
		if(C('URL_HTML_SUFFIX')!=$html && $_SERVER['PHP_SELF']!='/index.php'){
			$this->_empty();
		}
		//网站编码
		header("Content-Type:text/html; charset=utf-8");
		
		/*菜单导航*/
		$m = M('service_cat');
		
		//服务优势
		$Advantage_m = $m -> where(array('pid' => 3,'show_nav' => 1)) -> order('orders asc') -> select();
	
		$this -> assign('Advantage_m',$Advantage_m);
		/*菜单导航*/
		
		//友情链接
		$urlLink 		= M('nav') ->field('id,title,url')-> where('pos = 5 and is_show=1') -> order('orders asc') -> select();
		//dump($urlLink);
		$this -> assign('urlLink',$urlLink);
		
		//关于我们
		$about_menu = M('article_cat') -> where(array('pid' => 11,'show_nav' => 1)) -> order('cat_id asc') -> select();
		$this -> assign('about_menu',$about_menu);
		
		// 加载网站配置信息
    	$this->assignConfig();
		//加载广告
		$this->ad();
		//加载相关阅读
		$this->relation_news();
		//关于我们
		//$about_menu      = M('Service')->cache()->where('cat_id=1')->select();
		//服务指南
		$guide_menu      = M('Service_cat')->cache()->where('pid=2')->order('orders desc')->limit(8)->select();
		//服务优势
		$advantage_menu  = M('Service')->cache()->where('cat_id=12')->order('orders asc')->select();
		//学术资源
		$resources_menu  = M('Service')->cache()->where('cat_id=13')->order('orders asc')->select();
		
		//中文期刊下面的分类
		// $periodical_menu = M('Periodical_cate')->cache()->where(array('pid'=>9))->order('cat_id asc')->select();
		//医药期刊下面的分类列表
		// $medicineList    = M('Periodical_cate')->cache()->where(array('pid' => 11))->order('cat_id desc')->select();
    	//获取大类名称 cat_name
		// $cat_array = M('Periodical_cate')->cache()->where(array('pid'=>0))->order('orders desc')->select();
		// foreach($cat_array as $k => $v){
		// 	if($v['cat_id'] == '9'){
		// 		$cat_name = $v['cat_name'];
		// 	}
		// }
		//首页Banner图
		$ad = M('ad')->field('id,link,ad_img')->where(array('pos_id'=>8,'is_show'=>1))->order('id desc')->limit(3)->select();

		//最新动态新闻
		$hot_news = M('News')->field('title')->where(array('cat_id'=>1))->order('id desc')->limit(3)->select();


		//招聘及加盟
		// $join_menu       = M('Article_cat')->cache()->where(array('pid'=>14))->order('cat_id asc')->select();
		//安全保密 
		// $security_menu   = M('Article_cat')->cache()->where(array('pid'=>18))->order('cat_id asc')->select();
		//专业知识
		// $knowledge_menu  = M('Article_cat')->cache()->where(array('pid'=>21))->order('cat_id asc')->select();
		//联系我们
		// $contact_menu    = M('Article_cat')->cache()->where(array('pid'=>30))->order('cat_id asc')->select();
		// $class_menu      = M('Article_cat')->cache()->where(array('cat_id'=>30))->find();
		// $class_name      = $class_menu['cat_name'];
		
		
		$this->assign('ad',$ad);
		$this->assign('hot_news',$hot_news);
		$this->assign('home_name','SCI文章');
                $this->assign('module_name',strtolower(MODULE_NAME));
                $this->pageTheme = "%first% %upPage%  %linkPage% %downPage% %end%";
    }
	//加载相关阅读
	protected function relation_news(){
		$relation = M('News')->field('id,title,cat_id')
								->where("cat_id = 1")
								->order('id desc')
								->limit(10)
								->select();
		$this->assign('relation_news',$relation);
	}
	//加载编辑分类
	protected function editor_cat(){
		$editor_cat = M('Editor_cat')->field('cat_id,cat_name,pid')
								->cache(true)
								->where('pid=1')
								->order('cat_id desc')
								->select();
		$this->assign('editor_cat',$editor_cat);
	}
	//加载安全保密信息
	protected function safe_list(){
		$safe_list = M('Service')->field('id,title')->cache(true)->where('cat_id=2')->order('id desc')->select();
		$this->assign('safe_list',$safe_list);
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
    	//print_r($config);
    	C('sConfig', $config);
    	// 将配置赋值到模板
    	$this->assign('sConfig', $config);
    }
    protected function assignSlideInfo()
    {
    	$slideLeft = M('Ad')->cache(true)
    					->where('is_show=1 AND pos_id = 1 ')
    					->order('orders DESC, id DESC')
    					->limit(10)->select();
    	$this->assign('slideLeft', $slideLeft);
    }
	protected function ad(){
		$Image = M('Ad');
		$img = $Image->where("is_show=1")->order('orders desc')->select();
		$i = 0;
		foreach($img as $k=>$v){
			$banner[$v['pos_id']][$i] = $v;
			$i++;
		}
		//print_r($banner);
		$this->assign('banner', $banner);
	}
    
    /**
     * 赋值seo信息到模板
     *
     * @param string $title    	    seo标题
     * @param string $keywords   	seo关键字
     * @param string $description 	seo描述
     * @return void
     */
    protected function assignSeoInfo($title, $keywords = '', $description = '')
    {
        $site_config=S('site_config');
    	$seoInfo = array();
    	$seoInfo['title'] 	    = empty($title)?"蓝译-{$site_config['seo_title']}_蓝译":$title;
    	$seoInfo['keywords']    = $keywords;
    	$seoInfo['description'] = $description;
    	
    	$this->assign('seoInfo', $seoInfo);
    }
    
    // 不存在的操作处理
    protected function _empty()
    {
		$this->assignSeoInfo('404页面不存在');
    	$this->display('Public:404');
    	exit();
    }
	
	/**
     * 登录后设置用户session信息
     * @param array $userInfo
     * @return void
     */
    protected function setLoginedSession($userInfo)
    {
    	session('user_id', 		$userInfo['user_id']);
    	session('username', 	$userInfo['username']);
    	//session('userInfo', 	$userInfo);
    }
	
	/**
	 * 用户动态
	 */
	protected function member_action($user_id,$content = '',$model = '',$article_id = ''){
		$data = array();
		$data['user_id'] = $user_id;
		$data['content'] = $content;
		$data['model'] = $model;
		$data['article_id'] = $article_id;
		$data['add_time'] = time();
		M('member_log')->add($data);
	}
	
    /**
	 * 验证码
	 */
	// 验证码
    public function verify(){
        import("ORG.Util.Image");
        Image::buildImageVerify(4, 1, I('get.type', 'png'));
    }
}