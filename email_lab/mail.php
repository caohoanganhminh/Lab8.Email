<?php

require __DIR__ . '/config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$tmpFile = null;
try {
    $mail = taoMailer();


    $to      = trim($_POST['email'] ?? '');
    $to_name = 'bạn';
    $tieude  = trim($_POST['tieude'] ?? '');

    if (!filter_var($to, FILTER_VALIDATE_EMAIL)) {
        throw new Exception('Email người nhận không hợp lệ');
    }

    $mail->addAddress($to, $to_name);
    $mail->Subject = $tieude;
    $mail->Body = '
    <div class="card" style="width: 18rem;">
        <div class="card-body">
            <h5 class="card-title"><b>Xin chào ' . htmlspecialchars($to_name) . '</b></h5>
            <p class="card-text">' . ($_POST['content'] ?? '') . '</p>
        </div>
    </div>';


    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        $tmpFile = tempnam(sys_get_temp_dir(), sha1($_FILES['file']['name']));
        if (move_uploaded_file($_FILES['file']['tmp_name'], $tmpFile)) {
            $mail->addAttachment($tmpFile, $_FILES['file']['name']);
        }
    }

    $mail->send();
    header('Location: index.php?status=ok');
} catch (Exception $e) {
    header('Location: index.php?status=error&msg=' . urlencode(isset($mail) ? $mail->ErrorInfo : $e->getMessage()));
} finally {
    if ($tmpFile && file_exists($tmpFile)) {
        unlink($tmpFile);
    }
}