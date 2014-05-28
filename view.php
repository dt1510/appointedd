<?php
class View { 
    private $model; 
    private $controller; 
     
    public function __construct(Controller $controller, Model $model) { 
        $this->controller = $controller; 
        $this->model = $model;
        
        if(@$_GET['request']=="add_appointment") {
            $this->controller->add_appointment();
        }
    } 
     
    public function output() {
        $this->controller->load();
        return $this->appointments_table().
                $this->add_appointment_form(); 
    } 
    
    private function appointments_table() {
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
    
    private function select($selection_name, $options) {
        $select="<select name='$selection_name'>";
        foreach($options as $option) {
            $select.="<option value='".$option['id']."'>".$option['name']."</option>";
        }
        $select.="</select>";
        return $select;
    }
    
    private function customer_select() {
        return $this->select("customer_id",$this->model->get_customers_list());
    }
    
    private function staff_member_select() {
        return $this->select("staff_member_id",$this->model->get_staff_list());
    }
    
    private function service_select() {
        return $this->select("service_id",$this->model->get_services_list());
    }
    
    private function add_appointment_form() {
        $form="<form method='post' action='index.php?request=add_appointment'>";
        $form.='Customer '.$this->customer_select().' ';
        $form.='Staff member '.$this->staff_member_select().' ';
        $form.='Service'.$this->service_select().' ';
        $form.='Start time <input name="start_time_timestamp" value="'.time().'"/>';
        $form.='<input type="submit" value="Submit">';
        $form.="</form>";
        return $form;
    }
} 
?>
