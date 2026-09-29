<?php
require_once "../includes/auth.php";
require_once "../includes/database.php";

 

$search = $_GET['search'] ?? "";

if($search != ""){

$sql="
SELECT 
members.*,
trainers.name AS trainer_name,
membership_plans.name AS plan_name
FROM members 
LEFT JOIN trainers  
ON members.trainer_id = trainers.id 
LEFT JOIN membership_plans
ON members.plan_id = membership_plans.id
WHERE members.name LIKE ?
OR members.phone LIKE ?
ORDER BY members.id ASC
";


$stmt=$conn->prepare($sql);
$searchValue="%".$search."%";
$stmt->bind_param(
    "ss",
    $searchValue,
    $searchValue
);
$stmt->execute();
$result=$stmt->get_result();



}else{


$sql="
SELECT 
members.*,
trainers.name AS trainer_name,
membership_plans.name AS plan_name
FROM members 
LEFT JOIN trainers  
ON members.trainer_id = trainers.id 
LEFT JOIN membership_plans
ON members.plan_id = membership_plans.id
ORDER BY members.id ASC
";


$result=$conn->query($sql);


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
    
    <title>الأعضاء</title>
</head>
<body>
    <?php require_once "../includes/navbar.php" ?>


<div class="container mt-5">
       <div class="d-flex justify-content-between align-items-center">
            <h2 class="fw-bold">إدارة جميع المتدربين المسجلين في Gym Power</h2>
            <a href="add_members.php" class="btn btn-primary btn-lg">+ إضافة عضو</a>
       </div>


    <div class="card mt-5">
        <div class="card-body">

<form method="GET" class="row g-2 mb-3">

    <div class="col-md-8">
        <input type="text"  name="search"  class="form-control" placeholder="ابحث عن اسم العضو أو رقم الهاتف" value="<?= $_GET['search'] ?? '' ?>">
    </div>

    <div class="col-md-4">
        <button class="btn btn-primary w-100"> بحث</button>
    </div>

</form>
           

      <div class="table-responsive rounded ">
        <table class="table table-hover table-bordered text-center align-middle">
            <thead class="table-dark">
                 <tr>
                            <th>#</th>
                            <th>الصورة</th>
                            <th>الاسم</th>
                            <th>الهاتف</th>
                            <th>Email</th>
                            <th>العمر</th>
                            <th>الطول</th>
                            <th>الوزن</th>
                            <th>تاريخ التسجيل</th>
                            <th>المدرب</th>
                            <th>الاشتراك</th>
                            <th>الجنس</th>
                            <th>المدة</th>
                            <th>الإجراء</th>
                        </tr>

                    </thead>

                    <tbody>

                    <?php $id_number=1; while($row=$result->fetch_assoc()){ ?>

               
                        <tr>
                            <td><?= $id_number++; ?></td>
                            <td><img src="uploads/<?= $row['image'] ?>" width="50" height="50" class="rounded-circle" alt="Member"></td>
                            <td><?= $row['name'] ?></td>
                            <td><?= $row['phone'] ?></td>
                            <td><?= $row['email'] ?></td>
                            <td><?= $row['age'] ?></td>
                            <td><?= $row['height'] ?></td>
                            <td><?= $row['weight'] ?></td>
                            <td><?= $row['join_date'] ?></td>                            
                            <td><?= htmlspecialchars($row['trainer_name']) ?></td>
                            <td><?= htmlspecialchars($row['plan_name']) ?></td>
                            <td><?= $row['gender']=="male" ? "ذكر" : "أنثى" ?></td>
                            <td><span class="badge bg-info"><?= $row['subscription_duration'] ?></span></td>

                             
                            


                            <td>
                                <div class="d-flex gap-1 justify-content-center">

                                    <a href="edit_members.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm"> تعديل</a>

                                     <a href="delete_members.php?id=<?= $row['id']; ?>"
                                     class="btn btn-danger btn-sm"
                                     onclick="return confirm('هل تريد حذف العضو؟')">
                                     حذف
                                     </a>
                                </div>
                            </td>

                        </tr>
                    <?php }?>


            </tbody>
        </table>
      </div> 
    </div>
    </div>
</div>

 

<?php require_once"../includes/footer.php" ?>
 
</body>


</html>