(function (doc, win) {  
  var docEl = doc.documentElement,  
    resizeEvt = 'orientationchange' in window ? 'orientationchange' : 'resize',  
    recalc = function () {  
      var clientWidth = docEl.clientWidth;  
      if (!clientWidth) return;  
      docEl.style.fontSize = 20 * (clientWidth / 720) + 'px';  
    };  
   
  if (!doc.addEventListener) return;  
  win.addEventListener(resizeEvt, recalc, false);  
  doc.addEventListener('DOMContentLoaded', recalc, false);  
})(document, window);  




//一開始執行
$(document).ready(function(){
    gei_height();
    $('.banner-bxslider').bxSlider({
        controls:false,
        auto:true,
        pager:false
    })
}) 

//當瀏覽器發生改變的時候執行(用於ipad切換)
$(window).resize(function () {  
    gei_height();
})	
function gei_height(){
        all_height=$(window).height(); //浏览器当前窗口可视区域高度 
        header_height=$(".header").outerHeight();
        footer_height=$(".footer").outerHeight();
        content_height = all_height-header_height-footer_height;
        //alert(1);
        //alert(content_height);
        if(content_height>0){
                jQuery(".site-content").css({ "min-height": content_height });
        }
}

function feedback_check(){
    phone=$('#feedback_phone').val();
    if(!(/^1[34578]\d{9}$/.test(phone))){
         alert('请输入正确手机号码');
         return false;
    }
    return true;
}

 
   
function kf1(){
    // window.open("https://www41.53kf.com/webCompany.php?arg=10121262&style=1&language=zh-cn&charset=gbk&kflist=on&kf=kefu01@sina.com&zdkf_type=1&referer=http%3A%2F%2Fwww.sciedit.cn%2F&keyword=https%3A%2F%2Fwww.baidu.com%2Flink%3Furl%3Dl89GkG4MNxTrxWFmVUUeifV22EEhMGuQsJ_1djLO1Bi%26wd%3D%26eqid%3Df0a4815200019f1b000000065a604dd2&tfrom=1&tpl=crystal_blue&uid=d10b87640a52532a27eee7ee198c4061&timeStamp=1516262963382&ucust_id=","_blank","toolbar=yes, location=yes, directories=no, status=no, menubar=yes, scrollbars=yes, resizable=no, copyhistory=yes, width=800, height=600,top=200,left=200")
    window.open("http://www8.53kf.com/webCompany.php?arg=10151809&style=1&kflist=off&kf=&zdkf_type=1&lnk_overflow=0&callback_id6ds=&language=zh-cn&charset=gbk&referer=http%3A%2F%2Fwww.lanye.wood%2F&keyword=http%3A%2F%2Fwww.lanye.wood%2F&tfrom=1&tpl=crystal_blue&uid=515b351ddee9b95fa026f06e8f05f68e&is_group=&timeStamp=1540800255155&ucust_id=")
    return false;
}