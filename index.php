<?php
session_start();

include('config/connection.php');

if(!isset($_POST['_action_']))  { $_POST['_action_'] = FALSE;  }

print '
<!DOCTYPE html>
<html>

<head>
<title>Napredne tehnike projektiranja web servisa</title>
<meta http-equiv="content-type" content="text.php; charset=UTF-8" />
<meta name="description" content="Opis stranice" />
<meta name="keywords" content="ključna riječ1, ključna riječ2" />
<meta name="author" content="Kristijan Milanović" />
<meta name="viewport" content="width=device-width, inital-scale=1" />
<link rel="stylesheet" href="assets/css/style.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
</head>

<body> ';
include('includes/header.php');
print '    
<main>';

if (isset($_SESSION['message'])) {
    print $_SESSION['message'];
    unset($_SESSION['message']);
}

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
} else if ($_GET['menu'] == 'register') {
    include("pages/register.php");
} else if ($_GET['menu'] == 'login') {
    include("pages/login.php");
} else if ($_GET['menu'] == 'logout') {
    include("pages/logout.php");
} else if($_GET['menu'] == 'table'){
    include("pages/table.php");
}
print '        
</main>';
include('includes/footer.php');
print '    
</body>
</html>';
