var WINDOW_WIDTH = 800;
var WINDOW_HEIGHT = 400;
var RADIUS = 6;
var MARGING_TOP = 10;
var MARGING_LEFT = 10;

const endTime = new Date(2016,0,21,18,00,00)//2016-1-20 23:59:59 
var currShowTimeSeconds = 0;
var ballList = [];
var color = ["red","green","blue","grey","black"];

window.onload = function(){
	WINDOW_WIDTH = document.body.clientWidth;
	WINDOW_HEIGHT = document.body.clientHeight;
	console.log('widht:'+WINDOW_WIDTH+', height:'+WINDOW_HEIGHT);
    //最后一个数字（秒）的起始位置 MARGIN_LEFT+93*(RADIUS+1),数字占用位置是15*(RADIUS+1),总共108*(RADIUS+1)；
	RADIUS = Math.round(WINDOW_WIDTH*4/5/108)-1 //占领屏幕的4/5

	MARGING_LEFT = Math.round(WINDOW_WIDTH*1/10);
	MARGING_TOP = Math.round(WINDOW_HEIGHT/5);

	var canvas = document.getElementById('canvas');
	var context = canvas.getContext('2d');
	canvas.width = WINDOW_WIDTH;
	canvas.height = WINDOW_HEIGHT;
	currShowTimeSeconds = getCurrShowTimeSeconds();

	setInterval(function(){
		render(context);
		update();
	},50);

}

/**更新画面帧，包括时间刷新和小球动画
 * @return {[type]}
 */
function update(){
	var nextShowTimeSeconds = getCurrShowTimeSeconds();
	var nexthours = parseInt(nextShowTimeSeconds/3600);
	var nextminutes = parseInt((nextShowTimeSeconds-nexthours*3600)/60);
	var nextseconds = parseInt(nextShowTimeSeconds%60);

	var currhours = parseInt(currShowTimeSeconds/3600);
	var currminutes = parseInt((currShowTimeSeconds-currhours*3600)/60);
	var currseconds = parseInt(currShowTimeSeconds%60);

	if(nextseconds != currseconds){
		currShowTimeSeconds = nextShowTimeSeconds;
	}

	if(parseInt(nexthours/10) != parseInt(currhours/10)){
		addBalls(MARGING_LEFT, MARGING_TOP, parseInt(nexthours/10));
	}
	if(parseInt(nexthours%10) != parseInt(currhours%10)){
		addBalls(MARGING_LEFT+15*(RADIUS+1), MARGING_TOP, parseInt(nexthours%10));
	}
	if(parseInt(nextminutes/10) != parseInt(currminutes/10)){
		addBalls(MARGING_LEFT+39*(RADIUS+1), MARGING_TOP, parseInt(nextminutes/10));
	}
	if(parseInt(nextminutes/10) != parseInt(currminutes/10)){
		addBalls(MARGING_LEFT+54*(RADIUS+1), MARGING_TOP, parseInt(nextminutes%10));
	}
	if(parseInt(nextseconds/10) != parseInt(currseconds/10)){
		addBalls(MARGING_LEFT+78*(RADIUS+1), MARGING_TOP, parseInt(nextseconds/10));
	}
	if(parseInt(nextseconds%10) != parseInt(currseconds%10)){
		addBalls(MARGING_LEFT+93*(RADIUS+1), MARGING_TOP, parseInt(nextseconds%10));
	}

	updateBalls();

}

/**
 * 更新小球，同时优化小球显示，不在屏幕内的小球清除
 * @return {[type]} [description]
 */
function updateBalls(){
	for(var i = 0; i< ballList.length; i++) {
		ballList[i].x += ballList[i].xv;
		ballList[i].y += ballList[i].yv;
		ballList[i].yv += ballList[i].g;
		if(ballList[i].y >= WINDOW_HEIGHT-RADIUS){
			ballList[i].y = WINDOW_HEIGHT-RADIUS;
			ballList[i].yv = -ballList[i].yv*0.5;
		}
	};

	var cnt = 0;
	for(var i=0; i<ballList.length; i++){
		if(ballList[i].x+RADIUS>0 && ballList[i].x-RADIUS<WINDOW_WIDTH){
			ballList[cnt++] = ballList[i];
		}
	}
	//console.log(ballList.length);
	while(ballList.length>Math.min(300,cnt)){
		ballList.pop();
	}

}

/**
 * 获取当前时间的秒数
 * @return {[type]}
 */
function getCurrShowTimeSeconds(){
	
	var currTime = new Date();
	/*
	var ret = endTime.getTime() - currTime.getTime();
	//console.log(ret);
	ret = Math.round(ret/1000);
	return ret>0 ? ret : 0; 
	*/
   
    ret = currTime.getHours()*3600+currTime.getMinutes()*60+currTime.getSeconds();
    return ret;


}


function addBalls(x, y, num){
	for(var i=0; i<digit[num].length; i++){
		for(var j = 0; j < digit[num][i].length; j++) {			
			if(digit[num][i][j] == 1){
				var ball = {
					x:x+j*2*(RADIUS+1)+(RADIUS+1),
					y:y+i*2*(RADIUS+1)+(RADIUS+1),
					g:1.5*Math.random(),
					xv:Math.pow(-1, Math.ceil(Math.random()*1000))*4,
					yv:-4,
					color:color[Math.floor(Math.random()*color.length)]
				}
				ballList.push(ball);
				//console.log(Math.floor(Math.random()*color.length));
			}
		}
	}
	
}


/**
 * 设置时间数据及显示的位置
 * @param  {[type]}
 * @return {[type]}
 */
function render(cxt){
	cxt.clearRect(0, 0, WINDOW_WIDTH, WINDOW_WIDTH) //清理指定区域的图像

	var hours = parseInt(currShowTimeSeconds/3600);
	var minutes = parseInt((currShowTimeSeconds-hours*3600)/60);
	var seconds = parseInt(currShowTimeSeconds%60);

	/* hours ：7*2(RADIUS+1)+(RADIUS+1) digit每个数组有7列
	 * 每个元素的大小（包括间距）是(RADIUS+1)，然后加(RADIUS+1)的距离	
	*/
	renderDigit(MARGING_LEFT, MARGING_TOP, parseInt(hours/10), cxt);
	renderDigit(MARGING_LEFT+15*(RADIUS+1), MARGING_TOP, parseInt(hours%10), cxt); //+15
	//冒号 ：
    renderDigit(MARGING_LEFT+30*(RADIUS+1), MARGING_TOP, 10, cxt); //+9
    //minutes
    renderDigit(MARGING_LEFT+39*(RADIUS+1), MARGING_TOP, parseInt(minutes/10), cxt);
	renderDigit(MARGING_LEFT+54*(RADIUS+1), MARGING_TOP, parseInt(minutes%10), cxt);
	//冒号 ：
    renderDigit(MARGING_LEFT+69*(RADIUS+1), MARGING_TOP, 10, cxt);
    //seconds
    renderDigit(MARGING_LEFT+78*(RADIUS+1), MARGING_TOP, parseInt(seconds/10), cxt);
	renderDigit(MARGING_LEFT+93*(RADIUS+1), MARGING_TOP, parseInt(seconds%10), cxt);

	for(var i = 0; i< ballList.length; i++) {
		cxt.beginPath();
		cxt.arc(ballList[i].x, ballList[i].y ,RADIUS, 0, 2*Math.PI);
		cxt.closePath();
		cxt.fillStyle = ballList[i].color;
		cxt.fill();
	}
	
}


/**根据digit显示数字
 * @param  {[type]}
 * @param  {[type]}
 * @param  {[type]}
 * @param  {[type]}
 * @return {[type]}
 */
function renderDigit(x, y, num, cxt){	
	cxt.fillStyle = "blue";
	for(var i=0; i<digit[num].length; i++){
		for(var j = 0; j < digit[num][i].length; j++) {			
			if(digit[num][i][j] == 1){
				cxt.beginPath();
				cxt.arc(x+j*2*(RADIUS+1)+(RADIUS+1), y+i*2*(RADIUS+1)+(RADIUS+1), RADIUS, 0, 2*Math.PI);
				cxt.closePath();
				cxt.fill();
			}
		}
	}
		
}
