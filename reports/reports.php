<?php
require_once "../includes/auth.php";
require_once "../includes/database.php";

 
//لوحة التحكم
$member_count=$conn->query("
        SELECT COUNT(*) AS total_members FROM members");
$members=$member_count->fetch_assoc();
$total_members=$members['total_members'] ?? 0;


$trainers_count=$conn->query("
        SELECT COUNT(*) AS total_trainers FROM trainers");
$trainers=$trainers_count->fetch_assoc();
$total_trainers=$trainers['total_trainers'] ?? 0;


$classes_count=$conn->query("
        SELECT COUNT(*) AS total_classes FROM classes");
$classes=$classes_count->fetch_assoc();
$total_classes=$classes['total_classes'] ?? 0;


$payment_sum=$conn->query("
       SELECT SUM(amount) AS total_income FROM payments");
$income =$payment_sum->fetch_assoc();
$total_income=$income['total_income'] ?? 0;


// التنبيهات 
$expired_query = $conn->query("
    SELECT COUNT(*) AS expired_members
    FROM members WHERE DATE_ADD(join_date, INTERVAL subscription_duration MONTH) < CURDATE()");
$expired = $expired_query->fetch_assoc();
$expired_members = $expired['expired_members'] ?? 0;

$soon_query = $conn->query("
    SELECT COUNT(*) AS soon_expire FROM members WHERE DATE_ADD(join_date, INTERVAL subscription_duration MONTH)
    BETWEEN CURDATE()
    AND DATE_ADD(CURDATE(), INTERVAL 7 DAY)");
$soon = $soon_query->fetch_assoc();
$soon_expire = $soon['soon_expire'] ?? 0;


$new_members_query = $conn->query("
    SELECT COUNT(*) AS new_members FROM members WHERE MONTH(join_date)=MONTH(CURRENT_DATE()) AND YEAR(join_date)=YEAR(CURRENT_DATE())");
$new_members = $new_members_query->fetch_assoc();
$this_month_members = $new_members['new_members'] ?? 0;



// تقرير المدفوعات

$today_payment_query = $conn->query("
    SELECT SUM(amount) AS today_income FROM payments WHERE DATE(payment_date) = CURDATE()");
$today_payment = $today_payment_query->fetch_assoc();
$today_income = $today_payment['today_income'] ?? 0;


$month_payment_query = $conn->query("
    SELECT SUM(amount) AS month_income FROM payments WHERE MONTH(payment_date) = MONTH(CURRENT_DATE())
    AND YEAR(payment_date) = YEAR(CURRENT_DATE())");
$month_payment = $month_payment_query->fetch_assoc();
$month_income = $month_payment['month_income'] ?? 0;


$week_payment_query = $conn->query("
    SELECT SUM(amount) AS week_income FROM payments WHERE YEARWEEK(payment_date, 1) = YEARWEEK(CURDATE(), 1)");
$week_payment = $week_payment_query->fetch_assoc();
$week_income = $week_payment['week_income'] ?? 0;


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
    
</head>
<body>
<?php require_once "../includes/navbar.php" ?>

<div class="container py-5">

    <div class="mb-5">
        <h3 class="mb-4"> لوحة التحكم</h3>
        <div class="row g-4">

            <div class="col-lg-3 col-md-6">
                <div class="card shadow-sm border-0 rounded-4 p-4 text-center">
                    <h5> إجمالي الأعضاء</h5>
                    <h2 class="text-primary"><?php echo $total_members ?></h2>
                    
                </div>
            </div>


            <div class="col-lg-3 col-md-6">
                <div class="card shadow-sm border-0 rounded-4 p-4 text-center">
                    <h5> المدربين</h5>
                    <h2 class="text-success"><?php echo $total_trainers ?></h2>
                   
                </div>
            </div>


            <div class="col-lg-3 col-md-6">
                <div class="card shadow-sm border-0 rounded-4 p-4 text-center">
                    <h5>الحصص</h5>
                    <h2 class="text-warning"><?php echo $total_classes ?></h2>
                     
                </div>
            </div>


            <div class="col-lg-3 col-md-6">
                <div class="card shadow-sm border-0 rounded-4 p-4 text-center">
                    <h5>  الإيرادات</h5>
                    <h2 class="text-danger"><?php echo$total_income?>$</h2>
                    
                </div>
            </div>

        </div>
    </div>


    <!-- Notifications -->
    <div class="mb-5">
        <h3 class="mb-4">  التنبيهات</h3>
        <div class="row g-4">

            <div class="col-lg-4">
                <div class="alert alert-danger rounded-4">
                    <h6> اشتراكات منتهية</h6>
                    <p class="mb-0"> يوجد  <?php echo$expired_members?> أعضاء انتهى اشتراكهم</p>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="alert alert-warning rounded-4">
                    <h6> اشتراكات قريبة الانتهاء </h6>
                    <p class="mb-0"> <?php echo $soon_expire ?> أعضاء خلال أسبوع</p>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="alert alert-info rounded-4">
                    <h6> أعضاء جدد</h6>
                    <p class="mb-0"> <?php echo $this_month_members ?> عضو جديد هذا الشهر</p>
                </div>
            </div>

        </div>
    </div>







    <!-- Reports -->


    <div>
        <h3 class="mb-4"> التقارير</h3>
        

            
                <div class="card shadow-sm border-0 rounded-4 p-4">
                    <h5 class="mb-3"> تقرير المدفوعات</h5>
                    <table class="table table-hover text-center">
                        <thead>
                            <tr>
                                <th>الفترة</th>
                                <th> المبلغ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><span  class="badge  bg-info">اليوم</span></td>
                                <td><?php echo $today_income; ?> $</td>
                            </tr>
                            <tr>
                                <td> <span  class="badge  bg-primary"> هذا الأسبوع</span></td>
                                <td><?php echo $week_income; ?> $</td>
                            </tr>
                            <tr>
                                <td><span  class="badge  bg-success"> هذا الشهر </span></td>
                                <td><?php echo $month_income; ?> $</td>
                            </tr>
                        </tbody>
                    </table>
                    </div>
                </div>

</div>
</body>
</html>