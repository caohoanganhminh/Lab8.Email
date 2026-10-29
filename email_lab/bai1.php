<?php

require __DIR__ . '/config.php';

try {
    $mail = taoMailer();


    $mail->addAddress('minhcha.25it@vku.udn.vn', 'Người nhận'); 
    $mail->Subject = 'Gửi thư từ PHP';
    $mail->Body    = '<b>Chào bạn!</b><br>Chúc an lành!';
    $mail->AltBody = 'Chào bạn! Chúc an lành!';

    if (file_exists(__DIR__ . '/4.jpg')) {
        $mail->addAttachment(__DIR__ . '/4.jpg', 'picture.jpg');
    }

    $mail->send();
    echo 'Đã gửi mail xong';
} catch (Exception $e) {
    echo 'Mail không gửi được. Lỗi: ', $mail->ErrorInfo;
}