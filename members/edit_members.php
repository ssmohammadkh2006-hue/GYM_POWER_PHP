<?php
require_once "../includes/auth.php";
require_once "../includes/database.php";
 

$trainers = $conn->query("SELECT id, name FROM trainers");
$plans= $conn->query("SELECT id, name FROM membership_plans");


if(!isset($_GET['id'])){
    die("No ID");
}


$id = $_GET['id'];

$sql="SELECT * FROM members WHERE id=?";

$stmt=$conn->prepare($sql);
$stmt->bind_param("i",$id);
$stmt->execute();

$result=$stmt->get_result();
$member=$result->fetch_assoc();

if($_SERVER['REQUEST_METHOD'] =="POST"){

    $name=trim($_POST['name'] ?? "");
    $phone=trim($_POST['phone'] ?? "");
    $email=trim($_POST['email'] ?? "");
    $age=$_POST['age'] ?? 0;
    $height=$_POST['height'] ?? 0;
    $weight=$_POST['weight'] ?? 0;
    $join_date=$_POST['join_date'] ?? "";
    $trainer_id=$_POST['trainer_id'] ?? "";
    $gender=$_POST['gender'] ?? "";
    $plan_id=$_POST['plan_id'] ?? "";
    $subscription_duration=$_POST['subscription_duration'] ?? "";

    $image = "";
    if(isset($_FILES['image']) && $_FILES['image']['error'] == 0){
    $image = $_FILES['image']['name'];
    $tmp_name = $_FILES['image']['tmp_name'];
    $upload_path = "uploads/" . $image;
    move_uploaded_file($tmp_name, $upload_path);

    }

    if(empty($name) || empty($phone) || empty($age) ||empty($join_date) ||empty($trainer_id)  ){
        $error="يرجى تعبئة جميع الحقول المطلوبة";
    }
    elseif($age <1 || $age >100){
        $error = "العمر غير صحيح";
    }
    elseif(!is_numeric($phone)){
        $error="رقم الهاتف يجب أن يحتوي أرقام فقط";
    }
    elseif(!is_numeric($height) || !is_numeric($weight)){
        $error = "الطول والوزن يجب أن يكون رقم";
    }
    elseif(!empty($email) and !filter_var($email, FILTER_VALIDATE_EMAIL)){
         $error = "البريد الإلكتروني غير صحيح";
    }
  
if(empty($error)){

    $sql="UPDATE members SET 
        name=?,
        phone=?,
        email=?,
        age=?,
        height=?,
        weight=?,
        gender=?,
        trainer_id=?,
        plan_id=?,
        subscription_duration=?,
        join_date=?
        WHERE id=?";

        $stmt = $conn->prepare($sql);


    $stmt->bind_param(
        "sssiiisisisi",
        $name,
        $phone,
        $email,
        $age,
        $height,
        $weight,
        $gender,
        $trainer_id,
        $plan_id,
        $subscription_duration,
        $join_date,
        $id
    );


    if($stmt->execute()){

        header("Location:show.php?updated=1");
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

    <title>تعديل عضو</title>

</head>

<body>

    <?php require_once "../includes/navbar.php" ?>


    <div class="container mt-5">

        <div class="card">

            <h4 class="card-header bg-warning fw-bold p-3"> تعديل بيانات العضو</h4>

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
                            <input type="text" name="name" id="name" class="form-control" value="<?= htmlspecialchars($member['name']) ?>" placeholder="ادخل الاسم">
                        </div>


                        <div class="col-md-4">
                            <label for="phone" class="form-label fw-bold">الهاتف</label>
                            <input type="tel" name="phone" id="phone" class="form-control" value="<?=   htmlspecialchars($member['phone']) ?>" placeholder="ادخل الهاتف">
                        </div>

                        <div class="col-md-4">
                            <label for="email" class="form-label fw-bold">Email</label>
                            <input type="email" name="email" id="email" class="form-control" value="<?= htmlspecialchars($member['email']) ?>" placeholder="ادخل Email">
                        </div>

                        <div class="col-md-4">
                            <label for="age" class="form-label fw-bold">العمر</label>
                            <input type="number" name="age" id="age" class="form-control" value="<?= htmlspecialchars($member['age']) ?>" placeholder="ادخل العمر">
                        </div>

                        <div class="col-md-4">
                            <label for="height" class="form-label fw-bold">الطول</label>
                            <input type="number" name="height" id="height" class="form-control" value="<?= htmlspecialchars($member['height']) ?>" placeholder="ادخل الطول">
                        </div>

                        
                        <div class="col-md-4">
                            <label for="weight" class="form-label fw-bold">الوزن</label>
                            <input type="number" name="weight" id="weight" class="form-control" value="<?= htmlspecialchars($member['weight']) ?>" placeholder="ادخل الوزن">
                        </div>



                        <div class="col-md-4">
                            <label for="date" class="form-label fw-bold">تاريخ التسجيل</label>
                            <input type="date" name="join_date" id="date" value="<?= htmlspecialchars($member['join_date']) ?>" class="form-control">
                        </div>

 

                        <div class="col-md-4">
                        <label for="trainer" class="form-label fw-bold"> المدرب المسؤول</label>
                        <select class="form-select" name="trainer_id" id="trainer" required>
                        <option value="" disabled>
                        اختر المدرب المسؤول
                        </option>
                        <?php while($trainer = $trainers->fetch_assoc()): ?>

                        <option 
                        value="<?= $trainer['id'] ?>"
                        <?= $member['trainer_id'] == $trainer['id'] ? "selected" : "" ?>
                        >
                        <?= htmlspecialchars($trainer['name']) ?>
                        </option>
                        <?php endwhile; ?>
                        </select>
                        </div>

                        <div class="col-md-4">
                            <label for="subscription" class="form-label fw-bold">نوع الاشتراك</label>
                            <select class="form-select" name="plan_id" id="subscription" required>
                                <option value=""   disabled>اختر نوع الاشتراك</option>
                            <?php while($plan=$plans->fetch_assoc()){ ?>

                                <option value="<?= $plan['id'] ?>"
                                    <?= $member['plan_id'] == $plan['id'] ? "selected" : "" ?>
                                >
                                <?= htmlspecialchars($plan['name']) ?>
                                </option>
                            <?php } ?>
                            </select>
                        </div>


                        <div class="col-md-4">
                            <label for="subscription_duration" class="form-label fw-bold">مدة الاشتراك</label>
                            <select class="form-select" name="subscription_duration" required>

<option value="" disabled>
اختر مدة الاشتراك
</option>


<option value="1_month"
<?= $member['subscription_duration']=="1_month" ? "selected":"" ?>>
شهر واحد
</option>


<option value="3_months"
<?= $member['subscription_duration']=="3_months" ? "selected":"" ?>>
3 أشهر
</option>


<option value="1_year"
<?= $member['subscription_duration']=="1_year" ? "selected":"" ?>>
سنة
</option>


</select>
                        </div>


                        <div class="col-md-4">
                            <label class="form-label fw-bold">الجنس</label>
                            <div class="d-flex gap-4 mt-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="gender" value="male" <?= $member['gender']=="male" ? "checked" : "" ?> id="male" value="male" required>
                                    <label class="form-check-label" for="male">ذكر</label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="gender" value="female" <?= $member['gender']=="female" ? "checked" : "" ?> id="female" value="female">
                                    <label class="form-check-label" for="female">أنثى</label>
                                </div>
                            </div>
                        </div>


                        <div class="col-md-8">
                            <label for="image" class="form-label fw-bold">تحميل صوره</label>
                            <input type="file" name="image" id="image" class="form-control" value="<?= htmlspecialchars($member['image']) ?>" accept="image/*">

                             
                        </div>


                        <div class="col-12 text-end mt-4">
                            <button type="submit" class="btn btn-warning btn-lg">
                                تعديل العضو
                            </button>
                            <a href="show.php" class="btn btn-secondary btn-lg">
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