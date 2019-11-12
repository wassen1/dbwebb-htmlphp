<?php
$db = connectToDatabase($dsnBmo);
$sql = <<<EOD
SELECT content FROM Article
WHERE title LIKE "Om BMO"
;
EOD;
$stmt = $db->prepare($sql);
executeDB($stmt);
$res = $stmt->fetch(PDO::FETCH_ASSOC);

$sql = <<<EOD
SELECT text, image FROM Object
WHERE title LIKE "Minnestavla EPAD"
;
EOD;
$stmt = $db->prepare($sql);
executeDB($stmt);
$resImg = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<header>
    <h1 class="title">Om BMO</h1>
    <p class="author">
        <?php echo "Last modified: "?> <time datetime="<?= date("Y-m-d H:i:s", filemtime(__FILE__)); ?>"><?= date("d F Y", filemtime(__FILE__)); ?></time> by Fredrik Wassermeyer
    </p>
</header>
<a href="objects.php?page=details&id=19" style="float:right;">
    <figure class="me flex-column">
        <img src="img/250/<?= $resImg['image'] ?>" alt="<?= $resImg['text'] ?>">
        <figcaption><?= $resImg["text"]?></figcaption>
    </figure>
</a>
<?php echo $res["content"];
