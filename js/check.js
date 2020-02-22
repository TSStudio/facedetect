xmlhttp=new XMLHttpRequest();
xmlhttp.onreadystatechange=function(){
    if(xmlhttp.readyState==4&&xmlhttp.status==200){
        console.log("Successfully GET LOGIN INFO");
        response=JSON.parse(xmlhttp.responseText);
        if(type="mainp"){
            if(response["isLogged"]==false){
                window.location.href="login.html";
            }else{
                document.getElementById("UN").innerText=response["userName"];
            }
            return;
        }
        if(type='prelogin'){
            if(response["isLogged"]==true){
                window.location.href="index.html";
            }
            return;
        }
    }
    if(xmlhttp.readyState==4&&xmlhttp.status!=200){
        console.warn("Could not GET apis/checkLoginStatus.php:"+xmlhttp.status);
    }
}
xmlhttp.open("GET","apis/checkLoginStatus.php",true);
xmlhttp.send();