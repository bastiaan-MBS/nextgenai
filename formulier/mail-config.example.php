<?php
// Kopieer dit bestand naar mail-config.php en vul het wachtwoord in voor lokaal testen.
// Op de live server wordt mail-config.php automatisch aangemaakt door de GitHub Actions
// deploy-workflow op basis van de SMTP_PASSWORD secret — dit bestand wordt nooit gecommit.

return [
    'smtp_host' => 'mail.origyns.nl',
    'smtp_port' => 587,
    'smtp_username' => 'nextgen@origyns.nl',
    'smtp_password' => 'VUL_HIER_JE_WACHTWOORD_IN',
    'from_email' => 'nextgen@origyns.nl',
    'from_name' => 'NextGen AI website',
    'to_email' => 'nextgen@origyns.nl',
];
