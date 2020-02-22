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
        <form action="upload.php" method="post" enctype="multipart/form-data">
            <label for="file">Choose a photo(jpg/png)</label>
            <input type="file" name="file" id="file"/>
            <input type="submit" name="submit" value="Submit">
        </form>
    </body>
</html>