<?php
// Logout by unsetting user in session
$user = $_SESSION["user"] ?? null;
$_SESSION["user"] = null;
$_SESSION["message"] = "Användare $user har loggat ut.";
header("Location: ?page=status");
