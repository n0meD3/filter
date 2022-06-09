<?php
require 'filter.core.php';

$id = $_POST["del"];

$test = new FilterSupp();

$delete = "delete";

$test->$delete($id);

header("Location: index.html");
?>
