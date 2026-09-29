<?php
require_once "../includes/auth.php";
require_once "../includes/database.php";

 

if(!isset($_GET['id'])){
    die("No ID");
}

$id = $_GET['id'];


$sql="SELECT * FROM membership_plans WHERE id=?";
$stmt=$conn->prepare($sql);
$stmt->bind_param("i",$id);
$stmt->execute();
$result=$stmt->get_result();
$plan=$result->fetch_assoc();



if(!$plan){
    die("Membership not found");
}

if($_SERVER['REQUEST_METHOD']=="POST"){

    $name=trim($_POST['name'] ?? "");
    $membership=trim($_POST['membership'] ?? "");


    if(empty($name) || empty($membership)){
        $error="يرجى تعبئة جميع الحقول المطلوبة";
    }
    elseif(!is_numeric($membership)){
        $error="سعر الاشتراك يجب أن يكون رقم";
    }
    elseif($membership <= 0){
        $error="سعر الاشتراك يجب أن يكون أكبر من صفر";
    }


    if(empty($error)){
    $sql="UPDATE membership_plans SET
    name=?,
    membership=?
    WHERE id=?";

    $stmt=$conn->prepare($sql);
    $stmt->bind_param(
        "sii",
        $name,
        $membership,
        $id
    );

    if($stmt->execute()){
        header("Location:show_memberships.php?updated=1");
        exit();
    }
    else{
        echo "Error: ".$stmt->error;
    }
}
}
?>





<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../style/style.css">


    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <title>تعديل الاشتراك</title>
</head>
<body>
    <?php require_once "../includes/navbar.php" ?>

    <div class="container mt-5">

        <div class="card">

            <h4 class="card-header bg-warning text-white fw-bold p-3">  تعديل اشتراك</h4>
            <div class="card-body">
                <?php if(isset($error)){ ?>
                <div class="alert alert-danger">
                 <?= $error ?>
                </div>
            <?php } ?>

                <form action="" method="POST"  enctype="multipart/form-data">
                    <div class="row g-3">

                        <div class="col-md-4">
                            <label for="name" class="form-label fw-bold">اسم الاشتراك</label>
                            <input type="text" name="name" id="name" class="form-control"value="<?= htmlspecialchars($plan['name']) ?>" placeholder="ادخل الاسم">
                        </div>

 
 
                        <div class="col-md-4">
                            <label for="membership" class="form-label fw-bold">سعر الاشتراك</label>
                            <input type="number" name="membership" id="membership" class="form-control" value="<?= htmlspecialchars($plan['membership']) ?>" placeholder="ادخل السعر">
                        </div>


                        <div class="col-12 text-end mt-4">
                            <button type="submit" class="btn btn-warning btn-lg">
                                تعديل اشتراك
                            </button>
                            <a href="show_memberships.php" class="btn btn-secondary btn-lg">
                                إلغاء التعديل
                            </a>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>

 

</body>


</html>