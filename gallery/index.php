<?php
$id = $_GET["id"] ?? null;
$db = connectToDatabase($dsnBmo);
$radios = [
    "2" => "två",
    "4" => "fyra",
    "8" => "åtta",
];
$radiochooser = $_SESSION['radiochooser'] ?? array_key_first($radios);
$offset = $_GET["offset"] ?? 0;
$limit = $_GET["limit"] ?? $radiochooser;
$rows = 0;

//Get amount of rows in table
$sql = <<<EOD
SELECT Count(*)
FROM Object
;
EOD;
$stmt = $db->prepare($sql);
$stmt->execute();
$rows = intval($stmt->fetch(PDO::FETCH_COLUMN));



//Get images to gallery
$sql = <<<EOD
SELECT
    id, image, title
FROM Object
LIMIT $limit OFFSET $offset
;
EOD;
    
$stmt = $db->prepare($sql);
$stmt->execute();
$res = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="flex-column align-items-center">
    <h1 class="title">Galleri</h1>

    <form action="?page=form-process" method="post">
        <input type="hidden" name="redirect" value="?page=index&offset=<?= $offset ?>">

        <label>Välj antal bilder: </label><br>
        <?php foreach ($radios as $key => $label) :
            $checked = null;
            if ($key === $radiochooser) {
                $checked = "checked=\"checked\"";
            }
            ?>
            <label><?= $label ?></label>
            <input <?= $checked ?> type="radio" name="radiochooser" value="<?= $key ?>" onchange="this.form.submit();">
        <?php endforeach; ?>
    </form>
    <?= printGalleryResultsetToHTMLTable($res); ?>

    <nav class="small-navbar space-between">
        <?php if ($offset > 1) : ?>
            <a href="?offset=<?= ($offset - $limit) ?>">&#x2770; Föregående</a>
        <?php else : ?>
            <div style="visibility:hidden;"></div>
        <?php endif; ?>

        <?php if (($offset + $limit) < $rows) : ?>
            <a href="?offset=<?= ($offset + $limit) ?>">Nästa &#x2771;</a>
        <?php endif; ?>
    </nav>
</div>
