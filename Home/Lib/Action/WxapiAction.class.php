<?php
/**
 * 微信小程序服务接口
 * code
 * @author zero
 */
class WxapiAction extends Action
{
    /**
     * 用户登录信息接口
     * @return code  签名码
     * @author zero
     */
    public function checklogin($code){

        $code = $code;
        $AppID = "wxd12e99bdf70656a5";
        $Secret = "";
        $url = "http://api.weixin.qq.com/sns/jscode2session?appid={$AppID}&secret={$Secret}&js_code={$code}&grant_type=authorization_code";

        $res = redirect($url);

        echo json_encode($res);exit;
    }

    /**
     * 首页banner数据接口
     * @return code  签名码
     * @author zero
     */
    public function advent(){

        $ad = M('ad')->field('id,ad_img')->cache(true)->where(array('pos_id'=>16,'is_show'=>1))->order('orders desc')->select();

        foreach($ad as $key=>$val){
            $ad[$key]['ad_img'] = 'https://www.blueedit.cn'.$val['ad_img'];
        }
//		echo '<pre>';
        echo json_encode($ad);exit;
    }

    /**
     * 产品展示数据接口（服务项目）
     * @return code  签名码
     * @author zero
     */
    public function productInfo(){


        $serverdata = M('service')->where(array('cat_id'=>81,'status'=>1))->order('orders desc')->select();
        //echo M()->getlastsql();
        foreach($serverdata as $key=>$val){

            $serverdata[$key]['thumb'] = 'https://www.blueedit.cn'.$val['thumb'];
            $serverdata[$key]['summary'] = mb_substr($val['summary'],0,50);
        }
        //echo '<pre>';

        //var_dump($serverdata);
        echo json_encode($serverdata);exit;
    }

    /**
     * 产品展示数据接口（服务详情）
     * @return code  签名码
     * @author zero
     */
    public function productDetail($id){


        $serverdata = M('service')->where(array('id'=>$id))->find();
        $serverdata['thumb'] = 'https://www.blueedit.cn'.$serverdata['thumb'];
        //echo '<pre>';
        //var_dump($serverdata);exit;
        echo json_encode($serverdata);exit;
    }

    /**
     * 企业动态数据接口（新闻数据）
     * @return code  签名码
     * @author zero
     */
    public function dynamics(){

        $data = M("news")->cache(true)->where(array('cat_id'=>3,'show_index'=>1))->field("id,title,summary,content")->order("addtime desc")->limit(10)->select();
        foreach($data as $key=>$val){
            $data[$key]['title'] = mb_substr($val['title'],0,20);
            $data[$key]['summary'] = mb_substr($val['summary'],0,70);
        }

        echo json_encode($data);exit;

    }

    /**
     * 企业动态详情数据接口（详情数据）
     * @return code  签名码
     * @author zero
     */
    public function dydatial($id){
        $data = M("news")->where(array('id'=>$id))->field("id,title,summary,content,addtime")->find();
        $data['addtime'] = date('Y-m-d',$data['addtime']);

        echo json_encode($data);exit;
    }

    /**
     * 公司简介数据接口
     * @return code  签名码
     * @author zero
     */
    public function aboutInfo(){

        $compdata = M('service')->cache(true)->where(array('id'=>1,'show_nav'=>1))->field("id,title,content,thumb")->find();
        $compdata['thumb'] = $_SERVER['REMOTE_HOST'].$compdata['thumb'];

        echo json_encode($compdata);exit;
    }

    /**
     * 联系我们数据接口
     * @return code  签名码
     * @author zero
     */
    public function contact(){

        $data = [
            "sama"		=> '扫一扫,关注我',
            "address"	=> '广州市天河区燕岭路89号燕侨大厦',
            "phone"		=> '020-89819613',
        ];

        echo json_encode($data);exit;
    }

    /**
     * SCI影响因子数据接口
     * @return code  签名码
     * @author zero
     */
    public function sci_factor(){
        //查询条件
        $search = trim($_GET['search']);
        $child_id = trim($_GET['period_name2']);
        $ifsmall = trim($_GET['ifsmall']);
        $ifbig = trim($_GET['ifbig']);
        $sort = trim($_GET['sort']);
        $where = [];
        //名称关键字
        if($search){
            $where['name'] = ['like',"%$search%"];
        }
        //期刊领域分类
        if($child_id){
            $where['cat_id'] = $child_id;
        }
        //IF范围
        if($ifsmall && $ifbig){
            $where['if'] = array(array('gt',$ifsmall),array('lt',$ifbig));
        }elseif($ifsmall && !$ifbig ){
            $where['if'] =['gt',$ifsmall];
        }elseif($ifbig && $ifsmall){
            $where['if'] =['lt',$ifbig];
        }
        //排列方式
        if($sort){
            if($sort == '0'){
                $order = "medSci DESC";
            }elseif($sort == '1'){
                $order = "medSci ASC";
            }elseif($sort == '2'){
                $order = "article_num DESC";
            }elseif($sort == '3') {
                $order = "article_num ASC";
            }
        }else{
            $order == 'medSci desc';
        };
        $sci_info = M('impact')->field('id,name,issn,first,addtime')->where($where)->order($order)->limit(15)->select();
        foreach($sci_info as $key=>$val){
            $sci_info[$key]['name'] = mb_substr($val['name'],0,15);
        }
        echo json_encode($sci_info);exit;
    }

    /**
     * SCI影响因子详情数据接口
     * @return code  签名码
     * @author zero
     */
    public function sci_factor_detail($id){
        $sci_detail = M('impact')->where(array('id'=>$id))->find();
        echo json_encode($sci_detail);exit;
    }

    /**
     * SCI影响因子一级分类数据接口
     * @author zero
     */
    public function sci_catinfo(){
        $sci_catlist = M('impact_cat')->where(array('pid'=>0))->select();
        $arr = [];
        foreach($sci_catlist as $val){
            $arr[$val['id']] = $val['name'];
        }
        echo json_encode($arr);exit;
    }

    /**
     * SCI影响因子二级分类数据接口
     * @author zero
     */
    public function sci_detailinfo(){
        $index = $_GET['index'];
        $sci_catlist = M('impact_cat')->where(array('pid'=>0))->select();
        $arr = [];
        foreach($sci_catlist as $val){
            $arr[] = $val['name'];
        }
        $res = M('impact_cat')->field('id')->where(array('pid'=>0,'name'=>$arr[$index]))->find();
        $sci_info = M('impact_cat')->where(array('pid'=>$res['id']))->select();
        echo json_encode($sci_info);exit;
    }

    /**
     * SCI影响因子查询对应分类信息id
     * @return  fid  	   第一级的序列【index】下标
     * @return  child_id   第二级的序列【index】下标
     * @author zero
     */
    public function SearchcatInfo($Fid=0,$child_id=0){
        $sci_catlist = M('impact_cat')->where(array('pid'=>0))->select();
        $arr = [];
        foreach($sci_catlist as $val){
            $arr[] = $val['name'];
        }
        //获取二级父ID
        $res = M('impact_cat')->field('id')->where(array('pid'=>0,'name'=>$arr[$Fid]))->find();

        //二级列表
        $sci_info = M('impact_cat')->where(array('pid'=>$res['id']))->select();
        $arrTow = [];
        foreach($sci_info as $val){
            $arrTow[] = $val['name'];
        }
        //获取二级列表child_id对应序号的id值
        $result = M('impact_cat')->field('id')->where(array('pid'=>$res['id'],'name'=>$arrTow[$child_id]))->find();
        return $result['id'];
    }

    /**
     * 服务项目数据接口
     * @author zero
     */
    public function ServerPrject(){
        $ServPrject = M("service")->where(array('cat_id'=>$_GET['cat_id'],'status'=>1))->select();

        if($_GET['cid']){
            $ServPrject = M("service")->where(array('cat_id'=>$_GET['cid'],'status'=>1))->select();
            $ServInfo = M('service')->where(array('id'=>$ServPrject[0]['id']))->find();
            echo json_encode($ServInfo);exit;
        }

        if($_GET['id']){
            $Serv_info = M("service")->where(array('id'=>$_GET['id']))->find();
            echo json_encode($Serv_info);exit;
        }
        echo json_encode($ServPrject);exit;
    }

    /**
     * 服务优势数据接口
     * @author zero
     */
    public function serviceAdvantage(){
        // 首页服务优势
        $serv = M('service_cat') -> where(array('pid'=>3,'show_nav'=>1)) -> order('orders desc') -> limit(6) -> select();
        foreach($serv as $key => $val){
            $serv_info[] = M('service') -> field('id,cat_id,title') -> where(array('cat_id'=>$val['cat_id'])) -> find();
            $serv_info[$key]['cat_name'] = $val['cat_name'];
            $serv_info[$key]['thumb'] = 'https://'.$_SERVER['HTTP_HOST'].$val['thumb'];
            $serv_info[$key]['description'] = $val['description'];
        }
        //服务详情
        if($_GET['id']){
            $service_detail = M('service')->where(array('id'=>$_GET['id']))->find();

            echo json_encode($service_detail);exit;
        }
        echo json_encode($serv_info);exit;
    }
    /**
     * 编辑团队数据接口
     * @author zero
     */
    public function editorialTeam(){

        //编辑团队
        $count = M('editor')->where(array('status'=>1,'show_index'=>1))->count();
        $num = $count%4;

        if($_GET['type']){
            $edit_list = M('editor')->where(array('status'=>1,'show_index'=>1))->order('orders desc')->select();
        }else{
            $edit_list = M('editor')->where(array('status'=>1,'show_index'=>1))->order('orders desc')->limit(5)->select();
        }

        //组装数组
        foreach($edit_list as $key=>$val){
            $edit_list[$key]['avatar'] = 'http://'.$_SERVER['HTTP_HOST'].$val['avatar'];
            $edit_list[$key]['summary'] = mb_substr($val['summary'],0,60);
        }
        //循环删除多余的记录
        for($i=0;$i<$num;$i++){
            array_pop($edit_list);
        }
        //编辑团队详情
        if($_GET['id']){
            $editor_info = M('editor')->where(array('id'=>$_GET['id']))->find();
            $editor_info['avatar'] = 'http://'.$_SERVER['HTTP_HOST'].$editor_info['avatar'];
            echo json_encode($editor_info);exit;
        }

        //var_dump($edit_list);
        echo json_encode($edit_list);exit;
    }

    /**
     * 关于我们数据接口
     * @author zero
     */
    public function aboutUs(){

        $about_info = M('article_cat')->field('cat_id,description,thumb')->where(array('cat_id'=>11))->find();

        $about_info['thumb'] = 'http://'.$_SERVER['HTTP_HOST'].$about_info['thumb'];
        $about_info['description'] = mb_substr($about_info['description'],0,150);
        //$about_info[$key]['summary'] = mb_substr($val['summary'],0,60);

        echo json_encode($about_info);exit;
    }

    /**
     * 公司新闻数据接口
     * @author zero
     */
    public function CompanyNews(){


        if($_GET['type']){
            $news_list = M('news')->field('id,title,addtime,thumb,description,summary')->where('status = 1 AND show_index = 1 AND (cat_id=2 or cat_id=3) AND thumb != ""')->order('addtime desc')->select();
        }else{
            $news_list = M('news')->field('id,title,addtime,thumb,description,summary')->where('status = 1 AND show_index = 1 AND (cat_id=2 or cat_id=3) AND thumb != ""')->order('addtime desc')->limit(4)->select();
        }

        foreach($news_list as $key=>$val){
            $news_list[$key]['title'] = $val['title'];
            $news_list[$key]['addtime'] = date('Y-m-d',$val['addtime']);
            $news_list[$key]['thumb'] = 'http://'.$_SERVER['HTTP_HOST'].$val['thumb'];
            $news_list[$key]['summary'] = mb_substr($val['summary'],0,40);
        }

        //公司新闻详情
        if($_GET['id']){
            $news_detail = M('news')->where(array('id'=>$_GET['id']))->find();
            $news_detail['thumb'] = 'http://'.$_SERVER['HTTP_HOST'].$news_detail['thumb'];
            echo json_encode($news_detail);exit;
        }
        //var_dump($news_list);
        echo json_encode($news_list);exit;
    }

    /**
     * 首页期刊转载数据接口
     * @author zero
     */
    public function Periodical(){
        $Period_list = M("reprint")->where(true)->order('addtime desc')->limit(5)->select();
        foreach($Period_list as $key=>$val){
            $Period_list[$key]['title'] = mb_substr($val['title'],0,30);
        }
        //var_dump($Period_list);
        echo json_encode($Period_list);exit;
    }

    /*
     * 期刊转载页数据接口
     * @author zero
     */
    public function Period_info(){

        //期刊列表
        $Period_cat = M('reprint_cat')->where(array('pid'=>0))->select();

        //期刊列表
        if($_GET['cat_id']){
            if($_GET['cat_id'] == 'all'){
                $PeriodList = M('reprint')->where(true)->order('addtime desc')->select();
                foreach($PeriodList as $key=>$val){
                    $PeriodList[$key]['title'] = mb_substr($val['title'],0,20);
                    $PeriodList[$key]['summary'] = mb_substr($val['summary'],0,60);
                }
                echo json_encode($PeriodList);exit;
            }else{
                $PeriodList = M('reprint')->where(array('cat_id'=>$_GET['cat_id']))->order('addtime desc')->select();
                foreach($PeriodList as $key=>$val){
                    $PeriodList[$key]['title'] = mb_substr($val['title'],0,20);
                    $PeriodList[$key]['summary'] = mb_substr($val['summary'],0,60);
                }
                echo json_encode($PeriodList);exit;
            }
        }

        //期刊详情
        if($_GET['id']){
            $Periods_detail = M('reprint')->where(array('id'=>$_GET['id']))->find();
            $Periods_detail['content'] = str_replace('http','http',$Periods_detail['content']);
            echo json_encode($Periods_detail);exit;
        }


        echo json_encode($Period_cat);exit;
    }

    /**
     * 客户留言数据接口
     * @author zero
     */
    public function feedback(){
        $data = M('feedback')->where('status=1')->order('id desc')->limit('4')->select();
        foreach($data as $key=>$val){
            $data[$key]['content'] = mb_substr($val['content'],0,110);
        }
        echo json_encode($data);exit;
    }

    /**
     * 留言数据接口
     * @author zero
     */
    public function Leaving_message(){

        $data = array(
            'name'	=>  trim($_GET['name']),
            'phone'	=>  trim($_GET['phone']),
            'liuyan'=>  trim($_GET['liuyan']),
        );
        if(!empty($data['name']) && !empty($data['phone'] && !empty($data['liuyan']))){
            //手机正则
            $pattern = '#^1[3|5|8|7]\d{9}$#';
            if(!preg_match($pattern,$data['phone'])){
                $res = ['status' => false,'msg' => '请填写正确的手机号码！'];
                echo json_encode($res);exit;
            }

                $result = M('message')->add($data);
            if($result){
                $res = ['status' => true,'msg' => '添加留言成功！'];
                echo json_encode($res);exit;
            }else{
                $res = ['status' => false,'msg' => '添加留言失败'];
                echo json_encode($res);exit;
            }

        }else{
            $res = ['status' => false,'msg' => '请填写完整信息'];
            echo json_encode($res);exit;
        }
    }
}
        
        
        
        
        
        
        
        