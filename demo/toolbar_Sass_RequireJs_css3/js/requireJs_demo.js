//配置路径
requirejs.config({
    paths:{
        jquery:'jquery-1.12.2.min',
        validate:'validate_demo'
    }
});

//使用模块
requirejs(['jquery','validate'], function($,validate){
    $('body').css('background','red');
    //console.log(validate.isEqual(1,1));
    alert(validate.isEqual(1,1));
});