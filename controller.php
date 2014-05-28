<?php

class Controller { 
    private $model; 

    public function __construct(Model $model) { 
        $this->model = $model;
    }
    
    public function load() {
        $this->model->load();
    }
    
    public function add_appointment() {
        $this->model->add_appointment($_POST['staff_member_id'], $_POST['customer_id'], $_POST['service_id'], $_POST['start_time_timestamp']);
    }
}
?>
