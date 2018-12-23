/**
 * Created by Administrator on 2017/8/9 0009.
 */
function Slicer (arg) {
    var that = this;
    var $slicer =  arg.$slicer,$children = $slicer.children();
    var $slicerBtn =  arg.$slicerBtn,$btn = $slicerBtn.children();

    that.$targer  = $children.eq(0);
    that.length = $children.length;
    that.now = 0;

    if(that.length === 1){
        return;
    }
    if($slicer.width()/this.$targer .width() === 1){
        that.offset = -100;
        that.unit = "%";
    }else {
        that.offset = - this.$targer .width();
        that.unit = "px";
    }

    var i = 1;
    while ( i < that.length){
        var $newBtn = $btn.clone().removeClass("active");
        $slicerBtn.append($newBtn);
        i++;
    }
    that.$btns = $slicerBtn.children();

    that.play = function () {
        that.now = that.now >= that.length - 1 ? 0 : that.now + 1;
        that.$btns.removeClass("active").eq(that.now).addClass("active");
        that.$targer.css("margin-left",that.offset * that.now + that.unit);
    };

    that.time = setInterval(that.play,5000);

    that.$btns.on("click",function () {
        clearInterval(that.time);
        that.$btns.removeClass("active");
        that.now = $(this).addClass("active").prevAll().length;
        that.$targer .css("margin-left",that.offset * that.now + that.unit);
        that.time = setInterval(that.play,5000);
    });



}