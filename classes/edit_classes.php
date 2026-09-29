<?php

require_once "../includes/auth.php";
require_once "../includes/database.php";

$trainers = $conn->query("
SELECT id,name 
FROM trainers
ORDER BY name ASC
");


if(!isset($_GET['id'])){

    die("No ID");
}

$id = $_GET['id'];

$sql="SELECT * FROM classes WHERE id=?";

$stmt=$conn->prepare($sql);
$stmt->bind_param("i",$id);
$stmt->execute();

$result=$stmt->get_result();
$class=$result->fetch_assoc();

if(!$class){

    die("Class Not Found");

}


// تحديث الحصة

if($_SERVER['REQUEST_METHOD'] =="POST"){

    $name=trim($_POST['name'] ?? "");
    $trainer_id =trim($_POST['trainer_id'] ?? "");
    $day=trim($_POST['day'] ?? "");
    $hour=trim($_POST['hour'] ?? "");
    $max_limit=trim($_POST['max_limit'] ?? 0);


if(empty($name) || empty($trainer_id) || empty($day) || empty($hour) || empty($max_limit)){
    $error="يرجى تعبئة جميع الحقول المطلوبة";
}
elseif(!is_numeric($max_limit)){
    $error="الحد الأعلى يجب أن يكون رقم";
}
elseif($max_limit <= 0){
    $error="الحد الأعلى يجب أن يكون أكبر من صفر";
}

    if(empty($error)){
    $sql="UPDATE classes SET
        name=?,
        trainer_id=?,
        day=?,
        hour=?,
        max_limit=?

        WHERE id=?";
    $stmt=$conn->prepare($sql);
    $stmt->bind_param(
        "sissii",

        $name,
        $trainer_id,
        $day,
        $hour,
        $max_limit,
        $id

    );

    if($stmt->execute()){

        header("Location: classes.php?updated=1");
     exit();
    }else{
        echo $stmt->error;
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
    
    <title>إضافة عضو</title>
</head>
<body>
    <?php require_once "../includes/navbar.php" ?>

    <div class="container mt-5">

        <div class="card">

            <h4 class="card-header bg-warning text-white fw-bold p-3">تعديل الحصة</h4>
            <div class="card-body">
<?php if(isset($error)){ ?>

<div class="alert alert-danger">

<?= $error ?>

</div>

<?php } ?>
                <form action="" method="POST" >
                    <div class="row g-3">

                        <div class="col-md-4">
                            <label for="name" class="form-label fw-bold">الاسم</label>
                            <input type="text" name="name" id="name" class="form-control" value="<?= $class['name']; ?>" placeholder="ادخل الاسم">
                        </div>


                        <div class="col-md-4">
                            <label for="trainer" class="form-label fw-bold">اسم المدرب</label>
                            <select class="form-select" name="trainer" required>

                            <option disabled>
                            اختر المدرب
                            </option>


                            <?php while($trainer=$trainers->fetch_assoc()){ ?>


                            <option 
                            value="<?= $trainer['id']; ?>"
                            <?= $trainer['id']==$class['trainer_id'] ? "selected" : "" ?>
                            >

                            <?= $trainer['name']; ?>

                            </option>


                            <?php } ?>


                            </select>                           
                        </div>
 
                        
                        <div class="col-md-4">
                            <label for="day" class="form-label fw-bold">الايام</label>
                            <input type="text" name="day" id="day" class="form-control" value="<?= $class['day']; ?>" placeholder="ادخل الوزن">
                        </div>



                        <div class="col-md-4">
                            <label for="hour" class="form-label fw-bold">الساعة</label>
                            <input type="text" name="hour" id="hour" value="<?= $class['hour']; ?>" class="form-control">
                        </div>


                        <div class="col-md-4">
                            <label for="limit" class="form-label fw-bold">الحد الاعلى</label>
                            <input type="number" name="max_limit" id="limit" value="<?= $class['max_limit']; ?>" class="form-control">
                        </div>
 
                        <div class="col-12 text-end mt-4">
                            <button type="submit" class="btn btn-warning btn-lg">
                                 تعديل الحصة  
                            </button>
                            <a href="show_classes.php" class="btn btn-secondary btn-lg">
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