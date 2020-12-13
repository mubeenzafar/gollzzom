<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Click to Download</h1>
    <a href="?file=Nexa Bold.otf" class="">Download</a>
</body>
</html>

<?php

if(!empty($_GET['file']))
{
    $filename = basename($_GET['file']);
    downloadFont($filename);
}

function downloadFont($filename)
{
    $filepath = 'fonts/' . $filename;
    if(!empty($filename) && file_exists($filepath)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename='.urlencode($filename));
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filename));
        ob_clean(); // not necessary
        flush();  // not necessary
        readfile($filename);
        exit;
    } else {
        http_response_code(404);
        die();
    }
}

?>


    

