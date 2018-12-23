<?php
/**
 * 后台公共控制器
 * 
 * @author xiaosibo
 */
class CommonAction extends Action
{
	// 初始化
    public function _initialize() 
    {
    	//session_destroy();
    	//print_r($_SESSION); exit();
    	
    
    	// 加载网站配置信息
    	$this->assignConfig();
    	//用户权限检查
    	$this->checkAccess();
    }
    
    // 加载网站配置信息
    protected function assignConfig()
    {
		$tmpArr = M('Sysconfig')->select();
		$config  = array();
    	foreach ($tmpArr as $val) {
    		$config[$val['name']] = $val['value'];
    	 }
    	C('SITE_CONFIG', $config);
    }
    
    // 用户权限检查
    protected function checkAccess()
    {
    	if (C('USER_AUTH_ON') && !in_array(MODULE_NAME, explode(',', C('NOT_AUTH_MODULE')))) {
    		// 导入权限控制类
    		import('ORG.Util.RBAC');
    		
    		if (!RBAC::AccessDecision()) {
    			//检查认证识别号
    			if (!session(C('USER_AUTH_KEY'))) {
    				//跳转到认证网关
    				redirect(PHP_FILE . C('USER_AUTH_GATEWAY'));
    			}
    			// 没有权限 抛出错误
    			if (C('RBAC_ERROR_PAGE')) {
    				// 定义权限错误页面
    				redirect(C('RBAC_ERROR_PAGE'));
    			} else {
    				if (C('GUEST_AUTH_ON')) {
    					$this->assign('jumpUrl', PHP_FILE . C('USER_AUTH_GATEWAY'));
    				}
    				// 提示错误信息
    				$this->error('您没有权限访问此页面');
    			}
    		}
    	}
    }
    
    /**
     * 上传图片
     * 
     * @param string  $subDir 保存的文件目录
     * @param boolean $isMultiple (默认返回一维数组，设为true二维数组 )
     * @return array 上传成功的文件信息
     */
    /*
    protected function _uploadPic($subDir, $isMultiple = false)
    {
    	import("ORG.Net.UploadFile");
    	$upload = new UploadFile();
    
    	//设置上传文件大小
    	$upload->maxSize = 2097152;  // 2M (1024*1024*2)
    	//设置上传文件类型
    	$upload->allowExts = explode(',', 'jpg,gif,png,jpeg');
    
    	$saveDir = 'Uploads/'.trim($subDir, '/').'/';
    	
    	if (!is_dir($saveDir)) {
    		mkdir($saveDir, 0777, true);
    	}
    	
    	//设置附件上传目录
    	$upload->savePath = $saveDir;
    	// 启用子目录保存
    	$upload->autoSub = true;
    	// 子目录创建方式
    	$upload->subType    = 'date';
    	$upload->dateFormat = 'Ym';
    	
    	//设置需要生成缩略图，仅对图像文件有效
    	//$upload->thumb = true;
    	// 设置引用图片类库包路径
    	//$upload->imageClassPath = '@.ORG.Image';
    	//设置需要生成缩略图的文件后缀
    	//$upload->thumbPrefix = 'm_,s_';  //生产2张缩略图
    	//设置缩略图最大宽度
    	//$upload->thumbMaxWidth = '400,100';
    	//设置缩略图最大高度
    	//$upload->thumbMaxHeight = '400,100';
    
    	//设置上传文件规则
    	$upload->saveRule = uniqid;
    
    	//删除原图
    	//$upload->thumbRemoveOrigin = true;
    
    	if (!$upload->upload()) {
    		//捕获上传异常
    		$this->error($upload->getErrorMsg());
    	} else {
    		//取得成功上传的文件信息
    		$uploadList = $upload->getUploadFileInfo();
    			
    		
    		//import("ORG.Util.Image");
    		//给m_缩略图添加水印, Image::water('原文件名','水印图片地址')
    		//Image::water($uploadList[0]['savepath'].'m_'.$uploadList[0]['savename'], '/tp/Examples/File/Tpl/default/Public/Images/logo2.png');
    		//$_POST['image'] = $uploadList[0]['savename'];
    		
    		
    		if ($isMultiple) {
    			return $uploadList;
    		} else {
    			return $uploadList[0];
    		}
    	}
    	
    }
    */
    
}