<?php
if (!($_SESSION["user"] ?? null)) {
    header("Location: login.php?page=login&location=" . urlencode($_SERVER['REQUEST_URI']));
    return;
}

$db = connectToDatabase($dsnBmo);


$action         = $_POST["action"] ?? "";
$id             = $_POST['id'] ?? null;
$title          = $_POST['title'] ?? "";
$category       = $_POST['category'] ?? "";
$text           = $_POST['text'] ?? "";
$image          = $_POST['image'] ?? "";
$owner          = $_POST['owner'] ?? "";
$author         = $_POST['author'] ?? "";
$pubdate        = $_POST['pubdate'] ?? "";
$content        = $_POST['content'] ?? "";

if ($_SESSION["tablechooser"] === "object") {

    if ($action == "Lägg till") {
        // Store posted form in parameter array
        
        $params = [$title, $category, $text, $image, $owner];
        
        $sql = <<<EOD
        INSERT INTO Object
        (title, category, text, image, owner)
        VALUES
        (?, ?, ?, ?, ?)
        ;
EOD;
    
        $stmt = $db->prepare($sql);
    
        executeDB($stmt, $params);
        $_SESSION['message'] = "Du har lagt till ett nytt objekt.";
    
    } else if ($action == "Updatera") { 
        $params = [$title, $category, $text, $image, $owner, $id];
        
        $sql = <<<EOD
        UPDATE Object
        SET 
            title = ?,
            category = ?,
            text = ?,
            image = ?,
            owner = ?
        WHERE id = ?
        ;
EOD;
    
        $stmt = $db->prepare($sql);
    
        executeDB($stmt, $params);
        $_SESSION['message'] = "Du har updaterat objekt nr $id.";

    } else if ($action == "Radera") {
        $params = [$id];
        
        $sql = <<<EOD
        DELETE
        FROM Object
        WHERE id = ?
        ;
EOD;
    
        $stmt = $db->prepare($sql);
        
        executeDB($stmt, $params);
        $_SESSION['message'] = "Du har raderat objekt nr $id.";
    }

} else if ($_SESSION["tablechooser"] === "article") {

    if ($action == "Lägg till") {

        $params = [$title, $category, $content, $author, $pubdate];
        
        $sql = <<<EOD
        INSERT INTO Article
        (title, category, content, author, pubdate)
        VALUES
        (?, ?, ?, ?, ?)
        ;
EOD;
    
        $stmt = $db->prepare($sql);
    
        executeDB($stmt, $params);
        $_SESSION['message'] = "Du har lagt till en ny artikel.";
    
    } else if ($action == "Updatera") {

        $params = [$title, $category, $content, $author, $pubdate, $id];
        
        $sql = <<<EOD
        UPDATE Article
        SET 
            title = ?,
            category = ?,
            content = ?,
            author = ?,
            pubdate = ?
        WHERE id = ?
        ;
EOD;
    
        $stmt = $db->prepare($sql);
    
        executeDB($stmt, $params);
        $_SESSION['message'] = "Du har updaterat artikel nr $id.";

    } else if ($action == "Radera") {

        $params = [$id];
        
        $sql = <<<EOD
        DELETE
        FROM Article
        WHERE id = ?
        ;
EOD;
    
        $stmt = $db->prepare($sql);
        
        executeDB($stmt, $params);
        $_SESSION['message'] = "Du har raderat artikel nr $id.";
    }
}

if ($action == "Återskapa") {

    $sql = <<<EOD
    DROP TABLE IF EXISTS "Article";
EOD;

    $stmt = $db->prepare($sql);
    executeDB($stmt);

    $sql = <<<EOD
    CREATE TABLE IF NOT EXISTS "Article" (
        "id"	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
        "category"	TEXT,
        "title"	TEXT,
        "content"	TEXT,
        "author"	TEXT,
        "pubdate"	DATETIME NOT NULL DEFAULT CURRENT_DATE
    );
EOD;
    
    $stmt = $db->prepare($sql);

    executeDB($stmt);

    $sql = <<<EOD
    DROP TABLE IF EXISTS "Object";
EOD;
    $stmt = $db->prepare($sql);
    executeDB($stmt);

    $sql = <<<EOD
    CREATE TABLE IF NOT EXISTS "Object" (
        "id"	INTEGER NOT NULL UNIQUE,
        "title"	TEXT,
        "category"	TEXT,
        "text"	TEXT,
        "image"	TEXT,
        "owner"	TEXT,
        PRIMARY KEY("id")
    );
EOD;
    $stmt = $db->prepare($sql);
    executeDB($stmt);

    $sql = <<<EOD
    INSERT INTO "Object" VALUES (1,'Begravningskonfekt, svart, änglar, 4 stycken','Begravningskonfekt','Begravningskonfekt för allmmoge. Motiv av änglar.','begravningskonfekt_anglar_x4.jpg','Ronny Holm'),
 (2,'Begravningskonfekt, högre stånd','Begravningskonfekt','Begravningskonfekt för högre stånd.','begravningskonfekt_hogre_stand.jpg','Ronny Holm'),
 (3,'Begravningskonfekt x2. Madonna, Maria och Jesus-barnet','Begravningskonfekt','Begravningskonfekt för allmmoge. Motiv Madonna med kors samt Maria och Jesus-barnet.','begravningskonfekt_madonna_maria_o_jesus.jpg','Ronny Holm'),
 (4,'Begravningskonfekt, tro hopp och kärlek','Begravningskonfekt','Begravningskonfekt för allmmoge. Motiv med Tro hopp och kärlek.','begravningskonfekt_svart_tro_hopp_karlek.jpg','Ronny Holm'),
 (5,'Begravningskonfekt x2, svart, tro hopp och kärlek','Begravningskonfekt','Begravningskonfekt för allmoge. Symboler av tro hopp och kärlek.','begravningskonfekt_svart_tro_hopp_karlekx2.jpg','Ronny Holm'),
 (6,'Begravningskonfekt silver x2, tro hopp och kärlek samt grav','Begravningskonfekt','Begravningskonfekt för allmoge. Symboler för tro hopp kärlek samt en gravsymbol.','begravningskonfekt_tro_hopp_karlek_samt_grav.jpg','Ronny Holm'),
 (7,'Begravningskonfekt vit x3, maria med Jesus-barnet samt Madonna-bild','Begravningskonfekt','Begravningskonfekt för allmoge. Vita med bild på Maria och Jesusbarnet samt en Madonna-bild.','begravningskonfekt_x3_maria_jesus_samt_madonna.jpg','Ronny Holm'),
 (8,'Begravningssked','Begravningssked','Begravningssked, 1804. Inskriptionen lyder "Pr. Th. Prof. DomProsten Dr Lars T Palmberg" Född 10/8 1713, Död 28/10 1804. Begravningsskedar användes främst vid adelsbegravningar och fungerade som hedersbetygleser till de som hjälpte till med begravningen eller bar kistan.','begravningssked_lars_palmberg.jpg','Ronny Holm'),
 (9,'Begravningstal Eric Crispin Segercrona','Begravningstal','Begravningstal för Eric Crsipin Segercrona i Clarae kyrka den 14 april 1795. 

Begravningstal hålls i samband med begravningen och beskrev den avlidnes levnadshistoria. Ju längre begravningstal desto finare hedersbetygelse.','begravningstal_eric_crispin_segercronas.jpg','Ronny Holm'),
 (10,'Begravningstal Mårten Cronstierna','Begravningstal','Begravningstal för "Den Högvälborne Herren, Herr Mårten Cronstierna, Friherre till Håtuna och Hammarby, i Håtuna Kyrka i uppland den 1 Octobris 1752".

Begravningstal hålls i samband med begravningen och beskrev den avlidnes levnadshistoria. Ju längre begravningstal desto finare hedersbetygelse.','begravningstal_marten_cronstierna.jpg','Ronny Holm'),
 (11,'Begravningstårta','Begravningsfest','Begravningstårta med inskription "Älskad Sörjd Saknad".','begravningstarta.jpg','Ronny Holm'),
 (12,'Gravöl','Begravningsfest','Bricka med glas och gravöl, pilsner från Egnells bryggeri i Eksjö.','gravol.jpg','Ronny Holm'),
 (13,'Portvin med glas','Begravningsfest','Bricka med glas och portvin, "Fint Superior Portvin, AB Fredrik Ingelman & Co".','portvin_med_glas.jpg','Ronny Holm'),
 (14,'Inbjudningsbrev Johan August Lång','Inbjudningsbrev','Inbjudningsbrev till jordfästning av Johan August Lång i Långaryds kyrka söndagen den 11 september 1927 kl 10 f.m.','inbjudningsbrev_johan_august_lang.jpg','Ronny Holm'),
 (15,'Inbjudningsbrev Johan Nikolaus Ekstrand','Inbjudningsbrev','Inbjudningsbrev till begravningsakt vid Södra Hestra Kyrka, söndagen den 25 niv. 1928 kl. 10 f.m. samt enklare middag i sorgehuset.','inbjudningsbrev_johan_nikolaus_ekstrand.jpg','Ronny Holm'),
 (16,'Minnestavla Anders Petters','Minnestavla','Minnestavla 1909, "Minne af Anders Petters".','minnestavla_anders_petters.jpg','Ronny Holm'),
 (17,'Minnestavla Anna Persson','Minnestavla','Minnestavla 1901, "Minne efter flickan Anna Persson".','minnestavla_anna_persson.jpg','Ronny Holm'),
 (18,'Minnestavla Petter Anders Son','Minnestavla','Minnestavla, 1869, "Minne av Petter Anders Son"','minnestavla_pas.jpg','Ronny Holm'),
 (19,'Minnestavla EPAD','Minnestavla','Minnestavla 1899 efter EPAD.','minnestavla_epad.jpg','Ronny Holm'),
 (20,'Minnestavla EUG','Minnestavla','Minnestavla, 1881 efter EUG.','minnestavla_eug.jpg','Ronny Holm'),
 (21,'Minnestavla Granstorp','Minnestavla','Minnestavla 1854, inskription Granstorp.','minnestavla_granstorp.jpg','Ronny Holm'),
 (22,'Minnestavla SUS','Minnestavla','Minnestavla 1857. ','minnestavla_sus.jpg','Ronny Holm'),
 (23,'Minnestavla USS','Minnestavla','Minnestavla 1874.','minnestavla_uss.jpg','Ronny Holm'),
 (24,'Pärlkrans med blomma','Pärlkrans','Pärlkrans, gravprydnad av glasstavar och pärlor med blomprydnad i mitten.','parlkrans_blomma.jpg','Ronny Holm'),
 (25,'Pärlkrans med handslag','Pärlkrans','Pärlkrans, gravprydnad av glasstavar och pärlor med prydnad av ett handslag i mitten.','parlkrans_handslag.jpg','Ronny Holm'),
 (26,'Pärlkrans med kristusbild','Pärlkrans','Pärlkrans, gravprydnad av glasstavar och pärlor med prydnad av kristusbild i mitten.','parlkrans_jesus_bild.jpg','Ronny Holm'),
 (27,'Pärlkrans Jesus på Golgata','Pärlkrans','Pärlkrans, gravprydnad av glasstavar och pärlor med bild på Jesus med korset som symboliserar Golgata-vandringen.','parlkrans_jesus_golgata.jpg','Ronny Holm'),
 (28,'Pärlkrans Kristus med törnkrans','Pärlkrans','Pärlkrans, gravprydnad av glasstavar och pärlor med bild på Jesus med med en krans av törner.','parlkrans_jesus_med_tornkrans.jpg','Ronny Holm'),
 (29,'Pärlkrans Jesus på korset','Pärlkrans','Pärlkrans, gravprydnad av glasstavar och pärlor med bild på Jesus på korset.','parlkrans_jesus_pa_korset.jpg','Ronny Holm'),
 (30,'Pärlkrans med korsfäst Jesus','Pärlkrans','Pärlkrans, gravprydnad av glasstavar och pärlor med bild på Jesus på korset.','parlkrans_korsfast_jesus.jpg','Ronny Holm');
EOD;
    $stmt = $db->prepare($sql);
    executeDB($stmt);

    $sql = <<<EOD
    INSERT INTO "Article" VALUES (1,'article','Begravningskonfekt','<p>Seden att bjuda på sorgekonfekt spred sig under senare hälften av 1800-talet 
från adeln till borgarfamiljerna i de större städerna. Från 1800-talets slut  och fram till 1930-talet var det en vedertagen sedvänja i stora delar av vårt land. Begravningskonfekten beställdes antingen på ortens konditori eller från någon av bygdens karamellgummor. Innehållet i högtidskonfekterna tycks alltid ha varit en tjock glasyr, ibland med någon essens i. Den avlidnes initialer kunde skrivas i svart glasyr ovanpå.</p>

<p>Konfekten hade omslag av svart eller vitt krusat papper och dekor av tyll och spets. Ofta dekorerades de med sentimentala texter som monterades på konfekternas ovansida med en liten änglabild, ett kors eller något liknande. Vanligtvis serverades konfekten före begravningen men även direkt då gästerna återvänt till sorgehuset efter begravningshögtiden. Ofta sparades begravningskonfekten till minne av den avlidne och lades undan i stället för att ätas upp.</p>
','Av Ronny Holm, bearbetad av Mikael Roos','2010-10-14'),
 (2,'article','Minnestavlor','<p>Bruket med begravningstavlor får allt större utbredning i början av 1800-talet och är vanligast i sydvästra Sverige, Halland, västra Småland och sydöstra Skåne. Seden upphörde under 1900-talets första decennier. Minnestavlorna består  ofta av namn på den döde, födelsedatum, dödsdatum och en hyllningstext i form av en vers som omges av kors, kistor, änglar, sorgtråd, urnor m.m.</p>

<p>Bland dem som målade minnestavlor fanns ofta i äldre tider skollärare och indelta soldater som lärt sig skriva, ibland också församlingens klockare. Efter folkskolestadgans införande 1842 lärde sig allt flera att läsa och skriva, vilket gjorde att även lantbrukare kunde måla minnestavlor vid sidan av sitt ordinarie arbete. En bygdekonstnär som hade en egen personlig stil kunde bli tongivande i en hel trakt och hans tavlor kom att pryda väggarna i många hem till minne av en kär anhörig som gått bort.</p>

<p>Den mångsidige halländske bonden Eric Jacob Romberg (1810-1895) är främst känd för sina målade minnestavlor. Vad man först lägger märke till i hans tavlor är de många grälla färgerna, helt i stil med allmogemåleriets gamla traditioner,  vilket ger ett något brokigt intryck. Utmärkande är också målningens arkitektoniska uppbyggnad.</p>
','Av Ronny Holm, bearbetad av Mikael Roos','2010-10-14'),
 (3,'article','Pärlkransar','<p>Kransar gjorda av glaspärlor hängdes på gravkorset eller lades på graven. Den tunna tråden med glaspärlor formades till spiraler, blad eller blommor. Bruket kom ursprungligen från Italien och Frankrike men började förekomma i Sverige under senare delen av 1800-talet. Man lade den på kistan i hemmet och 
sedan följde kransen kistan till gravsättningen då man lade kransen på graven.</p>

<p>Trots att metalltråden rostade och glaspärlorna kunde gå sönder av frosten varade kransarna längre än de av naturligt material. Efter en tid tog man hem kransen och förvarade den på loge eller vind för att användas vid nästa dödsfall. Först på 30-talet försvann de från kyrkogårdarna; på landsbygden kunde de dock ses ända in på 50- och 60-talen.</p>
','Av Ronny Holm, bearbetad av Mikael Roos','2010-10-14'),
 (4,'about','Om BMO','<p>Begravningsmuseum Online (BMO) finns för att vårda ett kulturarv av seder och bruk kring begravningar. Vilka var de seder och bruk som användes vid begravningar för ett eller två sekel sedan? Vi glömmer snabbt. BMO finns för att vårda minnen av gångna tiders seder och bruk. Förhoppningsvis ger det oss en förståelse för hur det var på farfars och mormors tid, kanske kan det även hjälpa oss att nyansera vår bild av hur vi gör idag.</p>

<p>Denna webbplats är resultat av ett samarbete mellan Ronny Holm, Mikael Roos och studenter på kursen "Databaser, HTML, CSS och skriptbaserad PHP-programmering" vid Blekinge Tekniska Högskola.</p>

<p>Texterna på BMO är skapade av Ronny Holm och Mikael Roos, om inte annat anges. Bilderna som används är från Ronny Holms privata samling. De objekt som finns på BMO är från Ronny Holms privata samling om inget annat anges.</p>

<p>Varje student har skapat ett eget BMO, mer eller mindre inspirerade av 
sina med-studenters arbeten, input från Ronny Holm i sin funktion som kund samt input och feedback från kursens lärare.</p>

<p>Text och material på denna webbplats är publicerat enligt licensen 
<a href="http://creativecommons.org/licenses/by-sa/3.0/">Creative Commons Attribution Share-Alike License v3.0</a> om inte annat anges.</p>

<p>Denna webbplatsen har ingen koppling till det befintliga Begravningsmuseum som fortfarande finns i Ljungby.</p>
',NULL,'2011-04-13'),
 (5,'article','Begravningsfest och Gravöl - ett stort kalas','<p>När ett dödsfall inträffat, fick de närmaste anhöriga bråda dagar. Den döde skulle med heder och aktning komma i jorden. Men det gällde också att rusta för begravningskalaset. Ofta skedde bjudningen på själva begravningsdagen. Inbjudning skickades ut i samband med att dödsfallet meddelades. De som var bjudna dök oftast upp, man tackade hellre nej till bröllop än till en begravning.</p>

<p>Vid större begravningskalas hade gästerna med sig "förning", husmödrarna rådslog vilken förning som skulle medtagas så att det blev lagom mycket av varje sort. Vanliga matvaror i en förningskorg var bröd, mjölk, smör, ost, ägg, gröt, färdiga stekar, fårlår, höns, fläsk, äggpannkakor, puddingar, tårtor och kakor.</p>

<p>Ett begravningskalas var lika ståtligt och storartat som ett bröllop. Man dukade i vitt och svart i husets finaste rum, detta var ofta samma rum som den döde stått lik i, på detta sätt ansåg man att man hedrade den avlidne. Var huset för litet så dukade man även hos grannen. Ett kalas kunde pågå i två gårdar samtidigt.</p>

<p>Borden prålade av maträtter och dryck. Man åt i omgångar, smårgåsbord, soppa, varmrätt och efterätt.</p>

<p>Vid en begravning anno 1795 skrev Märta Helena Reenstierna följande om maten:</p>

<p>"Efter jordfästningen kommo alla hit, och undfägnades först med Renskt vin och Confect, sedan med en Soupée af 10 rätter, Désere, Sylt, Pounch, Biscop (bål), och viner."</p>

<p>Känsloläget var ofta långt ifrån bedrövat vid dessa tillställningar. Man kunde höra gästerna säga "Det var en riktigt trevlig begravning!". Det var inte alla bröllop som nådde samma nivå av glädje och uppslupenhet. Man skämtade, berättade historier, gissade gåtor och spelade kort. Ibland dansade man till och med."</p>

<p>Källa: "Seder och bruk vid livets slut, bok av Lars Bondeson"</p>
','Av Mikael Roos','2011-04-13'),
 (6,'maggy','Begravningsseder och bruk','<h2 id="Bakgrund">Bakgrund</h2>

 <p>Följande artikel är skriven av Maggy Larsson och är publicerad i "Hakarps Församlingsblad, Höst, Nr 3 - 2008". Maggy har gett sin tillåtelse att vi använder den.</p>
 
 <p>Artikeln skrevs efter att församlingen gjorde en resa till Begravningsmuséet i Ljungby. Därefter anordnade församlingen en egen utställning. Som avslutning på utställningen berättade kyrkogårdschefen och grundaren av begravningsmuséet, Ronny Holm, om gamla begravningsseder.</p>
 
 <p>Artikeln bygger på Ronny Holm''s anförande och återges med hjälp av texter från Begravningsmuséet i Ljungby och från boken ”Begravningsseder i förändring”.</p>
 
 <p>Bilderna kommer från Ronny Holms samling och är redigerade av Mikael Roos som även skrivit bildtexterna samt redigerat artikel för webb-bruk.</p>
 
 <img src="img/maggy/hakarpsforsamlingsblad20083.png" alt="hakarpsforsamlingsblad 20083" class="image--article">
 
 <h2 id="Forr_i_tiden">Förr i tiden</h2>
 
 <p>Begravningen skedde förr i tiden ganska snart efter dödsfallet och den döde bars från hemmet till graven. Kring mitten av 1800-talet blev det allt vanligare att man körde den döde till kyrkan med häst och vagn.</p>
 
 <img src="img/maggy/begravning_1800.jpg" alt="begravning 1800" class="image--article">
 <img src="img/maggy/begravningsfolje.jpg" alt="begravningsfölje" class="image--article">
 
 <h2 id="Den_forsta_likvagnen_i_Hakarp">Den första likvagnen i Hakarp</h2>
 
 <p>Den första likvagnen i Hakarp tillverkades av Granlunds Vagnfabrik i Gränna. Fabriken var berömd för leveranser till hovet, Finland och Ryssland. Vagnarna gjordes helt för hand. Kyrkoherden Knut Anders Sandström (präst i Hakarp 1903-1923) skänkte vagnen till församlingen 1907. Vagnen användes i Hakarp mellan åren 1907 och 1948. Som ny kostade vagnen ca 700 kronor. Men då vagnen så småningom ansågs ”livsfarlig” med dåliga bromsar överlämnades den till länsmuseet. För 1 krona inköptes Huskvarnaförsamlingens likvagn. I Huskvarna anskaffades en likbil år 1947. Den då inköpta likvagnen finns nu i Garpa skans 
 (vid Huskvarna kyrkogård).</p>
 
 <img src="img/maggy/likvagn_med_hast.jpg" alt="likvagn med hast" class="image--article">
 
 <img src="img/maggy/likvagn.jpg" alt="likvagn" class="image--article">
 
 <img src="img/maggy/begravningsbil.jpg" alt="begravningsbil" class="image--article">
 
 <h2 id="Begravningsbyraer">Begravningsbyråer</h2>
 
 <p>Begravningsbyråer fanns till en början inte. Förberedelser inför begravningen sköttes av de anhöriga och alla i byn ställde upp och stöttade på olika sätt.
 På 1880-talet fanns det bara tre begravningsfirmor i Stockholm, men redan kring sekelskiftet drygt tio. De svenska begravningsentreprenörerna organiserade sig 1922 i ett eget förbund.</p>
 
 <img src="img/maggy/begravningsbyra_medarbetare.jpg" alt="begravningsbyrå medarbetare" class="image--article">
 
 <img src="img/maggy/begravningsbyra_skylt.jpg" alt="begravningsbyra skylt" class="image--article">
 
 <img src="img/maggy/annons_begravningsbyra.jpg" alt="annons begravningsbyra" class="image--article">
 
 <h2 id="Begravningstavlor_-_minnestavlor">Begravningstavlor - minnestavlor</h2>
 
 <p>Bruket med begravningstavlor fick en allt större utbredning i början av 1800-talet och var vanligast i sydvästra Sverige, Halland, västra Småland och sydöstra Skåne. Seden upphörde under 1900-talets första decennier. Minnestavlorna består ofta av namn på den döde, födelsedatum, dödsdatum och en hyllningstext i form av en vers som omges av kors, kistor, änglar, sorgträd, urnor mm.</p>
 
 <img src="img/maggy/minnestavla.jpg" alt="minnestavla" class="image--article">
 
 <h2 id="Parlkransar">Pärlkransar</h2>
 
 <p>Kransar gjorda av glaspärlor hängdes på gravkorset eller lades på graven. Den tunna tråden med glaspärlor formades till spiraler, blad eller blommor. Bruket kom ursprungligen från Italien och Frankrike men började förekomma i Sverige under senare delen av 1800-talet. Man lade den på kistan i hemmet och sedan följde kransen kistan till gravsättningen, då man lade kransen på graven. Blommor var dyra och kunde vara svåra att anskaffa.</p>
 
 <p>Trots att metalltråden rostade och glaspärlorna kunde gå sönder av frosten varade kransarna längre än de av naturligt material. Efter en tid tog man hem kransen och förvarade den på loge eller vind för att användas vid nästa dödsfall. Först på 30-talet försvann de från kyrkogårdarna. På landsbygden kunde de dock ses ända in på 50- och 60-talen.</p>
 
 <img src="img/maggy/parlkrans.jpg" alt="pärlkrans"  class="image--article">
 <img src="img/maggy/parlkrans_vid_grav.jpg" alt="pärlkrans vid grav" class="image--article">
 
 <h2 id="Gravol">Gravöl</h2>
 
 <p>Att ställa till med stort kalas i sorgehuset efter begravningen var förr en självklarhet. Det är först under 1900-talets gång som begravningar och gravöl omformats till minnesstunder i form av stillsamma och lågmälda samkväm, ofta i litet format. Tidigt på begravningsdagens morgon samlades alla inbjudna gäster i sorgehuset för att äta frukost. Efter jordfästningen och gudstjänsten var det åter dags att bege sig till sorgehuset. Det var nu den stora festen skulle börja. Festens form vid ett gravöl skilde sig inte nämnvärt från ett bröllop i äldre tid.</p>
 
 <p>Gästerna skulle ha förning med sig. Vanliga matvaror i förningen var bröd, smör, ost, ägg, gröt, kött, fläsk, pudding och ostkakor. Gästerna skulle ha förning med sig tillbaka när bjudningen var över. Många gånger bestod den av smakbitar av de övriga gästernas förning men det förekom också att värdinnan ställde till med brödbak för att gästerna skulle få något med sig hem. Det var vanligt med stora begravningskringlor – sockerkringlor – av vete eller saffran. I regel var de så väl tilltagna, att de kunde hängas på armen. Ju större, desto bättre blev anseendet för värdfolket och desto mer hedrades den döde.</p>
 
 <img src="img/maggy/gravol.jpg" alt="gravöl"  class="image--article">
 
 <h2 id="Dodsannonser">Dödsannonser</h2>
 
 <p>Dödsannonser förekom i dagstidningarna först på 1850-talet. Från början hade de formen av ett kort och mycket formellt tillkännagivande. Längre fram blev det vanligt att tillfoga uppgifter om tidpunkt och plats för begravningen. I början av 1900-talet uppstod bruket att sätta ut de sörjandes förnamn i annonsen. Det blev också vanligt att referera till en bibel- eller psalmvers. På 1930-talet bortföll uträkningen av den avlidnes exakta ålder liksom uppgiften om klockslaget då döden inträffade.</p>
 
 <p>Vid tiden kring sekelskiftet kunde man se de första korsen i annonserna, men först vid mitten på 1900-talet hade korssymbolen slagit igenom helt. Nyårsaftonen 1977 förekom den första blomman i en dödsannons och idag har vi många symboler att välja bland, mer än 250 stycken. Valet av symbol motiveras oftast av att det ska passa in på den döda.</p>
 
 <img src="img/maggy/dodsannonser.jpg" alt="dödsannonser" class="image--article">
 
 <h2 id="Kladsel">Klädsel</h2>
 
 <p>Det ansågs allmänt att de anhöriga skulle sörja den döde ett år. Under den tiden skulle festliga tillställningar undvikas. Den sörjande borde också bära en särskild klädedräkt för att utåt visa sin sorg. Svart är av traditionen sorgens färg och den svarta sorgdräkten blev vanlig i slutet av 1600-talet. Inom de borgerliga samhällsklasserna var frack och hög hatt långt fram i vår egen tid  det vanliga sorgplagget för män.</p>
 
 <p>Det mest slående inslaget i den kvinnliga sorgdräkten har annars varit sorgslöjan, som de närmast anhöriga bar under hela sorgetiden. Slöjans längd skulle stå i proportion till sorgens ”djup”. Den svarta, kvinnliga sorgdräkten kompletterades förr i tiden av vita förkläden, en sed som först brukats i samband med hovsorg. Men många hade inte fler plagg än som de bar. För dem blev sorgförklädet en möjlighet att klä sig i sorg. Högborgerliga kvinnor bar ”Smäck och gravor”, snibbmössor med flor, vid begravningar och kondoleansvisiter.</p>
 <img src="img/maggy/sorgesloja.jpg" alt="sorgeslöja" class="image--article">
 ','Av Maggy Larsson','2010-09-10');
EOD;
    $stmt = $db->prepare($sql);
    executeDB($stmt);
    
    $_SESSION['message'] = "Du har återskapat databaserna.";

}
header("Location: ?page=index");
