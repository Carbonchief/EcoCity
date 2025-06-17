<?php
session_start();
$logged_in = isset($_SESSION['logged_in']) && $_SESSION['logged_in'];
$upload_dir = __DIR__ . '/downloads/';
$posts_file = __DIR__ . '/posts.json';
$images_dir = __DIR__ . '/img/media_uploads/';

$response = ['success' => false, 'message' => ''];

if (isset($_POST['action'])) {
    switch ($_POST['action']) {
        case 'login':
            $user = $_POST['username'] ?? '';
            $pass = $_POST['password'] ?? '';
            if ($user === 'admin' && $pass === 'password') {
                $_SESSION['logged_in'] = true;
                $logged_in = true;
                $response['success'] = true;
                $response['message'] = 'Logged in.';
            } else {
                $response['message'] = 'Invalid credentials.';
            }
            break;
        case 'upload_file':
            if ($logged_in && isset($_FILES['file'])) {
                $target = $upload_dir . basename($_FILES['file']['name']);
                if (move_uploaded_file($_FILES['file']['tmp_name'], $target)) {
                    $response['success'] = true;
                    $response['message'] = 'File uploaded.';
                } else {
                    $response['message'] = 'Upload failed.';
                }
            } else {
                $response['message'] = 'Not logged in.';
            }
            break;
        case 'add_post':
            if ($logged_in) {
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
                    $response['success'] = true;
                    $response['message'] = 'Post added.';
                } else {
                    $response['message'] = 'Missing title or text.';
                }
            } else {
                $response['message'] = 'Not logged in.';
            }
            break;
        case 'status':
            $response['success'] = $logged_in;
            break;
        case 'logout':
            $_SESSION['logged_in'] = false;
            $response['success'] = true;
            break;
        default:
            $response['message'] = 'Unknown action.';
    }
}

header('Content-Type: application/json');
echo json_encode($response);
