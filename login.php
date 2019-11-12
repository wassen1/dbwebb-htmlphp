<?php
/**
 * This is a page controller for a multipage. You should name this file
 * as the name of the pagecontroller for this multipage. You should then
 * add a directory with the same name, excluding the file suffix of ".php".
 * You then then have several multipages within the same directory, like this.
 *
 * multipage.php
 * multipage/
 *
 * some-test-page.php
 * some-test-page/
 */
 // Include the configuration file
 require __DIR__ . "/config.php";

 // Include essential functions
 require __DIR__ . "/src/functions.php";

// Get what subpage to show, defaults to index
$pageReference = $_GET["page"] ?? "index";

// Get the filename of this multipage, excluding the file suffix of .php
$base = basename(__FILE__, ".php");
$pages = [];

// Create the collection of valid sub pages.
$pages = [
    "index" => [
        "title" => null,
        "file" => __DIR__ . "/$base/index.php",
    ],
    "login" => [
        "title" => isset($_SESSION["user"]) ? null : "Logga in",
        "file" => __DIR__ . "/$base/login.php",
    ],
    "login-process" => [
        "title" => null,
        "file" => __DIR__ . "/$base/login-process.php",
    ],
    "logout" => [
        "title" => isset($_SESSION["user"]) ? "Logga ut" : null,
        "file" => __DIR__ . "/$base/logout.php",
    ],
    "logout-process" => [
        "title" => null,
        "file" => __DIR__ . "/$base/logout-process.php",
    ],
    "status" => [
        "title" => "Status",
        "file" => __DIR__ . "/$base/status.php",
    ],
    "init-users-process" => [
        "title" => null,
        "file" => __DIR__ . "/$base/init-users-process.php",
    ],
    "init-users" => [
        "title" => "Återskapa användar db",
        "file" => __DIR__ . "/$base/init-users.php",
    ],
    
];

// Get the current page from the $pages collection, if it matches
$page = $pages[$pageReference] ?? null;

// Base title for all pages and add title from selected multipage
$title = $page["title"] ?? "404";
$title .= " | htmlphp";

// Render the page
require __DIR__ . "/view/header.php";
require __DIR__ . "/view/multipage.php";
require __DIR__ . "/view/footer.php";
