<?php

$servername = "localhost"; 
$username = "root";      
$password = "";          
$dbname = "aim4thestar"; 

try {
    $conn = new mysqli($servername, $username, $password, $dbname);


    if ($conn->connect_errno) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

} catch (Exception $e) {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();     
    }
    
error_log($e->getMessage()); // Log the error for debugging
echo "An error occurred while connecting to the database."; // Display a generic error message

    exit(); 
}
?>
