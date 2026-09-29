<?php
require_once "../includes/auth.php";
require_once "../includes/database.php";


if(!isset($_GET['id'])){
    die("Class ID Missing");
}


$class_id = $_GET['id'];


// جلب بيانات الكلاس

$class_query = $conn->prepare("
SELECT 
classes.*,
trainers.name AS trainer_name

FROM classes

LEFT JOIN trainers 
ON classes.trainer_id = trainers.id

WHERE classes.id = ?
");


$class_query->bind_param("i",$class_id);
$class_query->execute();

$class = $class_query->get_result()->fetch_assoc();



if(!$class){
    die("Class Not Found");
}



// إضافة عضو

if($_SERVER["REQUEST_METHOD"]=="POST"){


    $name   = trim($_POST['name']);
    $phone  = trim($_POST['phone']);
    $age    = $_POST['age'];
    $gender = $_POST['gender'];



    // حساب عدد الأعضاء الحاليين

    $count_query = $conn->prepare("
    SELECT COUNT(*) AS total 
    FROM class_attendees
    WHERE class_id = ?
    ");


    $count_query->bind_param("i",$class_id);
    $count_query->execute();

    $current = $count_query
    ->get_result()
    ->fetch_assoc()['total'];



    if($current >= $class['max_limit']){


        echo "
        <script>
        alert('الحصة مكتملة لا يمكن إضافة عضو جديد');
        </script>
        ";


    }else{


        $insert = $conn->prepare("
        INSERT INTO class_attendees
        (class_id,name,phone,age,gender,join_date)

        VALUES (?,?,?,?,?,?)
        ");



        $date=date("Y-m-d");


        $insert->bind_param(
            "ississ",
            $class_id,
            $name,
            $phone,
            $age,
            $gender,
            $date
        );


        if($insert->execute()){


            header("Location: class_members.php?id=".$class_id);
            exit;


        }

    }

}



// جلب أعضاء الكلاس


$members = $conn->prepare("
SELECT * 
FROM class_attendees
WHERE class_id = ?

ORDER BY id DESC
");


$members->bind_param("i",$class_id);
$members->execute();


$result = $members->get_result();




// عدد المسجلين

$count = $conn->prepare("
SELECT COUNT(*) AS total
FROM class_attendees
WHERE class_id=?
");


$count->bind_param("i",$class_id);
$count->execute();


$total_members =
$count->get_result()->fetch_assoc()['total'];



?>


<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">


<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">


<link rel="stylesheet" href="../style/style.css">


<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800&display=swap" rel="stylesheet">


<title>أعضاء الحصة</title>


</head>


<body>


<?php require_once "../includes/navbar.php"; ?>



<div class="container mt-5">



<h2 class="fw-bold mb-4">

إدارة أعضاء الحصة:
<?= $class['name']; ?>

</h2>



<div class="card mb-4">

<div class="card-body">


<div class="row text-center">


<div class="col-md-3">

<h6>المدرب</h6>

<strong>
<?= $class['trainer_name']; ?>
</strong>

</div>



<div class="col-md-3">

<h6>اليوم</h6>

<strong>
<?= $class['day']; ?>
</strong>

</div>



<div class="col-md-3">

<h6>الساعة</h6>

<strong>
<?= $class['hour']; ?>
</strong>

</div>



<div class="col-md-3">

<h6>عدد المقاعد</h6>

<strong>

<?= $total_members; ?>

/

<?= $class['max_limit']; ?>

</strong>


</div>


</div>


</div>

</div>





<!-- الفورم -->


<div class="card">


<div class="card-header bg-primary text-white">

إضافة عضو للحصة

</div>



<div class="card-body">


<form method="POST">



<div class="row">



<div class="col-md-6 mb-3">

<label>اسم العضو</label>

<input type="text" 
name="name"
class="form-control"
required>

</div>



<div class="col-md-6 mb-3">

<label>رقم الهاتف</label>

<input type="text"
name="phone"
class="form-control">

</div>



<div class="col-md-6 mb-3">

<label>العمر</label>

<input type="number"
name="age"
class="form-control">

</div>




<div class="col-md-6 mb-3">


<label>الجنس</label>


<select name="gender" class="form-select">


<option value="ذكر">
ذكر
</option>


<option value="أنثى">
أنثى
</option>


</select>


</div>



</div>



<button class="btn btn-success">

+ إضافة

</button>


</form>


</div>

</div>






<!-- الجدول -->


<div class="card mt-5">


<div class="card-header">

الأعضاء المسجلين

</div>


<div class="card-body">


<div class="table-responsive">


<table class="table table-bordered table-hover text-center">


<thead class="table-dark">


<tr>

<th>#</th>

<th>الاسم</th>

<th>الهاتف</th>

<th>العمر</th>

<th>الجنس</th>

<th>التاريخ</th>

<th>حذف</th>


</tr>


</thead>



<tbody>


<?php 

$i=1;

while($row=$result->fetch_assoc()){

?>


<tr>


<td>
<?= $i++; ?>
</td>


<td>
<?= $row['name']; ?>
</td>


<td>
<?= $row['phone']; ?>
</td>


<td>
<?= $row['age']; ?>
</td>


<td>
<?= $row['gender']; ?>
</td>


<td>
<?= $row['join_date']; ?>
</td>


<td>


<a href="delete_class_member.php?id=<?= $row['id']; ?>&class=<?= $class_id; ?>"
class="btn btn-danger btn-sm">

حذف

</a>


</td>



</tr>



<?php } ?>



</tbody>


</table>


</div>


</div>


</div>



</div>





<?php require_once "../includes/footer.php"; ?>


</body>


</html>