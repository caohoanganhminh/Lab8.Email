<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>DEMO GỬI EMAIL</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
</head>
<body>
<div class="container mt-4" style="max-width:720px">
    <h2>Email tới bạn</h2>

    <?php if (isset($_GET['status'])): ?>
        <div class="alert alert-<?= $_GET['status'] === 'ok' ? 'success' : 'danger' ?>">
            <?= $_GET['status'] === 'ok' ? 'Đã gửi mail thành công!' : 'Gửi mail thất bại: ' . htmlspecialchars($_GET['msg'] ?? '') ?>
        </div>
    <?php endif; ?>

    <form action="mail.php" enctype="multipart/form-data" method="POST">
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" class="form-control" name="email" placeholder="Email" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Subject</label>
            <input type="text" class="form-control" name="tieude" placeholder="Tiêu đề" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Nội dung</label>
            <textarea name="content" id="editor" class="form-control"></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">File đính kèm</label>
            <input type="file" class="form-control" name="file">
        </div>
        <button type="submit" class="btn btn-primary">Gửi</button>
    </form>
</div>
<script>CKEDITOR.replace('editor');</script>
</body>
</html>