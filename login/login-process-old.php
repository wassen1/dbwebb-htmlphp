<?php
// Get incoming values from posted form
$user = $_POST["user"] ?? null;
$password = $_POST["password"] ?? null;

// Check that user and password matches
// The array $users of valid users is defined in config.php
$aUser = $users[$user] ?? null;
$aPassword = $users[$user]["password"] ?? null;
if ($aUser && password_verify($password, $aPassword)) {
    $_SESSION["user"] = $user;
    $_SESSION["name"] = $aUser["name"];
    $_SESSION["message"] = "Your login was successful!";

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
