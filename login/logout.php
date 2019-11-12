<?php 
if (!$_SESSION["user"] ?? null) {
    header("Location: ?page=login");
}
?>
<div class="flex-column align-items-center">
    <h1 class="title">Logga ut</h1>

    <form method="post" action="?page=logout-process">

        <fieldset>
            <legend>Logga ut</legend>
            <input type="submit" id="logout" name="logout" value="Logga ut">
        </fieldset>

    </form>
</div>