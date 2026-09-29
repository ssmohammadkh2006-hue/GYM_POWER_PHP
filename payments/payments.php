<?php
require_once "../includes/auth.php";
require_once "../includes/database.php";

 


$sql="
SELECT
payments.*,
members.name AS member_name,
membership_plans.name AS plan_name
FROM payments
LEFT JOIN members
ON payments.member_id = members.id
LEFT JOIN membership_plans
ON payments.plan_id = membership_plans.id
ORDER BY payments.id DESC ";
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
 
<title>المدفوعات</title>
</head>
<body>

<?php require_once "../includes/navbar.php"; ?>

<div class="container mt-5">

<div class="d-flex justify-content-between align-items-center">

<h2 class="fw-bold">
إدارة المدفوعات Gym Power
</h2>
<a href="add_payment.php"
class="btn btn-primary btn-lg">

+ إضافة دفعة
</a>
</div>

<div class="card mt-5">

<div class="card-body">

<div class="table-responsive">
<table class="table table-bordered table-hover text-center align-middle">
<thead class="table-dark">

<tr>
<th>#</th>
<th>العضو</th>
<th>الاشتراك</th>
<th>المبلغ</th>
<th>نوع الدفعة</th>
<th>التاريخ</th>
<th>الإجراء</th>
</tr>
</thead>
<tbody>
<?php
$i=1;
while($row=$result->fetch_assoc()){?>
<tr>
<td><?= $i++; ?></td>
<td><?= $row['member_name']; ?></td>
<td><?= $row['plan_name']; ?></td>
<td><?= $row['amount']; ?> شيكل</td>
<td><?= $row['payment_method']; ?></td>
<td><?= $row['payment_date']; ?></td>

<td>
<a href="edit_payment.php?id=<?= $row['id']; ?>"
class="btn btn-warning btn-sm">
تعديل
</a>

<a href="delete_payment.php?id=<?= $row['id']; ?>"
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
</body>
</html>