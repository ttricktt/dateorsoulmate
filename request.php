<?php

$http_response = '';

$fp = fsockopen('dateorsoulmate.com', 80);
fputs($fp, "GET / HTTP/1.1\r\n");
fputs($fp, "Host: dateorsoulmate.com\r\n\r\n");

while (!feof($fp))
{
    $http_response .= fgets($fp, 128);
}

fclose($fp);

echo nl2br(htmlentities($http_response));

?>

