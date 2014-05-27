<?php
include_once "configuration.php";

class Model { 
    public $text;
    private $appointsments;
    private $customers;
    private $staff;
    private $services;
     
    public function __construct($db) { 
        $this->text = 'Hello world!'; 
        $this->appointments=$db->appointments->find();
        $this->customers=$db->customers->find();        
        $this->staff=$db->staff->find();
        $this->services=$db->services->find();
    }
    
    public function get_appointments_list() {
        return $appointments;
    }
    
    public function get_customers_list() {
        return $customers;
    }
    
    public function get_staff_list() {
        return $staff;
    }
    
    public function get_services_list() {
        return $services;
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
    
    public function get_appointments_table() {
        $table="<table>";
        foreach($model->get_appointments_list() as $appointment) {
            $table.="<tr>";
                $table.="<td>appointment</id>";
            $table.="</tr>";
        }
        $table.="</table>";
        return $table;
    }
} 

class Controller { 
    private $model; 

    public function __construct(Model $model) { 
        $this->model = $model; 
    } 
} 

try {
    // open connection to MongoDB server
    $conn = new Mongo(MONGODB_LOCATION);
    // access database
    $db = $conn->selectDB(DATABASE_NAME);
    
    //initiate the triad 
    $model = new Model($db); 
    //It is important that the controller and the view share the model 
    $controller = new Controller($model); 
    $view = new View($controller, $model);
    
    // disconnect from server
    $conn->close();    
} catch (MongoConnectionException $e) {
    if ($debug) {
        print ('Error connecting to MongoDB server: ' . $e->getMessage());
    } else {
        print ('Error connecting PHP with MongoDB');
    }
    exit(FAILURE);
} catch (MongoException $e) {  
    if ($debug) {
        print ('Error: ' . $e->getMessage());
    } else {
        print ('Error connecting PHP with MongoDB');  
    }
    exit(FAILURE);
}


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
