<?php

$base_path = 'http://bt.local';

// // echo "<pre>";
// // print_r($_SERVER);

// $servername = "localhost";

// $username = "root"; 

// $password = ""; 

// $dbname = "bt"; 

// $conn = new mysqli($servername, $username, $password, $dbname);

// if ($conn->connect_error) {

//     die("Connection failed: " . $conn->connect_error);

// }


// Database credentials 
define('DB_HOST', 'localhost'); 
define('DB_USER', 'root'); 
define('DB_PASS', ''); 
define('DB_NAME', 'bt'); 

// include_once 'config.php'; 
 
// Connect to the database  
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);  
if($conn->connect_error){  
    die("Failed to connect with MySQL: " . $conn->connect_error);  
} 

?> 