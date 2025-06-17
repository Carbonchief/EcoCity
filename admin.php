<?php
session_start();
$logged_in = isset($_SESSION['logged_in']) && $_SESSION['logged_in'];
$upload_dir = __DIR__ . '/downloads/';
$posts_file = __DIR__ . '/posts.json';
$images_dir = __DIR__ . '/img/media_uploads/';

// Handle login
if (isset($_POST['login'])) {
    $user = $_POST['username'] ?? '';
    $pass = $_POST['password'] ?? '';
    if ($user === 'admin' && $pass === 'password') {
        $_SESSION['logged_in'] = true;
        $logged_in = true;
    }
}

// Handle file upload
$message = '';
if ($logged_in && isset($_POST['upload_file']) && isset($_FILES['file'])) {
    $target = $upload_dir . basename($_FILES['file']['name']);
    if (move_uploaded_file($_FILES['file']['tmp_name'], $target)) {
        $message = 'File uploaded.';
    } else {
        $message = 'Upload failed.';
    }
}

// Handle post creation
if ($logged_in && isset($_POST['add_post'])) {
    $title = trim($_POST['title'] ?? '');
    $text = trim($_POST['text'] ?? '');
    $image_path = '';
    if (!empty($_FILES['post_image']['name'])) {
        $image_target = $images_dir . basename($_FILES['post_image']['name']);
        if (move_uploaded_file($_FILES['post_image']['tmp_name'], $image_target)) {
            $image_path = 'img/media_uploads/' . basename($_FILES['post_image']['name']);
        }
    }
    if ($title && $text) {
        $posts = file_exists($posts_file) ? json_decode(file_get_contents($posts_file), true) : [];
        $posts[] = ['title' => $title, 'text' => $text, 'image' => $image_path];
        file_put_contents($posts_file, json_encode($posts, JSON_PRETTY_PRINT));
        $message = 'Post added.';
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Admin Upload</title>
    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
</head>
<body class="p-4">
<div class="container">
    <h1>Admin Panel</h1>
    <?php if(!$logged_in): ?>
        <form method="post" class="mb-3" style="max-width:300px;">
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control">
            </div>
            <button class="btn btn-primary" name="login" value="1">Login</button>
        </form>
    <?php else: ?>
        <?php if($message): ?><div class="alert alert-info"><?php echo $message; ?></div><?php endif; ?>
        <h2>Upload Downloadable File</h2>
        <form method="post" enctype="multipart/form-data" class="mb-5">
            <div class="mb-3"><input type="file" name="file" class="form-control"></div>
            <button class="btn btn-primary" name="upload_file" value="1">Upload</button>
        </form>

        <h2>Add Media Post</h2>
        <form method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label">Title</label>
                <input type="text" name="title" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Text</label>
                <textarea name="text" class="form-control" rows="3" required></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Image</label>
                <input type="file" name="post_image" class="form-control">
            </div>
            <button class="btn btn-success" name="add_post" value="1">Add Post</button>
        </form>
    <?php endif; ?>
</div>
</body>
</html>
