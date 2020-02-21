var timeele=document.getElementById("time");
function gtime(){
    time=new Date();
    h=time.getHours()<10?"0"+time.getHours():time.getHours();
    m=time.getMinutes()<10?"0"+time.getMinutes():time.getMinutes();
    string=h+":"+m;
    return string;
}
function stime(ele){
    ele.innerText=gtime();
    return true;
}
timeele.innerText=gtime();
setInterval("stime(timeele)",100);
function logout(){
    if(window.confirm("你确定要登出吗?")){
        window.location.href="logout.php?URL=index.php";
    }
}
function browserRedirect() {
    var sUserAgent = navigator.userAgent.toLowerCase();
    var bIsIphoneOs = sUserAgent.match(/iphone/i) == "iphone";
    var bIsMidp = sUserAgent.match(/midp/i) == "midp";
    var bIsUc7 = sUserAgent.match(/rv:1.2.3.4/i) == "rv:1.2.3.4";
    var bIsUc = sUserAgent.match(/ucweb/i) == "ucweb";
    var bIsAndroid = sUserAgent.match(/android/i) == "android";
    var bIsCE = sUserAgent.match(/windows ce/i) == "windows ce";
    var bIsWM = sUserAgent.match(/windows mobile/i) == "windows mobile";
    if (!(bIsIphoneOs || bIsMidp || bIsUc7 || bIsUc || bIsAndroid || bIsCE || bIsWM) ){
            //电脑端
            var linkNode = document.createElement("link");
            linkNode.setAttribute("rel","stylesheet");
            linkNode.setAttribute("type","text/css");
            linkNode.setAttribute("href","css/style.css");
            document.head.appendChild(linkNode);
    }else{
            //手机端
            var linkNode = document.createElement("link");
            linkNode.setAttribute("rel","stylesheet");
            linkNode.setAttribute("type","text/css");
            linkNode.setAttribute("href","css/style_m.css");
            document.head.appendChild(linkNode);
    }
}

browserRedirect();