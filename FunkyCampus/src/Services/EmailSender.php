<?php

namespace App\Services;

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

class EmailSender
{
    private PHPMailer $mailer;

    public function __construct()
    {
        $this->mailer = new PHPMailer(true);
        // Настройка почтового сервера
        $this->mailer->isSMTP();
        $this->mailer->Host = 'smtp.dreamhost.com';
        $this->mailer->SMTPAuth = true;
        $this->mailer->Username = 'olena@funkycorgi.com';
        $this->mailer->Password = 'su0menlinna';
        $this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $this->mailer->Port = 587;
    }

    public function sendConfirmationEmail(string $email, string $token): bool
    {
        try {
            $this->mailer->setFrom('olena@funkycorgi.com', 'Funky Campus');
            $this->mailer->addAddress($email);
            $this->mailer->isHTML(true);
            $this->mailer->Subject = 'Confirm your registration';
            $this->mailer->Body = "Please confirm your registration by clicking the following link:<br>
            <a href='http://localhost/funkycampus/public/?c=VerifyController&m=verifyEmail&token=$token'>Confirm</a>";
            return $this->mailer->send();
        } catch (Exception $e) {
            // Обработка ошибки
            error_log('Mailer Error: ' . $this->mailer->ErrorInfo);
            return false;
        }
    }

    public function sendPasswordRestoreEmail(string $email, string $token): bool
    {
        try {
            $this->mailer->setFrom('olena@funkycorgi.com', 'Funky Campus');
            $this->mailer->addAddress($email);
            $this->mailer->isHTML(true);
            $this->mailer->Subject = 'Someone requested to change your password at Funky Campus';
            $this->mailer->Body =
             "Looks like you want to change your password. Just click the link below to confirm and finish up:<br>
            <a href='http://localhost/funkycampus/public/?c=VerifyController&m=verifyPasswordUpdate&token=$token&email=$email'>
                Confirm Password Change</a><br>
            If you didn't ask for this, no worries — just ignore this email!";
            return $this->mailer->send();
        } catch (Exception $e) {
            // Обработка ошибки
            error_log('Mailer Error: ' . $this->mailer->ErrorInfo);
            return false;
        }
    }
}