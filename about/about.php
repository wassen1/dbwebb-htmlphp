<header>
    <h1 class="title">Om skaparen av webbsidan</h1>
    <p class="author">
        <?php echo "Last modified: "?> <time datetime="<?= date("Y-m-d H:i:s", filemtime(__FILE__)); ?>"><?= date("d F Y", filemtime(__FILE__)); ?></time> by Fredrik Wassermeyer
    </p>
</header>
<figure class="me flex-column" style="float:right;">
    <img src="img/me.jpg" alt="Bild på Fredrik">
    <figcaption>Fredrik Wassermeyer</figcaption>
</figure>

<p>Hej,</p>
<p>jag heter Fredrik och har skapat denna sida inom ramen för kursen Webbteknologier vid Blekinge tekniska högskola.</p>
<p>I kursen har vi fördjupat oss inom framförallt PHP och SQLite men även html- och css-tekniker.</p>
<p>Jag har intresserat mig för programmering sedan 2017. Det började med att vi startade en dataklubb tillsammans med några vänner för att förkovra oss inom datorer och programmering.</p>
<p>Jag har även läst en kurs i Java och en i Android. Har också läst kurspaketet Webbutveckling och programmering vid Blekinge Tekniska Högskola. I kursen har vi läst kurser så som Python, Linux, Javascript och Webapp.</p>
<p>Ett annat intresse än programmering är segling. Har alltid varit ute i båt om somrarna och även läst Fartygsbefäl kl7 på sjöfartshögskolan i Kalmar.</p>
<p>Under de senaste åren har jag varit anställd på ett filmbolag. Vi har producerat filmer framför allt för TV, både SVT och andra europeiska kanaler.</p>
<p>Jag har inte sysslat med datorer som ung och jag körde heller inte moppe. Men det är aldrig för sent att lära sig något nytt och intressant! Så numera kör jag motorcykel och ser ett nöje i att programmera på datorn och skapa häftiga saker.</p>

<?php require __DIR__ . "/../view/byline.php"; ?>