var timer = null;
var offset = 3500;
var index = -1; 

//大图交替轮换
function slideImage(i){
    var id = 'image_'+ target[i];
    $('#'+ id)
        .animate({opacity: 1}, 800, function(){
            $(this).find('.team_word').animate();
        }).show()
        .siblings(':visible')
        .find('.team_word').animate({height: 'show'},'slow',function(){
            $(this).parent().animate({opacity: 0}, 500).hide();
        });
}
//bind thumb a
function hookThumb(){    
    $('#thumbs li a')
        .bind({
        	mouseover:function(){
	            if (timer) {
	                clearTimeout(timer);
	            }                
	            var id = this.id;            
	            index = getIndex(id.substr(6));
	            rechange(index);
	            slideImage(index); 
	            
	            this.blur();            
	            return false;
        	},  
  			mouseout:function(){
  				timer = window.setTimeout(auto, offset);
  			}  
        });
}
//bind next/prev img
function hookBtn(){
    $('#thumbs li img').filter('#play_prev,#play_next')
        .bind('click', function(){
            if (timer){
                clearTimeout(timer);
            }
            var id = this.id;
            if (id == 'play_prev') {
                index--;
                if (index < 0) index = 7;
            }else{
                index++;
                if (index > 7) index = 0;
            }
            rechange(index);
            slideImage(index);
            timer = window.setTimeout(auto, offset);
        });
}
//get index
function getIndex(v){
    for(var i=0; i < target.length; i++){
        if (target[i] == v) return i;
    }
}
function rechange(loop){
    var id = 'thumb_'+ target[loop];
    $('#thumbs li a.current').removeClass('current');
    $('#'+ id).addClass('current');
}
function auto(){
    index++;
    if (index > 7){
        index = 0;
    }
    rechange(index);
    slideImage(index);
    timer = window.setTimeout(auto, offset);
}
$(function(){    
    //change opacity
    $('div.team_word').css({opacity: 0.85});
    auto();  
    hookThumb(); 
    hookBtn();
    
});