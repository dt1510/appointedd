<?php

class Model {
    private $appointsments;
    private $customers;
    private $staff;
    private $services;
     
    public function __construct() { 
    }
    
    public function load($db) {
        $this->appointments=array();
        foreach($db->appointments->find() as $appointment) {
            $customer=get_customer_by_id($db, $appointment['customer_id']);
            $staff_member=get_staff_member_by_id($db, $appointment['staff_member_id']);
            $service=get_service_by_id($db, $appointment['service_id']);
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
        foreach($db->customers->find() as $customer) {
            array_push($this->customers,
                array("id"=>(String)$customer["_id"],
                "name"=>$customer["first_name"]." ".$customer["last_name"]));
        }
        
        $this->staff=array();
        foreach($db->staff->find() as $staff_member) {
            array_push($this->staff,
                array("id"=>(String)$staff_member["_id"],
                "name"=>$staff_member["first_name"]." ".$staff_member["last_name"]));
        }
        
        $this->services=array();
        foreach($db->services->find() as $service) {
            array_push($this->services,
                array("id"=>(String)$service["_id"],
                "name"=>$service["name"]));
        }        
    }
    
    public function add_appointment($staff_member_id, $customer_id, $service_id, $start_time_timestamp) {
        insert_appointment($staff_member_id, $customer_id, $service_id, $start_time_timestamp);
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
