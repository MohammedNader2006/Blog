<?php
session_start();

require __DIR__ . '/../config/database.php';
require __DIR__ . '/../helpers/functions.php';

$errors = [];

if(isset($_POST['register'])){

    $name = clean($_POST['name']);
    $email = clean($_POST['email']);
    $password = $_POST['password'];

    // validation
    if(empty($name)){
        $errors[] = "Name is required";
    }

    if(!validateEmail($email)){
        $errors[] = "Invalid email";
    }

    if(!validatePassword($password)){
        $errors[] = "Password must be at least 6 characters";
    }

    if(empty($errors)){

        $hashed = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (name,email,password) 
                VALUES ('$name','$email','$hashed')";

        if(mysqli_query($conn, $sql)){
            header("location: login.php");  
            exit;
        } else {
            $errors[] = "Error: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Your CSS -->
    <link rel="stylesheet" href="../css/style.css">
</head>

<body class="bg-light">

<div class="container d-flex justify-content-center align-items-center vh-100">

  <div class="card auth-card shadow" style="width: 400px;">

        <h3 class="text-center mb-4"> Register</h3>

        <!-- Errors -->
        <?php if(!empty($errors)): ?>
            <?php foreach($errors as $error): ?>
                <div class="alert alert-danger"><?= $error ?></div>
            <?php endforeach; ?>
        <?php endif; ?>

        <!-- Form -->
        <form method="POST">

            <div class="mb-3">
                <label class="form-label">Name</label>
                <input 
                    type="text" 
                    name="name" 
                    class="form-control" 
                    placeholder="Enter your name"
                    value="<?= isset($_POST['name']) ? htmlspecialchars($_POST['name']) : '' ?>"
                >
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input 
                    type="email" 
                    name="email" 
                    class="form-control" 
                    placeholder="Enter your email"
                    value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>"
                >
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <input 
                    type="password" 
                    name="password" 
                    class="form-control" 
                    placeholder="Enter your password"
                >
            </div>

            <button name="register" class="btn btn-success w-100">
                Register
            </button>

        </form>

        <p class="text-center mt-3">
            Already have an account?
            <a href="login.php">Login</a>
        </p>

    </div>

</div>

</body>
</html>