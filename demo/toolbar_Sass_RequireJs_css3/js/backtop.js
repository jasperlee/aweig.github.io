define(['jquery', 'scrollto'],function($, scrollto){
    function BackTop(el, opts){
        this.opts = $.extend({}, BackTop.DEFAULTS, opts) //使用opts覆盖DEFAULTS默认值，保存到一个空对象返回
        this.$el = $(el);
        this.scroll = new scrollto.ScrollTo({
            dest:0,
            speed:this.opts.speed
        });

        this._checkPosition();

        if(this.opts.mode == 'move'){
            this.$el.on('click', $.proxy(this._move, this));
        }else{
            this.$el.on('click', $.proxy(this._go, this));
        }
        $(window).on('scroll', $.proxy(this._checkPosition, this));

    }

    BackTop.prototype._move = function(){
        this.scroll.move();
    }

    BackTop.prototype._go = function(){
        this.scroll.go();
    }

    BackTop.prototype._checkPosition = function(){
        var $el = this.$el
        if($(window).scrollTop() > this.opts.pos){
            $el.fadeIn();
        }else{
            $el.fadeOut();
        }
    }

    BackTop.DEFAULTS = { //定义属性
        mode: 'move',
        pos: $(window).height(),
        speed:800
    };

    $.fn.extend({ //注册jquery插件
        backtop: function(opts){
            return this.each(function(){
                new BackTop(this, opts);
            });
        }
    });

    return{//返回对象和构造函数名
        BackTop: BackTop
    }
});
