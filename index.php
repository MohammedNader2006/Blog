<?php
require __DIR__ . '/config/database.php';

if(isset($_GET['search']) && !empty($_GET['search'])){
    $search = mysqli_real_escape_string($conn, $_GET['search']);

    $sql = "SELECT posts.*, users.name AS author
            FROM posts
            JOIN users ON posts.user_id = users.id
            WHERE posts.title LIKE '%$search%' 
            OR posts.content LIKE '%$search%'
            ORDER BY posts.id DESC";
} else {
    $sql = "SELECT posts.*, users.name AS author
            FROM posts
            JOIN users ON posts.user_id = users.id
            ORDER BY posts.id DESC";
}

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Blog</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

<!-- Navbar -->
<nav class="navbar navbar-dark bg-dark px-4">
    <span class="navbar-brand">📰 Our Blogs</span>

    <a href="auth/login.php" class="btn btn-outline-light btn-sm">
        Login As admin
    </a>
</nav>

<!-- Search -->
<div class="container mt-4">
    <form method="GET" class="d-flex mb-4">
        <input 
            type="text" 
            name="search" 
            class="form-control me-2"
            placeholder="Search posts..."
            value="<?= isset($_GET['search']) ? $_GET['search'] : '' ?>"
        >
        <button class="btn btn-primary">Search</button>
    </form>
</div>


<div class="container mt-3">

    <div class="row">

        <?php if(mysqli_num_rows($result) > 0): ?>

            <?php while($post = mysqli_fetch_assoc($result)) : ?>

                <div class="col-lg-4 col-md-6 col-sm-12 mb-4">

                    <div class="card shadow h-100">

                        <div class="card-body d-flex flex-column">

                            <!-- Title -->
                            <h5 class="card-title">
                                <?= htmlspecialchars($post['title']) ?>
                            </h5>

                            <!-- Content -->
                            <p class="card-text text-muted">
                                <?= htmlspecialchars(substr($post['content'], 0, 120)) ?>...
                            </p>

                            <!-- Author + Date -->
                            <small class="text-muted mb-3">
                                By: <?= htmlspecialchars($post['author']) ?> |
                                Posted at: <?= htmlspecialchars($post['created_at']) ?>
                            </small>

                            <!-- Button -->
                            <div class="mt-auto">
                                <a href="post.php?id=<?= $post['id'] ?>" class="btn btn-primary btn-sm">
                                    Read More
                                </a>
                            </div>

                        </div>

                    </div>

                </div>

            <?php endwhile; ?>

        <?php else: ?>

            <p class="text-center">No posts available</p>

        <?php endif; ?>

    </div>

</div>

</body>
</html>