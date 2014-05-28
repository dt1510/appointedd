<?php

class Controller { 
    private $model; 

    public function __construct(Model $model) { 
        $this->model = $model;
        
        try {
            // open connection to MongoDB server
            $conn = new Mongo(MONGODB_LOCATION);
            // access database
            $db = $conn->selectDB(DATABASE_NAME);
            $this->model->load($db);
            
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
    }
} 

    //initiate the triad 
    $model = new Model();
    //It is important that the controller and the view share the model 
    $controller = new Controller($model); 
    $view = new View($controller, $model);

?>
