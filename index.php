<?php
include_once "configuration.php";
include_once "common.php";
include_once "model.php";
include_once "view.php";
include_once "controller.php";

//initiate the triad 
$model = new Model();
//It is important that the controller and the view share the model 
$controller = new Controller($model);       
$view = new View($controller, $model);

?>

<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css">
<link rel="stylesheet" type="text/css" href="style2.css">
<link rel="stylesheet" type="text/css" href="demo.css">
<link rel="stylesheet" type="text/css" href="jquery-ui-1.10.4.custom.min.css">
<link rel="stylesheet" type="text/css" href="jquery-ui-timepicker-addon.css">
<script src="jquery-2.0.2.min.js"></script>
<script src="jquery-ui-1.10.4.custom.min.js"></script>
<script src="jquery-ui-timepicker-addon.js"></script>
</head>
<body>
<h1>Simple appointment booking system</h1>
<?
    echo $view->output();
?>
</body>
</html>
