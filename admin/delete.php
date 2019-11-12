<?php
if (!($_SESSION["user"] ?? null)) {
    header("Location: login.php?page=login&location=" . urlencode($_SERVER['REQUEST_URI']));
    return;
}

$table = null;

if ($_SESSION["tablechooser"] === "object") {
    $table = "Object";
} else if ($_SESSION["tablechooser"] === "article") {
    $table = "Article";
}

    $id = $_GET['id'] ?? null;
    $db = connectToDatabase($dsnBmo);
        
    $sql = <<<EOD
    SELECT
        *
    FROM $table
    WHERE id = ?
    ;
EOD;
    $params = [$id];
    $stmt = $db->prepare($sql);
    $stmt->execute($params);
    $res = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<div class="flex-column align-items-center">
    <?php if ($_SESSION["tablechooser"] === "object") : ?>
        <h1 class="title">Är du helt säker på att du vill radera objektet?</h1>
        <nav class="small-navbar">
            <a href="?page=index">Alla objekt</a>
            <a href="?page=create">Lägg till objekt</a>
            <a href="?page=init">Återskapa databas</a>
        </nav>
        <form method="post" action="?page=process">
            <fieldset>
                <legend>Radera objekt</legend>
                <label for="id">id:</label>
                <input type="hidden" name="id" value="<?= htmlentities($res["id"]) ?>">
                <input type="text" id="id" name="id" value="<?= htmlentities($res["id"]) ?>" disabled>
                
                <label for="title">titel:</label>
                <input type="text" id="title" name="title" value="<?= htmlentities($res["title"]) ?>" disabled>
                
                <label for="category">kategori:</label>
                <input type="text" id="category" name="category" value="<?= htmlentities($res["category"]) ?>" disabled>
                
                <label  for="text">text:</label>
                <textarea id="text" name="text" disabled><?= htmlentities($res["text"]) ?></textarea>
                
                <label  for="image">bild:</label>
                <input type="text" id="image" name="image" value="<?= htmlentities($res["image"]) ?>" disabled>
                
                <input type="submit" name="action" value="Radera" class="danger">
            </fieldset>
        </form>
    <?php elseif ($_SESSION["tablechooser"] === "article") : ?>
        <h1 class="title">Är du helt säker på att du vill radera artikeln?</h1>
        <nav class="small-navbar">
            <a href="?page=index">Alla artiklar</a>
            <a href="?page=create">Lägg till artikel</a>
            <a href="?page=init">Återskapa databas</a>
        </nav>
        <form method="post" action="?page=process">
            <fieldset>
                <legend>Radera artikel</legend>
                <label for="id">id:</label>
                <input type="hidden" name="id" value="<?= htmlentities($res["id"]) ?>">
                <input type="text" id="id" name="id" value="<?= htmlentities($res["id"]) ?>" disabled>
                
                <label for="title">titel:</label>
                <input type="text" id="title" name="title" value="<?= htmlentities($res["title"]) ?>" disabled>
                
                <label for="category">kategori:</label>
                <input type="text" id="category" name="category" value="<?= htmlentities($res["category"]) ?>" disabled>
                
                <label  for="content">html:</label>
                <textarea id="content" name="content" disabled><?= htmlentities($res["content"]) ?></textarea>
                
                <label  for="author">författare:</label>
                <input type="text" id="author" name="author" value="<?= htmlentities($res["author"]) ?>" disabled>

                <label  for="pubdate">publicerat:</label>
                <input type="text" id="pubdate" name="pubdate" value="<?= htmlentities($res["pubdate"]) ?>" disabled>
                
                <input type="submit" name="action" value="Radera" class="danger">
            </fieldset>
        </form>
    <?php endif; ?>
</div>
