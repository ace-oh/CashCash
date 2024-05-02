<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
        <title><?php echo $titre ?></title>
        <style type="text/css">
            @import url("css/global.css");
        </style>
        <link href="https://fonts.googleapis.com/css?family=Lobster" rel="stylesheet">
    </head>
    <body>
    <header>
    
<div class="secondHead">
    <div id="menuContextuel">
        <ul>
            <?php if (isset($menuBurger)) { ?>
                <?php for ($i = 0; $i < count($menuBurger); $i++) { ?>
                    <li>
                        <a href="<?php echo $menuBurger[$i]['url']; ?>">
                            <?php echo $menuBurger[$i]['label']; ?>
                        </a>
                    </li>
                <?php } ?>
            <?php } ?>
        </ul>
