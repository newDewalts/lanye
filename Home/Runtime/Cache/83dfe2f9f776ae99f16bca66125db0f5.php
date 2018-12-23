<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="cn">

<head>
    <meta charset="UTF-8">
    <title><?php echo ($seoInfo["title"]); ?></title>
    <meta name="keywords" content="<?php echo ($sConfig["seo_keywords"]); ?>" />
    <meta name="description" content="<?php echo ($sConfig["seo_description"]); ?>" />
    <script src='__PUBLIC__/Js/jquery.js'></script>
    <script src="__PUBLIC__/Js/jquery.bxslider.min.js"></script>
    <script src="__PUBLIC__/Js/ajaxfileupload.js"></script>
    <script src="__PUBLIC__/Js/index.js"></script>
    <link rel="stylesheet" type="text/css" href="__PUBLIC__/css/jquery.bxslider.css">
    <link rel="stylesheet" href="__PUBLIC__/layui/css/layui.css">
    <script src="__PUBLIC__/layui/layui.js"></script>
    <link rel="stylesheet" href="../Public/css/style.css">
    <link rel="stylesheet" href="__PUBLIC__/css/common.css">
    <script>
        //跳转到移动端
        var is_mobi = navigator.userAgent.toLowerCase().match(/(ipod|iphone|android|coolpad|mmp|smartphone|midp|wap|xoom|symbian|j2me|blackberry|wince)/i) != null;
        if (is_mobi ) {
            window.location.href = "http://m.lanye.me/";
        }
    </script>


</head>
<header>
    <div class="menu-top" >
        <div class="container-box" >
            <div class="layui-row">
                <div class="menu-top-txt" >
                    <div class="layui-inline" ><img src="__PUBLIC__/images/icon_phone.png"  />服务热线 :  020-89819613</div>
                    <div class="layui-inline" ><img src="__PUBLIC__/images/icon_time.png"  />工作时间：09:00 am  - 18:00 pm</div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-box" >
        <div class="menu">
            <div class="layui-row" >
                <div class="menu-left" >
                    <a href="/"  ><img src="__PUBLIC__/images/logo.png"  /></a>
                </div>
                <div class="menu-right" >
                    <div class="layui-row"  >
                        <div class="nav" >
                            <ul>
                                <li><a href="/"   <?php if($module_name == 'index'): ?>class='current'<?php endif; ?>   >首   页</a></li>
                                <li><a href="/service/cat_id/73" <?php if($module_name == 'service'): ?>class='current'<?php endif; ?> >服务项目</a></li>
                                <li><a href="/sci/index.htm" <?php if($module_name == 'sci'): ?>class='current'<?php endif; ?> >SCI影响因子</a></li>
                                <li><a href="/study/index.htm" <?php if($module_name == 'study'): ?>class='current'<?php endif; ?> >学习资源</a></li>
                                <li><a href="<?php echo U('/newscat/3');?>" <?php if($module_name == 'news'): ?>class='current'<?php endif; ?> >新闻资讯</a></li>
                                <li><a href="/about/index.htm" <?php if($module_name == 'about'): ?>class='current'<?php endif; ?>   >关于我们</a></li>
                            </ul>
                        </div>
                        <div class="tougao">
                            <a href="<?php echo U('/contribute/index');?>" ><img src="__PUBLIC__/images/tougao.png"  /></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>


	<div class="content" >
    <div class="page-banner" >
        <img src="__PUBLIC__/images/banner_news.png"  />
    </div>
    <div class="container-box" >
        <div class="page-menu" > 当前位置: <a href="/" >首页</a> ><a href="<?php echo U('/newscat/3');?>" > 新闻资讯 </a> </div>
        <div class="article-box" >
            <div class="layui-row" >
                <div class="artice-left" >
                    <div class="artice-left-title" >新闻资讯</div>
    <div class="artice-menu" >
        <div class="artice-menu-list artice-menu-select" >
            <div class="artice-menu-title" >
                <img src="__PUBLIC__/images/page_menu_active.png" class="artice-active"  />
                <img src="__PUBLIC__/images/page_icon_news.png" class="artice-icon"  /> 
                <div class='txt' >新闻资讯</div>
            </div>
            <div class="artice-menu-nav" >
                <?php if(is_array($news_cat_list)): $i = 0; $__LIST__ = $news_cat_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class='artice-nav-list' ><img src="__PUBLIC__/images/page_li_icon.png" class="artice-li-icon"  />  <a href="<?php echo U('/newscat/'.$vo['cat_id']);?>"><?php echo ($vo["cat_name"]); ?></a> </div><?php endforeach; endif; else: echo "" ;endif; ?>    
            </div>
        </div>
    </div>
<div class='hotline' >
        <div class='txt' >服务热线</div>
        <div class='number' >020-89819613</div>
</div>    
                </div>
                <div class="artice-right" >
                    <div class='artice-right-title' >
                        <img src="__PUBLIC__/images/news_icon_title.png"  class='news_icon_title'  /> 
                        <div class='layui-inline bold letter' ><?php echo ($news_cat['cat_name']); ?></div> 
                        <img src="__PUBLIC__/images/page_line.png"  class='page_title_line'  />  
                    </div>
                    <div class='artice-right-content' >
                        <?php if(is_array($news_list)): foreach($news_list as $key=>$vo): ?><div class='artice-news-list' >
                                <div class='layui-row' >
                                    <div class='artice-news-left'  >
                                            <?php if(!empty($vo["thumb"])): ?><img src="<?php echo ($vo["thumb"]); ?>"  />
                                            <?php else: ?>
                                                <img src="__PUBLIC__/images/news_imgs_8.png"  /><?php endif; ?>
                                    </div>
                                    <div class='artice-news-right'  >
                                        <div class="title hide-long" ><a href="<?php echo U('News/detail',array('id'=>$vo['id'],'type'=>'news'));?>" ><?php echo ($vo["title"]); ?></a></div>
                                        <div class="txt" ><?php echo (subtext(strip_tags($vo["content"]),85)); ?></div>
                                        <div class="button-box" >
                                            <div class="date" ><?php echo (date("Y-m-d",$vo['addtime'])); ?></div>
                                            <div class="artice-news-more" ><a  href="<?php echo U('News/detail',array('id'=>$vo['id'],'type'=>'news'));?>" >查看更多 >></a></div>
                                        </div>
                                    </div>
                                </div>    
                             </div><?php endforeach; endif; ?>
                        
                    </div>  
                    <div class='page_box' >
                        <?php echo ($pages); ?>
                     </div>
                </div>
            </div>
        </div>
    </div> 
</div>    
<div class="footer" >
    <div  ><a href="<?php echo U('/sci/index');?>" ><img src="__PUBLIC__/images/sci_img.png"  /></a></div>
    <div class="footer-box" >
        <div class="container-box" >
            <div class="layui-row" >
                <div class="footer-1" >
                    <div  ><img src="__PUBLIC__/images/logo_b.png"  /></div>
                    <div class="footer-title bold" >广州蓝译信息科技有限公司</div>
                    <div class="footer-1-txt">全国咨询电话：020-89819613</div>
                    <div class="footer-1-txt">地址：广州市天河区燕岭路89号燕侨大厦2310</div>
                </div>
                <div class="footer-2" >
                    <div class="footer-title " >友情链接</div>
                    <div>
                        <?php if(is_array($urlLink)): $i = 0; $__LIST__ = $urlLink;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="footer-2-txt"><a href="<?php echo ($vo["url"]); ?>"><?php echo ($vo["title"]); ?></a></div><?php endforeach; endif; else: echo "" ;endif; ?>
                    </div>
                </div>
                <div class="footer-3" >
                    <div class="footer-title " >关于我们</div>
                    <div>
                        <div class="footer-2-txt"><a href="<?php echo U('About/index');?>">公司简介</a></div>
                        <div class="footer-2-txt"><a href="<?php echo U('About/index',array('cat_id'=>41));?>">联系我们</a></div>
                        <div class="footer-2-txt"><a href="<?php echo U('About/identify');?>"  >员工认证</a></div>
                        <div class="footer-2-txt"><a href="javascript:void(0);" onclick="hz6d_is_exist('setIsinvited()%3Bwindow.open(#liyc#http%3A%2F%2Fwww8.53kf.com%2FwebCompany.php%3Farg%3D10151809%26style%3D1%26kflist%3Doff%26kf%3D%26zdkf_type%3D1%26lnk_overflow%3D0%26language%3Dzh-cn%26charset%3Dgbk%26referer%3D%7Bhz6d_referer%7D%26keyword%3Dhttp%253A%252F%252Fwww.lanye.wood%252Fabout%252Findex.htm%26tfrom%3D1%26tpl%3Dcrystal_blue%26uid%3D9f3cef5346c7881775447248b1b44ab1%26is_group%3D#liyc#%2C#liyc#_blank#liyc#%2C#liyc#height%3D600%2Cwidth%3D800%2Ctop%3D50%2Cleft%3D200%2Cstatus%3Dyes%2Ctoolbar%3Dno%2Cmenubar%3Dno%2Cresizable%3Dyes%2Cscrollbars%3Dno%2Clocation%3Dno%2Ctitlebar%3Dno#liyc#)');" target="_blank">在线咨询</a></div>
                        <div class="footer-2-txt"><a href="<?php echo U('About/index',array('cat_id'=>40));?>">支付方式</a></div>
                    </div>
                </div>
                <div class="footer-4" >
                    <div class="footer-title " >关注我们</div>
                    <div >
                        <div class="layui-row" >
                            <div class="layui-col-lg6" >
                                <div><img src="__PUBLIC__/images/weixin_1.jpg" class='weixin_img'/></div>
                                <div class="footer-4-txt" >微信公众号</div>
                            </div>
                            <div class="layui-col-lg6" >
                                <div><img src="__PUBLIC__/images/weixin_2.jpg" class='weixin_img'/></div>
                                <div class="footer-4-txt" >微信小程序</div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="beian" >版权所有 © 2009-2019 蓝译版权归广州蓝译信息科技服务有限公司所有盗用必究  <a href="http://www.miitbeian.gov.cn/" target="_blank"><?php echo ($sConfig["record_number"]); ?></a></div>
   <!-- <div style='display:none;' >
        <script src="https://s22.cnzz.com/z_stat.php?id=1275018430&web_id=1275018430" language="JavaScript"></script>
    </div>-->

</div>
<script>
    b_width=$('#banner').innerWidth();
    b_height=b_width/1920*540;
    if(b_height>540){
        b_height=540;
    }
    // 你可以在这里继续使用$作为别名...
    layui.use('carousel', function(){
        var carousel = layui.carousel;
        //建造实例
        carousel.render({
            elem: '#banner'
            ,width: '100%' //设置容器宽度
            ,arrow: 'none' //始终显示箭头
            //,anim: 'updown' //切换动画方式
            ,height:b_height+'px'
            ,indicator:'none'
        });
    });



</script>
<!--<script> (function () {var _53code=document.createElement("script");_53code.src = '//tb.53kf.com/code/code/10151809/1'; var s = document.getElementsByTagName("script")[0];s.parentNode.insertBefore(_53code, s);})(); </script>-->