<?php
/**
 * 空模型控制器
 * 
 * @author su
 */
class EmptyAction extends Action{
	function _empty(){
		header("HTTP/1.0 404 Not Found");//使HTTP返回404状态码
		$this->display('Public:404');
		//$base_url = C('base_url');
		//header("Location:$base_url");
	}
	
	function index() {
		header("HTTP/1.0 404 Not Found");
		$this->display('Public:404');
	}
}
?>