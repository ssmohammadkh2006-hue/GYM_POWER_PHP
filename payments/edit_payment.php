<?php
require_once "../includes/auth.php";
require_once "../includes/database.php";

 

// التأكد من وجود ID

if(!isset($_GET['id'])){

    die("No ID");

}


$id = intval($_GET['id']);



// جلب بيانات الدفعة

$sql="
SELECT *
FROM payments
WHERE id=?
";

$stmt=$conn->prepare($sql);
$stmt->bind_param("i",$id);
$stmt->execute();
$result=$stmt->get_result();
$payment=$result->fetch_assoc();



if(!$payment){

    die("Payment Not Found");

}

$sqll="SELECT id,name FROM members ORDER BY name ASC";

$members=$conn->query($sqll);


$sql="SELECT id,name FROM membership_plans ORDER BY name ASC";
// جلب الاشتراكات

$plans=$conn->query($sql);


if($_SERVER['REQUEST_METHOD']=="POST"){
    $member_id=$_POST['member_id'] ?? "";
    $plan_id=$_POST['plan_id'] ?? "";
    $amount=$_POST['amount'] ?? 0;
    $payment_type=$_POST['payment_type'] ?? "";
    $payment_method=$_POST['payment_method'] ?? "";
    $payment_date=$_POST['payment_date'] ?? "";
    $notes=$_POST['notes'] ?? "";


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
    UPDATE payments SET 
    member_id=?,
    plan_id=?,
    amount=?,
    payment_type=?,
    payment_method=?,
    payment_date=?,
    notes=?
    WHERE id=?";

    $stmt=$conn->prepare($sql);
    $stmt->bind_param(
        "iiissssi",
        $member_id,
        $plan_id,
        $amount,
        $payment_type,
        $payment_method,
        $payment_date,
        $notes,
        $id

    );

    if($stmt->execute()){

        header("Location: payments.php?updated=1");
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
    
 

<title>تعديل دفعة</title>
</head>
<body>


<?php require_once "../includes/navbar.php"; ?>



<div class="container mt-5">


<div class="card">


<h4 class="card-header bg-warning text-white fw-bold">

تعديل الدفعة

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


<select name="member_id" class="form-select">


<?php while($m=$members->fetch_assoc()){ ?>


<option value="<?= $m['id']; ?>"
<?= $m['id']==$payment['member_id'] ? "selected":"" ?>
>

<?= $m['name']; ?>

</option>


<?php } ?>


</select>


</div>




<div class="col-md-6">
<label class="fw-bold">الاشتراك</label>
<select name="plan_id" class="form-select">

<?php while($p=$plans->fetch_assoc()){ ?>

<option value="<?= $p['id']; ?>"
<?= $p['id']==$payment['plan_id'] ? "selected":"" ?>
>
<?= $p['name']; ?>

</option>
<?php } ?>
</select>
</div>



<div class="col-md-4">
<label>المبلغ</label>
<input type="number" name="amount" class="form-control" value="<?= $payment['amount']; ?>">
</div>




<div class="col-md-4">
<label>نوع الدفعة</label>
<select name="payment_type" class="form-select">
<option <?= $payment['payment_type']=="دفعة أولى"?"selected":"" ?>>دفعة أولى</option>
<option <?= $payment['payment_type']=="دفعة ثانية"?"selected":"" ?>>دفعة ثانية</option>
<option <?= $payment['payment_type']=="تجديد اشتراك"?"selected":"" ?>>تجديد اشتراك</option>
</select>
</div>


<div class="col-md-4">
<label>
طريقة الدفع
</label>


<select name="payment_method" class="form-select">


<option <?= $payment['payment_method']=="نقدي"?"selected":"" ?>>
نقدي
</option>


<option <?= $payment['payment_method']=="تحويل"?"selected":"" ?>>
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
class="form-control"
value="<?= $payment['payment_date']; ?>">


</div>





<div class="col-md-6">


<label>
ملاحظات
</label>


<input type="text"
name="notes"
class="form-control"
value="<?= $payment['notes']; ?>">


</div>


</div>



<button class="btn btn-warning mt-4">

تعديل الدفعة

</button>


</form>


</div>


</div>


</div>


</body>

</html>