<?php
include_once "configuration.php";
include_once "common.php";

$debug=false;

try {
    echo "Connecting to the database...</br>";
    
    // open connection to MongoDB server
    $conn = new Mongo(MONGODB_LOCATION);

    // access database
    $db = $conn->selectDB(DATABASE_NAME);
    
    echo "Deleting data...</br>";
    $db->customers->drop();
    $db->staff->drop();
    $db->services->drop();
    $db->appointments->drop();
    $db->service_permissions->drop();
    
    echo "Seeding the examples...</br>";
    insert_customer($db, "David", "Jackson");
    insert_customer($db, "Alice", "Goldberg");
    insert_customer($db, "Matthew", "Jones");
    insert_staff_member($db, "Adam", "Smith");
    insert_staff_member($db, "Joshua", "Eilenberg");
    insert_service($db, "massage", 60*60);
    insert_service($db, "haircut", 20*60);
    insert_service($db, "hair styling", 30*60);
    insert_service($db, "dog walking", 90*60);
    insert_service_permission($db, get_staff_member_id($db, "Adam", "Smith"), get_service_id($db, "haircut"));
    insert_service_permission($db, get_staff_member_id($db, "Joshua", "Eilenberg"), get_service_id($db, "hair styling"));
    insert_service_permission($db, get_staff_member_id($db, "Joshua", "Eilenberg"), get_service_id($db, "massage"));
    
    $time=time();
    $service1=get_service($db,"haircut");
    $service2=get_service($db,"hair styling");
    insert_appointment($db, get_customer_id($db, "David", "Jackson"), get_staff_member_id($db, "Adam", "Smith"),
        (String)$service1['_id'], $time);
    insert_appointment($db, get_customer_id($db, "Alice", "Goldberg"), get_staff_member_id($db, "Joshua", "Eilenberg"),
        (String)$service2['_id'], $time);
    
    // disconnect from server
    $conn->close();    
    echo "Done. You can enter new appointments under <a href='index.php'>index.php</a>.</br>";
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

?>
