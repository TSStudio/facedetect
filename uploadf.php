<!DOCTYPE HTML>
<!--
上传表单
做一下装修就行
-->
<html>
    <head>
        <meta charset="utf-8">
        <title>Facedetect - Upload</title>
    <head>
    <body>
        <h1>人脸搜索</h1>
        <div>
            当前登录用户：<a id="UN"></a>
            <a href="logout.php" class="link">登出</a>
            <a href="reset.html" class="link">更改密码</a>
        </div>
        <form action="upload.php" method="post" enctype="multipart/form-data">
            <label for="file">选择一个文件(jpg/png)</label>
            <input type="file" name="file" id="file"/>
            <input type="submit" name="submit" value="提交">
        </form>
        <a href="index.html">首页</a>
    </body>
    <script>var type="mainp";</script>
    <script src="js/check.js"></script>
</html>