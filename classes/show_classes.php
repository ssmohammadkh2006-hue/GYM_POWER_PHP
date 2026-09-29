<?php
require_once "../includes/auth.php";
require_once "../includes/database.php";


$sql="SELECT * FROM classes ORDER BY id ASC";

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
    
    <title>الأعضاء</title>
</head>
<body>
    <?php require_once "../includes/navbar.php" ?>


<div class="container mt-5">

       <div class="d-flex justify-content-between align-items-center">

            <h2 class="fw-bold">إدارة جميع الحصص في Gym Power</h2>

            <a href="add_classes.php" class="btn btn-primary btn-lg">+ إضافة حصة</a>
       </div>


    <div class="card mt-5">
        <div class="card-body">

      <div class="table-responsive rounded ">
        <table class="table table-hover table-bordered text-center align-middle">
            <thead class="table-dark">
                 <tr>
                            <th>#</th>
                            <th>اسم الحصه</th>
                            <th>اسم المدرب</th>
                            <th>الايام</th>
                            <th>الساعه</th>
                            <th>الحد الاعلى</th>
                            <th>الحاله</th>
                            <th>الإجراء</th>
                        </tr>

                    </thead>

                    <tbody>

                    <?php $id_number=1; while($row=$result->fetch_assoc()){ ?>
                        <tr>
                            <td><?= $id_number++; ?></td>
                            <td><?= $row['name'] ?></td>
                            <td><?= $row['trainer_id'] ?></td>
                            <td><?= $row['day'] ?></td>
                            <td><?= $row['hour'] ?></td>
                            <td><?= $row['max_limit'] ?></td>
                            <td><span class="badge bg-success">متاحة</span></td>
                            <td>
                                <div class="d-flex gap-1 justify-content-center">

                                    <a href="class_members.php?id=<?= $row['id'] ?>" 
                                    class="btn btn-primary btn-sm">
                                    إضافة أعضاء
                                    </a>
                                    <a href="edit_classes.php?id=<?= $row['id']; ?>" 
                                    class="btn btn-warning btn-sm">
                                    تعديل
                                    </a>
                                    <a href="delete_classes.php?id=<?= $row['id']; ?>"
                                     class="btn btn-danger btn-sm"
                                     onclick="return confirm('هل تريد حذف الحصه؟')">
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