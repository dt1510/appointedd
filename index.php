<?php
include_once "configuration.php";
include_once "common.php";
include_once "model.php";
include_once "view.php";
include_once "controller.php";

?>

<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css">
<script src="jquery-2.0.2.min.js"></script>
</head>
<body>
<h1>Simple appointment booking system</h1>
<?
    echo $view->output();
?>
</body>
</html>
