<?php
require_once "../includes/auth.php";
require_once "../includes/database.php";

 

$members=$conn->query("SELECT id,name FROM members ORDER BY name");

$plans=$conn->query("SELECT id,name FROM membership_plans ORDER BY name");

if($_SERVER["REQUEST_METHOD"]=="POST"){


$member_id=trim($_POST['member_id']);
$plan_id=trim($_POST['plan_id']);
$amount=trim($_POST['amount']);
$payment_type=trim($_POST['payment_type']);
$payment_method=trim($_POST['payment_method']);
$payment_date=trim($_POST['payment_date']);
$notes=trim($_POST['notes']);

if(empty($member_id) || empty($plan_id) || empty($amount) || empty($payment_type) || empty($payment_method) || empty($payment_date)){
    $error="يرجى تعبئة جميع الحقول المطلوبة";
}
elseif(!is_numeric($amount)){
    $error="المبلغ يجب أن يكون رقم";
}
elseif($amount <= 0){
    $error="المبلغ يجب أن يكون أكبر من صفر";
}


if(empty($error)){

$sql="
INSERT INTO payments
(member_id,plan_id,amount,payment_type,payment_method,payment_date,notes)
VALUES (?,?,?,?,?,?,?)
";


$stmt=$conn->prepare($sql);

$stmt->bind_param(
"iiissss",
$member_id,
$plan_id,
$amount,
$payment_type,
$payment_method,
$payment_date,
$notes
);

if($stmt->execute()){
    header("Location: payments.php");
    exit();
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


<h4 class="card-header bg-primary text-white">
إضافة دفعة
</h4>


<div class="card-body">
            <?php if(isset($error)){ ?>
                <div class="alert alert-danger">
                 <?= $error ?>
                </div>
            <?php } ?>

<form method="POST">


<div class="row g-3">


<div class="col-md-6">

<label class="fw-bold">
العضو
</label>


<select name="member_id"
class="form-select">


<?php while($m=$members->fetch_assoc()){ ?>


<option value="<?= $m['id']; ?>">

<?= $m['name']; ?>

</option>


<?php } ?>


</select>

</div>



<div class="col-md-6">


<label class="fw-bold">
الاشتراك
</label>


<select name="plan_id"
class="form-select">


<?php while($p=$plans->fetch_assoc()){ ?>


<option value="<?= $p['id']; ?>">

<?= $p['name']; ?>

</option>


<?php } ?>


</select>


</div>



<div class="col-md-4">

<label>
المبلغ
</label>

<input type="number"
name="amount"
class="form-control">

</div>



<div class="col-md-4">

<label>
نوع الدفعة
</label>


<select name="payment_type"
class="form-select">

<option>
دفعة أولى
</option>

<option>
دفعة ثانية
</option>

<option>
تجديد اشتراك
</option>


</select>


</div>



<div class="col-md-4">

<label>
طريقة الدفع
</label>


<select name="payment_method"
class="form-select">

<option>
نقدي
</option>

<option>
تحويل
</option>


</select>


</div>



<div class="col-md-6">


<label>
تاريخ الدفع
</label>


<input type="date"
name="payment_date"
class="form-control">


</div>



<div class="col-md-6">


<label>
ملاحظات
</label>


<input type="text"
name="notes"
class="form-control">


</div>


</div>


<button class="btn btn-success mt-4">

حفظ الدفعة

</button>



</form>


</div>

</div>

</div>

</body>


</html>