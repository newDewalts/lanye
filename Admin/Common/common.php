<?php

/** 删除一个非空的目录
 *
 * 实现原理： 扫描整个目录， 是文件则直接删除， 是目录则递归delete_dir()
 *
 * @param $dir 需要删除的目录
 */
function delete_dir( $dir )
{
	if (!is_dir( $dir )) return false;

	$dh  = opendir($dir);
	while (false !== ($file = readdir($dh))) {
		if ($file == '.' || $file == '..') continue;
		$file = $dir.DIRECTORY_SEPARATOR.$file;
		is_dir($file) ? delete_dir($file) : @unlink($file);
	}

	/*
	foreach(scandir( $dir ) as $file) {
		if ($file == '.' || $file == '..') continue;

		$file = $dir.DIRECTORY_SEPARATOR.$file;
		is_dir($file) ? delete_dir($file) : @unlink($file);
	}
	*/

	return @rmdir($dir);
}


/**
 * 验证手机号码格式
 * @param string $mobile
 * @return boolean
 */
function isMobile($mobile)
{
	// 拥有模型中的匹配必须全等于false
	if (preg_match('/^1[3|5|8]\d{9}$/', $mobile)) {
		return true;
	} else {
		return false;
	}
}
/**
 * 获取sci申请的下拉信息
 */
function get_sci_app($id){
	$info = M('contribute_cat')->find($id);
	return $info['cat_name'];
}
