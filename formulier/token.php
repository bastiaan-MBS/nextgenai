<?php
// Geeft een servertijdstip terug waarmee het formulier later kan aantonen
// hoeveel tijd er verstreken is tussen openen en versturen. Bewust op de
// server gegenereerd (niet met JS Date.now()): zo vergelijkt send.php straks
// twee tijdstippen van dezelfde klok, en kan een afwijkende klok op het
// apparaat van de bezoeker nooit een echte aanvraag laten blokkeren.
header('Content-Type: application/json');
header('Cache-Control: no-store');
echo json_encode(['token' => (int) round(microtime(true) * 1000)]);
