<?php
include_once "configuration.php";

function insert_customer($db, $first_name, $last_name) {
    $collection = $db->customers;
    $collection->insert(array('first_name'=>$first_name, 'last_name'=>$last_name));
    return SUCCESS;
}

function insert_staff_member($db, $first_name, $last_name) {
    $collection = $db->staff;
    $collection->insert(array('first_name'=>$first_name, 'last_name'=>$last_name));
    return SUCCESS;
}

function insert_service($db, $name, $duration) {
    $collection = $db->services;
    $collection->insert(array('name'=>$name, 'duration'=>$duration));
    return SUCCESS;
}

function insert_appointment($db, $customer, $staff, $service, $start_time, $end_time, $duration) {
    $collection = $db->appointments;
    $collection->insert(array('customer'=>$customer, 'staff'=>$staff, 'start_time'=>$start_time, 'end_time'=>$end_time, 'duration'=>$duration));
    return SUCCESS;
}

?>
