<!DOCTYPE html>
<html>

<head>
    <title>Napredne tehnike projektiranja web servisa</title>
    <meta http-equiv="content-type" content="text.php; charset=UTF-8" />
    <meta name="description" content="Opis stranice" />
    <meta name="keywords" content="ključna riječ1, ključna riječ2" />
    <meta name="author" content="Kristijan Milanović" />
    <meta name="viewport" content="width=device-width, inital-scale=1.0" />
    <link rel="stylesheet" href="assets/css/style.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
</head>

<body>
    <?php
    include('includes/header.php');
    ?>
    <main>
        <?php
        if (!isset($_GET['menu']) || $_GET['menu'] == 'home') {
            include("pages/home.php");
        } else if ($_GET['menu'] == 'news') {
            include("pages/news.php");
        } else if ($_GET['menu'] == 'contact') {
            include("pages/contact.php");
        } else if ($_GET['menu'] == 'about') {
            include("pages/about.php");
        } else if ($_GET['menu'] == 'gallery') {
            include("pages/gallery.php");
        }
        ?>
    </main>
    <?php
    include('includes/footer.php');
    ?>
</body>

<.php>