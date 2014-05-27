<?php
include "configuration.php";

#phpinfo();
$debug = false;
 
try {
  // open connection to MongoDB server
  $conn = new Mongo (MONGODB_LOCATION);
 
  // access database
  $db = $conn->selectDB("test2");
 
  // access collection
  $collection = $db->users;
  //$collection->insert(array('username'=>"joe", 'password'=>"infinity123"));
 
  // execute query
  // retrieve all documents
  $cursor = $collection->find();
 
  // iterate through the result set
  // print each document
  // echo $cursor->count() . ' document(s) found. <br/>'; 
  echo $cursor->count()."</br>";  
  foreach ($cursor as $obj) {
    //if ($obj['language'] == 'PHP') echo $obj['message_text'];
    //echo $obj["username"]."</br>";
    print_r($obj);
    echo "</br>";
  }
  // disconnect from server
  $conn->close();
} catch (MongoConnectionException $e) {
  if ($debug) {
    print ('Error connecting to MongoDB server: ' . $e->getMessage());
  } else {
    print ('Error connecting PHP with MongoDB');
  }
} catch (MongoException $e) {  
  if ($debug) {
    print ('Error: ' . $e->getMessage());
  } else {
    print ('Error connecting PHP with MongoDB');  
  }
}

function insert_customer($db, $first_name, $last_name) {
    #TODO checking
    $collection = $db->users;
    $collection->insert(array('first_name'=>$first_name, 'last_name'=>$last_name));
    return SUCCESS;
}

function insert_staff_member($db, $fist_name, $last_name) {
    $collection = $db->staff;
    $collection->insert(array('first_name'=>$first_name, 'last_name'=>$last_name));
    return SUCCESS;
}

function insert_service($db, $name, $duration) {
    $collection = $db->services;
    $collection->insert(array('name'=>$name, 'duration'=>$duration));
    return SUCCESS;
}

function insert_appointment($customer, $staff, $service, $start_time, $end_time, $duration) {
    $collection = $db->appointment;
    $collection->insert(array('customer'=>$customer, 'staff'=>$staff, 'start_time'=>$start_time, 'end_time'=>$end_time, 'duration'=>$duration));
    return SUCCESS;
}

#$response = $db->execute("function() { return 'Hello, world!'; }");
#echo $response['retval'];

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
echo $view->output();

?>
