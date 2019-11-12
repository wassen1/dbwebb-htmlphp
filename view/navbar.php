<?php
$uri = $_SERVER['REQUEST_URI'];
$uriFile = explode("?", basename($uri))[0];
?>

<nav class="main-navbar">
    <a class="<?= $uriFile == "home.php" ? "selected" : ""; ?>" href="home.php">Hem</a>
    <a class="<?= $uriFile == "objects.php" ? "selected" : ""; ?>" href="objects.php">Objekt</a>
    <a class="<?= $uriFile == "articles.php" ? "selected" : ""; ?>" href="articles.php">Artiklar</a>
    <a class="<?= $uriFile == "gallery.php" ? "selected" : ""; ?>" href="gallery.php">Galleri</a>
    <a class="<?= $uriFile == "about.php" ? "selected" : ""; ?>" href="about.php">Om</a>
    <?php if ($_SESSION["user"] ?? null) : ?>
        <a class="<?= $uriFile == "admin.php" ? "selected" : ""; ?>" href="admin.php">Admin</a>
    <?php endif; ?>
    <?php if ($_SESSION["user"] ?? null) : ?>
        <a class="<?= $uriFile == "login.php" ? "selected" : ""; ?>" href="login.php">Logga ut</a>
    <?php else :?>
        <a class="<?= $uriFile == "login.php" ? "selected" : ""; ?>" href="login.php">Logga in</a>
    <?php endif; ?>
</nav>
