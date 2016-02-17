/**
 * Created by awei on 16-2-1.
 */

canvasWidth = window.innerWidth;
canvasHeight = window.innerHeight;

var canvas = document.getElementById('canvas');
var context = canvas.getContext('2d');

canvas.width = canvasWidth;
canvas.height = canvasHeight;

var radius = 100;
var clippingRegion = {x:-1, y:-1, r:radius};
var leftMargin = 0, topMargin = 0;
var imageSrc = 'image_'+Math.round(Math.random()*5)+'.jpg';

var image = new Image();
image.src = imageSrc;
image.onload = function(e){
    $('#blur-div').css('width',canvasWidth+'px');
    $('#blur-div').css('height',canvasHeight+'px');

    $('#blur-image').css('width',image.width+'px');
    $('#blur-image').css('height',image.height+'px');

    leftMargin = (image.width-canvas.width)/2;
    topMargin = (image.height-canvas.height)/2

    //使能自适应屏幕，String把数字转为为字符，两种情况：image尺寸大于canvas；canvas尺寸大于image
    $('#blur-image').css('left', String(-leftMargin)+'px');
    $('#blur-image').css('top', String(-topMargin)+'px');
    $('#blur-image').attr('src',imageSrc);
    initCanvas();
}

/**
 * 初始化
 */
function initCanvas(){

    var theLeft = leftMargin<0?-leftMargin:0;
    var theTop = topMargin<0?-topMargin:0;

    //Math.random()*(canvas.width-2*radius)+radius设置，保证圆不超出canvas的范围，x,y都在canvas-radius中
    clippingRegion = {x:Math.random()*(canvas.width-2*radius-2*theLeft)+radius+theLeft,
        y:Math.random()*(canvas.height-2*radius-2*theTop)+radius+theTop,
        r:radius
    };
    draw(image, clippingRegion);
}

/**
 * 生成圆图形，然后裁剪
 * @param clippingRegion
 */
function setClippingRegion(clippingRegion){
    context.beginPath();
    context.arc(clippingRegion.x, clippingRegion.y, clippingRegion.r, 0, Math.PI*2, false);
    //一旦剪切了某个区域，则所有之后的绘图都会被限制在被剪切的区域内（不能访问画布上的其他区域）
    context.clip();
}

/**
 * 在canvas上画图
 * @param image
 * @param clippingRegion
 */
function draw(image, clippingRegion){
    context.clearRect(0, 0, canvas.width, canvas.height);
    //您也可以在使用 clip() 方法前通过使用 save() 方法对当前画布区域进行保存，并在以后的任意时间对其进行恢复（通过 restore() 方法）。
    context.save();
    setClippingRegion(clippingRegion);
    context.drawImage(
        image,
        Math.max(leftMargin,0), Math.max(topMargin,0),//开始剪切的 x y坐标位置
        Math.min(canvas.width,image.width), Math.min(canvas.height,image.height),//被剪切图像的宽，高度
        leftMargin<0?-leftMargin:0, topMargin<0?-topMargin:0, //在画布上放置图像的 x 坐标位置
        Math.min(canvas.width,image.width), Math.min(canvas.height,image.height)//要使用的图像的宽，高度
    );
    context.restore();

}
/**
 * 重置
 */
function reset(){
    clearInterval(t);
    initCanvas();
}
/**
 * 显示全部，并产生动画
 */
var t;
function show(){
        t = setInterval(function(){
        clippingRegion.r += 20;
        if(clippingRegion.r > 2*Math.max(canvas.width,canvas.height)){
            clearInterval(t);
        }
        console.log('canvas.width'+canvas.width,'clippingRegion.r '+clippingRegion.r);
        draw(image, clippingRegion);
    },30);
}