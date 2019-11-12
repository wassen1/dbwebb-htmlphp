<?php
if (!($_SESSION["user"] ?? null)) {
    header("Location: login.php?page=login&location=" . urlencode($_SERVER['REQUEST_URI']));
    return;
}
?>
<div class="flex-column align-items-center">

    <?php if ($_SESSION["tablechooser"] === "object") : ?>
        <h1 class="title">Lägg till objekt</h1>
        <nav class="small-navbar">
            <a href="?page=index">Alla objekt</a>
            <a href="?page=init">Återskapa databas</a>
        </nav>
        <form method="post" action="?page=process">
            <fieldset>
                <legend>Lägg till objekt</legend>

                <label for="title">titel:</label>
                <input type="text" id="title" name="title" required autofocus>

                <label for="category">kategori:</label>
                <input type="text" id="category" name="category">

                <label for="text">text:</label>
                <textarea id="text" name="text" required></textarea>

                <label for="image">bild:</label>
                <input type="text" id="image" name="image" placeholder="my-image.jpg">

                <input type="submit" name="action" value="Lägg till" class="default-color">
            </fieldset>
        </form>
    <?php elseif ($_SESSION["tablechooser"] === "article") : ?>
        <h1 class="title">Lägg till artikel</h1>
        <nav class="small-navbar">
            <a href="?page=index">Alla artiklar</a>
            <a href="?page=init">Återskapa databas</a>
        </nav>
        <form method="post" action="?page=process">
            <fieldset>
                <legend>Lägg till artikel</legend>

                <label for="title">titel:</label>
                <input type="text" id="title" name="title" required autofocus>

                <label for="category">kategori:</label>
                <input type="text" id="category" name="category">

                <label for="content">html:</label>
                <textarea id="content" name="content" placeholder="<p>My paragraph</p>" required></textarea>

                <label for="author">författare:</label>
                <input type="text" id="author" name="author">

                <label for="pubdate">publicerat:</label>
                <input type="text" id="pubdate" name="pubdate" placeholder="2019-10-31">

                <input type="submit" name="action" value="Lägg till" class="default-color">
            </fieldset>
        </form>
    <?php endif; ?>
</div>
