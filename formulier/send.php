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

// De pagina roept dit endpoint aan via fetch() met Accept: application/json.
// In dat geval antwoorden we met JSON zodat de pagina pas doorstuurt zodra de
// mail echt is verstuurd. Zonder JavaScript (gewone POST) valt dit terug op
// een redirect.
function wil_json(): bool {
    return isset($_SERVER['HTTP_ACCEPT']) && str_contains($_SERVER['HTTP_ACCEPT'], 'application/json');
}

function stuur_fout(string $referer): void {
    if (wil_json()) {
        header('Content-Type: application/json');
        http_response_code(422);
        echo json_encode(['success' => false]);
        exit;
    }
    $scheiding = str_contains($referer, '?') ? '&' : '?';
    header('Location: ' . $referer . $scheiding . 'formulier_status=fout');
    exit;
}

function stuur_succes(): void {
    if (wil_json()) {
        header('Content-Type: application/json');
        echo json_encode(['success' => true]);
        exit;
    }
    header('Location: bedankt.html');
    exit;
}

// Spambescherming, twee lagen, allebei bewust ontworpen om nooit een echte
// aanvraag te blokkeren:
// 1. Checkbox-honeypot: onzichtbaar vinkje. Wachtwoordmanagers/autofill
//    vullen wel eens tekstvelden, maar vinken vrijwel nooit uit zichzelf
//    een checkbox aan.
// 2. Tijd-token: formulier.php geeft bij het openen een servertijdstip mee
//    (_token, via formulier/token.php). send.php vergelijkt dat met de
//    huidige servertijd — dus twee metingen van dezelfde klok, in
//    tegenstelling tot de eerdere versie die de kloktijd van de bezoeker
//    (JS Date.now()) vergeleek met de serverklok. Als de klokken uiteen
//    liepen, werd toen elke echte aanvraag onterecht als bot gezien.
//    Ontbreekt het token (bv. JS uitgeschakeld of fetch geblokkeerd)? Dan
//    slaan we deze check gewoon over, zodat het formulier ook zonder
//    JavaScript blijft werken.
if (!empty($_POST['_bevestig'])) {
    stuur_succes();
}
$token = (int) ($_POST['_token'] ?? 0);
if ($token > 0) {
    $verstreken = microtime(true) * 1000 - $token;
    if ($verstreken < 1200 || $verstreken > 3600000) {
        stuur_succes();
    }
}

$configPad = __DIR__ . '/mail-config.php';
if (!file_exists($configPad)) {
    stuur_fout($referer);
}
$config = require $configPad;

$pagina = trim($_POST['_pagina'] ?? 'onbekend');
$email = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);
$voornaam = trim($_POST['voornaam'] ?? '');
$achternaam = trim($_POST['achternaam'] ?? '');

if (!$email || $voornaam === '' || $achternaam === '') {
    stuur_fout($referer);
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
    'factuur_postcode' => 'Factuuradres - postcode',
    'factuur_huisnummer' => 'Factuuradres - huisnummer',
    'factuur_straat' => 'Factuuradres - straat',
    'factuur_stad' => 'Factuuradres - stad',
    'locatie_zelfde_factuuradres' => 'Locatie is gelijk aan factuuradres',
    'opmerkingen' => 'Opmerkingen',
    'bericht' => 'Bericht',
    'workshop' => 'Workshop',
];

$velden = [];
foreach ($_POST as $veld => $waarde) {
    if (in_array($veld, ['_token', '_bevestig', '_pagina'], true) || trim((string) $waarde) === '') {
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
    // Voorkomt dat een onbereikbare SMTP-server het script (en de pagina van de
    // bezoeker) minutenlang laat hangen tot aan een 504 Gateway Timeout.
    $mail->Timeout = 10;
    $mail->SMTPKeepAlive = false;
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
    error_log('[formulier/send.php] Mail verzenden mislukt: ' . $e->getMessage());
    stuur_fout($referer);
}

stuur_succes();
