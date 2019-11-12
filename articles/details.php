<?php
$id = $_GET["id"] ?? null;
$db = connectToDatabase($dsnBmo);

$rows = getNrOfRowsInTable("Article", $db);

$query = "SELECT * FROM Article WHERE id IS $id";
$stmt = $db->prepare($query);
$stmt->execute();

$res = $stmt->fetch(PDO::FETCH_ASSOC);

$text = $res['content'] ?? "Ursäkta, det verkar som att artikeln inte längre finns ...";
$title = $res['title'] ?? "Titel okänd.";
$owner = $res['author'] ?? "Författare okänd.";

?>
<div>
    <h1 class="title">Artikel</h1>
    <hr>
    <h4 class="padding-top-10"><?= htmlentities($id) ?> | <?= htmlentities($title) ?></h4>
    <p><?= htmlentities($owner) ?></p>
    <?= strip_tags($text, '<p><h2><img>') ?>

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
