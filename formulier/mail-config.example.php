<?php
// Kopieer dit bestand naar mail-config.php en vul het wachtwoord in voor lokaal testen.
// Op de live server wordt mail-config.php automatisch aangemaakt door de GitHub Actions
// deploy-workflow op basis van de SMTP_PASSWORD secret — dit bestand wordt nooit gecommit.

return [
    'smtp_host' => 'mail.mbscs.nl',
    'smtp_port' => 587,
    'smtp_username' => 'nextgen@mbscs.nl',
    'smtp_password' => 'VUL_HIER_JE_WACHTWOORD_IN',
    'from_email' => 'nextgen@mbscs.nl',
    'from_name' => 'NextGen AI website',
    // Demo-fase: alle interne meldingen gaan naar dit testadres.
    // Bij livegang aanpassen naar het definitieve eigenaarsadres.
    'owner_email' => 'bastiaan@mrbluesky.nl',
    // Gebruikt om het logo in de HTML-mails op te halen.
    // Demo-fase: subdomain van mbscs.nl. Bij livegang aanpassen naar https://nextgen-ai.club
    'site_url' => 'https://nextgen.mbscs.nl',
];
