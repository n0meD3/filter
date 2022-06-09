<?php
require 'filter.core.php';

$test = new FilterSupp();
$filter = "filter";
$test->$filter();
header("Location: index.html");

?>
