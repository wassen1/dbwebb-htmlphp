<?php
if (!($_SESSION["user"] ?? null)) {
    header("Location: login.php?page=login&location=" . urlencode($_SERVER['REQUEST_URI']));
    return;
}
?>
<div class="flex-column align-items-center">
    <?php if ($_SESSION["tablechooser"] === "object") : ?>
        <h1 class="title">Är du helt säker på att du vill återskapa db?</h1>
        <nav class="small-navbar">
            <a href="?page=index">Alla objekt</a>
            <a href="?page=create">Lägg till objekt</a>
        </nav>
        <form method="post" action="?page=process">
            <fieldset>
                <legend>Återskapa databas</legend>
                <input type="submit" name="action" value="Återskapa" class="danger">
            </fieldset>
        </form>
    <?php elseif ($_SESSION["tablechooser"] === "article") : ?>
        <h1 class="title">Är du helt säker på att du vill återskapa db?</h1>
        <nav class="small-navbar">
            <a href="?page=index">Alla artiklar</a>
            <a href="?page=create">Lägg till artikel</a>
        </nav>
        <form method="post" action="?page=process">
            <fieldset>
                <legend>Återskapa databas</legend>
                <input type="submit" name="action" value="Återskapa" class="danger">
            </fieldset>
        </form>
    <?php endif; ?>
</div>