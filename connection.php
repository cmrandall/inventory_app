<?php
    $description = $_POST['descript'];
    $tag = $_POST['tag'];
    $location = $_POST['location'];
    $department = $_POST['department'];
    $manufacturer = $_POST['manufacturer'];
    $model = $_POST['model'];
    $quantity = $_POST['quantity'];
    $cost = $_POST['cost'];
    $status = $_POST['stat'];
    $inventoried = $_POST['inventoried'];
    $owner = $_POST['own'];
    $expire = $_POST['expired'];

    $host = "localhost";
    $dbUsername = "root";
    $dbPassword = "b7QIPrAke?";
    $dbname = "inventorydb";
    

    // Create Connection to submit data
    $conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);

    if(mysqli_connect_error()) {
        die('Connect Error ('.mysqli_connect_errno().')'.mysqli_connect_error());
    } else {
        $sql = "INSERT INTO main (loc, depart, descript, manufacturer, model, tag, quantity, cost, stat, own, inventoried, expiration) values ('$location', '$department', '$description', '$manufacturer', '$model', '$tag', '$quantity', '$cost', '$status', '$owner', '$inventoried', '$expire')";
        if($conn->query($sql)){
           header("location:http://10.201.16.122:8080/");
        }else {
            echo "Error: ".$sql."<br>".$conn->error;
        }
        $conn->close();
        
    }

?>