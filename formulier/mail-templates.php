<?php
// HTML-mailtemplates. Styles staan bewust inline, omdat veel mailclients (Outlook,
// Gmail) losse <style>-blokken negeren of wegfilteren.

function nextgen_mail_wrapper(string $titel, string $inhoudHtml, array $config): string {
    $logoUrl = rtrim($config['site_url'], '/') . '/assets/logo.png';

    return <<<HTML
<!doctype html>
<html lang="nl">
<body style="margin:0; padding:0; background:#f2f3f8; font-family:Arial, Helvetica, sans-serif;">
  <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#f2f3f8; padding:32px 16px;">
    <tr>
      <td align="center">
        <table role="presentation" width="100%" style="max-width:560px; background:#ffffff; border-radius:12px; overflow:hidden;" cellpadding="0" cellspacing="0">
          <tr>
            <td style="background:#000870; padding:28px 32px;">
              <img src="{$logoUrl}" alt="NextGen AI" height="40" style="display:block;">
            </td>
          </tr>
          <tr>
            <td style="height:4px; background:linear-gradient(90deg,#18e6ee,#f02088,#f8c838,#6fb31a);"></td>
          </tr>
          <tr>
            <td style="padding:32px;">
              <h1 style="margin:0 0 16px; font-size:20px; color:#000870;">{$titel}</h1>
              {$inhoudHtml}
            </td>
          </tr>
          <tr>
            <td style="padding:20px 32px; background:#f7f8fc; font-size:12px; color:#767a94;">
              NextGen AI &mdash; deze e-mail is automatisch verzonden vanaf de website.
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</body>
</html>
HTML;
}

function nextgen_mail_velden_tabel(array $velden): string {
    $rijen = '';
    foreach ($velden as $label => $waarde) {
        $label = htmlspecialchars((string) $label, ENT_QUOTES, 'UTF-8');
        $waarde = nl2br(htmlspecialchars((string) $waarde, ENT_QUOTES, 'UTF-8'));
        $rijen .= <<<HTML
        <tr>
          <td style="padding:8px 0; border-bottom:1px solid #eceef5; color:#767a94; font-size:14px; width:40%; vertical-align:top;">{$label}</td>
          <td style="padding:8px 0; border-bottom:1px solid #eceef5; color:#050b3f; font-size:14px; vertical-align:top;">{$waarde}</td>
        </tr>
HTML;
    }

    return '<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">' . $rijen . '</table>';
}

function nextgen_mail_eigenaar_html(string $onderwerp, array $velden, array $config): string {
    $inhoud = '<p style="margin:0 0 20px; color:#050b3f; font-size:14px;">Er is zojuist een nieuw formulier verzonden via de website.</p>'
        . nextgen_mail_velden_tabel($velden);

    return nextgen_mail_wrapper($onderwerp, $inhoud, $config);
}

function nextgen_mail_klant_html(string $voornaam, string $pagina, array $velden, array $config): string {
    $voornaam = htmlspecialchars($voornaam, ENT_QUOTES, 'UTF-8');

    $intros = [
        'workshops' => 'Bedankt voor uw workshopboeking bij NextGen AI. Hieronder vindt u een overzicht van uw aanvraag.',
        'partnerprogramma' => 'Bedankt voor uw kennismakingsaanvraag bij NextGen AI. Hieronder vindt u een overzicht van wat u heeft doorgegeven.',
    ];
    $intro = $intros[$pagina] ?? 'Bedankt voor uw aanvraag bij NextGen AI. Hieronder vindt u een overzicht van wat u heeft doorgegeven.';

    $inhoud = "<p style=\"margin:0 0 20px; color:#050b3f; font-size:14px;\">Beste {$voornaam},</p>"
        . "<p style=\"margin:0 0 20px; color:#050b3f; font-size:14px;\">{$intro}</p>"
        . nextgen_mail_velden_tabel($velden)
        . '<p style="margin:24px 0 0; color:#050b3f; font-size:14px;">We nemen binnenkort contact met u op om de volgende stap te bespreken.</p>'
        . '<p style="margin:20px 0 0; color:#050b3f; font-size:14px;">Met vriendelijke groet,<br>Team NextGen AI</p>';

    return nextgen_mail_wrapper('Bevestiging van uw aanvraag', $inhoud, $config);
}
