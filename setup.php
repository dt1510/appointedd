<?php
include_once "configuration.php";
include_once "common.php";

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
    $db->appointment->drop();
    
    echo "Seeding the examples...</br>";s
    insert_customer($db, "David", "Jackson");
    insert_customer($db, "Alice", "Goldberg");
    insert_customer($db, "Matthew", "Jones");
    insert_staff_member($db, "Adam", "Smith");
    insert_staff_member($db, "Joshua", "Eilenberg");
    insert_service($db, "massage", 60);
    insert_service($db, "haircut", 20);
    insert_service($db, "hair styling", 30);
    insert_service($db, "dog walking", 90);
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
