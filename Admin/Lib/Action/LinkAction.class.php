<?php
/**
 * 友情链接管理控制器
 * 
 * @author xiaosibo
 */
class LinkAction extends CommonAction 
{
	// 友情链接列表
	public function index()
	{
		import('@.ORG.Page'); // 导入分页类
		
		$map    = $search = array();
		$name   = I('get.name', '', 'trim');
		$pos_id = I('get.pos_id', 0, 'intval');
		
		if ($name) {
			$map['name']     = array('like', "%$name%");
			$search['name']  = $name;
		}
		
		$Model = M('Link');
		
		// 查询满足要求的总记录数 $map表示查询条件
		$count  = $Model->where($map)->count(); 
		$Page   = new Page($count, 10, $search);
		$link_list = $Model->where($map)->order('id DESC')->limit($Page->firstRow.','.$Page->listRows)->select();
		
		
		$this->assign('search',   	$search);
		$this->assign('link_list', 	$link_list);
		$this->assign('pageShow', 	$Page->show());
		$this->display();
	}
	
	// 添加友情链接
	public function add()
	{
		if (IS_POST) {
			$Model = D('Link');
	
			if ($Model->create()) {	// 创建数据
			//if ($data = $Model->create()) {	// 创建数据
				
				/*
				//如果有文件上传 上传附件
				if ($_FILES['ad_img']['error'] == UPLOAD_ERR_OK) {
					$upFile = $this->_uploadPic('Ad');
					if (!empty($upFile)) {
						$data['ad_img'] = $upFile['savepath'].$upFile['savename'];
					}
				}
				
				$img_url = trim(I('post.img_url'));
				
				// 没有上传图片，但有图片链接地址
			
				if (!$data['ad_img'] && $img_url) {
					$data['ad_img'] = $img_url;
				}
				*/
				
				//if ($Model->add($data)) { // 插入数据
				
				if ($Model->add()) { // 插入数据
					$this->success('添加友情链接成功！', U('Link/index'));
				} else {
					$this->error('添加友情链接失败！');
				}
			} else {
				$this->error($Model->getError());
			}
		} else {
			$this->display('edit');
		}
	}
	
	// 编辑友情链接
	public function edit()
	{
		$id = I('id', 0, 'intval');
		if ($id <= 0) {
			$this->error('错误的请求');
		}
		
		if (IS_POST) {
			$Model = D('Link');
			// 创建数据
			
			if ($Model->create()) {
				//if ($data = $Model->create()) {
				/*
				//如果有文件上传 上传附件
				if ($_FILES['ad_img']['error'] == UPLOAD_ERR_OK) {
					$upFile = $this->_uploadPic('Ad');
					if (!empty($upFile)) {
						$data['ad_img'] = $upFile['savepath'].$upFile['savename'];
					}
				}
				
				$img_url 	  = trim(I('post.img_url'));
				$original_pic = I('post.original_pic'); // 原图片
				$delete_original_pic = false;
			
				// 有图片上传或有图片链接地址
				if ($data['ad_img'] || $img_url) {
					// 优先选择上传图片
					if (!$data['ad_img']) {
						$data['ad_img'] = $img_url;
					}
					// 判断原图片是上传的图片，还是地址链接, 如果为上传的图片，则需要删除原图片
					if (substr($original_pic, 0, 7) != 'http://') {
						// 删除原图片
						$delete_original_pic = true;
					}
				} else {
					// 没有图片上传, 也没有图片地址链接, 则还是为原始图片
					$data['ad_img'] = $original_pic;
				}
				*/
				//if ($Model->save($data) !== false) {
				
				// 保存数据
				if ($Model->save() !== false) {
					/*
					// 删除原图片
					if ($delete_original_pic) {
						@unlink($original_pic);
					}
					*/
					$this->success('修改友情链接成功！', I('post.forward_url', U('Link/index')));
				} else {
					$this->error('修改友情链接失败！');
				}
			} else {
				$this->error($Model->getError());
			}
		} else {
			// 友情链接信息
			$link_info = M('Link')->find($id);
			if (empty($link_info)) {
				$this->error('友情链接不存在');
			}
			
			$this->assign('link_info', 	 	 $link_info);
			$this->assign('forward_url', I('server.HTTP_REFERER', U('Link/index')));
			$this->display('edit');
		}
	}

	// 删除友情链接
	public function delete()
	{
		$id = I('get.id', 0, 'intval');
		if ($id <= 0) {
			$this->error('错误的请求');
		}
		
		$Model = M('Link');
		$ad    = $Model->field('id')->where(array('id' => $id))->find();
		
		if (empty($ad)) {
			$this->error('友情链接不存在！');
		}
		
		if ($Model->delete($id)) {
			$this->success('删除广告成功！');
		} else {
			$this->error('删除广告失败！');
		}
	}
	

}
