<?php
if (!($_SESSION["user"] ?? null)) {
    header("Location: login.php?page=login&location=" . urlencode($_SERVER['REQUEST_URI']));
    return;
}
$db = connectToDatabase($dsnBmo);
$create = "";
$options = [
    "choose" => "Välj tabell ...",
    "article" => "Artiklar", 
    "object" => "Utställningsobjekt",
];
$tablechooser = $_SESSION["tablechooser"] ?? null;
$html = null;

if ($tablechooser === "object") {
    $sql = <<<EOD
    SELECT
    *
    FROM Object
    ;
EOD;

    $stmt = $db->prepare($sql);
    $stmt->execute();
    $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // Loop through the array and gather the data into table rows
    $rows = null;
    foreach ($res as $row) {
        $rows .= "<tr>";
        $rows .= "<td>" . htmlentities($row["id"]) . "</td>";
        $rows .= "<td>" . htmlentities($row['title']) . "</td>";
        $rows .= "<td>" . htmlentities($row['category']) . "</td>";
        $rows .= "<td>". htmlentities($row['text']) . "</td>";
        $rows .= "<td><img src=\"img/80x80/" . htmlentities($row['image']) . "\" alt=\"bild\"></td>";
        
        $rows .= "<td><a href=\"?page=update&id=" . htmlentities($row['id']) . "\">&#x1F58A;</a></td>";
        $rows .= "<td><a href=\"?page=delete&id=" . htmlentities($row['id']) . "\">&#x1F5D1;</a></td>";
        $rows .= "</tr>\n";
    }

    // Print out the result as a HTML table using PHP heredoc
    $html = <<<EOD
    <table class="table-scroll">
    <tr>
    <th>id</th>
    <th>titel</th>
    <th>kategori</th>
    <th>text</th>
    <th>bild</th>
    <th>ändra</th>
    <th>radera</th>
    </tr>
    $rows
    </table>
EOD;
    $create = "Lägg till objekt";
} elseif ($tablechooser === "article") {
    $sql = <<<EOD
    SELECT
    *
    FROM Article
    ;
EOD;

    $stmt = $db->prepare($sql);
    $stmt->execute();
    $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // Loop through the array and gather the data into table rows
    $rows = null;
    foreach ($res as $row) {
        $rows .= "<tr>";
        $rows .= "<td>" . htmlentities($row["id"]) . "</td>";
        $rows .= "<td>" . htmlentities($row['title']) . "</td>";
        $rows .= "<td>" . htmlentities($row['category']) . "</td>";
        $rows .= "<td>" . htmlentities($row['author']) . "</td>";
        $rows .= "<td>" . htmlentities($row['pubdate']) . "</td>";
        $rows .= "<td><a href=\"?page=update&id=" . htmlentities($row['id']) . "\">&#x1F58A;</a></td>";
        $rows .= "<td><a href=\"?page=delete&id=" . htmlentities($row['id']) . "\">&#x1F5D1;</a></td>";
        $rows .= "</tr>\n";
    }

    // Print out the result as a HTML table using PHP heredoc
    $html = <<<EOD
    <table class="table-scroll">
    <tr>
    <th>id</th>
    <th>titel</th>
    <th>kategori</th>
    <th>författare</th>
    <th>publicerat</th>
    <th>ändra</th>
    <th>radera</th>
    </tr>
    $rows
    </table>
EOD;
    $create = "Lägg till artikel";
}
?>

<div class="flex-column align-items-center">
    <h1 class="title">Admin</h1>
    <form method="post" action="?page=form-process">
    
        <fieldset style="border:none">
            <!-- <legend>Välj tabell</legend> -->
            <input type="hidden" name="redirect" value="?page=index">
        
            <p><label>Välj tabell: <br>
                <select name="tablechooser" onchange="this.form.submit();">
                    <?php foreach ($options as $key => $option) :
                        $table = $tablechooser ?? null;
                        $selected = null;
                        $disabled = null;
                        if ($key === $table) {
                            $selected = "selected=\"selected\"";
                        }
                        if ($key === "choose") {
                            $disabled = "style=\"display:none\"";
                        }
                        ?>
                        <option <?= $disabled ?> <?= $selected ?> value="<?= $key ?>"><?= $option ?></option>
                    <?php endforeach; ?>
            </select>
            </label></p>
        </fieldset>
    </form>
    <?php if ($tablechooser) : ?>
        <nav class="small-navbar">
        <a href="?page=create"><?= $create ?></a>
        <a href="?page=init">Återskapa databas</a>
        </nav>
        <?= $html; ?>
    <?php endif; ?>
</div>
