<!DOCTYPE html>
<head>
<title>Test upload</title>
</head>
<body>

<form action="sendImg.asp" method="post" enctype="multipart/form-data">
     <p>Filename: <input type="text" name="imgname" size="50" /></p>
     <p><input type="file" name="file" />
	 <br>
	 <input type="submit" value="Upload file" /></p>
</form>

</body>
</html>