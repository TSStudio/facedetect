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
        <h1>人脸注册</h1>
        <form action="new.php" method="post" enctype="multipart/form-data">
            <label for="file">选择一个文件(jpg/png)</label>
            <input type="file" name="file" id="file" accept="image/jpeg,image/png"/><br>
            名字：<input type="text" name="name" />
            <input type="submit" name="submit" value="Submit">
        </form>
    </body>
</html>