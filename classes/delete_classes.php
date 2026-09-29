<?php
require_once "../includes/auth.php";
require_once "../includes/database.php";


if(!isset($_GET['id'])){

    die("No ID");

}


$id=intval($_GET['id']);



$sql="
DELETE FROM classes
WHERE id=?
";


$stmt=$conn->prepare($sql);


$stmt->bind_param("i",$id);



if($stmt->execute()){


    header("Location:  show_classes.php?deleted=1");

    exit();


}else{


    echo $stmt->error;


}


?>




 