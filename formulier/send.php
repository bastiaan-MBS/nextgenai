<?php
require __DIR__ . '/../lib/PHPMailer/Exception.php';
require __DIR__ . '/../lib/PHPMailer/PHPMailer.php';
require __DIR__ . '/../lib/PHPMailer/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Method not allowed');
}

$referer = $_SERVER['HTTP_REFERER'] ?? '/index.html';

function terug_met_fout(string $referer): void {
    $scheiding = str_contains($referer, '?') ? '&' : '?';
    header('Location: ' . $referer . $scheiding . 'formulier_status=fout');
    exit;
}

// Honeypot: bots vullen dit verborgen veld in, mensen niet.
if (!empty($_POST['website'])) {
    header('Location: bedankt.html');
    exit;
}

$configPad = __DIR__ . '/mail-config.php';
if (!file_exists($configPad)) {
    terug_met_fout($referer);
}
$config = require $configPad;

$pagina = trim($_POST['_pagina'] ?? 'onbekend');
$email = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);
$voornaam = trim($_POST['voornaam'] ?? '');
$achternaam = trim($_POST['achternaam'] ?? '');

if (!$email || $voornaam === '' || $achternaam === '') {
    terug_met_fout($referer);
}

$onderwerpen = [
    'workshops' => 'Nieuwe workshopboeking',
    'partnerprogramma' => 'Nieuwe kennismakingsaanvraag',
];
$onderwerp = $onderwerpen[$pagina] ?? 'Nieuw formulierbericht';

$regels = [];
foreach ($_POST as $veld => $waarde) {
    if (in_array($veld, ['website', '_pagina'], true) || $waarde === '') {
        continue;
    }
    $regels[] = ucfirst(str_replace('_', ' ', $veld)) . ': ' . $waarde;
}
$body = implode("\n", $regels);

$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->Host = $config['smtp_host'];
    $mail->Port = $config['smtp_port'];
    $mail->SMTPAuth = true;
    $mail->Username = $config['smtp_username'];
    $mail->Password = $config['smtp_password'];
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->CharSet = 'UTF-8';

    $mail->setFrom($config['from_email'], $config['from_name']);
    $mail->addAddress($config['to_email']);
    $mail->addReplyTo($email, $voornaam . ' ' . $achternaam);

    $mail->Subject = $onderwerp . ' (' . $pagina . ')';
    $mail->Body = $body;

    $mail->send();
} catch (Exception $e) {
    terug_met_fout($referer);
}

header('Location: bedankt.html');
exit;
