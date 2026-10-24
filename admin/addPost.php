<?php 
require __DIR__ . '/../helpers/auth.php';
adminOnly();

require __DIR__ . '/../config/database.php';
require __DIR__ . '/../helpers/functions.php';

$errors = [];
$success = "";

if(isset($_POST['addPost'])){

    $title = clean($_POST['title']);
    $content = clean($_POST['content']);
    $user_id = $_SESSION['user']['id'];

    if(empty($title)){
        $errors[] = "Title is required";
    }

    if(empty($content)){
        $errors[] = "Content is required";
    }

    if(empty($errors)){

        $sql = "INSERT INTO posts (title, content, user_id) 
                VALUES ('$title','$content','$user_id')";

        if(mysqli_query($conn, $sql)){
            $success = "Post added successfully";
        } else {
            $errors[] = "Error: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Post</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>

<div class="container mt-5">

    <!-- Top Bar -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>📝 Add New Blog</h2>

        <div>
            <a href="dashboard.php" class="btn btn-secondary btn-sm">Dashboard</a>
            <a href="../auth/logout.php" class="btn btn-danger btn-sm">Logout</a>
        </div>
    </div>

    <!-- Card -->
    <div class="card shadow p-4" style="border-radius: 15px;">

        <!-- Errors -->
        <?php if(!empty($errors)): ?>
            <?php foreach($errors as $error): ?>
                <div class="alert alert-danger"><?= $error ?></div>
            <?php endforeach; ?>
        <?php endif; ?>

        <!-- Success -->
        <?php if($success): ?>
            <div class="alert alert-success"><?= $success ?></div>
        <?php endif; ?>

        <!-- Form -->
        <form method="POST">

            <div class="mb-3">
                <label class="form-label">Title</label>
                <input 
                    type="text" 
                    name="title" 
                    class="form-control" 
                    placeholder="Enter post title"
                    value="<?= isset($_POST['title']) ? htmlspecialchars($_POST['title']) : '' ?>"
                >
            </div>

            <div class="mb-3">
                <label class="form-label">Content</label>
                <textarea 
                    name="content" 
                    class="form-control" 
                    rows="5" 
                    placeholder="Write your post..."
                ><?= isset($_POST['content']) ? htmlspecialchars($_POST['content']) : '' ?></textarea>
            </div>

            <button name="addPost" class="btn btn-primary w-100" >
                ➕ Add Post
            </button>

        </form>

    </div>

</div>

</body>
</html>