<!doctype html>
<html>
    <head>
        <title><?php if(!isset($title)){ echo("Photo4You"); } else { echo(ucfirst($title)); } ?></title>
        <meta charset="utf-8">
        <link rel='shortcut icon' href='./assets/Images/logo.png'>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="./assets/styles/FontAwesome-6.4.0-main/v6.4.0/css/all.css">
        <link rel="stylesheet" href="./assets/styles/style.css">
        <link rel="stylesheet" href="./assets/styles/toast.css">
        <link rel="stylesheet" href="./assets/styles/theme.css">
    </head>

    <body style="min-height: 100vh; display: flex; flex-direction: column;" id="salam">
    <?php
        include_once("./includes/navbar.inc.php"); 
    ?>
    <div class="container">