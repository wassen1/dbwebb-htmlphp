<?php 
if ($_SESSION["user"] ?? null) {
    header("Location: ?page=logout");
}
?>
<div class="flex-column align-items-center">
    <h1 class="title">Logga in</h1>
    
    <p>Logga in för att komma åt admingränssnittet med fredrik:fredrik eller admin:admin som användare och lösenord.</p>
    
    <form method="post" action="?page=login-process">
    
        <fieldset>
            <legend>Logga in</legend>
            <!-- transform location variable from GET to POST variable -->
            <?php
            echo '<input type="hidden" name="location" value="';
            if (isset($_GET['location'])) {
                echo htmlentities($_GET['location']);
            }
            echo '" />';
            ?>
    
            <label for="user">Användare:</label>
            <input type="text" id="user" name="user" value="<?= htmlentities($_POST["user"] ?? null) ?>" placeholder="användare" autofocus>
            
            <label for="password">Lösenord:</label>
            <input type="password" id="password" name="password" value="<?= htmlentities($_POST["password"] ?? null) ?>" placeholder="abc123">
            
            <input type="submit" name="login" value="Logga in">
        </fieldset>
    
    </form>
</div>