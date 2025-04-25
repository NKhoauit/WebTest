<?php
session_start();
require 'db.php';

// Kiểm tra nếu chưa đăng nhập thì chuyển hướng về trang login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

$username = $_SESSION['username'];

// Xử lý logout
if (isset($_POST['Logout'])) {
    session_destroy();
    header("Location: login.php");
    exit;
}

// Xử lý đăng bài
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['content'])) {
    $content = trim($_POST['content']);
    if (!empty($content)) {
        $stmt = $conn->prepare("INSERT INTO posts (content, username) VALUES (:content, :username)");
        $stmt->execute([
            'content' => $content,
            'username' => $username
        ]);
    }
}

// Lấy danh sách bài viết
$stmt = $conn->query("SELECT * FROM posts ORDER BY id DESC");
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- Hiển thị giao diện đăng bài viết -->
<!DOCTYPE html>
<html>
<head>
    <title>Trang chủ</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <div class="header-bar">
        <div><strong>Xin chào, <?= htmlspecialchars($username) ?>!</strong></div>
        <form method="POST">
            <button class="logout-btn" type="submit" name="Logout">Logout</button>
        </form>
    </div>

    <!-- Form đăng bài -->
    <form method="POST" class="form">
        <div class="input-group">
            <textarea name="content" rows="4" placeholder="Nhập nội dung bài viết..." required></textarea>
        </div>
        <button type="submit" class="submit-btn">Đăng bài</button>
    </form>

    <!-- Hiển thị bài viết -->
    <h3 style="margin-top: 30px;">📜 Bài viết gần đây:</h3>
    <div>
        <?php if (empty($posts)): ?>
            <p>Chưa có bài viết nào.</p>
        <?php else: ?>
            <?php foreach ($posts as $post): ?>
                <div class="post">
                    <p><?= htmlspecialchars($post['content']) ?></p>
                    <small>👤 <?= htmlspecialchars($post['username']) ?> | 🕒 <?= $post['created_at'] ?></small>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
</body>
</html>
