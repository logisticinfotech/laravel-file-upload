<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>File Upload Example</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css" />
    <script src="main.js"></script>
</head>
<body>
    <h2>Upload your file here</h2>
    <form name="file_upload_form" method="POST" action="/file-upload">
        <input class="form-control" type="file" name="file" id="file" required>
        <button type="submit" class="btn btn-default">Upload</button>
    </form>
</body>
</html>