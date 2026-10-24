<?php
require __DIR__ . '/../helpers/auth.php';
adminOnly();

require __DIR__ . '/../config/database.php';
require __DIR__ . '/../helpers/functions.php';


// 🔍 search
if(isset($_GET['search']) && !empty($_GET['search'])){
    $search = clean($_GET['search']);

    $sql = "SELECT * FROM posts 
            WHERE title LIKE '%$search%' 
            OR content LIKE '%$search%'
            ORDER BY id DESC";
} else {
    $sql = "SELECT * FROM posts ORDER BY id DESC";
}

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>

<div class="container mt-5">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>M&A Blogs</h2>

        <div>
            <a class="btn btn-success btn-sm" href="addPost.php">Add new blog</a>
            <a href="addUser.php" class="btn btn-info btn-sm"> Add more Admins</a>
<a class="btn btn-danger btn-sm" href="../auth/logout.php">Logout</a>
        </div>
    </div>

    <!-- Search -->
    <form method="GET" class="d-flex mb-3">
        <input 
            type="text" 
            name="search" 
            class="form-control me-2"
            placeholder="Search posts..." 
            value="<?= isset($_GET['search']) ? $_GET['search'] : '' ?>"
        >
        <button class="btn btn-primary">Search</button>
    </form>

    <!-- Table -->
    <div class="card shadow">
        <div class="card-body">

            <table class="table table-bordered table-hover align-middle">

                <thead class="table-dark text-center">
                    <tr>
                        <th>Title</th>
                        <th>Content</th>
                        <th width="180">Actions</th>
                    </tr>
                </thead>

                <tbody>

                <?php if(mysqli_num_rows($result) > 0): ?>

                    <?php while($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['title']) ?></td>

                            <td>
                                <?= htmlspecialchars(substr($row['content'], 0, 60)) ?>...
                            </td>

                            <td class="text-center">
                                <a href="editPost.php?id=<?= $row['id'] ?>" 
                                   class="btn btn-warning btn-sm">
                                    Edit
                                </a>

                                <a href="deletePost.php?id=<?= $row['id'] ?>" 
                                   class="btn btn-danger btn-sm"
                                   onclick="return confirm('Are you sure?')">
                                    Delete
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>

                <?php else: ?>

                    <tr>
                        <td colspan="3" class="text-center text-muted">
                            No posts found
                        </td>
                    </tr>

                <?php endif; ?>

                </tbody>

            </table>

        </div>
    </div>

</div>

</body>
</html>