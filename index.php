<?php
include_once "configuration.php";

class Model { 
    public $text; 
     
    public function __construct() { 
        $this->text = 'Hello world!'; 
    }         
} 


class View { 
    private $model; 
    private $controller; 
     
    public function __construct(Controller $controller, Model $model) { 
        $this->controller = $controller; 
        $this->model = $model; 
    } 
     
    public function output() {
        return '<h1>' . $this->model->text .'</h1>'; 
    } 
     
} 

class Controller { 
    private $model; 

    public function __construct(Model $model) { 
        $this->model = $model; 
    } 
} 



//initiate the triad 
$model = new Model(); 
//It is important that the controller and the view share the model 
$controller = new Controller($model); 
$view = new View($controller, $model); 

?>

<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css">
<script src="jquery-2.0.2.min.js"></script>
</head>
<body>
<?
    echo $view->output();
?>
</body>
</html>
