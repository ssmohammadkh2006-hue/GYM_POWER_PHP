<?php
$servername="localhost";
$username="root";
$password="";
$dbname="gym_project";


$conn=new mysqli($servername,$username,$password,$dbname);

if($conn->connect_error){
    die("error connction !!". $conn->connect_error);
}
 
$conn->set_charset("utf8mb4");

?>