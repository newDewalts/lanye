<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html class="no-js">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="../Public/images/favicon.ico">
    <title>
        <?php if(empty($site["title"])): echo ($sConfig["seo_title"]); ?>-蓝译
            <?php else: echo ($site['title']); ?>-蓝译<?php endif; ?>
    </title>
    <meta name="keywords" <?php if(empty($site["keywords"])): ?>content="<?php echo ($sConfig["seo_keywords"]); ?>"
    <?php else: ?>content="<?php echo ($site['keywords']); ?>"<?php endif; ?>>
    <meta name="description" <?php if(empty($site["description"])): ?>content="<?php echo ($sConfig["seo_description"]); ?>"
    <?php else: ?>content="<?php echo ($site['description']); ?>"<?php endif; ?>>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <script src='../Public/js/jquery.js'></script>
    <script src="../Public/js/jquery.bxslider.min.js"></script>
    <script src='../Public/js/common.js'></script>
    <link rel="stylesheet" type="text/css" href="../Public/css/jquery.bxslider.css">
    <script src='../Public/layui/layui.js'></script>
    <link rel="stylesheet" href="../Public/layui/css/layui.css">
    <link rel="stylesheet" href="../Public/css/style.css">
</head>

<body>
<header class="header">
    <div class='logo' >
        <a href="<?php echo U('/index');?>"><img src='__APP__/Home/Tpl/Public/images/logo.png' class='logo-img' /></a>
    </div>
</header>
        

	<div class='banner' >
    <ul class='banner-bxslider'>
        <?php if(is_array($bannerArr)): $i = 0; $__LIST__ = $bannerArr;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li><img src='<?php echo ($url); echo ($vo["ad_img"]); ?>' class='full-width'  ></li><?php endforeach; endif; else: echo "" ;endif; ?>    
    </ul>
</div>   
<div class='index-sci'>
    <a href="<?php echo U('/sci/index');?>" ><img src='__APP__/Home/Tpl/Public/images/sci.png' class="full-width" ></a>
</div>
<div class="xm" >
    <div class="layui-row" >
        <div class="layui-col-xs3" >
            <div><a href="<?php echo U('/service/index',array('cat_id'=>73));?>" ><img src="__APP__/Home/Tpl/Public/images/xm_1.png" class="xm-icon"  /></a></div>
            <div class="xm-txt"><a href="<?php echo U('/service/index',array('cat_id'=>73));?>" >SCI 翻译润色</a></div>
        </div>
        <div class="layui-col-xs3" >
            <div><a href="<?php echo U('/service/index',array('cat_id'=>72));?>" ><img src="__APP__/Home/Tpl/Public/images/xm_2.png" class="xm-icon"  /></a></div>
            <div class="xm-txt"><a href="<?php echo U('/service/index',array('cat_id'=>72));?>" >SCI 评估服务</a></div>
        </div>
        <div class="layui-col-xs3" >
            <div><a href="<?php echo U('/service/index',array('cat_id'=>74));?>" ><img src="__APP__/Home/Tpl/Public/images/xm_3.png" class="xm-icon"  /></a></div>
            <div class="xm-txt"><a href="<?php echo U('/service/index',array('cat_id'=>74));?>" >SCI 编译指导</a></div>
        </div>
        <div class="layui-col-xs3" >
            <div><a href="<?php echo U('/service/index',array('cat_id'=>67));?>" ><img src="__APP__/Home/Tpl/Public/images/xm_4.png" class="xm-icon"  /></a></div>
            <div class="xm-txt"><a href="<?php echo U('/service/index',array('cat_id'=>67));?>" >实验委托</a></div>
        </div>
    </div>
    
    <div class="layui-row" style="margin-top:1rem;" >
        <div class="layui-col-xs3" >
            <div><a href="<?php echo U('/service/index',array('cat_id'=>75));?>" ><img src="__APP__/Home/Tpl/Public/images/xm_5.png" class="xm-icon"  /></a></div>
            <div class="xm-txt"><a href="<?php echo U('/service/index',array('cat_id'=>75));?>" >专利与认证</a></div>
        </div>
        <div class="layui-col-xs3" >
            <div><a href="<?php echo U('/service/index',array('cat_id'=>77));?>" ><img src="__APP__/Home/Tpl/Public/images/xm_6.png" class="xm-icon"  /></a></div>
            <div class="xm-txt"><a href="<?php echo U('/service/index',array('cat_id'=>77));?>" >医学进修</a></div>
        </div>
        <div class="layui-col-xs3" >
            <div><a href="<?php echo U('/service/index',array('cat_id'=>76));?>" ><img src="__APP__/Home/Tpl/Public/images/xm_7.png" class="xm-icon"  /></a></div>
            <div class="xm-txt"><a href="<?php echo U('/service/index',array('cat_id'=>76));?>" >医学访学</a></div>
        </div>
        <div class="layui-col-xs3" >
            <div><a href="<?php echo U('/service/index',array('cat_id'=>70));?>" ><img src="__APP__/Home/Tpl/Public/images/xm_8.png" class="xm-icon"  /></a></div>
            <div class="xm-txt"><a href="<?php echo U('/service/index',array('cat_id'=>70));?>" >数据统计分析</a></div>
        </div>
    </div> 
</div>

<div class="ys" >
    <div class="index-title-1" >服务优势</div>
    <div class="index-title-2" >六大服务保障为您保驾护航</div>
    <div class="ys-box" >
        <div class="layui-row" >
            <div class="layui-col-xs4" >
                <a href="<?php echo U('/service_advant/index',array('cat_id'=>50));?>" >
                    <div class="ys-list" >
                        <div  ><img src="__APP__/Home/Tpl/Public/images/ys_1.png" class="ys-img"  /></div>
                        <div class="ys-txt" >资深编辑</div>
                    </div>
                </a>    
            </div>
            <div class="layui-col-xs4" >
                <a href="<?php echo U('/service_advant/index',array('cat_id'=>49));?>" >
                    <div class="ys-list ys-bg2" >
                        <div><img src="__APP__/Home/Tpl/Public/images/ys_2.png" class="ys-img"  /></div>
                        <div class="ys-txt" >质量保证</div>
                    </div>
                </a> 
            </div>
            <div class="layui-col-xs4" >
                <a href="<?php echo U('/service_advant/index',array('cat_id'=>45));?>" >
                    <div class="ys-list ys-bg3" >
                        <div><img src="__APP__/Home/Tpl/Public/images/ys_3.png" class="ys-img"  /></div>
                        <div class="ys-txt" >准时交稿</div>
                    </div>
                </a>
            </div>
        </div>
        <div class="layui-row" >
            <div class="layui-col-xs4" >
                <a href="<?php echo U('/service_advant/index',array('cat_id'=>48));?>" >
                    <div class="ys-list ys-bg4" >
                        <div  ><img src="__APP__/Home/Tpl/Public/images/ys_3.png" class="ys-img"  /></div>
                        <div class="ys-txt" >隐私权保护</div>
                    </div>
                </a>    
            </div>
            <div class="layui-col-xs4" >
                <a href="<?php echo U('/service_advant/index',array('cat_id'=>46));?>" >
                    <div class="ys-list ys-bg5" >
                        <div><img src="__APP__/Home/Tpl/Public/images/ys_4.png" class="ys-img"  /></div>
                        <div class="ys-txt" >资料安全</div>
                    </div>
                </a> 
            </div>
            <div class="layui-col-xs4" >
                <a href="<?php echo U('/service_advant/index',array('cat_id'=>47));?>" >
                    <div class="ys-list ys-bg6" >
                        <div><img src="__APP__/Home/Tpl/Public/images/ys_5.png" class="ys-img"  /></div>
                        <div class="ys-txt" >信息保密</div>
                    </div> 
                </a>
            </div>
        </div>
    </div>    
</div>

<div class="editor center" >
    <div class="index-title-1" >编辑团队</div>
    <div class="index-title-2" >资深团队值得您的信赖</div>
    <div class="editor-box" >
        <div class="layui-row" >
            <?php if(is_array($editorArr)): $i = 0; $__LIST__ = $editorArr;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="layui-col-xs6" >
                    <div class="editor-list" >
                        <div class="editor-img-box" >
                            <a href="<?php echo U('/editors/detail',array('id'=>$vo['id']));?>" ><img src="<?php echo ($url); echo ($vo["avatar"]); ?>" class="editor-img"  /></a>
                            <div class="editor-name" ><?php echo ($vo["name"]); ?></div>
                        </div>
                        <div class="editor-txt" >
                            <?php echo ($vo["summary"]); ?>
                        </div>    
                        <a href="<?php echo U('/editors/detail',array('id'=>$vo['id']));?>" ><div class="editor-button" >查看详情</div></a>
                    </div> 
                </div><?php endforeach; endif; else: echo "" ;endif; ?>    

        </div>
        <a href="<?php echo U('/editors/lists');?>" ><div class="more-button" >查看更多</div></a>
    </div>    
</div> 

<div class="index-news center" >
    <div class="index-title-1" >新闻资讯</div>
    <div class="index-title-2" >每天最新资讯为你推送</div>
    <div class="news-box" >
        <?php if(is_array($newArr)): $i = 0; $__LIST__ = $newArr;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class='news-list' >
                <div class='layui-row' >
                    <div class='news-left' >
                        <div class='news-title' > <a href="<?php echo U('/news/detail',array('id'=>$vo['id']));?>" ><?php echo ($vo["title"]); ?></a></div>
                        <div class='news-date' ><?php echo (date('Y-m-d',$vo["addtime"])); ?></div>
                    </div>
                    <div class='news-right' >
                        <a href="<?php echo U('/news/detail',array('id'=>$vo['id']));?>" ><img src="<?php echo ($url); ?>/<?php echo ($vo["thumb"]); ?>" class="full-width"  /></a>
                    </div>
                </div>    
            </div><?php endforeach; endif; else: echo "" ;endif; ?>    
        
    </div>
    <a href="<?php echo U('/news/lists');?>" ><div class="more-button" >查看更多</div></a>
</div>

<div class='study center' >
    <div class="index-title-1" >学习资源</div>
    <div class="index-title-2" >每天最新资讯为你推送</div>
    <div class='study-title'>
        <div class='layui-row'>
            <div class='study-title1' >
                <img src="__APP__/Home/Tpl/Public/images/stydy_line_1.png"   />
            </div>
            <div class='study-title2' >
               <a href="<?php echo U('/study/cat',array('cat_id'=>47));?>"> SCI编译指导</a>
            </div>   
             <div class='study-title3' >
                 <img src="__APP__/Home/Tpl/Public/images/stydy_line_2.png"   />
            </div>   
         </div>        
    </div>
    <div class='study-sci' >
        <div class='layui-row' >
            <div class='layui-col-xs6' >
                <div class='study-sci-list'>
                    <div class='study-sci-list-img' ><img src="__APP__/Home/Tpl/Public/images/study_icon_1.png"   /></div>
                    <div class='study-sci-list-txt'>基础知识</div>
                </div>
            </div>
            <div class='layui-col-xs6' >
                <div class='study-sci-list'>
                    <div class='study-sci-list-img' ><img src="__APP__/Home/Tpl/Public/images/study_icon_2.png"   /></div>
                    <div class='study-sci-list-txt'>发表知识</div>
                </div>
            </div>
            <div class='layui-col-xs6' >
                <div class='study-sci-list'>
                    <div class='study-sci-list-img' ><img src="__APP__/Home/Tpl/Public/images/study_icon_3.png"   /></div>
                    <div class='study-sci-list-txt'>实验委托</div>
                </div>
            </div>
            <div class='layui-col-xs6' >
                <div class='study-sci-list'>
                    <div class='study-sci-list-img' ><img src="__APP__/Home/Tpl/Public/images/study_icon_4.png"   /></div>
                    <div class='study-sci-list-txt'>课题设计</div>
                </div>
            </div>
        </div>
    </div>
    
    <div class='study-title'>
        <div class='layui-row'>
            <div class='study-title1' >
                <img src="__APP__/Home/Tpl/Public/images/stydy_line_1.png"   />
            </div>
            <div class='study-title2' >
                <a href="<?php echo U('/study/cat',array('cat_id'=>84));?>">写作指导</a>
            </div>   
             <div class='study-title3' >
                 <img src="__APP__/Home/Tpl/Public/images/stydy_line_2.png"   />
            </div>   
         </div>        
    </div>
     <div class='study-sci' >
        <div class='layui-row' >
            <div class='layui-col-xs6' >
                <div class='study-sci-list2'>
                    <div class='study-sci-list-img2' ><img src="__APP__/Home/Tpl/Public/images/xiezuo_icon_1.png"   /></div>
                    <div class='study-sci-list-txt2'>文 法</div>
                </div>
            </div>
            <div class='layui-col-xs6' >
                <div class='study-sci-list2'>
                    <div class='study-sci-list-img2' ><img src="__APP__/Home/Tpl/Public/images/xiezuo_icon_2.png"   /></div>
                    <div class='study-sci-list-txt2'>排 版</div>
                </div>
            </div>
            <div class='layui-col-xs6' >
                <div class='study-sci-list2'>
                    <div class='study-sci-list-img2' ><img src="__APP__/Home/Tpl/Public/images/xiezuo_icon_3.png"   /></div>
                    <div class='study-sci-list-txt2'>架 构</div>
                </div>
            </div>
            <div class='layui-col-xs6' >
                <div class='study-sci-list2'>
                    <div class='study-sci-list-img2' ><img src="__APP__/Home/Tpl/Public/images/xiezuo_icon_4.png"   /></div>
                    <div class='study-sci-list-txt2'>技 巧</div>
                </div>
            </div>

        </div>
    </div>
</div> 

<div class='customer center '>
    <div class="index-title-1" >客户留言</div>
    <div class="index-title-2" >您的反馈,以便我们更好地为您服务</div>
    <div class='customer-box' >
        <?php if(is_array($feedback)): $i = 0; $__LIST__ = $feedback;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; if(($mod) == "1"): ?><div class='customer-list-1' >
                    <div class='customer-img-1' ><img src="__APP__/Home/Tpl/Public/images/liuyan.png" class='full-width'  /></div>
                    <div class='customer-txt-1' ><?php echo (subtext(strip_tags($vo["content"]),120)); ?>                 ——<?php echo ($vo["fullname"]); ?></div>
                </div>
            <?php else: ?>
                <div class='customer-list' >
                <div class='customer-img' ><img src="__APP__/Home/Tpl/Public/images/liuyan.png" class='full-width'  /></div>
                <div class='customer-txt' ><?php echo (subtext(strip_tags($vo["content"]),120)); ?>                       ——<?php echo ($vo["fullname"]); ?></div>
            </div><?php endif; endforeach; endif; else: echo "" ;endif; ?>    
    </div>    
</div> 

<div class="brand center " >
    <div class="index-title-1" >合作伙伴</div>
    <div class="index-title-2" >100+合作品牌</div>
    <div class="brand-box" >
        <div class="layui-row" >
            <div class="layui-col-xs3" >
                <a href="http://muchong.com/"   ><img src="__APP__/Home/Tpl/Public/images/link-img-1.png"  class="link-img" /></a>
            </div>
            <div class="layui-col-xs3" >
                <a href="http://www.bio1000.com/"   ><img src="__APP__/Home/Tpl/Public/images/link-img-2.png"  class="link-img" /></a>
            </div>
            <div class="layui-col-xs3" >
                <a href="http://epub.cnki.net/kns/default.htm"   ><img src="__APP__/Home/Tpl/Public/images/link-img-3.png"  class="link-img" /></a>
            </div>
            <div class="layui-col-xs3" >
                <a href="http://www.wanfangdata.com.cn/index.html"   ><img src="__APP__/Home/Tpl/Public/images/link-img-4.png"  class="link-img" /></a>
            </div>
            <div class="layui-col-xs3" >
                <a href="http://cqvip.com/"   ><img src="__APP__/Home/Tpl/Public/images/link-img-5.png"  class="link-img" /></a>
            </div>
            <div class="layui-col-xs3" >
                <a href="https://sites.agu.org/"   ><img src="__APP__/Home/Tpl/Public/images/link-img-6.png"  class="link-img" /></a>
            </div>
            <div class="layui-col-xs3" >
                <a href="https://www.plos.org/"   ><img src="__APP__/Home/Tpl/Public/images/link-img-7.png"  class="link-img" /></a>
            </div>
            <div class="layui-col-xs3" >
                <a href="https://www.karger.com/"   ><img src="__APP__/Home/Tpl/Public/images/link-img-8.png"  class="link-img" /></a>
            </div> 
            <div class="layui-col-xs3" >
                <a href="https://www.aaas.org/"   ><img src="__APP__/Home/Tpl/Public/images/link-img-9.png"  class="link-img" /></a>
            </div>
            <div class="layui-col-xs3" >
                <a href="https://www.authoraid.info/en/"   ><img src="__APP__/Home/Tpl/Public/images/link-img-10.png"  class="link-img" /></a>
            </div>
            <div class="layui-col-xs3" >
                <a href="https://www.baidu.com"   ><img src="__APP__/Home/Tpl/Public/images/link-img-11.png"  class="link-img" /></a>
            </div>
            <div class="layui-col-xs3" >
                <a href="https://www.so.com/"   ><img src="__APP__/Home/Tpl/Public/images/link-img-12.png"  class="link-img" /></a>
            </div> 
        </div>    
    </div>    
</div>

<div class="online center" >
    <div class="index-title-1" >免费在线咨询 1分钟量身定制</div>
    <div class="index-title-2" >资深团队提供专业的修改意见，蓝译值得你信赖</div>
    <div class="online-box" >
        <form  action="<?php echo U('index/phone_feedback');?>" method="post"  onsubmit="return feedback_check(this); " >
            <div class="online-list" >
                <img src="__APP__/Home/Tpl/Public/images/zixun_1.png" />
                <input name="name" class="online-input" value='' placeholder='请输入您的称呼' required=""   />
            </div>
            <div class="online-list" >
                <img src="__APP__/Home/Tpl/Public/images/zixun_2.png" />
                <input name="phone"  class="online-input" value=''  id="feedback_phone" placeholder='请输入您的手机号，方便顾问联系您'  required=""   />
            </div>
            <div class="online-list online-area"  >
                <img src="__APP__/Home/Tpl/Public/images/zixun_3.png" />
                <textarea name="content" class="online-textarea"  placeholder='备注'  required=""  /></textarea>
            </div>
            <div><input type='submit' name='online-submit' value='免费咨询' class='online-button'  /></div>
        </form>
    </div>    
</div>
<script>
    $(".online-button").click(function () {
        console(123);
    })
</script>


<footer class="footer" >
    <div class="footer-box" >
        <div class="footer-link" >
            <a href="<?php echo U('/index');?>" >首页</a> |
            <a href="<?php echo U('/about/index',array('cat_id'=>36));?>" >公司简介</a> |
            <a href="<?php echo U('/about/index',array('cat_id'=>40));?>" >支付方式</a> |
            <a href="<?php echo U('/about/index',array('cat_id'=>41));?>" >联系我们</a> |
            <a href="<?php echo U('About/identify');?>" >员工认证</a> 
        </div>
        <div class="layui-row" >
            <div class="layui-col-xs8" >
                <div ><img src="__APP__/Home/Tpl/Public/images/logo_footer.png"  class="footer-img"   /></div>
                <div class="footer-txt" >全国咨询电话：<a href="tel:02089819613">020-89819613</a></div>
                <div class="footer-txt" >地址：广州市天河区燕岭路89号燕侨大厦2310</div>
            </div>
            <div class="layui-col-xs4" >
                <div class="weixin-box" >
                    <img src="__APP__/Home/Tpl/Public/images/weixin.png"  class="footer-weixin"   />
                    <div class="footer-txt center" >微信公众号</div>
                </div>
            </div>    
        </div>
    </div>
</footer>    

<!-- 底部浮动 -->

<div class="foot_fixed">
	<a href="/">
		<div class="foot_fixed_div">
			<img src="../Public/images/index.png" alt="">
			<p >首页</p>
		</div>
	</a>
	
	<a href="tel:020-89819613">
		<div class="foot_fixed_div">
			<img src="../Public/images/footf_tel.png" alt="">
			<p >电话咨询</p>
		</div>
	</a>

	<a href="javascript:" onclick='kf1()'>
		<div class="foot_fixed_div">
			<img src="../Public/images/footf_zx.png" alt="">
			<p >在线留言</p>
		</div>
	</a>
	<a href="javascript:" onclick='kf1()'>
		<div class="foot_fixed_div">
			<img src="../Public/images/footf_zx2.png" alt="">
			<p >在线咨询</p>
		</div>
	</a>
</div>

<div style='display:none;' ><script src="https://s22.cnzz.com/z_stat.php?id=1275018430&web_id=1275018430" language="JavaScript"></script></div>
</body>
</html>

<script> (function () {var _53code=document.createElement("script");_53code.src = '//tb.53kf.com/code/code/10151809/1'; var s = document.getElementsByTagName("script")[0];s.parentNode.insertBefore(_53code, s);})(); </script>