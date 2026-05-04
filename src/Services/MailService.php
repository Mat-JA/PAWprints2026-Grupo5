<?php

namespace App\Services;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception as MailException;

class MailService
{
    private PHPMailer $mailer;

    public function __construct()
    {
        $this->mailer = new PHPMailer(true);

        $this->mailer->isSMTP();
        $this->mailer->Host       = $_ENV['MAIL_HOST'];
        $this->mailer->SMTPAuth   = true;
        $this->mailer->Username   = $_ENV['MAIL_USERNAME'];
        $this->mailer->Password   = $_ENV['MAIL_PASSWORD'];
        $this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $this->mailer->Port       = (int) $_ENV['MAIL_PORT'];

        $this->mailer->setFrom(
            $_ENV['MAIL_FROM'],
            $_ENV['MAIL_FROM_NAME']
        );

        $this->mailer->CharSet = 'UTF-8';
    }

    public function send(string $to, string $subject, string $body): void
    {
        $this->mailer->clearAddresses();
        $this->mailer->addAddress($to);
        $this->mailer->Subject = $subject;
        $this->mailer->isHTML(true);
        $this->mailer->Body    = $body;
        try {
            $this->mailer->send();
        } catch (\PHPMailer\PHPMailer\Exception $e) {
            throw new \Exception('Error al enviar mail: ' . $e->getMessage());
        }
    }
}
