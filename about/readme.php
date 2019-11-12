<h1 class="title">Dokumentation och om sidans struktur</h1>

<h4>Kodstruktur</h4>
<p>Katalogstrukturen är organiserad dels efter menyvalen i navbaren. T ex menyn <i>Artiklar</i> har en egen folder som heter <i>articles</i> där filer som har med den menyn att göra ligger. Strukturen följer upplägget för en multisida med submenyer även om submenyerna inte finns på alla sidor i denna aplikation (menyerna kan vara dålda). Men de finns där i bakgrunden. För att ta sig till subsidorna används en query string (?page="subpage") som utökar URL'en. </p>
<p>I <i>config-filen</i> sätts felhantering av sidan, dns'er till databaserna, start av namngiven session och en array av tabeller i databasen bmo2 som är giltiga att hämta data från.</p>
<p>I filen <i>functions.php</i> har jag samlat några funktioner, bland annat uppkoppling till databas, utskrifter av htmlkod som använder resultatet från databashämtning och en funktion som räknar ut antal rader i en databas.</p>

<h4>Responsivitet</h4>
<p>Sidan är tänkt att fungera relativt bra för format från iPhone 6/7/8 och större enheter. Menyn fälls ihop då skärmen blir mindre och visas då som en hamburger-meny. Man kommer åt menyn genom att klicka på hamburgern-menyn varvid menyvalen läggs vertikalt under varandra.</p>
<p>Det mesta på webbplatsen är uppbyggt med flex-kolumner vilket gör att det går att trycka ihop sidan. Sedan sker det också vissa förändringar i CSS'en för mindre skrämar så som att eventuella sidomenyer läggs ovanför och tar upp hela bredden istället för att lägga sig i vänsterspalt.</p>

<h4>Förbättringsförslag</h4>
<p>För att förbättra sidan så kan man så klart göra en hel del på bland annat detaljer. Tex skulle man behöva lägga in felhantering för inmatningsfält så att man inte kan mata in felaktiga uppgifter. Och att det skall visas ett användarvänligt meddelande till användaren om något är fel.</p>
<p>Man skulle också behöva ändra hur undersidorna till <i>Artiklar</i> och till <i>Objekt</i> hanterar hämtningar från databasen. Som det är nu så hämtas raden i tabellen med hjälp av id. Ifall man går till nästa genom att stega vidare med knappen <i>Nästa</i> så kan det bli en tom sida ifall det id't har plockats bort. Man skulle därför först behöva lista vilka id som finns i databasen och sedan kolla om det man vill hämt stämmer överens med den listan.</p>