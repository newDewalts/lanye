$(function(){
           $('.xm-box').hover(
            function () {
              $(this).find('.xm-hide-top').show();
              $(this).find('.xm-list').addClass("xm-list-bg");
            },
            function () {
              $(this).find('.xm-hide-top').hide();
              $(this).find('.xm-list').removeClass("xm-list-bg");
            }
          );

          $('.customer-bxslider').bxSlider({
                    controls:false,
                    auto:true,
                    pager:true
          });
          $('.study-top-left-bxslider').bxSlider({
                    controls:false,
                    auto:true,
                    pager:true
          });
           //在线投稿 
            $(".online-upload-button").click(function () {
                    $('#online-upload').click();
            })
            $(".attach_name").click(function () {
                    $('#online-upload').click();
            })
            
            $('#online-upload-2').change(function() {
                var name = $(this).val();
                //alert(name);
                filename = name.slice(12);
                $('.act-input').text(filename);
             })
        });
        function ajaxFileUpload() {
            $.ajaxFileUpload
            (
                {
                    url: '/contribute/upload', //用于文件上传的服务器端请求地址
                    secureuri: false, //是否需要安全协议，一般设置为false
                    fileElementId: 'online-upload', //文件上传域的ID
                    dataType: 'json', //返回值类型 一般设置为json
                    success: function (data)  //服务器成功响应处理函数
                    {
                        $('.attach_name').val(data);
                        //alert('上传成功！');
                    },
                    error: function (data, status, e)//服务器响应失败处理函数
                    {
                        alert(e);
                    }
                }
            )
            return false;
        }

       var system ={};  
            var p = navigator.platform;       
            system.win = p.indexOf("Win") == 0;  
            system.mac = p.indexOf("Mac") == 0;  
            system.x11 = (p == "X11") || (p.indexOf("Linux") == 0);     
            if(system.win||system.mac||system.xll){ 
            }else{  //如果是手机,跳转到谷歌
            window.location.href="http://m.blueedit.lanye168.com";  
        }