<div class="clearfix">

    <main class="single-page">
        <?php require __DIR__ . "/flashmessage.php"; ?>

    
        <?php if ($page) : ?>
            <?php require $page["file"] ?>
        <?php else : ?>
            <p>You have selected a page reference '<?= htmlentities($pageReference) ?>' that does not map to an actual page.</p>
        <?php endif; ?>
    </main>
</div>
