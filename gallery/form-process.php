<?php
// Get incoming values from posted form
$radiochooser = $_POST["radiochooser"] ?? null;
$redirect = $_POST["redirect"] ?? "?page=index";

if ($radiochooser) {
    $_SESSION["radiochooser"] = intval($radiochooser);
    header("Location: $redirect");
    exit;
}

// Failed to select a valid style.
$_SESSION["message"] = "Du har inte valt en giltig tabell!";
header("Location: $redirect");
