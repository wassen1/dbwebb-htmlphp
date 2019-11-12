<?php
// Get incoming from search form
$search = isset($_GET["search"]) ? $_GET["search"] : null;
$id = $_GET["id"] ?? null;
$db = connectToDatabase($dsnBmo);
$params = [];
?>

<div class="flex-column align-items-center">
    <h1 class="title">Utställningsbjekt</h1>
    <form>
        <input type="search" name="search" placeholder="Fyll i söksträng, använd % som wildcard." autofocus value="<?=htmlentities($search)?>">
        <input type="submit" value="Sök">
    </form>

<?php
if (!is_null($search)) {
    $sql = <<<EOD
    SELECT
    *
    FROM Object
    WHERE
    title LIKE ? OR
    category LIKE ? OR
    text LIKE ? OR
    image LIKE ? OR
    owner LIKE ?;
EOD;
    
    $params = [$search, $search, $search, $search, $search];
    
} else if (isset($_GET["id"])) {
    header("Location: ?page=details&id=$id");
} else {
    $sql = "SELECT * FROM Object";
}

$stmt = $db->prepare($sql);
$stmt->execute($params);
$res = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo printObjectResultsetToHTMLTable($res);
?>

<a href="?search=%25%25">Visa alla objekt</a>

</div>