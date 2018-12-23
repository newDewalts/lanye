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


	
<div class="main-content" >
    <div class="layui-carousel banner" id='banner' >
        <div carousel-item >
            <?php if(is_array($ad)): foreach($ad as $key=>$v): ?><li> <img src="<?php echo ($v["ad_img"]); ?>" /></li><?php endforeach; endif; ?> 
        </div>
    </div>
        
    <div class="line-box">
        <div class="layui-row" >
            <div class="line-width color1"></div>
            <div class="line-width color2"></div>
            <div class="line-width color3"></div>
            <div class="line-width color4"></div>
            <div class="line-width color5"></div>
        </div>    
    </div>
    <div class="index-content" >
        <div class="xm"  >
            <div class="container-box" >
                <div class="index-title-img" ><img src="__PUBLIC__/images/title_01.png"  /></div>
                <div class='xm-content'>
                    <div class='layui-row' >
                        <div class='layui-col-lg3' >
                            <div class='xm-box'  >
                                <div class='xm-img' >
                                    <img src="__PUBLIC__/images/xm_img_1.png"  />
                                    <div class='xm-icon' ><img src="__PUBLIC__/images/xm_icon_1.png"  /></div>
                                    <div class='xm-hide-top' ><img src="__PUBLIC__/images/xm_mask.png"  /></div>
                                </div>
                                <div class='xm-list '  >
                                    <div class='xm-title hide-long' >SCI 翻译润色</div>
                                    <div class='xm-txt hide-long' >资深团队为学者提供优质科研服务</div>
                                    <a href="<?php echo U('/service/index',array('cat_id'=>73));?>"><div class='xm-button' >免费润色</div></a>
                                </div>    
                            </div>    
                        </div>
                        <div class='layui-col-lg3' >
                            <div class='xm-box'  >
                                <div class='xm-img' >
                                    <img src="__PUBLIC__/images/xm_img_2.png"  />
                                    <div class='xm-icon' ><img src="__PUBLIC__/images/xm_icon_2.png"  /></div>
                                    <div class='xm-hide-top' ><img src="__PUBLIC__/images/xm_mask.png"  /></div>
                                </div>
                                <div class='xm-list xm-border2'  >
                                    <div class='xm-title hide-long' >SCI 评估服务</div>
                                    <div class='xm-txt hide-long' >专业科研品牌，值得信赖。</div>
                                    <a href="<?php echo U('/service/index',array('cat_id'=>72));?>"><div class='xm-button xm-bg2' >快速评估</div></a>
                                </div>    
                            </div>    
                        </div>
                        <div class='layui-col-lg3' >
                            <div class='xm-box'  >
                                <div class='xm-img' >
                                    <img src="__PUBLIC__/images/xm_img_3.png"  />
                                    <div class='xm-icon' ><img src="__PUBLIC__/images/xm_icon_3.png"  /></div>
                                    <div class='xm-hide-top' ><img src="__PUBLIC__/images/xm_mask.png"  /></div>
                                </div>
                                <div class='xm-list xm-border3'  >
                                    <div class='xm-title hide-long' >SCI 编辑指导</div>
                                    <div class='xm-txt hide-long' >权威专家，专业指导</div>
                                    <a href="<?php echo U('/service/index',array('cat_id'=>74));?>"><div class='xm-button xm-bg3' >马上指导</div></a>
                                </div>    
                            </div>    
                        </div>
                        <div class='layui-col-lg3' >
                            <div class='xm-box'  >
                                <div class='xm-img' >
                                    <img src="__PUBLIC__/images/xm_img_4.png"  />
                                    <div class='xm-icon' ><img src="__PUBLIC__/images/xm_icon_4.png"  /></div>
                                    <div class='xm-hide-top' ><img src="__PUBLIC__/images/xm_mask.png"  /></div>
                                </div>
                                <div class='xm-list xm-border4'  >
                                    <div class='xm-title hide-long' >实验委托</div>
                                    <div class='xm-txt hide-long' >执行实验工作，返还一切原始数据</div>
                                    <a href="<?php echo U('/service/index',array('cat_id'=>67));?>"><div class='xm-button xm-bg4' >立即实验</div></a>
                                </div>    
                            </div>    
                        </div>
                    </div> 

                    <div class='layui-row mtb25'  >
                        <div class='layui-col-lg3' >
                            <div class='xm-box'  >
                                <div class='xm-img' >
                                    <img src="__PUBLIC__/images/xm_img_5.png"  />
                                    <div class='xm-icon' ><img src="__PUBLIC__/images/xm_icon_5.png"  /></div>
                                    <div class='xm-hide-top' ><img src="__PUBLIC__/images/xm_mask.png"  /></div>
                                </div>
                                <div class='xm-list xm-border5'  >
                                    <div class='xm-title hide-long' >专利与认证</div>
                                    <div class='xm-txt hide-long' >全程把关，保密保证</div>
                                    <a href="<?php echo U('/service/index',array('cat_id'=>75));?>"><div class='xm-button xm-bg5' >马上认证</div></a>
                                </div>    
                            </div>    
                        </div>
                        <div class='layui-col-lg3' >
                            <div class='xm-box'  >
                                <div class='xm-img' >
                                    <img src="__PUBLIC__/images/xm_img_6.png"  />
                                    <div class='xm-icon' ><img src="__PUBLIC__/images/xm_icon_6.png"  /></div>
                                    <div class='xm-hide-top' ><img src="__PUBLIC__/images/xm_mask.png"  /></div>
                                </div>
                                <div class='xm-list xm-border6'  >
                                    <div class='xm-title hide-long' >医学进修</div>
                                    <div class='xm-txt hide-long' >100+海外医学博士跨国指导</div>
                                    <a href="<?php echo U('/service/index',array('cat_id'=>77));?>"><div class='xm-button xm-bg6' >开始咨询</div></a>
                                </div>    
                            </div>    
                        </div>
                        <div class='layui-col-lg3' >
                            <div class='xm-box'  >
                                <div class='xm-img' >
                                    <img src="__PUBLIC__/images/xm_img_7.png"  />
                                    <div class='xm-icon' ><img src="__PUBLIC__/images/xm_icon_7.png"  /></div>
                                    <div class='xm-hide-top' ><img src="__PUBLIC__/images/xm_mask.png"  /></div>
                                </div>
                                <div class='xm-list xm-border7'  >
                                    <div class='xm-title hide-long' >医学访学</div>
                                    <div class='xm-txt hide-long' >医学类申请文书量身定制</div>
                                    <a href="<?php echo U('/service/index',array('cat_id'=>76));?>"><div class='xm-button xm-bg7' >马上定制</div></a>
                                </div>    
                            </div>    
                        </div>
                        <div class='layui-col-lg3' >
                            <div class='xm-box'  >
                                <div class='xm-img' >
                                    <img src="__PUBLIC__/images/xm_img_8.png"  />
                                    <div class='xm-icon' ><img src="__PUBLIC__/images/xm_icon_8.png"  /></div>
                                    <div class='xm-hide-top' ><img src="__PUBLIC__/images/xm_mask.png"  /></div>
                                </div>
                                <div class='xm-list xm-border8'  >
                                    <div class='xm-title hide-long' >数据统计分析</div>
                                    <div class='xm-txt hide-long' >一对一服务，确保质量</div>
                                    <a href="<?php echo U('/service/index',array('cat_id'=>70));?>"><div class='xm-button xm-bg8' >提交数据</div></a>
                                </div>    
                            </div>    
                        </div>
                    </div>
                </div>    
            </div>
        </div> 

        <div class='fw' >
            <div class="index-title-img" ><img src="__PUBLIC__/images/title_02.png"  /></div>
            <div class='layui-row' >
                <div class='layui-col-lg6' >
                    <a href="<?php echo U('/service_advant/index',array('cat_id'=>50));?>">
                        <div class='fw-list' >
                            <div class='fw-list-box' >
                                <img src='__PUBLIC__/images/ys_icon_1.png' class='ys_icon' >
                                <img src='__PUBLIC__/images/ys_bg_1.png' class='ys_bg' >
                                <div class='fw-list-content' >
                                    <div class='fw-list-title hide-long' >资深 编辑</div>
                                    <div class='fw-list-txt hide-long'>汇聚国内外各专业编辑，具备美国医学作家协会认证资格...</div>
                                </div>
                            </div>
                        </div>
                    </a>    
                </div>
                <div class='layui-col-lg6' >
                    <a href="<?php echo U('/service_advant/index',array('cat_id'=>49));?>">
                        <div class='fw-list-2' >
                            <div class='fw-list-box-2' >
                                <img src='__PUBLIC__/images/ys_icon_2.png' class='ys_icon' >
                                <img src='__PUBLIC__/images/ys_bg_2.png' class='ys_bg' >
                                <div class='fw-list-content' >
                                    <div class='fw-list-title hide-long' >质量 保证</div>
                                    <div class='fw-list-txt hide-long'>行内专家质量把控，及时沟通，按时按质完成</div>
                                </div>
                            </div>
                        </div>
                    </a>    
                </div>
            </div> 
            <div class='layui-row' >
                <div class='layui-col-lg6' >
                    <a href="<?php echo U('/service_advant/index',array('cat_id'=>48));?>">
                        <div class='fw-list' >
                            <div class='fw-list-box' >
                                <img src='__PUBLIC__/images/ys_icon_3.png' class='ys_icon' >
                                <img src='__PUBLIC__/images/ys_bg_3.png' class='ys_bg' >
                                <div class='fw-list-content' >
                                    <div class='fw-list-title hide-long' >隐私权 保护</div>
                                    <div class='fw-list-txt hide-long'>保障客户隐私，所有的员工和合作机构均已签署保密条款。</div>
                                </div>
                            </div>
                        </div>
                    </a>    
                </div>
                <div class='layui-col-lg6' >
                    <a href="<?php echo U('/service_advant/index',array('cat_id'=>47));?>">
                        <div class='fw-list-2' >
                            <div class='fw-list-box-2' >
                                <img src='__PUBLIC__/images/ys_icon_4.png' class='ys_icon' >
                                <img src='__PUBLIC__/images/ys_bg_4.png' class='ys_bg' >
                                <div class='fw-list-content' >
                                    <div class='fw-list-title hide-long' >信息 保密</div>
                                    <div class='fw-list-txt hide-long'>客户的文件均提供信息保密，保证决不让任何文稿信息外泄。</div>
                                </div>
                            </div>
                        </div>
                    </a>    
                </div>
            </div>
        </div>  
        <!--editor -->
        <div class='editor' >
            <div class='container-box'  >
                <div class="index-title-img" ><img src="__PUBLIC__/images/title_03.png"  /></div>
                <div class='editor-comtent' >
                    <div class='layui-row' >
                        <?php if(is_array($edit_list)): $i = 0; $__LIST__ = $edit_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class='layui-col-lg4' >
                                <div class='editor-list editor-bg<?php echo ($i); ?> ' >
                                    <div class='editor-img' ><img src="<?php echo ($vo["avatar"]); ?>"  /></div>
                                    <div class='editor-box' >
                                        <div class='center' ><span class='editor-title' ><?php echo ($vo["name"]); ?></span></div>
                                        <div class='editor-txt'><?php echo ($vo["summary"]); ?></div>
                                        <div class='editor-button editor-bt<?php echo ($i); ?>' ><a href="<?php echo U('/editors/detail',array('id'=>$vo['id']));?>" >查看详情</a> | 
                                           <a href="javascript:void(0);" onclick="hz6d_is_exist('setIsinvited()%3Bwindow.open(#liyc#http%3A%2F%2Fwww8.53kf.com%2FwebCompany.php%3Farg%3D10151809%26style%3D1%26kflist%3Doff%26kf%3D%26zdkf_type%3D1%26lnk_overflow%3D0%26language%3Dzh-cn%26charset%3Dgbk%26referer%3D%7Bhz6d_referer%7D%26keyword%3Dhttp%253A%252F%252Fwww.lanye.wood%252Fabout%252Findex.htm%26tfrom%3D1%26tpl%3Dcrystal_blue%26uid%3D9f3cef5346c7881775447248b1b44ab1%26is_group%3D#liyc#%2C#liyc#_blank#liyc#%2C#liyc#height%3D600%2Cwidth%3D800%2Ctop%3D50%2Cleft%3D200%2Cstatus%3Dyes%2Ctoolbar%3Dno%2Cmenubar%3Dno%2Cresizable%3Dyes%2Cscrollbars%3Dno%2Clocation%3Dno%2Ctitlebar%3Dno#liyc#)');">立刻咨询</a>
                                        </div>
                                    </div>
                                </div>
                            </div><?php endforeach; endif; else: echo "" ;endif; ?>    

                    </div>    
                </div>
            </div>
        </div>    
        <!--online -->  
        <div class='online' >
            <div class='container-box'  >
                <div class="index-title-img" ><img src="__PUBLIC__/images/title_04.png"  /></div>
                <div class="online-content" >
                    <form class="action_form" name="orderforms" id="contribute" action="<?php echo U('/index/messages');?>" enctype="multipart/form-data"  method="post">
                        <div class="layui-row mtb25" >
                            <div class='layui-col-lg1' ><div class='online-txt' >称 呼：</div></div>
                            <div class='layui-col-lg5' ><input name='name' type='text'     /></div>
                            <div class='layui-col-lg1' ><div class='online-txt' >稿件上传：</div></div>
                            <div class='layui-col-lg5' ><label class="activity_label"><span class="act-input" id="act-file-name"></span><input accept=".doc,.docx,.xls,.zip,.rar,.ppt,.wps,.xlsx" type='file' name='attach_file' id='online-upload-2' class='hide  online-upload'    > <img src="__PUBLIC__/images/upload_btn.png" class='online-upload-button'  /></label> </div>
                        </div>
                        <div class="layui-row mtb25" >
                            <div class='layui-col-lg1' ><div class='online-txt' >手机\邮箱：</div></div>
                            <div class='layui-col-lg5' ><input name='phone' type='text'     /></div>
                            <div class='layui-col-lg1' ><div class='online-txt' >备      注：</div></div>
                            <div class='layui-col-lg5' ><input name='liuyan' type='text'     /></div>
                        </div>
                        <div class="layui-row mtb25" >
                            <div class='layui-col-lg1' ><div class='online-txt' >选择优惠：</div></div>
                            <div class='layui-col-lg5' >
                                <select id="role" name="youhui" >
                                    <option value="0">选择优惠</option>
                                    <option value="2">免费评估</option>
                                    <option value="3">免费选题</option>
                                    <option value="4">免费查重</option>
                                    <option value="5">免费询问信</option>
                                    <option value="6">免费cover letter</option>
                                    <option value="7">免费设计课题</option>
                                    <option value="8">免费标书评估	</option>
                                    <option value="9">在线下单9折</option>
                                </select>
                            </div>
                            <div class='layui-col-lg1' ><div class='online-txt' ></div></div>
                            <div class='layui-col-lg5' ><img src="__PUBLIC__/images/online_icon.png"  class="online-icon" /><input type="submit" value="提交信息" class="online-button" >  <input type="reset" value="重&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp置" class="online-reset" ></div>
                        </div>
                    </form>    
                </div>    
            </div>        
        </div>
        <!--news -->
        <div class='news' >
            <div class='container-box'  >
                <div class="index-title-img2" ><img src="__PUBLIC__/images/title_05.png"  /></div>
                <div class="news-content" >
                    <div class="layui-row"  >
                        <?php if(is_array($news_list)): $i = 0; $__LIST__ = $news_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="layui-col-lg4" >
                                <div class="news-box" >
                                    <div class="news-img" >
                                        <a href="<?php echo U('/news/detail',array('id'=>$vo['id']));?>" >
                                            <?php if(empty($vo["thumb"])): ?><img src="__PUBLIC__/images/news_img_3.png"  />
                                                <?php else: ?><img src="<?php echo ($vo["thumb"]); ?>"  /><?php endif; ?>
                                        </a>
                                    </div>
                                    <div class="news-top" >
                                        <div class="news-date" >
                                            <span class="news-date-d" ><?php echo (date("d",$vo["addtime"])); ?></span>
                                            <div class="news-date-m" ><?php echo (date("n",$vo["addtime"])); ?>月</div>
                                        </div>
                                        <div class="news-title hide-long" ><a href="<?php echo U('/news/detail',array('id'=>$vo['id']));?>" ><?php echo ($vo["title"]); ?></a></div>
                                    </div>
                                    <div class="news-txt" >
                                        <?php echo (subtext(strip_tags($vo["content"]),100)); ?>
                                    </div>
                                </div>
                            </div><?php endforeach; endif; else: echo "" ;endif; ?>
                    </div>
                </div>
                <div class="news-line"><img src="__PUBLIC__/images/news_line.png"  /></div>
            </div>        
        </div>
        <!--learning-->
        <div class="learning" >
            <div class="container-box" >
                <div class="index-title-img" ><img src="__PUBLIC__/images/title_06.png"  /></div>
                <div class="learning-content" >
                    <div class="layui-row mtb20"  >
                        <div class="l_width_1 l_fl" >
                            <div class="layui-row">
                                <div class="layui-col-lg6" ><img src="__PUBLIC__/images/study_left_img_1.png"  /></div>
                                <div class="layui-col-lg6" ><img src="__PUBLIC__/images/study_left_img_2.png"  /></div>
                                <div class="layui-col-lg6" ><img src="__PUBLIC__/images/study_left_img_3.png"  /></div>
                                <div class="layui-col-lg6" ><img src="__PUBLIC__/images/study_left_img_4.png"  /></div>
                            </div>
                        </div>
                        <div class="l_width_2 l_fr" >
                            <div class="learning-title"><img src="__PUBLIC__/images/study_title_1.png"  /></div>
                            <div class="learning-box" >
                                <?php if(is_array($article_list_sci_new)): $i = 0; $__LIST__ = $article_list_sci_new;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="learning-list" >
                                        <div class="learning-list-n" >0<?php echo ($i); ?></div>
                                        <div class="learning-date" ><?php echo (date("Y-m-d",$vo["addtime"])); ?></div>
                                        <div class="learning-txt1 hide-long" ><a href="<?php echo U('/study/detail',array('id'=>$vo['id']));?>" ><?php echo ($vo["title"]); ?></a></div>
                                        <div class="learning-txt2" ><?php echo (subtext(strip_tags($vo["content"]),95)); ?></div>
                                    </div><?php endforeach; endif; else: echo "" ;endif; ?>    
                                
                            </div>    
                        </div>
                    </div>
                    <div class="layui-row mtb20"  >
                        <div class="l_width_3 l_fl" >
                            <div class="learning-title"><img src="__PUBLIC__/images/study_title_2.png"  /></div>
                            <div class="learning-box" >
                                <?php if(is_array($article_list_sci_xie)): $i = 0; $__LIST__ = $article_list_sci_xie;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="learning-list" >
                                        <div class="learning-list-n" >0<?php echo ($i); ?></div>
                                        <div class="learning-date" ><?php echo (date("Y-m-d",$vo["addtime"])); ?></div>
                                        <div class="learning-txt1 hide-long" ><a href="<?php echo U('/study/detail',array('id'=>$vo['id']));?>" ><?php echo ($vo["title"]); ?></a></div>
                                        <div class="learning-txt2" ><?php echo (subtext(strip_tags($vo["content"]),95)); ?></div>
                                    </div><?php endforeach; endif; else: echo "" ;endif; ?>   
                            </div>    
                        </div>
                        <div class="l_width_1 l_fr" >
                            <div class="layui-row">
                                <div class="layui-col-lg6" ><img src="__PUBLIC__/images/study_left_img_5.png"  /></div>
                                <div class="layui-col-lg6" ><img src="__PUBLIC__/images/study_left_img_6.png"  /></div>
                                <div class="layui-col-lg6" ><img src="__PUBLIC__/images/study_left_img_7.png"  /></div>
                                <div class="layui-col-lg6" ><img src="__PUBLIC__/images/study_left_img_8.png"  /></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--customer-->
        <div class="customer" >
            <div class="container-box" >
                <div class="index-title-img pb10" ><img src="__PUBLIC__/images/title_07.png"  /></div>
                <div class="layui-row" >
                    <div class="layui-col-lg6 center" ><img src="__PUBLIC__/images/mess_icon.png"  /></div>
                     <div class="layui-col-lg6 center" ><img src="__PUBLIC__/images/mess_icon.png"  /></div>
                </div>
                <div  >
                    <ul class="customer-bxslider">
                        <?php if(is_array($feedback_data)): $i = 0; $__LIST__ = $feedback_data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li>
                                <div class="layui-row" >
                                    <?php if(is_array($vo)): $i = 0; $__LIST__ = $vo;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo_c): $mod = ($i % 2 );++$i;?><div class="layui-col-lg6" >
                                            <div class="customer-txt" ><?php echo ($vo_c["content"]); ?>   ——<?php echo ($vo_c["fullname"]); ?></div>
                                        </div><?php endforeach; endif; else: echo "" ;endif; ?>  
                                </div>
                            </li><?php endforeach; endif; else: echo "" ;endif; ?>    
                    </ul>    
                    
                </div>    
            </div>
        </div>
        <!--link -->
        <div class="link" >
            <div class="container-box" >
                <div class="index-title-img" ><img src="__PUBLIC__/images/title_08.png"  /></div>
                <div class="link-content center" >
                    <div class="layui-row" >
                        <div class="layui-col-lg2" ><div class="mtb10" ><a href="http://muchong.com/" target="_blank" ><img src="__PUBLIC__/images/link_1.png"  /></a></div></div>
                        <div class="layui-col-lg2" ><div class="mtb10" ><a href="http://www.bio1000.com/" target="_blank" ><img src="__PUBLIC__/images/link_2.png"  /></a></div></div>
                        <div class="layui-col-lg2" ><div class="mtb10" ><a href="http://epub.cnki.net/kns/default.htm" target="_blank" ><img src="__PUBLIC__/images/link_3.png"  /></a></div></div>
                        <div class="layui-col-lg2" ><div class="mtb10" ><a href="http://www.wanfangdata.com.cn/index.html" target="_blank"><img src="__PUBLIC__/images/link_4.png"  /></a></div></div>
                        <div class="layui-col-lg2" ><div class="mtb10" ><a href="http://pubmed.cn/" target="_blank"><img src="__PUBLIC__/images/link_5.png"  /></a></div></div>
                        <div class="layui-col-lg2" ><div class="mtb10" ><a href="http://www.cma.org.cn/" target="_blank"><img src="__PUBLIC__/images/link_6.png"  /></a></div></div>
                        <div class="layui-col-lg2" ><div class="mtb10" ><a href="http://www.dxy.cn/" target="_blank"><img src="__PUBLIC__/images/link_7.png"  /></a></div></div>
                        <div class="layui-col-lg2" ><div class="mtb10" ><a href="http://cqvip.com/" target="_blank"><img src="__PUBLIC__/images/link_8.png"  /></a></div></div>
                        <div class="layui-col-lg2" ><div class="mtb10" ><a href="https://sites.agu.org/" target="_blank"><img src="__PUBLIC__/images/link_9.png"  /></a></div></div>
                        <div class="layui-col-lg2" ><div class="mtb10" ><a href="https://www.plos.org/" target="_blank"><img src="__PUBLIC__/images/link_10.png"  /></a></div></div>
                        <div class="layui-col-lg2" ><div class="mtb10" ><a href="https://www.karger.com/" target="_blank"><img src="__PUBLIC__/images/link_11.png"  /></a></div></div>
                        <div class="layui-col-lg2" ><div class="mtb10" ><a href="https://seedinglabs.org/" target="_blank"><img src="__PUBLIC__/images/link_12.png"  /></a></div></div>
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