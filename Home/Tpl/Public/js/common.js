layui.use(['carousel', 'layer', 'form'], function() {
    var carousel = layui.carousel;
    var layer = layui.layer;
    var form = layui.form;
    //建造实例
    carousel.render({
        elem: '#banner',
        width: '100%', //设置容器宽度
        arrow: 'hover', //始终显示箭头
        height:'30rem'
    });

});

 window.onload = function() {
   var bannerH = $('#banner img')[0].height;
    bannerH = bannerH - 5;
   $('.layui-carousel').css('height', bannerH + 'px');

 }
　
$('#act-file').change(function() {
    var name = $(this).val();
    filename = name.slice(12);

    $('.input').text(filename);
})



function kf1(){
    // window.open("https://www41.53kf.com/webCompany.php?arg=10121262&style=1&language=zh-cn&charset=gbk&kflist=on&kf=kefu01@sina.com&zdkf_type=1&referer=http%3A%2F%2Fwww.sciedit.cn%2F&keyword=https%3A%2F%2Fwww.baidu.com%2Flink%3Furl%3Dl89GkG4MNxTrxWFmVUUeifV22EEhMGuQsJ_1djLO1Bi%26wd%3D%26eqid%3Df0a4815200019f1b000000065a604dd2&tfrom=1&tpl=crystal_blue&uid=d10b87640a52532a27eee7ee198c4061&timeStamp=1516262963382&ucust_id=","_blank","toolbar=yes, location=yes, directories=no, status=no, menubar=yes, scrollbars=yes, resizable=no, copyhistory=yes, width=800, height=600,top=200,left=200")
    window.open("https://www41.53kf.com/webCompany.php?arg=10121262&style=1&language=zh-cn&charset=gbk&kflist=off&kf=kefu01@sina.com&zdkf_type=1&lnk_overflow=0&referer=http%3A%2F%2Fwww.sciedit.cn%2F&keyword=&tfrom=1&tpl=crystal_blue&uid=73e8713cd012d2cb356580915762e575&is_group=&is_group=&timeStamp=1522122730381&ucust_id=","_blank","toolbar=yes, location=yes, directories=no, status=no, menubar=yes, scrollbars=yes, resizable=no, copyhistory=yes, width=800, height=600,top=200,left=200")
    return false;
}
