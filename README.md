# NextGen AI, website (prototype)

## Structuur
```
index.html             → homepage (/)
ai-workshops/          → boekingspagina voor AI-workshops (/ai-workshops/)
organisaties/          → aanbod voor organisaties: workshop/lessenreeks/licentie (/organisaties/)
licentie/              → NextGen AI-licentie: prijzen, voordelen, aanvragen (/licentie/, niet in hoofdnav)
ai-lessenreeks/        → AI-lessenreeks digitale geletterdheid groep 7/8 (/ai-lessenreeks/, niet in hoofdnav)
in-beeld/              → mediapagina: nieuwsoverzicht, fotobibliotheek en impacttijdlijn (/in-beeld/)
nieuws/<slug>/         → losse artikelpagina's, één per mijlpaal uit in-beeld/ (/nieuws/<slug>/)
over-ons/              → team, missie en ontstaansgeschiedenis (/over-ons/)
bedankt/               → bedankpagina na een succesvolle aanvraag (/bedankt/, noindex)
css/styles.css         → sitewide design tokens en componenten (kleur, typografie, header, footer, ticker)
assets/                → logo, merk-blobs en foto's
assets/nieuws/         → foto's per nieuwsartikel (zie assets/nieuws/LEESMIJ.md voor de naamgeving)
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

## Hoofdnavigatie en submenu
De hoofdnavigatie bestaat bewust uit precies 5 items: Home, Workshops
(`/ai-workshops/`), Organisaties, In Beeld, Over Ons. `/licentie/` en
`/ai-lessenreeks/` staan hier NIET in — dit is een expliciete klantkeuze: het
zijn onderliggende proposities, bereikbaar via een submenu onder
"Organisaties" en via interne links elders op de site.

Het submenu (Licentie, Lessenreeks) werkt op desktop en mobiel verschillend:
- **Desktop**: verschijnt alleen bij `:hover`/`:focus-within` op "Organisaties"
  (classes `.nav-has-dropdown`/`.nav-dropdown` in `css/styles.css`), niet
  standaard zichtbaar.
- **Mobiel**: staat standaard ingeklapt en wordt via een apart pijltje-knopje
  naast "Organisaties" getoond/verborgen (`.nav-dropdown-toggle`,
  `aria-expanded`, class `.nav-dropdown-mobile.is-open`). De link naar
  `/organisaties/` zelf blijft los daarvan gewoon aanklikbaar.

Dit is sitewide identiek op alle 20 pagina's; nieuwe pagina's moeten dezelfde
header-markup en de bijbehorende JS-blokken (twee losse IIFE's: één voor het
desktop-dropdown-gedrag, één voor de mobiele toggle) overnemen.

## Mobiele navigatie
Vanaf 960px breed schakelt de header om naar een hamburgermenu met dezelfde
links en knoppen (zie ook "Hoofdnavigatie en submenu" hierboven voor het
submenu-gedrag). Dit staat sitewide in `css/styles.css`, met de bijbehorende
JS onderaan elke pagina, dus nieuwe pagina's werken hier automatisch mee
zolang ze dezelfde header-markup gebruiken.

## Footer (sitewide, identiek op elke pagina)
De footer heeft geen contactformulier. In plaats daarvan staan er twee
duidelijke kaarten met een geel rond knopje: "Ik wil partner worden" (linkt
naar `/organisaties/`) en "Ik wil een workshop boeken" (linkt naar
`/ai-workshops/`). Onder de witte kaarten volgt de donkerblauwe balk met
sitemap, organisatiegegevens en juridische links.

In de kolom "Organisatie" staat, onder de contactgegevens
(`Peter Brouwers: +31 6 11 73 60 39`), het BRAIN Nederland-logo
(`.footer-org-badge`, ca. 60px hoog — bewust 3x groter dan de eerdere,
kleinere variant die in de onderste balk stond). De LinkedIn-knop
(`.footer-social-btn`, onderin) is een gele, duidelijk klikbare knop zonder
onderlijning; let bij wijzigingen op de CSS-specificiteit van de regel
`.footer-legal .footer-bottom a.footer-social-btn` — die moet minstens even
specifiek blijven als `.footer-legal .footer-bottom a` (die laatste zet
standaard `text-decoration: underline` op alle links in de onderste balk).

## Homepage
De hero heeft een automatische fotoslideshow (4 foto's, wisselt elke 4,5
seconde). De impact-sectie is een interactieve tijdlijn met sleepbare slider
en een gele stip die ook direct op de grafiek te verslepen is; bij het
scrollen naar de sectie loopt alles rustig op tot vandaag.

## Workshoppagina
`/ai-workshops/` toont de vijf themaworkshops (basis, muziek, verhaal, game,
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
partner te worden (met link naar `/organisaties/`).

Foto's: AI for Kids, AI Hackathon en AI Family Festival gebruiken echte
foto's. Voor AI Music, AI Story, AI Game en AI Arts is nog geen passende
foto beschikbaar; die tonen een duidelijk gelabelde placeholder met het
bijpassende icoon in de themakleur.

## In beeld-pagina
`/in-beeld/` is de mediapagina van de site, met echte content (geen
voorbeeldcontent meer):
- Filtertabs (Alles, Nieuws, In de media) die de mediagrid filteren op
  `data-category`.
- Mediagrid met 11 echte mijlpalen uit de geschiedenis van NextGen AI (van de
  oprichting in 2023 tot het founding member-schap van BRAIN Nederland in
  2026), elk als tegel met datum, titel en link naar het volledige artikel.
  Eigen aankondigingen staan onder **Nieuws**, persaandacht van derden onder
  **In de media**.
- Een fotobibliotheek met de beschikbare workshopfoto's, klikbaar voor een
  vergrote weergave (lightbox). Deze bibliotheek groeit mee naarmate er meer
  foto's beschikbaar komen.

De interactieve impacttijdlijn staat niet meer op deze pagina (hoort hier
niet thuis) en blijft alleen op de homepage staan.

## Nieuwsartikelen (`nieuws/`)
Elke tegel op `/in-beeld/` linkt naar een eigen artikelpagina in
`nieuws/`, opgebouwd met dezelfde header/footer als de rest van de site.
Elk artikel bevat een uitgebreide, in eigen bewoording geschreven tekst
(gebaseerd op de feiten uit de bronnen, met korte letterlijke citaten waar
relevant, altijd met attributie) en een "Bronnen"-blok met links naar de
oorspronkelijke publicaties. **Er wordt bewust geen volledige tekst of
beeldmateriaal van externe media overgenomen** — dat is auteursrechtelijk
beschermd. Voor het overnemen van tekst geldt het citaatrecht (kort en met
bronvermelding), voor beeldmateriaal is toestemming van de rechthebbende
nodig.

**Foto's staan nog op placeholder.** Zowel de tegels in `/in-beeld/` als
de artikelpagina's zelf tonen nu een placeholder-blok
(`data-nieuws-foto="<slug>"`). Zodra er eigen foto's per artikel
beschikbaar zijn: zet ze in `assets/nieuws/` met de bestandsnaam die
overeenkomt met de slug (zie `assets/nieuws/LEESMIJ.md`), en laat alle
placeholders in één keer vervangen door `<img>`-tags.

## SEO
Alle 20 pagina's (inclusief `/licentie/` en `/ai-lessenreeks/`) hebben nu:
- Unieke `<title>` en `<meta name="description">`.
- `<link rel="canonical">`, Open Graph- en Twitter Card-tags (`og:title`,
  `og:description`, `og:image`, `twitter:card`, etc.).
- Eén `<h1>` per pagina, logische H2/H3-opbouw daaronder.
- `favicon-32.png` en `apple-touch-icon.png` (gegenereerd uit `assets/logo.png`).
- Structured data (JSON-LD): `Organization` op de homepage, `NewsArticle` op
  elke pagina in `nieuws/`.
- `/bedankt/` staat op `noindex` (dankpagina's horen niet in zoekresultaten)
  en is uitgesloten in `robots.txt`.

`robots.txt` en `sitemap.xml` staan in de root en verwijzen naar elkaar.

**Let op:** canonical- en Open Graph-URL's wijzen bewust al naar het
toekomstige domein `https://nextgen-ai.club`, niet naar de huidige
demo-omgeving (`nextgen.mbscs.nl`). Dat betekent dat social-media-previews
van de demo-link nu geen werkende afbeelding tonen (de afbeelding staat nog
niet op dat domein) — dat lost zichzelf op zodra de site live gaat op
`nextgen-ai.club`. Wil je dat de demo-omgeving ook correcte previews heeft,
laat dat dan weten, dan zet ik de URL's tijdelijk om.

## Over ons-pagina
`/over-ons/` bevat, ook geïnspireerd op de Junior AI League-opzet:
- Het ontstaan: NextGen AI komt voort uit ACTNOW B.V., dat sinds 2016 werkt
  aan digitale jeugdeducatie (10+ jaar ervaring).
- De volledige merkmissie, overgenomen uit het merkdocument (THE_NEXTGEN.pdf).
- Het team, in de volgorde Geraldine (CEO), Peter (CGO), Bastiaan (CPO),
  Daniel (tech support), gevolgd door de trainers Laurens, Sjors en
  Jan-Willem. Er zijn nog geen echte profielfoto's; de gekleurde cirkels met
  initialen hebben nu een duidelijk camera-icoontje en een toelichtende
  tekst eronder, zodat helder is dat dit placeholders zijn die later door
  echte foto's vervangen worden.

## Organisaties-pagina
`/organisaties/` is de centrale overzichtspagina voor scholen, bibliotheken
en andere organisaties, opgebouwd als:
- **Wat levert dit op**: algemene voordelen, met een informatie-CTA.
- **Logo-slider**: scrollende logo's van organisaties die al een workshop of
  licentie hebben afgenomen (`.logo-ticker`, bestanden in
  `assets/Organisaties/`). Deze sectie hoort hier en NIET op `/licentie/` —
  dat is in een eerdere feedbackronde per ongeluk verward met de aparte
  "licentiehouders"-carrousel (zie hieronder bij `/licentie/`).
- **Drie keuzes**: een `.choices-grid`/`.choice-plan`-blok met de 3 manieren
  om met NextGen AI te werken — AI-workshop boeken (→ `/ai-workshops/`),
  AI-lessenreeks (→ `/ai-lessenreeks/`) en licentie (→ `/licentie/`, visueel
  aanbevolen/`is-featured`, want dit heeft de voorkeur van de klant als
  meest structurele propositie).
- **Kennismaking**: een CTA-kaart met twee opties — direct een demo plannen
  via de Calendly-link van Peter Brouwers
  (`https://calendly.com/peter-impact`, zijn echte agenda-link), of een
  kennismakingsformulier uitklappen. Dat formulier staat als
  volledige-breedte-blok onder de aanbodsectie.
- **Junior AI League**: een blok over dit gelieerde programma, met een link
  naar junioraileague.nl.
- **Wat u krijgt als partner**: dezelfde kindveilige-software-boodschap als
  op de homepage, herschreven vanuit het perspectief van de bezoeker.

Verspreid over de pagina staan meerdere extra CTA-knoppen ("Vraag
vrijblijvend informatie aan" / "Plan direct een demo bij Peter") die naar het
juiste contactelement op dezelfde pagina scrollen — zie "Formulieren en
CTA-gedrag" hieronder voor hoe dat technisch werkt.

De partnerlogo's-websitelinks in de logo-slider zijn echte bestanden; vul
eventueel ontbrekende namen/logo's aan zodra bekend.

## Licentiepagina
`/licentie/` (niet in de hoofdnav, wel bereikbaar via het submenu bij
"Organisaties" en via interne links) is opgebouwd als:
- **Hero**: tekst + een echte foto uit de fotobibliotheek
  (`assets/fotobibliotheek/IMG_1290-licentie-hero.jpg`, apart gecomprimeerd
  naar ca. 300KB — het origineel in `assets/fotobibliotheek/` blijft
  ongemoeid voor de lightbox op `/in-beeld/`).
- **Licentiehouders**: een doorscrolbare carrousel (`.testi-carousel`,
  gedeelde CSS met de vergelijkbare carrousel-stijl) met voorbeeld-
  licentiehouders (bibliotheken/jeugdorganisaties). Deze sectie stond eerder
  op `/organisaties/` onder de kop "Wie werken er al met ons" en is bewust
  hierheen verplaatst en herkaderd naar licentie-specifieke tekst.
- **Voor wie / Wat kun je zelfstandig organiseren**: bij die laatste sectie
  staat het NextGen AI-logo zichtbaar (niet als vaag watermerk) linksonder de
  introtekst, op klantverzoek.
- **Wat levert een licentie op**: bewust GEEN concrete prijzen (die zijn op
  klantverzoek verwijderd) — in plaats daarvan een voordelenblok dat uitlegt
  wanneer een licentie zich terugverdient (bij meerdere workshops per jaar)
  en verwijst naar het aanvraagformulier voor een prijsopgave op maat.
- **Ondersteuning / Waarom een licentie**: bewust met verschillende
  ontwerpprincipes (vinklijst vs. genummerde kaarten) voor visuele
  afwisseling, zelfde inhoud.
- **Vergelijking**: hetzelfde 3-koloms `.compare-grid`/`.compare-card`-blok
  (workshop / lessenreeks / licentie, licentie aanbevolen) als op
  `/ai-lessenreeks/` — CSS staat sitewide in `css/styles.css`.
- **Hoe word je licentiehouder**: een tijdlijn met de globale stappen.
- **Aanvragen**: twee losstaande, wederzijds exclusieve opties — "Vraag
  informatie aan" opent het contactformulier, "Vraag een demo aan" opent
  in plaats daarvan een apart blok met uitleg dat Peter Brouwers de demo's
  persoonlijk verzorgt plus zijn Calendly-link. Zie "Formulieren en
  CTA-gedrag" hieronder.

**Openstaande TODO's in de code** (bewust niet verzonnen, staan als HTML-
comment op de pagina): exacte contractduur/opzegtermijn/facturatiewijze van
de licentie, en de exacte aanvraagprocedure/doorlooptijd tot de licentie
ingaat.

## AI-lessenreeks-pagina
`/ai-lessenreeks/` (niet in de hoofdnav, wel bereikbaar via het submenu bij
"Organisaties") beschrijft de voormalige propositie "Project Reboot" — die
naam wordt nergens meer gebruikt, de propositie heet nu simpelweg
"AI-lessenreeks digitale geletterdheid". Opgebouwd als:
- **Hero**: tekst + foto (`IMG_1268-lessenreeks.jpg`, gecomprimeerde kopie).
- **Kenmerken**: met een tweede foto (`NextgenAI-hackathon_1-lessenreeks.jpg`)
  en het NextGen AI-logo als decoratief watermerk verderop op de pagina.
- **Leerdoelen / Praktische informatie**: BEWUST geen vast aantal lessen of
  vaste lesduur genoemd (op klantverzoek verwijderd, was eerder "18 lessen
  van 30 minuten") — omschreven als flexibele lessenreeks die passend wordt
  gemaakt binnen onderwijs/projectperiode/planning.
- **Andere manieren om te starten**: hetzelfde `.compare-grid`-drieluik als
  op `/licentie/`, met de licentie-kaart aanbevolen.
- **Aanvragen**: een informatie-CTA (opent het formulier) én een directe
  Calendly-link voor een demo bij Peter Brouwers.

**Openstaande TODO in de code**: de exacte prijsopgave en aanvraagprocedure
voor de AI-lessenreeks.

## Bedankpagina
`/bedankt/` verschijnt automatisch na een succesvol verzonden formulier
(boekingsformulier op de workshoppagina, of het kennismakingsformulier op de
partnerpagina). De pagina leest de meegegeven gegevens uit de link
(workshopnaam, voornaam, type aanvraag) en past de inhoud daarop aan:
- Workshopaanvraag: bedankregel met de gekozen workshop, plus een tijdlijn
  met de 3 vervolgstappen (aanvraag ontvangen, trainers inplannen, workshop
  geboekt inclusief informatie en factuur).
- Kennismaking/partneraanvraag: een algemenere bedankboodschap, zonder tijdlijn.

Zodra er een echte server is: laat de `fetch(...)` in de submit-handlers
afwachten of de aanvraag echt is gelukt voordat je doorstuurt naar
`/bedankt/` (dit staat als commentaar bij de code). Nu, zonder server,
stuurt het formulier door zodra het geldig is ingevuld, en wordt de data op
de achtergrond verstuurd.

## Formulieren en CTA-gedrag
Er zijn meerdere formulier-contexten, allemaal aangesloten op dezelfde
verwerker (`formulier/send.php`):
- Het boekingsformulier per workshop op `/ai-workshops/` (`_pagina=workshops`).
- Het kennismakingsformulier op `/organisaties/` (`_pagina=organisaties`).
- Het aanvraagformulier op `/licentie/`, met twee waarden voor `_pagina`
  afhankelijk van welke knop is gebruikt: `licentie-info` (informatie
  aanvragen) of `licentie-demo` (gebruikt vóór de Calendly-omzetting
  hieronder; deze waarde staat nog in `formulier/send.php` en
  `formulier/mail-templates.php` maar wordt momenteel niet meer vanuit de
  pagina verstuurd — zie volgende punt).
- Het aanvraagformulier op `/ai-lessenreeks/` (`_pagina=ai-lessenreeks`).

**Informatie vs. demo, bewust verschillend afgehandeld.** Op `/licentie/`
en `/ai-lessenreeks/` opent "Vraag informatie aan" altijd het contactformulier
(dat via `formulier/send.php` mailt). "Vraag een demo aan" doet dat NIET meer
— die knop toont in plaats daarvan een apart blok met uitleg dat Peter
Brouwers de demo's persoonlijk verzorgt, met een directe link naar zijn
Calendly (`https://calendly.com/peter-impact`). Op `/licentie/` zijn deze
twee blokken (`#introFields` / `#demoFields`) wederzijds exclusief: het
openen van de één sluit de ander. Dezelfde Calendly-link wordt ook gebruikt
op `/organisaties/` bij "Plan direct in de agenda".

**Meerdere CTA-knoppen per pagina.** Op `/organisaties/`, `/licentie/` en
`/ai-lessenreeks/` staan bewust meerdere CTA-knoppen verspreid over de
pagina (niet alleen onderaan), die allemaal naar hetzelfde contactelement op
dezelfde pagina linken. Dit werkt via herbruikbare classes i.p.v. losse
`id`'s, zodat je knoppen kunt toevoegen zonder JS aan te passen:
- `.js-open-intro-form` (met `data-pagina="..."`) opent het formulier —
  gebruikt door alle "Vraag informatie aan"-knoppen op een pagina.
- `.js-open-demo-block` opent het demo-blok op `/licentie/` (was eerder een
  uniek `id="toggleDemoBlock"`, gerefactored naar een class toen er meerdere
  demo-knoppen op de pagina kwamen).

**Scroll-gedrag.** Bij het openen van een formulier/demo-blok wordt de
pagina er smooth naartoe gescrold, maar pas ná de uitklap-animatie
(`grid-template-rows`-transitie van 420ms) — de `scrollIntoView`-aanroep zit
in een `setTimeout(..., 450)`. Doe je dit niet, dan berekent de browser de
scrollpositie op basis van de nog niet volledig uitgeklapte (dus te kleine)
hoogte, en schiet de pagina te ver door zodra de animatie de hoogte alsnog
laat groeien. Voeg je een nieuwe uitklapbare sectie toe: pas dit patroon toe.

Voor alle formulieren geldt verder:
- Alle velden hebben een `name`-attribuut dat als POST-data binnenkomt
  (voornaam, achternaam, email, telefoon, organisatie, regio, workshop,
  gewenste/alternatieve datum, aantal kinderen, leeftijd/groep, locatie,
  factuurgegevens, bericht/opmerkingen).
- Er zit een verborgen honeypot-veld (checkbox, `_bevestig`) en een
  server-uitgegeven/server-vergeleken token (`formulier/token.php`) in voor
  spambescherming. **Bewust niet client-clock-gebaseerd** — dat heeft eerder
  tot bugs geleid waarbij echte inzendingen stil werden geweigerd.
- Bij een serverfout verschijnt een foutmelding met een directe
  mailto-link naar info@nextgen-ai.club, zodat er nooit een dode knop is.

## Mailverwerking
`formulier/send.php` verwerkt alle formulier-contexten hierboven en verstuurt via SMTP
(PHPMailer, bestanden in `lib/PHPMailer/`) twee e-mails per inzending:
1. Een interne melding met alle ingevulde velden naar `owner_email`
   (momenteel `peter@lead2deal.nl`), met BCC naar `owner_bcc`
   (`bastiaan@origyns.nl`).
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
`nextgen.mbscs.nl` (op de eigen server van Bastiaan, inclusief mail voor deze
demo), niet op het uiteindelijke domein. Zodra de site live gaat op het echte domein
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
- **Eigenaarsadres**: `owner_email` (en eventueel `owner_bcc`) in de
  workflow aanpassen naar de definitieve adressen waar aanvragen binnen
  moeten komen.
- De bestaande mailto-links in de code (`info@nextgen-ai.club`) kunnen
  blijven staan, die verwijzen al naar het toekomstige domein.
- **`.htaccess`**: bevat al de definitieve 301-redirects van de bestaande
  live NextGen AI-site (`/ai-for-kids`, `/licentiehouder`, `/sponsoring`,
  `/digitale-vaardigheden`, `/digitale-geletterdheid-project-reboot`) naar
  de nieuwe URL's, met het domein `nextgen-ai.club` hardcoded als doel. Geen
  wijziging nodig bij livegang zolang het productiedomein `nextgen-ai.club`
  blijft. `/junior-ai-league` redirect direct naar de zelfstandige Junior AI
  League-website (`junioraileague.nl`).

## Volgende stappen
1. **Openstaande TODO's** (bewust niet verzonnen, staan als HTML-comment in
   de code — vul aan zodra bekend, verzin niets):
   - `/licentie/`: exacte contractduur, opzegtermijn en facturatiewijze;
     exacte stappen/doorlooptijd van onboarding; exacte aanvraagprocedure en
     doorlooptijd tot de licentie ingaat.
   - `/ai-lessenreeks/`: exacte prijsopgave en aanvraagprocedure.
   - `/organisaties/`: partnerlogo's/websitelinks en voorbeeldpartners in de
     carrousels vervangen door de echte gegevens zodra bekend.
2. Teksten laten uitschrijven en aanscherpen.
3. Eigen CMS bouwen zodat teksten, impactcijfers en testimonials buiten de
   code om aan te passen zijn.
4. Bij livegang: alle punten onder "Demo-omgeving" hierboven doorlopen om
   van `nextgen.mbscs.nl` over te zetten naar `nextgen-ai.club`.
