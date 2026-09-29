<?php

require_once "includes/auth.php";
 
?>


<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style/style.css">


    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <title>الرئيسية</title>
</head>
<body>
    <?php require_once "includes/navbar.php" ?>

    <div class="container py-5">
    <div class="row align-items-center">
        <div class="col-lg-7">
            <h1 class="fw-bold display-5">
                إدارة ناديك الرياضي
                <br>
                أصبحت أسهل مع
                <span class="text-primary">
                    Gym Power
                </span>
            </h1>

            <p class="text-secondary fs-5 mt-4 lh-lg">
                نظام متكامل يساعدك على إدارة أعضاء النادي،
                متابعة الاشتراكات،
                تنظيم الحصص التدريبية،
                إدارة المدفوعات،
                ومراقبة أداء النادي بكل سهولة واحترافية.
            </p>

            <p class="text-muted mt-3">
                كل الأدوات التي تحتاجها لإدارة نادي رياضي ناجح
                في مكان واحد.</p>

            <div class="mt-4">
                <a href="members/show.php"
                   class="btn btn-primary btn-lg px-4">
                    إدارة الأعضاء
                </a>



                <a href="reports/reports.php"
                   class="btn btn-outline-secondary btn-lg px-4 ms-2">
                    عرض التقارير
                </a>
            </div>
        </div>


        <div class="col-lg-5 mt-5 mt-lg-0">
            <div class="card border-0 shadow-sm rounded-4 p-5 text-center">
                <h3 class="fw-bold">
                    Gym Power
                </h3>
                <p class="text-muted mt-3">
                    Smart Gym Management System
                </p>

                <hr>

                <div class="row text-center">
                    <div class="col-6 mb-3">
                        <h4 class="text-primary fw-bold">
                            100%
                        </h4>
                        <small>
                            تنظيم
                        </small>
                    </div>

                    <div class="col-6 mb-3">
                        <h4 class="text-success fw-bold">
                            Easy
                        </h4>
                        <small>
                            إدارة
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    
    
</body>
</html>