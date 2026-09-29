<?php
require_once "../includes/auth.php";
require_once "../includes/database.php";

if(isset($_GET['id'])){
    $id = $_GET['id'];

    $sql = "DELETE FROM members WHERE id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);


    if($stmt->execute()){
        header("Location: show.php?deleted=1");
        exit();
    }
    else{
        echo "Error: ".$stmt->error;
    }

}

?>

