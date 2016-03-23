# h5_source
h5源码，博客http://aweig.com/

###canvas_redphotos
红包照片，类似微信里红包照片，详细介绍：http://aweig.com/aweiglabs/showcase/136.html

###canvas_time
HTML5是实现计时动画效果，详细介绍：http://aweig.com/aweiglabs/showcase/82.html

###h5_springFestival
h5实现移动端春节祝福，在不同的设备上显示有些bug，在iphone6上显示正常

###h5_offlineapp
h5 Web存储和应用程序缓存的应用实例，离线的新闻阅读器

###photos_zeptoJs_animateCss
利用zepto.js和animate.css开发的移动相册

###toolbar_Sass_RequireJs_css3
利用Sass和RequireJs制作工具条  
Less/Sass编译工具:Koala  
图标字体库：<https://icomoon.io/> 和 <http://www.iconfont.cn>

######SASS
1、嵌套  
.toolbar-item{  
  position: relative;    
  transition: background-position 1s;   
  &:hover{  
    .toolbar-layer{  
      @include opacity(1);        
    }  
  }  
}    

2、$变量  
$toolbar-size:52px;  

3、@mixin函数名(参数)-定义函数   
@mixin transition($transition){ //定义一个函数  
  -webkit-transition: $transition;  
  -moz-transition: $transition;  
  -ms-transition: $transition;  
  -o-transition: $transition;  
  transition: $transition;  
}

4、@import -引入其他SASS文件    
@import "mixin"; 如引入SASS文件_mixin.scss

5、@extend -继承其他样式   
@extend .icon-mobile;

######RequireJs
1、requirejs.config -配置别名  
requirejs.config({ 
    paths:{ 
        jquery:'jquery-1.12.2.min',
        validate:'validate_demo'
    } 
}); 

2、requirejs -引入模块   
//使用模块
requirejs(['jquery','validate'], function($,validate){  
    $('body').css('background','red');  
    //console.log(validate.isEqual(1,1));  
    alert(validate.isEqual(1,1));  
});  

3、define -定义模块 
define(['jquery'],function($){   
    return {  
        isEmpty:function(){},  
        checkLength:function(){},  
        isEqual:function(str1, str2){  
            return str1 === str2;  
        }  
    }  
});
  
######CSS3实现简单的动画效果
1、过渡效果transition  
transition: top 1s;

2、2D变换transform  
transform-origin: 95% 95%; 
transform: scale(0.01);

#######CSS精灵、图标字体和伪类
1、将多张图片合并成一张图片，减少HTTP请求，提高速度  
2、代替简单图片，方便修改  
3、减少标签的书写，降低HTML结构的复杂性  