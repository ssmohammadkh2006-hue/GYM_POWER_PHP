<?php
require_once "../includes/auth.php";
require_once "../includes/database.php";

 

$sql="SELECT * FROM trainers ORDER BY id ASC";


$result=$conn->query($sql);



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
    
    <title>عرض المدربين</title>
</head>
<body>
    <?php require_once "../includes/navbar.php" ?>


<div class="container mt-5">

       <div class="d-flex justify-content-between align-items-center">

            <h2 class="fw-bold">إدارة جميع المدربين في Gym Power</h2>

            <a href="add_trainers.php" class="btn btn-primary btn-lg">+ إضافة مدرب</a>
       </div>


    <div class="card mt-5">
        <div class="card-body">

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
                            <th>تاريخ التسجيل</th>                                              
                            <th>الجنس</th>
                            <th>الإجراء</th>
                        </tr>

                    </thead>

                    <tbody>

                    <?php $id_number=1; while($row= $result ->fetch_assoc()){ ?>
                        <tr>

                            <td><?=   $id_number ++; ?></td>
                            <td><img src="uploads/<?= $row['image']; ?>" width="50" height="50" class="rounded-circle" alt="Member"></td>
                            <td><?= $row['name'] ?></td>
                            <td><?= $row['phone'] ?></td>
                            <td><?= $row['email'] ?></td>
                            <td><?= $row['age'] ?></td>                                                
                            <td><?= $row['join_date'] ?></td>                        
                            <td><?= $row['gender'] == "male" ? "ذكر" : "أنثى"; ?></td>


                            <td>
                                <div class="d-flex gap-1 justify-content-center">

                                    <a href="edit_trainers.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm"> تعديل</a>
                                    
                                    <a href="delete_trainers.php?id=<?= $row['id'] ?>"
                                     class="btn btn-danger btn-sm"
                                     onclick="return confirm('هل تريد حذف العضو؟')">
                                     حذف
                                     </a>
                                </div>
                            </td>

                        </tr>


                <?php } ?>
            </tbody>
        </table>
      </div> 
    </div>
    </div>
</div>

 

<?php require_once"../includes/footer.php" ?> 
</body>


</html>