# NextGen AI, website (prototype)

## Structuur
```
index.html             → homepage
workshops.html         → workshoppagina met alle workshops en boeken per workshop
partnerprogramma.html  → partnerpagina met aanbod, kennismaking en huidige partners
inbeeld.html           → mediapagina: verslagen, video's, fotobibliotheek en impacttijdlijn
overons.html           → team, missie en ontstaansgeschiedenis
bedankt.html           → bedankpagina na een succesvolle aanvraag
css/styles.css         → sitewide design tokens en componenten (kleur, typografie, header, footer, ticker)
assets/                → logo, merk-blobs en foto's
```

## Bestandsnamen (belangrijk voor later)
Zodra de echte bestanden klaarstaan, vervang ze dan onder exact dezelfde naam
in de map `assets/`. Alle pagina's verwijzen naar deze namen, dus een bestand
vervangen is voldoende, de site hoeft niet aangepast te worden.

- `assets/logo.png`, transparant NextGen AI logo
- `assets/hero-photo-1.jpg` t/m `assets/hero-photo-4.jpg`, de vier foto's in de
  hero-slideshow op de homepage (nu: IMG_1271 en drie Junior AI League-foto's).
  `hero-photo-1.jpg` (AI for Kids), `hero-photo-2.jpg` (AI Family Festival) en
  `hero-photo-4.jpg` (AI Hackathon) worden ook hergebruikt op de workshoppagina.
- `assets/blob-*-clean.png`, merk-blobs, niet wijzigen

## Stijlregels
- Kleuren, lettertypes en spacing staan als CSS-variabelen in `css/styles.css`,
  inclusief `--color-red` (`#ff595d`), overgenomen uit de muzieknoot in het logo.
- Merk-blobs: altijd volle kleur, nooit transparant, altijd half afgesneden
  aan de rand van de pagina. Spaarzaam gebruikt: alleen in de header en de footer.
- Foto's krijgen afgeronde hoeken met een zachte schaduw (`class="photo"`).
- Geen koppelstreepjes (—) in lopende tekst tenzij echt nodig.

## Mobiele navigatie
Vanaf 960px breed schakelt de header om naar een hamburgermenu met dezelfde
links en knoppen. Dit staat sitewide in `css/styles.css`, met de bijbehorende
JS onderaan elke pagina, dus nieuwe pagina's werken hier automatisch mee
zolang ze dezelfde header-markup gebruiken.

## Footer (sitewide, identiek op elke pagina)
De footer heeft geen contactformulier. In plaats daarvan staan er twee
duidelijke kaarten met een geel rond knopje: "Ik wil partner worden" (linkt
naar `partnerprogramma.html`) en "Ik wil een workshop boeken" (linkt naar
`workshops.html`). Onder de witte kaarten volgt de donkerblauwe balk met
sitemap, organisatiegegevens en juridische links.

## Homepage
De hero heeft een automatische fotoslideshow (4 foto's, wisselt elke 4,5
seconde). De impact-sectie is een interactieve tijdlijn met sleepbare slider
en een gele stip die ook direct op de grafiek te verslepen is; bij het
scrollen naar de sectie loopt alles rustig op tot vandaag.

## Workshoppagina
`workshops.html` toont de vijf themaworkshops (basis, muziek, verhaal, game,
kunst) elk als een volledige rij onder elkaar, met genoeg ruimte voor het
boekingsformulier dat eronder uitklapt. Elke rij heeft een eigen kleur voor
kader, icoon, boekingsmodule en knop:
- Basis: donkerblauw
- Muziek: rood
- Verhaal: lichtblauw
- Game: geel
- Kunst: groen

Foto's zijn nu 1,5x hoger dan de vorige versie (max. 195px) zodat er meer
sfeer in zit, maar nog steeds kleiner dan de allereerste versie. De
prijstrap-uitsplitsing (395/595) is uit de kaart zelf gehaald: daar staat nu
alleen nog "Vanaf € 395". De volledige staffel werkt wel door in het
boekingsformulier.

**Boekingsformulier, compacter en met prijs op de juiste plek:**
- Minder witruimte tussen de velden (formulier is sitewide compacter gemaakt).
- Geen grote gekleurde balk meer bovenaan die over de eerste velden heen
  viel. In plaats daarvan: een klein naamlabel bovenaan het formulier, en
  een kleine prijsindicatie direct onder het veld "Aantal kinderen", die
  live meeverandert met het ingevulde aantal.

AI Hackathon en AI Family Festival staan nu onder elkaar in hun eigen rij
(niet meer naast elkaar). De AI Hackathon-kaart heeft een groen-blauwe
gradient-achtergrond (gelieerd aan de Junior AI League-huisstijl), met witte
tekst voor voldoende contrast.

Verder op deze pagina: dezelfde reviews-carrousel als op de homepage, en een
blok dat bezoekers die vaker een workshop willen organiseren uitnodigt om
partner te worden (met link naar `partnerprogramma.html`).

Foto's: AI for Kids, AI Hackathon en AI Family Festival gebruiken echte
foto's. Voor AI Music, AI Story, AI Game en AI Arts is nog geen passende
foto beschikbaar; die tonen een duidelijk gelabelde placeholder met het
bijpassende icoon in de themakleur.

## In beeld-pagina
`inbeeld.html` is nu opgezet als echte mediapagina, qua opzet geïnspireerd op
junioraileague.nl/in-beeld, maar in de eigen NextGen AI-huisstijl (de
gradient-banner van de Junior AI League is teruggedraaid naar de normale
witte page-hero die op alle andere pagina's wordt gebruikt):
- Filtertabs (Alles, Workshops, Video, In de media, Foto's) die de
  mediagrid filteren.
- Mediagrid met voorbeeldkaarten (verslag, video, perslink). **Dit is
  duidelijk gelabelde voorbeeldcontent** ("Voorbeeld · datum") die vervangen
  moet worden door echte verslagen, video's en persberichten.
- Een fotobibliotheek met de beschikbare workshopfoto's, klikbaar voor een
  vergrote weergave (lightbox). Deze bibliotheek groeit mee naarmate er meer
  foto's beschikbaar komen.

De interactieve impacttijdlijn staat niet meer op deze pagina (hoort hier
niet thuis) en blijft alleen op de homepage staan.

## Over ons-pagina
`overons.html` bevat, ook geïnspireerd op de Junior AI League-opzet:
- Het ontstaan: NextGen AI komt voort uit ACTNOW B.V., dat sinds 2016 werkt
  aan digitale jeugdeducatie (10+ jaar ervaring).
- De volledige merkmissie, overgenomen uit het merkdocument (THE_NEXTGEN.pdf).
- Het team, in de volgorde Geraldine (CEO), Peter (CGO), Bastiaan (CPO),
  Daniel (tech support), gevolgd door de trainers Laurens, Sjors en
  Jan-Willem. Er zijn nog geen echte profielfoto's; de gekleurde cirkels met
  initialen hebben nu een duidelijk camera-icoontje en een toelichtende
  tekst eronder, zodat helder is dat dit placeholders zijn die later door
  echte foto's vervangen worden.

## Partnerprogramma-pagina
`partnerprogramma.html` beschrijft het aanbod (licentie, volledig
programma, Train-de-Trainer) met een CTA-kaart die twee opties biedt: direct
een afspraak plannen via een Calendly-link, of een kennismakingsformulier
uitklappen. Dat formulier staat nu als volledige-breedte-blok onder de
aanbodsectie (niet meer verstopt in de smalle donkerblauwe kaart, waar
eerder velden werden afgekapt).

Onderaan de pagina, vlak boven de footer, staat "Wat u krijgt als partner":
dezelfde kindveilige-software-boodschap als op de homepage, maar herschreven
vanuit het perspectief van de bezoeker (wat ze krijgen, niet wat ons
onderscheidt).

**Let op:** vervang de Calendly-link (`https://calendly.com/nextgen-ai/kennismaking`)
door de echte agenda-link van Peter zodra die bekend is.

Onder de partners-carrousel staat nu ook een blok over de Junior AI League
(gelieerd programma), met een link naar junioraileague.nl.

Daaronder staat een doorscrolbare carrousel met huidige partners (naam,
regio, korte toelichting, review en een link naar hun eigen website). De
websitelinks staan nu op `#` als placeholder; vul de echte adressen in
zodra die bekend zijn, en vervang de voorbeeldpartners door de echte namen.

## Bedankpagina
`bedankt.html` verschijnt automatisch na een succesvol verzonden formulier
(boekingsformulier op de workshoppagina, of het kennismakingsformulier op de
partnerpagina). De pagina leest de meegegeven gegevens uit de link
(workshopnaam, voornaam, type aanvraag) en past de inhoud daarop aan:
- Workshopaanvraag: bedankregel met de gekozen workshop, plus een tijdlijn
  met de 3 vervolgstappen (aanvraag ontvangen, trainers inplannen, workshop
  geboekt inclusief informatie en factuur).
- Kennismaking/partneraanvraag: een algemenere bedankboodschap, zonder tijdlijn.

Zodra er een echte server is: laat de `fetch(...)` in de submit-handlers
afwachten of de aanvraag echt is gelukt voordat je doorstuurt naar
`bedankt.html` (dit staat als commentaar bij de code). Nu, zonder server,
stuurt het formulier door zodra het geldig is ingevuld, en wordt de data op
de achtergrond verstuurd.

## Formulieren
Er zijn twee formulieren, allebei aangesloten op dezelfde verwerker:
- Het boekingsformulier per workshop op `workshops.html`.
- Het kennismakingsformulier op `partnerprogramma.html`.

Beide posten naar `formulier/send.php` (PHP-script, zie
"Mailverwerking" hieronder). Voor beide geldt verder:
- Alle velden hebben een `name`-attribuut dat als POST-data binnenkomt
  (voornaam, achternaam, email, telefoon, organisatie, regio, workshop,
  gewenste/alternatieve datum, aantal kinderen, leeftijd/groep, locatie,
  factuurgegevens, bericht/opmerkingen).
- Er zit een verborgen honeypot-veld (`website`) in voor basale
  spambescherming.
- Bij een serverfout verschijnt een foutmelding met een directe
  mailto-link naar info@nextgen-ai.club, zodat er nooit een dode knop is.

## Mailverwerking
`formulier/send.php` verwerkt beide formulieren en verstuurt via SMTP
(PHPMailer, bestanden in `lib/PHPMailer/`) twee e-mails per inzending:
1. Een interne melding met alle ingevulde velden naar `owner_email`
   (in de mail-config, momenteel het testadres `bastiaan@mrbluesky.nl`).
2. Een HTML-bevestigingsmail naar het e-mailadres van de aanvrager, met een
   overzicht van de aanvraag en de mededeling dat er binnenkort contact
   wordt opgenomen.

De HTML-templates staan in `formulier/mail-templates.php` (navy header met
logo, kleurstreep in de merkkleuren, nette content-tabel).

**SMTP-instellingen en het eigenaarsadres staan nooit in de repository**
(deze is publiek op GitHub). In plaats daarvan genereert de GitHub Actions
deploy-workflow (`.github/workflows/deploy.yml`) het bestand
`formulier/mail-config.php` bij elke deploy, met de waarden uit de
GitHub secrets `SMTP_HOST`, `SMTP_PORT`, `SMTP_USERNAME` en
`SMTP_PASSWORD`. Zie `formulier/mail-config.example.php` voor de vorm van
dit bestand (handig om lokaal te testen: kopieer het naar
`formulier/mail-config.php` en vul het wachtwoord in — dit bestand staat in
`.gitignore` en wordt dus nooit gecommit).

## ⚠️ Demo-omgeving — belangrijk voor de livegang
Deze site draait momenteel als **demo-omgeving** op het subdomain
`nextgen.origyns.nl` (op de eigen DirectAdmin-server van Bastiaan), niet op
het uiteindelijke domein. Zodra de site live gaat op het echte domein
**`nextgen-ai.club`**, moet het volgende worden omgezet:
- **DNS/hosting**: het domein `nextgen-ai.club` koppelen aan de juiste
  server/hosting-omgeving.
- **FTP-deploy**: `server-dir` in `.github/workflows/deploy.yml` aanpassen
  naar het pad op de nieuwe server, en de secrets `FTP_SERVER`,
  `FTP_USERNAME` en `FTP_PASSWORD` vervangen door de gegevens van de nieuwe
  hosting.
- **Mail-config**: `site_url` in de workflow (gebruikt voor het logo in de
  HTML-mails) aanpassen naar `https://nextgen-ai.club`, en de
  `SMTP_*`-secrets vervangen door een mailaccount op `nextgen-ai.club`.
- **Eigenaarsadres**: `owner_email` in de workflow aanpassen van het
  testadres `bastiaan@mrbluesky.nl` naar het definitieve adres waar
  aanvragen binnen moeten komen.
- De bestaande mailto-links in de code (`info@nextgen-ai.club`) kunnen
  blijven staan, die verwijzen al naar het toekomstige domein.

## Volgende stappen
1. Calendly-link en partnerlogo's/links vervangen door de echte gegevens.
2. Teksten laten uitschrijven en aanscherpen.
3. Eigen CMS bouwen zodat teksten, impactcijfers en testimonials buiten de
   code om aan te passen zijn.
4. Bij livegang: alle punten onder "Demo-omgeving" hierboven doorlopen om
   van `nextgen.origyns.nl` over te zetten naar `nextgen-ai.club`.
