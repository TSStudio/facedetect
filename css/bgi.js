//Copyright TS Studio 2018
//初始化
window.onload=function(){
body=document.getElementById('body');
var height=window.innerHeight;
var width=window.innerWidth;
if (height>=width){
    body.style.backgroundImage='url("css/background-mobo.png")';
}else{
    body.style.backgroundImage='url("css/background.png")';
}
inputbox=document.getElementById('input-box');
var boxheight=inputbox.offsetHeight;
var trushheight=boxheight+50;
var mainwindow=height-trushheight;
var margin=mainwindow*0.5;
inputbox.style.margin=margin+"px auto auto auto";
}
//当窗口大小改变时
window.onresize=function(){
    var height=window.innerHeight;
    var width=window.innerWidth;
    if (height>=width){
        body.style.backgroundImage='url("css/background-mobo.png")';
    }else{
        body.style.backgroundImage='url("css/background.png")';
    }
    var boxheight=inputbox.offsetHeight;
    var trushheight=boxheight+50;
    var mainwindow=height-trushheight;
    var margin=mainwindow*0.5;
    inputbox.style.margin=margin+"px auto auto auto";
}