<?php
    session_start();

    unset($_POST);
	unset($_SESSION['user']);

	$_SESSION['user']['valid'] = 'false';
	$_SESSION['message'] = '<p>See you again soon!</p>';
	header("Location: index.php?menu=home");

    exit;
?>