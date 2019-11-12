<?php
/**
 * Configuration file with common settings.
 */
error_reporting(-1);              // Report all type of errors
ini_set("display_errors", 1);     // Display all errors

/**
 * Create a DSN for the database users
 */
$filename = __DIR__ . "/db/users.sqlite";
$dsnUsers = "sqlite:$filename";

/**
 * Create a DSN for the database bmo2
 */
$filename = __DIR__ . "/db/bmo2.sqlite";
$dsnBmo = "sqlite:$filename";

/**
 * Start a named session
 */
$name = preg_replace("/[^a-z\d]/i", "", __DIR__);
session_name($name);
session_start();

/**
 * Create an array of valid tables
 */
$tables = [
    "default" => "Article",
    "article" => "Article",
    "object" => "Object",
];
