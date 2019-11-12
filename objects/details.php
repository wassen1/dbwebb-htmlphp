<?php

$id = $_GET["id"] ?? null;

$db = connectToDatabase($dsnBmo);
$rows = getNrOfRowsInTable("Object", $db);

$query = "SELECT * FROM Object WHERE id IS $id";
$stmt = $db->prepare($query);
$stmt->execute();
$res = $stmt->fetch(PDO::FETCH_ASSOC);

$text = $res['text'] ?? "Ursäkta, det verkar som att objektet inte längre finns ...";
$image = $res['image'] ?? "Bild saknas.";
$title = $res['title'] ?? "Titel okänd.";
$owner = $res['owner'] ?? "okänd";

?>
<div class="flex-column align-items-start">
    <h1 class="title">Utställningsobjekt</h1>
    <hr>
    <h4 class="padding-top-10"><?= htmlentities($id) ?> | <?= htmlentities($title) ?></h4>
    <img src="img/550/<?= htmlentities($image) ?>" alt="bild på utställningsobjekt" class="image--details">
    <p><?= htmlentities($text) ?></p>
    <p>Ägare: <?= htmlentities($owner) ?>.</p>
    <nav class="small-navbar space-between">
        <?php if (htmlentities($id) > 1) : ?>
            <a href="?id=<?= (htmlentities($id) - 1) ?>">&#x2770; Föregående</a>
        <?php else : ?>
            <div style="visibility:hidden;"></div>
        <?php endif; ?>

        <?php if (htmlentities($id) < $rows) : ?>
            <a href="?id=<?= (htmlentities($id) + 1) ?>">Nästa &#x2771;</a>
        <?php endif; ?>
    </nav>
</div>
