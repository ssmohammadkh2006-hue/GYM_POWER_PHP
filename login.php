<?php

session_start();
require_once "includes/database.php";

if($_SERVER["REQUEST_METHOD"]=="POST"){

    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username=?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s",$username);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows == 1){
        $user = $result->fetch_assoc();
        if($password == $user['password']){

            $_SESSION['username']=$user['username'];
            header("Location:index.php");
            exit;
        }
        else{
            $error="كلمة المرور غير صحيحة";
        }
    }
    else{
        $error="اسم المستخدم غير موجود";
    }
}

?>



<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    
    <link rel="stylesheet" href="style/style.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <title>تسجيل الدخول</title>
</head>
<body>


<div class="container">
    <div class="d-flex justify-content-center align-items-center vh-100">
        <div class="card shadow" style="width:500px;">
            <h3 class="card-header bg-primary text-white text-center"> تسجيل الدخول</h3>
            <div class="card-body">
                <form action="" method="POST">
                    <div class="mb-3">
                        <label class="form-label">اسم المستخدم</label>
                        <input type="text"  name="username" class="form-control" placeholder="ادخل اسم المستخدم" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label"> كلمة المرور</label>
                        <input type="password"  name="password"  class="form-control"  placeholder="ادخل كلمة المرور" required>
                    </div>

                    <button 
                    type="submit"
                    class="btn btn-primary w-100">

                        دخول
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

</body>
</html>