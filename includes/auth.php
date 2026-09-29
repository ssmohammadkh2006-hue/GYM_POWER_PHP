<?php

session_start();

if(!isset($_SESSION['username'])){

    header("Location:/GYM_PROJECT/login.php");

    exit;

}

?>