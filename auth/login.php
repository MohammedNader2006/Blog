<?php
session_start();

require __DIR__ . '/../config/database.php';
require __DIR__ . '/../helpers/functions.php';

$errors = [];

if(isset($_POST['login'])){

    $email = clean($_POST['email']);
    $password = $_POST['password'];

    if(empty($email) || empty($password)){
        $errors[] = "All fields are required";
    }

    if(empty($errors)){

        $sql = "SELECT * FROM users WHERE email='$email'";
        $result = mysqli_query($conn, $sql);

        if(mysqli_num_rows($result) == 1){

            $user = mysqli_fetch_assoc($result);

            if(password_verify($password, $user['password'])){

                $_SESSION['user'] = $user;

                if($user['role'] == 'admin'){
                    header("location: ../admin/dashboard.php");
                } else {
                    header("location: ../index.php");
                }
                exit;

            } else {
                $errors[] = "Wrong password";
            }

        } else {
            $errors[] = "User not found";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Your CSS -->
    <link rel="stylesheet" href="../css/style.css">
</head>

<body class="bg-light">

<div class="container d-flex justify-content-center align-items-center vh-100">

   <div class="card auth-card shadow" style="width: 400px;">

        <h3 class="text-center mb-4"> Login</h3>

        <!-- Errors -->
        <?php if(!empty($errors)): ?>
            <?php foreach($errors as $error): ?>
                <div class="alert alert-danger"><?= $error ?></div>
            <?php endforeach; ?>
        <?php endif; ?>

        <!-- Form -->
        <form method="POST">

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" placeholder="Enter your email">
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Enter your password">
            </div>

            <button name="login" class="btn btn-primary w-100">
                Login
            </button>

        </form>

       

    </div>

</div>

</body>
</html>