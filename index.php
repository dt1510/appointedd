<?php
include_once "configuration.php";
include_once "common.php";

class Model { 
    private $appointsments;
    private $customers;
    private $staff;
    private $services;
     
    public function __construct($db) { 
        $this->appointments=array();
        foreach($db->appointments->find() as $appointment) {
            $customer=get_customer_by_id($db, $appointment['customer_id']);
            $staff_member=get_staff_member_by_id($db, $appointment['staff_member_id']);
            $service=get_service_by_id($db, $appointment['service_id']);
            array_push($this->appointments,
                array("customer_name"=>$customer["first_name"]." ".$customer["last_name"],
                "staff_member_name"=>$staff_member["first_name"]." ".$customer["last_name"],
                "service_name"=>$service["name"],
                "start_time"=>$appointment['start_time'],
                "end_time"=>$appointment['end_time']
                )
            );
        }
        $this->customers=$db->customers->find();        
        $this->staff=$db->staff->find();
        $this->services=$db->services->find();
    }
    
    public function get_appointments_list() {
        return $this->appointments;
    }
    
    public function get_customers_list() {
        return $this->customers;
    }
    
    public function get_staff_list() {
        return $this->staff;
    }
    
    public function get_services_list() {
        return $this->services;
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
        return $this->get_appointments_table(); 
    } 
    
    public function get_appointments_table() {
        $table="<table>";
        $table.="<tr><td>Staff member</td><td>Customer</td><td>Service</td><td>Start time</td><td>End time</td></tr>";        
        foreach($this->model->get_appointments_list() as $appointment) {
            $table.="<tr>";
                $table.="<td>".$appointment["staff_member_name"]."</td><td>".$appointment["customer_name"]."</td><td>".$appointment["service_name"]."</td>";
                $start_time=new DateTime("@".$appointment['start_time']);
                $end_time=new DateTime("@".$appointment['end_time']);
                $table.="<td>".$start_time->format(DATETIME_FORMAT)."</td><td>".$end_time->format(DATETIME_FORMAT)."</td>";
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
