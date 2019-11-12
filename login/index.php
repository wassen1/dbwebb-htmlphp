<?php
/**
 * A processing page that does a redirect.
 */

// Redirect to eather login or logout

//Check if already logged in. If so go to status page
if ($_SESSION["user"] ?? null) {
    $url = "?page=logout";
} else {
    $url = "?page=login";
}

header("Location: $url");
