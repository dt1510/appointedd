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

function insert_appointment($db, $customer_id, $staff_id, $service_id, $start_time, $end_time, $duration) {
    $collection = $db->appointments;
    $collection->insert(array('customer'=>$customer_id, 'staff'=>$staff_id, 'start_time'=>$start_time, 'end_time'=>$end_time, 'duration'=>$duration));
    return SUCCESS;
}

function get_customer_id($db, $first_name, $last_name) {
    $collection = $db->customers;
    $cursor = $collection->find(array('first_name'=>$first_name, 'last_name'=>$last_name));
    foreach ($cursor as $customer) {
        return (String)$customer['_id'];
    }
    return null;
}

function get_staff_member_id($db, $first_name, $last_name) {
    $collection = $db->staff;
    $cursor = $collection->find(array('first_name'=>$first_name, 'last_name'=>$last_name));
    foreach ($cursor as $staff_member) {
        return (String)$staff_member['_id'];
    }
    return null;    
}

function get_service_id($db, $name) {
    $collection = $db->services;
    $cursor = $collection->find(array('name'=>$name));
    foreach ($cursor as $service) {
        return (String)$service['_id'];
    }
    return null;    
}

?>
