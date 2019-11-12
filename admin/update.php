<?php
if (!($_SESSION["user"] ?? null)) {
    header("Location: login.php?page=login&location=" . urlencode($_SERVER['REQUEST_URI']));
    return;
}

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
        <h1 class="title">Updatera</h1>
        <nav class="small-navbar">
            <a href="?page=index">Alla objekt</a>
            <a href="?page=create">Lägg till objekt</a>
            <a href="?page=init">Återskapa databas</a>
        </nav>
        <form method="post" action="?page=process">
            <fieldset>
                <legend>Updatera objekt</legend>
                <label for="id">id:</label>
                <input type="hidden" name="id" value="<?= htmlentities($res["id"]) ?>">
                <input type="text" id="id" name="id" value="<?= htmlentities($res["id"]) ?>" disabled>
                
                <label for="title">titel:</label>
                <input type="text" id="title" name="title" value="<?= htmlentities($res["title"]) ?>">
                
                <label for="category">kategori:</label>
                <input type="text" id="category" name="category" value="<?= htmlentities($res["category"]) ?>">
                
                <label  for="text">text:</label>
                <textarea id="text" name="text"><?= htmlentities($res["text"]) ?></textarea>
                
                <label  for="image">bild:</label>
                <input type="text" id="image" name="image" value="<?= htmlentities($res["image"]) ?>">

                <label  for="owner">ägare:</label>
                <input type="text" id="owner" name="owner" value="<?= htmlentities($res["owner"]) ?>">
                
                <input type="submit" name="action" value="Updatera" class="default-color">
            </fieldset>
        </form>
    <?php elseif ($_SESSION["tablechooser"] === "article") : ?>
        <h1 class="title">Updatera</h1>
        <nav class="small-navbar">
            <a href="?page=index">Alla artiklar</a>
            <a href="?page=create">Lägg till artkel</a>
            <a href="?page=init">Återskapa databas</a>
        </nav>
        <form method="post" action="?page=process">
            <fieldset>
                <legend>Updatera artikel</legend>
                <label for="id">id:</label>
                <input type="hidden" name="id" value="<?= htmlentities($res["id"]) ?>">
                <input type="text" id="id" name="id" value="<?= htmlentities($res["id"]) ?>" disabled>
                
                <label for="title">titel:</label>
                <input type="text" id="title" name="title" value="<?= htmlentities($res["title"]) ?>">
                
                <label for="category">kategori:</label>
                <input type="text" id="category" name="category" value="<?= htmlentities($res["category"]) ?>">
                
                <label  for="content">html:</label>
                <textarea id="content" name="content"><?= strip_tags($res["content"], '<p><h2><img>') ?></textarea>
                
                <label  for="author">författare:</label>
                <input type="text" id="author" name="author" value="<?= htmlentities($res["author"]) ?>">

                <label  for="pubdate">publicerat:</label>
                <input type="text" id="pubdate" name="pubdate" value="<?= htmlentities($res["pubdate"]) ?>">
                
                <input type="submit" name="action" value="Updatera" class="default-color">
            </fieldset>
        </form>
    <?php endif; ?>
</div>
