/**
 * Created by liuzhiwei on 2016/2/25.
 */

window.onload = function(){
    var page1 = document.getElementById("page1");
    var page2 = document.getElementById("page2");
    var page3 = document.getElementById("page3");
    var blessing = document.getElementById("blessing"); //用于以后改进

    var music = document.getElementById("music");
    var audio = document.getElementsByTagName("audio")[0];
    //音乐停止，光盘停止旋转
    audio.addEventListener("ended",function(e){
        music.setAttribute("class","");
    },false);

    //点击音乐图标，控制音乐播放效果
    music.addEventListener("touchstart", function(e){
        if(audio.paused){
            audio.play();
            //this.style.animationPlayState = "running";
            //this.style.webkitanimationPlayState = "running";
            this.setAttribute('class','play');

        }else{
            audio.pause();
            //this.style.animationPlayState = "paused";
            //this.style.webkitanimationPlayState = "paused";
            this.setAttribute('class','');
        }
    },false);

    //点击第一页时，进行翻页
    page1.addEventListener("touchstart", function(e){
        page1.style.display = "none";
        page2.style.display = "block";
        page3.style.display = "block";
        page3.style.top = "100%";

        setTimeout(function(){
            page2.setAttribute("class", "page fadeOut");
            page3.setAttribute("class", "page fadeIn");
        }, 5500);
    },false);
}