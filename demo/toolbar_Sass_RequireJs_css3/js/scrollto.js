define(['jquery'], function($){//定义模块，同时引入jquery
    function ScrollTo(opts){ //构造函数
        this.opts = $.extend({}, ScrollTo.DEFAULTS, opts) //使用opts覆盖DEFAULTS默认值，保存到一个空对象返回
        this.$el = $('html, body');
    }

    ScrollTo.prototype.move = function(){ //在构造函数原型上定义方法，可以节省内存-回到顶部
        var opts = this.opts,
            dest = opts.dest;
        if($(window).scrollTop != dest){
            if(!this.$el.is(':animated')){
                this.$el.animate({
                    scrollTop: opts.dest
                },opts.speed);
            }
        }
    }

    ScrollTo.prototype.go = function(){ //在构造函数原型上定义方法-快速回到顶部
        var dest = this.opts.dest;
        if($(window).scrollTop != dest){
            this.$el.scrollTop(this.opts.dest)
        }
    }

    ScrollTo.DEFAULTS = { //定义属性
        dest:0,
        speed:800
    }

    return{ //返回对象和构造函数名
        ScrollTo:ScrollTo
    }
});
