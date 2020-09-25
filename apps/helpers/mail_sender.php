<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
function sendemail($email_tujuan, $pesan = null, $subject = null, $nama_pengirim = 'Keuangan BQN', $email_pengirim = 'kamscode@kamscode.tech')
{
    require DEPENDENCIES_PATH . 'phpmailer/phpmailer/src/Exception.php';
    require DEPENDENCIES_PATH . 'phpmailer/phpmailer/src/PHPMailer.php';
    require DEPENDENCIES_PATH . 'phpmailer/phpmailer/src/SMTP.php';
    $mail = new PHPMailer(TRUE);

    try {
        /* Set the mail sender. */
        $mail->IsSMTP();
        $mail->Host = "mail.kamscode.tech";

        // optional
        // used only when SMTP requires authentication  
        $mail->SMTPAuth = true;
        $mail->Username = 'kamscode';
        $mail->Password = '3bS9Fn2g8n';
        $email_tujuan = strtolower($email_tujuan);
        $mail->setFrom($email_pengirim, $nama_pengirim);

        /* Add a recipient. */
        $mail->addAddress($email_tujuan);

        /* Set the subject. */
        $mail->Subject = $subject;

        /* Set the mail message body. */
        $mail->Body = $pesan;

        $mail->send();
        return ['message' => 'Berhasil mengirim email', 'sts' => true];
    } catch (Exception $e) {
        return ['message' => $e->errorMessage(), 'sts' => false];
        echo $e->errorMessage();
    } catch (\Exception $e) {
        return ['message' => $e->getMessage(), 'sts' => false];
    }
}
