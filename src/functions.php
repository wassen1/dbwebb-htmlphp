<?php
/**
 * Polyfills.
 */

if (!function_exists('array_key_first')) {
    function array_key_first(array $array) 
    {
        if (!empty($array)) {
            return key(array_slice($array, 0, 1, true));
        }
    }
}


/**
 * Connect to the database
 * @param $dsn the path to the database
 * @return $db the database
 */
function connectToDatabase(string $dsn) :object
{
    //Open the database file and catch the exception if it fails.
    try {
        $db = new PDO($dsn);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Failed to connect to the database using DSN:<br>$dsn<br>";
        throw $e;
    }
    return $db;
}

function printObjectResultsetToHTMLTable(array $res) : string
{
    // Loop through the array and gather the data into table rows
    $rows = null;
    foreach ($res as $row) {
        $rows .= "<tr>";
        $rows .= "<td><a href=\"?id=" . htmlentities($row['id']) . "\"><img src=\"img/80x80/" . htmlentities($row['image']) . "\" alt=\"bild\"></a></td>";
        $rows .= "<td>" . htmlentities($row['title']) . "</td>";
        $rows .= "<td>" . htmlentities($row['text']) . "</td>";
        $rows .= "<td>" . htmlentities($row['owner']) . "</td>";
        $rows .= "</tr>\n";
    }

    // Print out the result as a HTML table using PHP heredoc
    $html = <<<EOD
    <table class="table-scroll">
    <tr>
        <th>bild</th>
        <th>titel</th>
        <th>text</th>
        <th>ägare</th>
    </tr>
    $rows
    </table>
EOD;
    return $html;
}

function printArticleResultsetToHTMLTable(array $res) : string
{
    // Loop through the array and gather the data into table rows
    $rows = null;
    foreach ($res as $row) {
        $rows .= "<tr>";
        $rows .= "<td><a href=\"?id=" . htmlentities($row["id"]) . "\">". htmlentities($row['title']) . "</a></td>";
        $rows .= "<td>" . htmlentities($row['author']) . "</td>";
        $rows .= "<td>" . htmlentities($row['pubdate']) . "</td>";
        $rows .= "</tr>\n";
    }

    // Print out the result as a HTML table using PHP heredoc
    $html = <<<EOD
    <table class="table-scroll">
    <tr>
        <th>titel</th>
        <th>författare</th>
        <th>publicerat</th>
    </tr>
    $rows
    </table>
EOD;
    return $html;
}

function printGalleryResultsetToHTMLTable(array $res) : string
{
    // Loop through the array and gather the data into table rows
    $rows = null;
    foreach ($res as $row) {
        $rows .= "<a href=\"img/full-size/{$row['image']}\" class=\"link--gallery\"><div class=\"image-container\">";
        $rows .= "<img class=\"image--gallery\" src='img/80x80/{$row['image']}' alt=\"{$row['title']}\">";
        $rows .= "<div class=\"image-overlay\"><div class=\"text-overlay\">{$row['title']}</div></div>";
        $rows .= "</div></a>";
    }

    // Print out the result as a HTML table using PHP heredoc
    $html = <<<EOD
    <div class="gallery">
    $rows
    </div>
EOD;
    return $html;
}

function getNrOfRowsInTable(string $table, object $db) : int
{
    $rows = 0;

    //Get amount of rows in table
    $sql = <<<EOD
    SELECT Count(*)
    FROM $table
    ;
EOD;
    $stmt = $db->prepare($sql);
    executeDB($stmt);
    $rows = intval($stmt->fetch(PDO::FETCH_COLUMN));

    return $rows;
}

/**
 * Execute to DB with try/catch
 * @param $stmt the statement
 * @param $params optional to be sent to execute
 */
function executeDB($stmt, $params = [])
{
    try {
        $stmt->execute($params);
    } catch (PDOException $e) {
        echo "<p>Failed to insert a new row, dumping details for debug.</p>";
        echo "<p>Incoming \$_POST:<pre>" . print_r($_POST, true) . "</pre>";
        echo "<p>The error code: " . $stmt->errorCode();
        echo "<p>The error message:<pre>" . print_r($stmt->errorInfo(), true) . "</pre>";
        throw $e;
    }
    return $stmt;
}
