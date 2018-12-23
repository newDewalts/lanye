<?php
/**
 * 优惠券模块控制器
 * 
 * @author xiaosibo
 */
class CouponAction extends CommonAction
{
	// 优惠券列表
	public function index()
	{
		import('@.ORG.Page'); // 导入分页类
		
		$map = $search = array();
		$sn    = I('get.sn', '', 'trim');
		
		if ($sn) {
			$map['sn']     = array('like', "%$sn%");
			$search['sn']  = $sn;
			$addsql = " AND C.sn LIKE '%".addslashes($sn)."%'";
		}
		
		$Model = M('Coupon');
		$count = $Model->where($map)->count(); // 查询满足要求的总记录数 $map表示查询条件
		$Page  = new Page($count, '', $search);
		
		/*
		$couponList = $Model->where($map)
						  		->order('id DESC')
						  		->limit($Page->firstRow.','.$Page->listRows)
						  		->select();
		*/
		
		$couponList = $Model->query("SELECT C.*,U.username AS receive_username  FROM __TABLE__ AS C LEFT JOIN ".C('DB_PREFIX')."user AS U ON C.receive_uid=U.user_id WHERE 1=1 $addsql ORDER BY C.id DESC LIMIT ".$Page->firstRow.','.$Page->listRows);
		
		//var_dump($Model->getLastSql()); exit();

		// 已过期的优惠券ID
		$expiredIds = array();
		foreach ($couponList as $key => $val) {
			// 过期时间
			$expiredTime = $val['addtime'] + ($val['valid_time']*3600*24);
			// 未使用, 但时间已经过期
			if (($val['status'] == 0) && ($expiredTime <= time())) {
				$expiredIds[] = $val['id'];
				$couponList[$key]['status'] = 2;
			}
			$couponList[$key]['expired_time'] = $expiredTime;
		}
		 
		// 更新已过期的优惠券
		if (!empty($expiredIds)) {
			$where = array();
			$where['id'] = array('in', $expiredIds);
			$Model->where($where)->save(array('status' => 2));
		}
		
		$this->assign('search',   		 $search);
		$this->assign('couponList', 		 $couponList);
		$this->assign('pageShow', 		 $Page->show());
		$this->display();
	}
   
    // 添加优惠券
    public function add()
    {
    	if (IS_POST) {
    		$money 	  = intval($_POST['money']);
    		$username = trim($_POST['username']);
    		$validTime  = intval($_POST['valid_time']);
    		if (!$username) {
    			$this->error('请填写接收者名称');
    		}
    		$receive_uid = M('User')->where(array('username' => $username))->getField('user_id');
    		if (intval($receive_uid) <= 0) {
    			$this->error('接收者用户不存在');
    		}
    		if ($money <= 0) {
    			$this->error('金额必须为大于0的整数');
    		}
    		if (D('Coupon')->addCoupon($receive_uid, $money, $validTime, 2, session(C('USER_AUTH_KEY')))) {
    				$this->success('发放优惠券成功！', U('Coupon/index'));
    		} else {
    				$this->error('发放优惠券失败！');
    		}
    	} else {
    		$this->display();
    	}
    }
    
    // 优惠券详情
    public function detail()
    {
    	$id = I('get.id', 0, 'intval');
    	if ($id <= 0) {
    		$this->error('错误的请求');
    	}
    	$coupon = M('Coupon')->find($id);
    	if (empty($coupon)) {
    		$this->error('优惠券不存在');
    	}
    	
    	$userModel = M('User');
    	
    	if ($coupon['give_uid'] > 0) {
    		$coupon['give_name'] = $userModel->where(array('user_id' => $coupon['give_uid']))->getField('username');
    	} else {
    		$coupon['give_name'] = '系统发放';
    	}
    	if ($coupon['use_uid'] > 0) {
    		$coupon['use_username'] = $userModel->where(array('user_id' => $coupon['use_uid']))->getField('username');
    	}
    	$coupon['receive_username'] = $userModel->where(array('user_id' => $coupon['receive_uid']))->getField('username');
    	$coupon['expired_time'] = $coupon['addtime'] + ($coupon['valid_time']*3600*24);
    	
    	$this->assign('coupon', $coupon);
    	$this->assign('forward_url', I('server.HTTP_REFERER', U('Coupon/index')));
    	$this->display();
    }
    
    public function consume()
    {
    	$id = I('get.id', 0, 'intval');
    	if ($id <= 0) {
    		$this->error('错误的请求');
    	}
    	
    	$data = array();
    	$data['id'] 			= $id;
    	$data['status'] 		= 1;
    	$data['use_time'] 	= time();
    	$data['use_uid']   	= session(C('USER_AUTH_KEY'));
    	
    	if (M('Coupon')->save($data) !== false) {
    		$this->success('使用优惠券成功！');
    	} else {
    		$this->error('使用优惠券失败！');
    	}
    } 
    
    // 删除优惠券
    public function delete()
    {
    	$id = I('get.id', 0, 'intval');
    	if ($id <= 0) {
    		$this->error('错误的请求');
    	}
    	if (M('Coupon')->delete($id)) {
    		$this->success('删除优惠券成功！');
    	} else {
    		$this->error('删除优惠券失败！');
    	}
    }
    
}





