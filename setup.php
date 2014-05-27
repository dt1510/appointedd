<?php
include_once "configuration.php";
include_once "common.php";

$debug=false;

try {
    echo "Connecting to the database...</br>";
    
    // open connection to MongoDB server
    $conn = new Mongo (MONGODB_LOCATION);

    // access database
    $db = $conn->selectDB(DATABASE_NAME);
    
    echo "Deleting data...</br>";
    $db->customers->drop();
    $db->staff->drop();
    $db->services->drop();
    $db->appointments->drop();
    
    echo "Seeding the examples...</br>";
    insert_customer($db, "David", "Jackson");
    insert_customer($db, "Alice", "Goldberg");
    insert_customer($db, "Matthew", "Jones");
    insert_staff_member($db, "Adam", "Smith");
    insert_staff_member($db, "Joshua", "Eilenberg");
    insert_service($db, "massage", 60);
    insert_service($db, "haircut", 20);
    insert_service($db, "hair styling", 30);
    insert_service($db, "dog walking", 90);
    
    $time=time();
    $service1=get_service($db,"haircut");
    $service2=get_service($db,"hair styling");
    insert_appointment($db, get_customer_id($db,"David", "Jackson"), get_staff_member_id($db,"Adam", "Smith"),
        (String)$service1['_id'], $time, $time+$service1['duration']*3600);
    insert_appointment($db, get_customer_id($db,"Alice", "Goldberg"), get_staff_member_id($db,"Joshua", "Eilenberg"),
        (String)$service2['_id'], $time, $time+$service2['duration']*3600);
    
    var_dump(get_staff_member_id($db,"Adam","Smith"));
    echo "</br>";
    //insert_appointment($customer, $staff, $service, $start_time, $end_time, $duration) {
     
    // disconnect from server
    $conn->close();    
    echo "Done. You can enter new appointments under index.php.</br>";
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

?>
