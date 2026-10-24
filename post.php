<?php
require __DIR__ . '/config/database.php';

if(!isset($_GET['id'])){
    header("location: index.php");
    exit;
}

$id = (int) $_GET['id'];

$sql = "SELECT * FROM posts WHERE id='$id'";
$result = mysqli_query($conn, $sql);
$post = mysqli_fetch_assoc($result);

if(!$post){
    header("location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title><?= htmlspecialchars($post['title']) ?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

<!-- Navbar -->
<nav class="navbar navbar-dark bg-dark px-4">
    <a href="index.php" class="navbar-brand">📰 My Blog</a>
</nav>

<div class="container mt-5">

    <div class="card shadow p-4">

       <h2 class="post-title">
    <?= htmlspecialchars($post['title'] ?? 'No Title') ?>
</h2>

        <hr>

        <p class="mt-3" style="line-height:1.8;">
            <?= nl2br(htmlspecialchars($post['content'])) ?>
        </p>

    </div>

</div>

</body>
</html>