<?php

require __DIR__ . '/config.php';

$ketqua = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nguon  = $_POST['nguon'] ?? 'tay';
    $tieude = trim($_POST['tieude'] ?? '');
    $noidung = $_POST['content'] ?? '';
    $emails = [];

    if ($nguon === 'sql') {
       
        try {
            $pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4', DB_USER, DB_PASS);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $emails = $pdo->query('SELECT email FROM khachhang')->fetchAll(PDO::FETCH_COLUMN);
        } catch (PDOException $e) {
            $ketqua[] = ['', false, 'Lỗi CSDL: ' . $e->getMessage()];
        }
    } else {
       
        $emails = preg_split('/[\s,;]+/', $_POST['recipients'] ?? '', -1, PREG_SPLIT_NO_EMPTY);
    }

   
    $emails = array_unique(array_filter(array_map('trim', $emails), fn($e) => filter_var($e, FILTER_VALIDATE_EMAIL)));

    if ($emails) {
        try {
            $mail = taoMailer();
            $mail->SMTPKeepAlive = true; 
            $mail->Subject = $tieude;
            $mail->Body    = $noidung;

            foreach ($emails as $email) {
                try {
                    $mail->clearAddresses();
                    $mail->addAddress($email);   
                    $mail->send();
                    $ketqua[] = [$email, true, 'Đã gửi'];
                } catch (Exception $e) {
                    $ketqua[] = [$email, false, $mail->ErrorInfo];
                }
            }
            $mail->smtpClose();
        } catch (Exception $e) {
            $ketqua[] = ['', false, 'Lỗi cấu hình: ' . $e->getMessage()];
        }
    } elseif (!$ketqua) {
        $ketqua[] = ['', false, 'Không có email hợp lệ để gửi'];
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Gửi email nhiều người</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-4" style="max-width:720px">
    <h2>Gửi email cho nhiều địa chỉ</h2>

    <?php foreach ($ketqua as [$email, $ok, $msg]): ?>
        <div class="alert alert-<?= $ok ? 'success' : 'danger' ?> py-2">
            <?= htmlspecialchars($email) ?> — <?= htmlspecialchars($msg) ?>
        </div>
    <?php endforeach; ?>

    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Nguồn danh sách email</label><br>
            <label class="me-3"><input type="radio" name="nguon" value="tay" checked> Nhập tay</label>
            <label><input type="radio" name="nguon" value="sql"> Lấy từ CSDL (bảng <code>khachhang</code>)</label>
        </div>
        <div class="mb-3">
            <label class="form-label">Danh sách email (cách nhau bởi dấu phẩy hoặc xuống dòng)</label>
            <textarea name="recipients" class="form-control" rows="3"
                placeholder="test1@test.com,test2@test.com,test3@test.com"></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Tiêu đề</label>
            <input type="text" name="tieude" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Nội dung (hỗ trợ HTML)</label>
            <textarea name="content" class="form-control" rows="5" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Gửi</button>
    </form>
</div>
</body>
</html>