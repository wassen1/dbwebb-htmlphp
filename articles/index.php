<?php
// Get incoming from search form
$search = isset($_GET["search"]) ? $_GET["search"] : null;
$id = $_GET["id"] ?? null;
$db = connectToDatabase($dsnBmo);
$params = [];

?>

<div class="flex-column align-items-center">
    <h1 class="title">Artiklar</h1>
    <form>
        <input type="search" name="search" placeholder="Fyll i söksträng, använd % som wildcard." autofocus value="<?=htmlentities($search)?>">
        <input type="submit" value="Sök">
    </form>

<?php
if (!is_null($search)) {
    $sql = <<<EOD
    SELECT
    *
    FROM Article
    WHERE
    title LIKE ? OR
    category LIKE ? OR
    content LIKE ? OR
    author LIKE ? OR
    pubdate LIKE ?;
EOD;
    
    $params = [$search, $search, $search, $search, $search];
    
} else if (isset($_GET["id"])) {
    header("Location: ?page=details&id=$id");
} else {
    $sql = "SELECT * FROM Article";
}

$stmt = $db->prepare($sql);
$stmt->execute($params);
$res = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo printArticleResultsetToHTMLTable($res);
?>

<a href="?search=%25%25">Visa alla artiklar</a>

</div>
