<?php
// Get incoming values from posted form
$user = $_POST["user"] ?? null;
$password = $_POST["password"] ?? null;

// Get users login credentials from db
$db = connectToDatabase($dsnUsers);
    
$sql = <<<EOD
SELECT
    username, name, password
FROM users
WHERE username LIKE "$user"
;
EOD;

$stmt = $db->prepare($sql);
try {
    $stmt->execute();
} catch (PDOException $e) {
    echo "<p>Failed to insert a new row, dumping details for debug.</p>";
    echo "<p>Incoming \$_POST:<pre>" . print_r($_POST, true) . "</pre>";
    echo "<p>The error code: " . $stmt->errorCode();
    echo "<p>The error message:<pre>" . print_r($stmt->errorInfo(), true) . "</pre>";
    throw $e;
}
$res = $stmt->fetch(PDO::FETCH_ASSOC);

// Check that user and password matches
$aUser = $res["username"] ?? null;
$aPassword = $res["password"] ?? null;
$aName = $res["name"] ?? null;

if ($aUser && password_verify($password, $aPassword)) {
    $_SESSION["user"] = $user;
    $_SESSION["name"] = $aName;
    $_SESSION["message"] = "Du har loggat in!";
    
    // redirect back to last page
    $redirect = null;
    if ($_POST['location'] ?? null) {
        $url = $_POST['location'];
        header("Location: " . $url);
    } else {
        header("Location: ?page=status");
    }
    exit;
}

// Failed to login, redirect to login-page again.
$_SESSION["message"] = "You failed to login!";
header("Location: ?page=login");
