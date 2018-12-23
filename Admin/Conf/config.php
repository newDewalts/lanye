<?php

$common_config = require './Data/'.SITE_MODE.'.config.php';

$config =  array(
		
	// 新闻模块分类
	'NEWS_INDUSTRY_CAT' => 0,	// 行业分类的顶级ID
	//'NEWS_YEAR_CAT' 	=> 3,	// 年份分类的顶级ID
		

	// 0 (普通模式); 1 (PATHINFO 模式); 2 (REWRITE  模式); 3 (兼容模式)  默认为PATHINFO 模式，提供最好的用户体验和SEO支持
	'URL_MODEL' => 1, 
		
	'LAYOUT_ON' 	=> true, 		// 开启模板布局
	'LAYOUT_NAME'	=> 'layout',	// 模板布局文件
	
	'TMPL_ACTION_ERROR'     => APP_PATH.'Tpl/Public/success.html', // 默认错误跳转对应的模板文件
	'TMPL_ACTION_SUCCESS'   => APP_PATH.'Tpl/Public/success.html', // 默认成功跳转对应的模板文件
	
	// 超级管理员ID 多个用逗号隔开 例如: 1,2,3
	'SUPER_ADMIN_ID' => '1,302',
	
	'DATA_CACHE_TIME' => 300,
		
	// 开启令牌验证
	/*
	'TOKEN_ON'			=>	true,  			// 是否开启令牌验证
	'TOKEN_NAME'		=>	'__hash__',   	// 令牌验证的表单隐藏字段名称
	'TOKEN_TYPE'		=> 	'md5',  		// 令牌哈希验证规则 默认为MD5
	'TOKEN_RESET'		=> 	true,  			// 令牌验证出错后是否重置令牌 默认为true
	*/
	
	// 权限验证
	'USER_AUTH_ON'              =>  true,			// 开启权限验证
	'USER_AUTH_TYPE'			=>  1,				// 默认认证类型 1 登录认证 2 实时认证
	'USER_AUTH_KEY'             =>  'authId',		// 用户认证SESSION标记
	'ADMIN_AUTH_KEY'			=>  'administrator',
	'USER_AUTH_MODEL'           =>  'User',			// 默认验证数据表模型
	'AUTH_PWD_ENCODER'          =>  'md5',			// 用户认证密码加密方式
	'USER_AUTH_GATEWAY'         =>  '/Public/login',// 默认认证网关
	'NOT_AUTH_MODULE'           =>  'Public',		// 默认无需认证模块
	'REQUIRE_AUTH_MODULE'       =>  '',				// 默认需要认证模块
	'NOT_AUTH_ACTION'           =>  '',				// 默认无需认证操作
	'REQUIRE_AUTH_ACTION'       =>  '',				// 默认需要认证操作
	'GUEST_AUTH_ON'             =>  false,    		// 是否开启游客授权访问
	'GUEST_AUTH_ID'             =>  0,        		// 游客的用户ID
	//'DB_LIKE_FIELDS'            =>  'title|remark',
	
	'RBAC_ROLE_TABLE'           =>  'sci_role',
	'RBAC_USER_TABLE'           =>  'sci_role_user',
	'RBAC_ACCESS_TABLE'         =>  'sci_access',
	'RBAC_NODE_TABLE'           =>  'sci_node',
	
);

return array_merge($common_config, $config);
