<?php

class Model {
    private $appointsments;
    private $customers;
    private $staff;
    private $services;
    private $conn;
    private $db;
    private $error_messages=array();
     
    public function __construct() {
    
        $debug=false;
        try {
            // open connection to MongoDB server
            $this->conn = new Mongo(MONGODB_LOCATION);
            // access database
            $this->db = $this->conn->selectDB(DATABASE_NAME);            
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
    
    public function __destruct() {
        // disconnect from server
        $this->conn->close();
    }
    
    public function errors() {
        return $this->error_messages;
    }
    
    public function has_errors() {
        return count($this->error_messages)>0;
    }
    
    private function add_error($error_message) {
        array_push($this->error_messages, $error_message);
    }
    
    public function load() {
        $this->appointments=array();
        foreach($this->db->appointments->find() as $appointment) {
            $customer=get_customer_by_id($this->db, $appointment['customer_id']);
            $staff_member=get_staff_member_by_id($this->db, $appointment['staff_member_id']);
            $service=get_service_by_id($this->db, $appointment['service_id']);
            array_push($this->appointments,
                array("customer_name"=>$customer["first_name"]." ".$customer["last_name"],
                "staff_member_name"=>$staff_member["first_name"]." ".$staff_member["last_name"],
                "service_name"=>$service["name"],
                "start_time"=>$appointment['start_time'],
                "end_time"=>$appointment['end_time']
                )
            );
        }                
        
        $this->customers=array();        
        foreach($this->db->customers->find() as $customer) {
            array_push($this->customers,
                array("id"=>(String)$customer["_id"],
                "name"=>$customer["first_name"]." ".$customer["last_name"]));
        }
        
        $this->staff=array();
        foreach($this->db->staff->find() as $staff_member) {
            array_push($this->staff,
                array("id"=>(String)$staff_member["_id"],
                "name"=>$staff_member["first_name"]." ".$staff_member["last_name"]));
        }
        
        $this->services=array();
        foreach($this->db->services->find() as $service) {
            array_push($this->services,
                array("id"=>(String)$service["_id"],
                "name"=>$service["name"]));
        }        
    }
    
    public function add_appointment($staff_member_id, $customer_id, $service_id, $start_time_timestamp) {
        if(is_permitted($this->db, $staff_member_id, $service_id)) {
            insert_appointment($this->db, $customer_id, $staff_member_id, $service_id, $start_time_timestamp);
            return SUCCESS;
        } else {
            $this->add_error("A staff member not permitted to provide the selected service.");
            return FAILURE;
        }
    }
    
    public function get_appointments_list() {
        return $this->appointments;
    }
    
    public function get_customers_list() {;
        return $this->customers;
    }
    
    public function get_staff_list() {
        return $this->staff;
    }
    
    public function get_services_list() {
        return $this->services;
    }
} 

?>
