<?php

$common_config = require './Data/'.SITE_MODE.'.config.php';

$config =  array(
	'URL_HTML_SUFFIX'       => 'htm',
	'URL_MODEL' => 2,
	'DATA_AUTH_KEY' => '5m9m14XH3oqLJ8bNGw9e4rGpXpcktv9MSkHSVFVMjHbfv+SJ5v0ubqQxa5YjLN4vc49z7SVju8s0X4gZ6AzZTn06jzWOgyPRV54Q4I0DCYadWW4Ze3e+BOtwgVU1Og3qHKn8vygoj40J6U85Z/PTJu3hN1m75Zr195ju7g9v4Hk=', //默认数据加密KEY
	'URL_PATHINFO_DEPR' => '/',
	'REGISTER_USER_ROLE_ID'  	=> 4,	 // 注册会员用户的角色ID
	'URL_CASE_INSENSITIVE'  => true,
	'VAR_FILTERS'           =>  'filter_exp,add_htmlspecialchars',     
	'DEFAULT_FILTER'      => '', 
	'LAYOUT_ON' 			=> true, 		
	'LAYOUT_NAME'			=> 'layout',	
	'TMPL_ACTION_ERROR'     => APP_PATH.'Tpl/Public/success.html',
	'TMPL_ACTION_SUCCESS'   => APP_PATH.'Tpl/Public/success.html',
	'DATA_CACHE_TIME' 	=> 86400,
	'TMPL_PARSE_STRING'  => array(
		'SITE_MODE' => SITE_MODE,//dev,test,prod
	),
	//路由
	'URL_ROUTER_ON' =>true,
	'URL_ROUTE_RULES'=>array(
		/* 'serviceDetail/:id' =>'service/detail', */
		'service' =>'service/index',  //服务项目
		'service/:cat_id' =>'service/index',
		/* 'editor' =>'advantage/editor', */
		//'service/:id\d' =>   'service/',  //服务优势
		'journalDetail/:id' =>'journal/detail',
		/* 'journal' =>'journal/index',  //中文期刊
		'literatureShow/:id' =>'literature/show',
		'literatureDetail/:id' =>'literature/detail',
		'literature/search' =>'literature/search',  //文献频道
		'literature' =>'literature/index',  //文献频道
		'jinshengDetail/:id' =>'jinsheng/detail',
		'jinsheng' =>'jinsheng/index',  //晋升政策
		'materialDetail/:id' =>'material/mat_detail',
		'mat_list/:cat_id' =>'material/mat_list',
		'material' =>'material/index',  //学习资源 */
		//'about' =>'about/index',  //关于我们
		//'about/:cat_id' =>'about/index',
		//'news'	  =>'news/index',			//新闻中心
		'online'  =>'online/index',			//在线留言
		/* 'newsDetail/:id' =>'about/news_detail', */
		//'servicecat/:cat_id\d' => 'Service/index',           //服务项目
		//'service_advant/:cat_id\d' => 'ServiceAdvant/index', //服务优势
		'newscat/:cat_id\d' => 'News/index',				   //新闻资讯
		/* 'News'			=> 'News/index', */
		//'News/:id\d'	=> 'News/detail',
		
		
		),
);

return array_merge($common_config, $config);
