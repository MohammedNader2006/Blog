<?php
require __DIR__ . '/../helpers/auth.php';
adminOnly();

require __DIR__ . '/../config/database.php';
require __DIR__ . '/../helpers/functions.php';

$errors = [];
$success = "";


if(isset($_POST['addUser'])){

    $name = clean($_POST['name']);
    $email = clean($_POST['email']);
    $password = $_POST['password'];
    if(empty($name)) $errors[] = "Name required";
    if(!validateEmail($email)) $errors[] = "Invalid email";
    if(strlen($password) < 6) $errors[] = "Password too short";

    if(empty($errors)){

    // 🔍 check if email exists
    $check = mysqli_query($conn, "SELECT id FROM users WHERE email='$email'");

    if(mysqli_num_rows($check) > 0){
        $errors[] = "Email already exists";
    } else {

        $hashed = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (name,email,password,role) 
                VALUES ('$name','$email','$hashed','Admin')";

        if(mysqli_query($conn, $sql)){
            $success = "User added successfully";
        } else {
            $errors[] = "Error: " . mysqli_error($conn);
        }

    }
}
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Admin</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>

<div class="container mt-5">

    <!-- Top Bar -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>👤 Add Blog Partner</h2>

        <div>
            <a href="dashboard.php" class="btn btn-secondary btn-sm">Dashboard</a>
            <a href="../auth/logout.php" class="btn btn-danger btn-sm">Logout</a>
        </div>
    </div>

    <!-- Card -->
    <div class="card shadow p-4" style="max-width:500px; border-radius:15px;">

        <!-- Errors -->
        <?php if(!empty($errors)): ?>
            <?php foreach($errors as $e): ?>
                <div class="alert alert-danger"><?= $e ?></div>
            <?php endforeach; ?>
        <?php endif; ?>

        <!-- Success -->
        <?php if($success): ?>
            <div class="alert alert-success"><?= $success ?></div>
        <?php endif; ?>

        <!-- Form -->
        <form method="POST">

            <div class="mb-3">
                <label class="form-label">Name</label>
                <input 
                    type="text" 
                    name="name" 
                    class="form-control"
                    placeholder="Enter name"
                    value="<?= $_POST['name'] ?? '' ?>"
                >
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input 
                    type="email" 
                    name="email" 
                    class="form-control"
                    placeholder="Enter email"
                    value="<?= $_POST['email'] ?? '' ?>"
                >
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <input 
                    type="password" 
                    name="password" 
                    class="form-control"
                    placeholder="Enter password"
                >
            </div>

            <button name="addUser" class="btn btn-primary w-100">
                ➕ Add Admin
            </button>

        </form>

    </div>

</div>

</body>
</html>