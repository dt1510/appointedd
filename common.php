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

#duration in seconds.
function insert_service($db, $name, $duration) {
    $collection = $db->services;
    $collection->insert(array('name'=>$name, 'duration'=>$duration));
    return SUCCESS;
}

#start_time, end_time are unix timestamps in seconds.
function insert_appointment($db, $customer_id, $staff_id, $service_id, $start_time_timestamp) {
    $service=get_service_by_id($db, $service_id);
    $collection = $db->appointments;
    $collection->insert(array('customer_id'=>$customer_id, 'staff_member_id'=>$staff_id, 'service_id'=>$service_id,
        'start_time'=>$start_time_timestamp, 'end_time'=>$start_time_timestamp+$service['duration']));
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

function get_service($db, $name) {
    $collection = $db->services;
    $cursor = $collection->find(array('name'=>$name));
    foreach ($cursor as $service) {
        return $service;
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

#Returns a service duration in minutes
function get_service_duration($db, $name) {
    $collection = $db->services;
    $cursor = $collection->find(array('name'=>$name));
    foreach ($cursor as $service) {
        return (String)$service['duration'];
    }
    return null;            
}

function get_staff_member_by_id($db, $staff_member_id) {
    $cursor = $db->staff->find(array('_id'=>new MongoId($staff_member_id)));
    foreach ($cursor as $staff_member) {
        return $staff_member;
    }
    return null;    
}

function get_customer_by_id($db, $customer_id) {
    $cursor = $db->customers->find(array('_id'=>new MongoId($customer_id)));
    foreach ($cursor as $customer) {
        return $customer;
    }
    return null;    
}

function get_service_by_id($db, $service_id) {
    $cursor = $db->services->find(array('_id'=>new MongoId($service_id)));
    foreach ($cursor as $service) {
        return $service;
    }
    return null;    
}

function insert_service_permission($db, $staff_member_id, $service_id) {
    $service=get_service_by_id($db, $service_id);
    $collection = $db->service_permissions;
    $collection->insert(array('service_id'=>$service_id, 'staff_member_id'=>$staff_member_id));
    return SUCCESS;  
}

function is_permitted($db, $staff_member_id, $service_id) {
    $cursor = $db->service_permissions->find(array('staff_member_id'=>$staff_member_id, 'service_id'=>$service_id));    
    echo $cursor->count();
    foreach ($cursor as $permission) {
        return true;
    }
    return false;
}

?>
