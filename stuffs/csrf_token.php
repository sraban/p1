<?php
#print_r($_REQUEST);
//https://thebestdayiseveryday.blogspot.com/2019/01/sample-code-for-jstree-ajax-call-and.html
//https://everyething.com/Example-of-simple-jsTree-with-Search
header('Access-Control-Allow-Origin: *');
header('Content-type: application/json;charset=utf-8');
$time = time();
echo <<<EOL
{
    "status": "success",
    "wo_csrf_token": "c08df71f60a801a7a5df91caa95f1faa86d5d6f08fb2f359e566810a58fbd990acd921296f0b11d28713f5159a7c75504a37960d7014393c291a54c288c1674e$time"
}
EOL;
?>