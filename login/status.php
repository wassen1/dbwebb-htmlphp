<h1 class="title">Status</h1>

<?php if ($_SESSION["user"] ?? null) : ?>
    <p>Användaren <b><?= $_SESSION["user"] ?></b> är inloggad.</p>
    <p>Användarens fulla namn är <b><?= $_SESSION["name"] ?></b>.</p>
<?php else : ?>
    <p>Ingen användare är inloggad.</p>
<?php endif; ?>
