<?php
require __DIR__ . '/../lib/PHPMailer/Exception.php';
require __DIR__ . '/../lib/PHPMailer/PHPMailer.php';
require __DIR__ . '/../lib/PHPMailer/SMTP.php';
require __DIR__ . '/mail-templates.php';

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

$veldLabels = [
    'voornaam' => 'Voornaam',
    'achternaam' => 'Achternaam',
    'organisatie' => 'Organisatie',
    'regio' => 'Regio',
    'email' => 'E-mailadres',
    'telefoon' => 'Telefoonnummer',
    'gewenste_datum' => 'Gewenste datum',
    'alternatieve_datum' => 'Alternatieve datum',
    'aantal_kinderen' => 'Aantal kinderen',
    'leeftijd_groep' => 'Leeftijd of groep',
    'locatie' => 'Locatie',
    'factuur_naam' => 'Factuur t.n.v.',
    'kvk_btw' => 'KvK- of btw-nummer',
    'factuuradres' => 'Factuuradres',
    'opmerkingen' => 'Opmerkingen',
    'bericht' => 'Bericht',
    'workshop' => 'Workshop',
];

$velden = [];
foreach ($_POST as $veld => $waarde) {
    if (in_array($veld, ['website', '_pagina'], true) || trim((string) $waarde) === '') {
        continue;
    }
    $velden[$veldLabels[$veld] ?? ucfirst(str_replace('_', ' ', $veld))] = $waarde;
}

function verstuur_mail(PHPMailer $mail, array $config): void {
    $mail->isSMTP();
    $mail->Host = $config['smtp_host'];
    $mail->Port = $config['smtp_port'];
    $mail->SMTPAuth = true;
    $mail->Username = $config['smtp_username'];
    $mail->Password = $config['smtp_password'];
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->CharSet = 'UTF-8';
    $mail->isHTML(true);
}

try {
    // 1. Interne notificatie naar de eigenaar
    $ownerMail = new PHPMailer(true);
    verstuur_mail($ownerMail, $config);
    $ownerMail->setFrom($config['from_email'], $config['from_name']);
    $ownerMail->addAddress($config['owner_email']);
    $ownerMail->addReplyTo($email, $voornaam . ' ' . $achternaam);
    $ownerMail->Subject = $onderwerp . ' (' . $pagina . ')';
    $ownerMail->Body = nextgen_mail_eigenaar_html($onderwerp, $velden, $config);
    $ownerMail->AltBody = strip_tags(str_replace('</tr>', "\n", $ownerMail->Body));
    $ownerMail->send();

    // 2. Bevestigingsmail naar de klant
    $klantMail = new PHPMailer(true);
    verstuur_mail($klantMail, $config);
    $klantMail->setFrom($config['from_email'], $config['from_name']);
    $klantMail->addAddress($email, $voornaam . ' ' . $achternaam);
    $klantMail->addReplyTo($config['owner_email'], $config['from_name']);
    $klantMail->Subject = 'Bevestiging van uw aanvraag bij NextGen AI';
    $klantMail->Body = nextgen_mail_klant_html($voornaam, $pagina, $velden, $config);
    $klantMail->AltBody = "Beste $voornaam,\n\nBedankt voor uw aanvraag. We hebben deze goed ontvangen en nemen binnenkort contact met u op.\n\nMet vriendelijke groet,\nTeam NextGen AI";
    $klantMail->send();
} catch (Exception $e) {
    terug_met_fout($referer);
}

header('Location: bedankt.html');
exit;
