<?php
/**
 * 获取分类名称
 * @param int id
 * @return cat_name
 */
function getService($cat_id){
	$data = M('ServiceCat')->where("`cat_id`=".$cat_id)->find();
	return $data['cat_name'];
}

function getCate($cat_id){
	$data = M('ArticleCat')->where("`cat_id`=".$cat_id)->find();
	return $data['cat_name'];
}

function getEditorCat($cat_id){
	$data = M('EditorCat')->where("`cat_id`=".$cat_id)->find();
	return $data['cat_name'];
}
/**
 * 美化时间函数
 */
function time_($time){
	$t=time()-$time;
    $f=array(
        '31536000'=>'年',
        '2592000'=>'个月',
        '604800'=>'星期',
        '86400'=>'天',
        '3600'=>'小时',
        '60'=>'分钟',
        '1'=>'秒'
    );
    foreach ($f as $k=>$v)    {
        if (0 !=$c=floor($t/(int)$k)) {
            return $c.$v.'前';
        }
    }
}

/**
 * 删除空格
 */
function trimall($str){
    $qian=array(" ","　","\t","\n","\r");$hou=array("","","","","");
    return str_replace($qian,$hou,$str);   
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
 * 用于VAR_FILTERS过滤
 * 
 *	'VAR_FILTERS'  =>  'filter_exp,add_htmlspecialchars',   
 */
function add_htmlspecialchars(&$value)
{
	$value = htmlspecialchars($value);
}

/**
 * 加密解密函数
 * @param $string 需要加密或解密的字符串
 * @param $operation  DECODE(解密) ENCODE(加密)
 * @param $key 密匙
 * @param $expiry 密文有效期
 */
function authcode($string, $operation = 'ENCODE', $key = '', $expiry = 0) {
	$ckey_length = 4;

	$key  = md5($key != '' ? $key : C('AUTHKEY'));
	$keya = md5(substr($key, 0, 16));
	$keyb = md5(substr($key, 16, 16));
	$keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';

	$cryptkey = $keya.md5($keya.$keyc);
	$key_length = strlen($cryptkey);

	$string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
	$string_length = strlen($string);

	$result = '';
	$box = range(0, 255);

	$rndkey = array();
	for($i = 0; $i <= 255; $i++) {
		$rndkey[$i] = ord($cryptkey[$i % $key_length]);
	}

	for($j = $i = 0; $i < 256; $i++) {
		$j = ($j + $box[$i] + $rndkey[$i]) % 256;
		$tmp = $box[$i];
		$box[$i] = $box[$j];
		$box[$j] = $tmp;
	}

	for($a = $j = $i = 0; $i < $string_length; $i++) {
		$a = ($a + 1) % 256;
		$j = ($j + $box[$a]) % 256;
		$tmp = $box[$a];
		$box[$a] = $box[$j];
		$box[$j] = $tmp;
		$result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
	}

	if($operation == 'DECODE') {
		if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {
			return substr($result, 26);
		} else {
			return '';
		}
	} else {
		return $keyc.str_replace('=', '', base64_encode($result));
	}
}


/**
 * 发送邮件
 * 使用：sendMail('1502461515@qq.com', '邮件标题', '邮件正文');
 *
 * @param  string  $address  邮件地址
 * @param  string  $title 	  邮件标题
 * @param  string  $message  邮件主体
 * @return boolean
 */
function sendMail($address, $title, $message)
{
	vendor('PHPMailer.class#phpmailer');

	$mail=new PHPMailer();

	// 设置PHPMailer使用SMTP服务器发送Email
	$mail->IsSMTP();

	// 设置邮件的字符编码，若不指定，则为'UTF-8'
	$mail->CharSet='UTF-8';
	//$mail->CharSet = C('MAIL_CHARSET');

	// 添加收件人地址，可以多次使用来添加多个收件人
	$mail->AddAddress($address);

	// 设置邮件正文
	$mail->Body = $message;

	// 设置邮件头的From字段
	//$mail->From = C('SMTP_MAIL_ACCOUNT');
	$mail->From = C('sConfig.smtp_mail_account');
	
	// 设置发件人名称
	//$mail->FromName = C('SMTP_SEND_MAIL_NAME');
	$mail->FromName = C('sConfig.smtp_send_mail_name');
	
	// 设置邮件标题
	$mail->Subject = $title;

	// 设置SMTP服务器。
	//$mail->Host	= C('SMTP_HOST');
	$mail->Host	= C('sConfig.smtp_host');

	// 设置SMTP服务器端口。
	//$mail->Port = 25;
	//$mail->Port = C('SMTP_PORT');
	$mail->Port = C('sConfig.smtp_port');

	// 设置为“需要验证”
	$mail->SMTPAuth = true;
	if (C('sConfig.smtp_port') == 465){
    	$mail->SMTPSecure = 'ssl';                 // 使用安全协议
    }
	//$mail->SMTPAuth = C('MAIL_AUTH');

	// 是否使用html内容类型
	$mail->IsHTML(true);
	//$mail->IsHTML(C('MAIL_HTML'));

	// 设置用户名和密码。
	//$mail->Username = C('SMTP_MAIL_ACCOUNT');
	//$mail->Password = C('SMTP_MAIL_PASS');
	$mail->Username = C('sConfig.smtp_mail_account');
	$mail->Password = C('sConfig.smtp_mail_pass');

	// 发送邮件。
	return $mail->Send() ? true : $mail->ErrorInfo;;
}
function build_postform($p) {
	// echo 1;
	
	$sHtml = "<form id='E_FORM' name='E_FORM' action='https://Pay3.chinabank.com.cn/PayGate' method='post'>";

	while (list ($key, $val) = each ($p)) {
		$sHtml.= "<input type='hidden' name='".$key."' value='".$val."'/>";
	}
	$sHtml = $sHtml."</form>";
	$sHtml = $sHtml."<button type='submit' class='hidden' name='v_action' value='网银在线付款...' '>网银确认付款</button>";
	$sHtml = $sHtml."<script>document.forms['E_FORM'].submit();</script>";
	return $sHtml;
}

function isEmail($email) {
    if (preg_match('/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/', $email)) {
        return true;
    } else {
        return false;
    }
}
 function subtext($text, $length)
 {
        if(mb_strlen($text, 'utf8') > $length) 
        return mb_substr($text, 0, $length, 'utf8').'...';
        return $text;
 }



