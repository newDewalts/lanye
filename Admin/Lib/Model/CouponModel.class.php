<?php
/**
 * 优惠券模型类
 * 
 * @author xiaosibo
 */
class CouponModel extends Model
{

	/**
	 * 生成一个优惠券号码
	 * 
	 * @return string
	 */
	public function generate_sn()
	{
		$sn = 'PH'.date('YmdHis').mt_rand(1000, 9999);
		return $sn;
	}
	
	/**
	 * 添加优惠券
	 * 
	 * @param int  $receive_uid	收到者的用户ID
	 * @param int 	$money  		金额
	 * @param int	$validTime	有效期(单位: 天)
	 * @param int 	$get_type 	优惠券产生的方式(1注册得到,2管理员发放)
	 * @param int 	$give_uid		发放者ID (0表示系统)
	 */
	public function addCoupon($receive_uid, $money, $validTime,  $get_type,  $give_uid = 0)
	{
			$coupon['sn'] 					= $this->generate_sn();
			$coupon['money'] 			= $money;
			$coupon['valid_time'] 		= $validTime;  //单位：天
			$coupon['addtime'] 			= time();
			$coupon['get_type'] 			= $get_type;
			$coupon['receive_uid'] 		= $receive_uid; 
			$coupon['give_uid'] 			= $give_uid; 
			return $this->add($coupon);
	}
	
	
	
}