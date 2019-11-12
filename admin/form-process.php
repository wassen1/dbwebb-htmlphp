<?php
// Get incoming values from posted form
$tablechooser = $_POST["tablechooser"] ?? null;
$redirect = $_POST["redirect"] ?? "?page=index";

// Update the current selected style, if it is a valid style.
// The array $tables of valid tables is defined in config.php
$table = $tables[$tablechooser] ?? null;
if ($table) {
    $_SESSION["tablechooser"] = $tablechooser;
    header("Location: $redirect");
    exit;
}

// Failed to select a valid style.
$_SESSION["message"] = "Du har inte valt en giltig tabell!";
header("Location: $redirect");
