<?php
require_once "../includes/auth.php";
require_once "../includes/database.php";

 

if(!isset($_GET['id'])){
    die("No ID");
}

$id = $_GET['id'];

// جلب بيانات المدرب
$sql="SELECT * FROM trainers WHERE id=?";
$stmt=$conn->prepare($sql);
$stmt->bind_param("i",$id);
$stmt->execute();
$result=$stmt->get_result();
$trainer=$result->fetch_assoc();

if(!$trainer){

    die("Trainer not found");

}

if($_SERVER['REQUEST_METHOD']=="POST"){

    $name=trim($_POST['name'] ?? "");
    $phone=trim($_POST['phone'] ?? "");
    $email=trim($_POST['email'] ?? "");
    $age=$_POST['age'] ?? 0;
    $join_date=$_POST['join_date'] ?? "";
    $gender=$_POST['gender'] ?? "";

if(empty($name) || empty($phone) || empty($age) || empty($gender) || empty($join_date)){
    $error = "يرجى تعبئة جميع الحقول المطلوبة";
}
elseif($age < 1 || $age > 100){
    $error = "العمر غير صحيح";
}
elseif(!is_numeric($phone)){
    $error = "رقم الهاتف يجب أن يكون أرقام فقط";
}
elseif(!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)){
    $error = "البريد الإلكتروني غير صحيح";
}


    
    $image=$trainer['image'];

    if(isset($_FILES['image']) && $_FILES['image']['error']==0){

        $image=$_FILES['image']['name'];
        $tmp_name=$_FILES['image']['tmp_name'];
        $upload_path="uploads/".$image;
        move_uploaded_file($tmp_name,$upload_path);

    }
if(empty($error)){
    $sql="UPDATE trainers SET
    name=?,
    phone=?,
    email=?,
    age=?,
    join_date=?,
    gender=?,
    image=?
    WHERE id=?";

    $stmt=$conn->prepare($sql);
    $stmt->bind_param(
        "sssisssi",
        $name,
        $phone,
        $email,
        $age,
        $join_date,
        $gender,
        $image,
        $id
    );

    if($stmt->execute()){
        header("Location:show_trainers.php?updated=1");
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
    
    <title>تعديل مدرب</title>
</head>
<body>
    <?php require_once "../includes/navbar.php" ?>

    <div class="container mt-5">

        <div class="card">

            <h4 class="card-header bg-warning text-white fw-bold p-3">تعديل المدرب</h4>
            <div class="card-body">
       <?php if(isset($error)){ ?>
                <div class="alert alert-danger">
                 <?= $error ?>
                </div>
            <?php } ?>
                <form action="" method="POST"  enctype="multipart/form-data">
                    <div class="row g-3">

                        <div class="col-md-4">
                            <label for="name" class="form-label fw-bold">الاسم</label>
                            <input type="text" name="name" id="name" class="form-control" value="<?= htmlspecialchars($trainer['name']) ?>" placeholder="ادخل الاسم">
                        </div>

                        <div class="col-md-4">
                            <label for="phone" class="form-label fw-bold">الهاتف</label>
                            <input type="tel" name="phone" id="phone" class="form-control" value="<?= htmlspecialchars($trainer['phone']) ?>" placeholder="ادخل الهاتف">
                        </div>

                        <div class="col-md-4">
                            <label for="email" class="form-label fw-bold">Email</label>
                            <input type="email" name="email" id="email" class="form-control" value="<?= htmlspecialchars($trainer['email']) ?>" placeholder="ادخل Email">
                        </div>

                        <div class="col-md-4">
                            <label for="age" class="form-label fw-bold">العمر</label>
                            <input type="number" name="age" id="age" class="form-control" value="<?= htmlspecialchars($trainer['age']) ?>" placeholder="ادخل العمر">
                        </div>
 
                        <div class="col-md-4">
                            <label for="date" class="form-label fw-bold">تاريخ التسجيل</label>
                            <input type="date" name="join_date" id="date" value="<?= htmlspecialchars($trainer['join_date']) ?>" class="form-control">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-bold">الجنس</label>
                            <div class="d-flex gap-4 mt-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="gender" id="male" value="male" <?= $trainer['gender']=="male" ? "checked":"" ?> required>
                                    <label class="form-check-label" for="male">ذكر</label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="gender" id="female" value="female" <?= $trainer['gender']=="female" ? "checked":"" ?>>>
                                    <label class="form-check-label" for="female">أنثى</label>
                                </div>
                            </div>
                        </div>


                        <div class="col-md-8">
                            <label for="image" class="form-label fw-bold">تحميل صوره المدرب</label>
                            <input type="file" name="image" id="image" class="form-control" accept="image/*">

                             
                        </div>


                        <div class="col-12 text-end mt-4">
                            <button type="submit" class="btn btn-warning btn-lg">
                              تعديل المدرب
                            </button>
                            <a href="show_trainers.php" class="btn btn-secondary btn-lg">
                            إلغاء التعديل
                            </a>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>

<?php require_once"../includes/footer.php" ?>
</body>


</html>