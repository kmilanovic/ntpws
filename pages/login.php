<?php 
	print '
	<h1>Login</h1>';
	if ($_POST['_action_'] == false) {
		print '
        <div class="form">
            <form action="" name="myForm" id="myForm" method="POST">
                <input type="hidden" id="_action_" name="_action_" value="TRUE">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
                                        
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
                                        
                <input type="submit" value="Submit">
            </form>
        </div>';
	}
	else if ($_POST['_action_'] == true) {
		
		$query  = "SELECT * FROM users";
		$query .= " WHERE username='" .  $_POST['username'] . "'";
		$result = mysqli_query($conn, $query);
		$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
		
		if (password_verify($_POST['password'], $row['password'])) {
			$_SESSION['user']['valid'] = 'true';
			$_SESSION['user']['id'] = $row['id'];
			$_SESSION['user']['firstname'] = $row['firstname'];
			$_SESSION['user']['lastname'] = $row['lastname'];
			$_SESSION['message'] = '<p>Dobrodošli, ' . $_SESSION['user']['firstname'] . ' ' . $_SESSION['user']['lastname'] . '</p>';
			header("Location: index.php?menu=home");
		}
		
		# Bad username or password
		else {
			unset($_SESSION['user']);
			$_SESSION['message'] = '<p>You entered wrong email or password!</p>';
			header("Location: index.php?menu=login");
		}
	}
	print '
	</div>';
?>