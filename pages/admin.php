<?php 
	if ($_SESSION['user']['valid'] == 'true') {
		if (!isset($action)) { $action = 1; }
		print '
		<main>
		<h1>Administration</h1>
		<div id="admin">
			<ul>
            ';
            if ($_SESSION['user']['role'] === 'administrator') {
            print '
				<h4 style="float:left; margin-right:5px">Users<h4>
				<li style="list-style-type: none"><a href="index.php?menu=admin&amp;action=1"><i style="color:black" class="fas fa-users fa-3x"></i></a></li>';
            } print '
				<h4 style="float:left; margin-right:5px">News<h4>
				<li style="list-style-type: none"><a href="index.php?menu=admin&amp;action=2"><i style="color:black" class="fas fa-newspaper fa-3x"></i>
				</a></li>
			</ul>';
			# Admin Users
			if ($action == 1) { include("admin/users.php"); }
			
			# Admin News
			else if ($action == 2) { include("admin/news.php"); }
		print '
		</div>
		</main>';
	}
	else {
		$_SESSION['message'] = '<p>Please register or login using your credentials!</p>';
		header("Location: index.php?menu=admin");
	}
?>