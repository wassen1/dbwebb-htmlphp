<!doctype html>
<html lang="sv">
<head>
    <meta charset="utf-8">
    <title><?php echo $title ?></title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css?family=Old+Standard+TT&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet"> 
    <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=2.0;">
</head>

<body>
    <div class="navbar-container">
        <input type="checkbox" id="hamburgerControl"/>
        <label for="hamburgerControl"><img src="img/baseline_menu_white_36dp.png" alt="menu"/></label>
        <?php 
        require __DIR__ . "/navbar.php";
        ?>
        <a href="home.php" style="text-decoration: none;" class="logo"><div >BEGRAVNINGSMUSEEUM ONLINE &#9840;</div></a>
    </div>