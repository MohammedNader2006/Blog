<?php
require __DIR__ . '/../helpers/auth.php';
adminOnly();

require __DIR__ . '/../config/database.php';
require __DIR__ . '/../helpers/functions.php';

$errors = [];

// 🛡️ تأكد إن id موجود
if(!isset($_GET['id'])){
    header("location: dashboard.php");
    exit;
}

$id = (int) $_GET['id'];

$sql = "SELECT * FROM posts WHERE id='$id'";
$result = mysqli_query($conn, $sql);
$post = mysqli_fetch_assoc($result);

// لو البوست مش موجود
if(!$post){
    header("location: dashboard.php");
    exit;
}

if(isset($_POST['updatePost'])){

    $title = clean($_POST['title']);
    $content = clean($_POST['content']);

    if(empty($title)){
        $errors[] = "Title is required";
    }

    if(empty($content)){
        $errors[] = "Content is required";
    }

    if(empty($errors)){

        $sql = "UPDATE posts 
                SET title='$title', content='$content'
                WHERE id='$id'";

        mysqli_query($conn, $sql);

        header("location: dashboard.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Post</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>

<div class="container mt-5">

    <!-- Top Bar -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>✏️ Edit Post</h2>

        <div>
            <a href="dashboard.php" class="btn btn-secondary btn-sm">Dashboard</a>
            <a href="../auth/logout.php" class="btn btn-danger btn-sm">Logout</a>
        </div>
    </div>

    <!-- Card -->
    <div class="card shadow p-4" style="border-radius: 15px; max-width: 600px;">

        <!-- Errors -->
        <?php if(!empty($errors)): ?>
            <?php foreach($errors as $error): ?>
                <div class="alert alert-danger"><?= $error ?></div>
            <?php endforeach; ?>
        <?php endif; ?>

        <!-- Form -->
        <form method="POST">

            <div class="mb-3">
                <label class="form-label">Title</label>
                <input 
                    type="text" 
                    name="title" 
                    class="form-control" 
                    value="<?= htmlspecialchars($post['title']) ?>"
                >
            </div>

            <div class="mb-3">
                <label class="form-label">Content</label>
                <textarea 
                    name="content" 
                    class="form-control" 
                    rows="5"
                ><?= htmlspecialchars($post['content']) ?></textarea>
            </div>

            <button name="updatePost" class="btn btn-warning w-100">
                Update Post
            </button>

        </form>

    </div>

</div>

</body>
</html>