<?php
$common_config = require '../Data/' . SITE_MODE . '.config.php';
$config = array(
	//'配置项'=>'配置值'
	'TMPL_PARSE_STRING' => array(
        '__IMG__' => __ROOT__ . '/Home/Tpl/Public/images',
        '__JS__' => __ROOT__ . '/Home/Tpl/Public/js',
        '__CSS__' => __ROOT__ . '/Home/Tpl/Public/css',
    ),
    'TMPL_ACTION_SUCCESS'   => 'Public:success', // 默认成功跳转对应的模板文件
    'URL_HTML_SUFFIX'      => 'html',
	'URL_MODEL'            => 2,
	'URL_PATHINFO_DEPR'    => '/',
	'URL_CASE_INSENSITIVE' => true,

    'LAYOUT_ON' 			=> true, 		         // 开启模板布局
	'LAYOUT_NAME'			=> 'layout',	         // 模板布局文件

	'DATA_CACHE_TIME'   => 86400,
	'TMPL_PARSE_STRING' => array(
		'SITE_MODE'     => SITE_MODE, //dev,test,prod
	),

    'URL_ROUTER_ON'   => true,
	'URL_ROUTE_RULES' => array(
		'serlists/:cat_id\d' => array('service/lists'),
		'serdetail/:id\d'    => array('service/detail'),
		'categorylists'      => array('service/categorylists'),
	
		'nwlists/:cat_id\d'   => array('news/lists'),
		'nwdetail/:id\d'     => array('news/detail'),
	
		'editors/:cat_id\d' => array('editors/lists'),
		'edetail/:id\d'     => array('editors/detail'),

		'arlists/:cat_id\d'   => array('article/lists'),
		'ardetail/:id\d'      => array('article/detail'),
	
		'verify'              => array('common/verify'),
	
		'webmobile'           => array('index/webMobile')
	),
	
);
return array_merge($common_config, $config);

?>