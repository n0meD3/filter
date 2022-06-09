<?php
mb_http_output('UTF-8'); 
require 'filter.core.php';
$req_ip = $_POST["ip"];
$req_res = $_POST["res"];
$test = new FilterSupp();
$add = "add";
$test->$add($req_ip, $req_res);

?>
