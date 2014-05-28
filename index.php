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
<link rel="stylesheet" type="text/css" href="css/style.css">
<link rel="stylesheet" type="text/css" href="css/demo.css">
<link rel="stylesheet" type="text/css" href="css/jquery-ui-1.10.4.custom.min.css">
<link rel="stylesheet" type="text/css" href="css/jquery-ui-timepicker-addon.css">
<script src="js/jquery-2.0.2.min.js"></script>
<script src="js/jquery-ui-1.10.4.custom.min.js"></script>
<script src="js/jquery-ui-timepicker-addon.js"></script>
</head>
<body>
<h1>Simple appointment booking system</h1>
<?
    echo $view->output();
?>
</body>
</html>
