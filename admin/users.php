<?php 
    function pickerDateToMysql($pickerDate){
		$date = DateTime::createFromFormat('Y-m-d H:i:s', $pickerDate);
		return $date->format('d. m. Y H:i:s');
	}



	# Update user profile
	if (isset($_POST['edit']) && $_POST['action'] == 'TRUE') {
		$query  = "UPDATE users SET firstname='" . $_POST['firstname'] . "', lastname='" . $_POST['lastname'] . "', email='" . $_POST['email'] . "', username='" . $_POST['username'] . "', country='" . $_POST['country'] . "' , role='" . $_POST['role'] . "'";
        $query .= " WHERE id=" . (int)$_POST['edit'];
        $query .= " LIMIT 1";
        $result = @mysqli_query($conn, $query);
		@mysqli_close($conn);
		
		$_SESSION['message'] = '<p>You successfully changed user profile!</p>';
		
		header("Location: index.php?menu=admin&action=1");
	}
	
	# Delete user profile
	if (isset($_GET['delete']) && $_GET['delete'] != '') {
	
		$query  = "DELETE FROM users";
		$query .= " WHERE id=".(int)$_GET['delete'];
		$query .= " LIMIT 1";
		$result = @mysqli_query($conn, $query);

		$_SESSION['message'] = '<p>You successfully deleted user profile!</p>';
		
		header("Location: index.php?menu=admin");
	}
	
	
	#Show user info
	if (isset($_GET['id']) && $_GET['id'] != '') {
		$query  = "SELECT * FROM users";
		$query .= " WHERE id=".$_GET['id'];
		$result = @mysqli_query($conn, $query);
		$row = @mysqli_fetch_array($result);
		print '
		<h2>User profile</h2>
		<p><b>First name:</b> ' . $row['firstName'] . '</p>
		<p><b>Last name:</b> ' . $row['lastName'] . '</p>
		<p><b>Username:</b> ' . $row['username'] . '</p>
        <p><b>Role:</b> ' . $row['role'] . '</p>';
  
		$_query  = "SELECT * FROM countries";
		$_query .= " WHERE country_code='" . $row['country'] . "'";
		$_result = @mysqli_query($conn, $_query);
		$_row = @mysqli_fetch_array($_result);
		print '
		<p><b>Country:</b> ' .$_row['country_name'] . '</p>
		<p><b>Date:</b> ' . pickerDateToMysql($row['date']) . '</p>
		<p><a href="index.php?menu=admin&amp;action='.$action.'">Back</a></p>';
	}


	#Edit user profile
	else if (isset($_GET['edit']) && $_GET['edit'] != '') {
		$query  = "SELECT * FROM users";
		$query .= " WHERE id=".$_GET['edit'];
		$result = @mysqli_query($conn, $query);
		$row = @mysqli_fetch_array($result);		
		print '
		<div class="form">
		<hr style="border-color:#f00000">
		<div>
		<h2>Edit user profile</h2>
		<div class="form">
		<form action="" id="registration_form" name="registration_form" method="POST">
			<input type="hidden" id="action" name="action" value="TRUE">
			<input type="hidden" id="edit" name="edit" value="' . $_GET['edit'] . '">
			
			<label for="fname">First Name</label>
			<input type="text" id="fname" name="firstname" value="' . $row['firstname'] . '" placeholder="First name" required>
			<label for="lname">Last Name</label>
			<input type="text" id="lname" name="lastname" value="' . $row['lastname'] . '" placeholder="Last name" required>
				
			<label for="email">Your E-mail</label>
			<input type="email" id="email" name="email"  value="' . $row['email'] . '" placeholder="Email" required>
			
			<label for="username">Username</label>
			<input type="text" id="username" name="username" value="' . $row['username'] . '" placeholder="Username" required><br>
            <label for="role">Role</label>
			<div class="select">
            <select class="countries" name="role" id="role">
			<option value="" selected disabled hidden>Select</option>
            <option value="administrator">Administrator</option>
            <option value="editor">Editor</option>
            <option value="user">User</option>
            </select>
			</div>
            <br>
			
			<label for="country">Country</label>
			<div class="select">
			<select class="countries" name="country" id="country">
				<option value="">Select</option>';
				$_query  = "SELECT * FROM countries";
				$_result = @mysqli_query($conn, $_query);
				while($_row = @mysqli_fetch_array($_result)) {
					print '<option value="' . $_row['country_code'] . '"';
					if ($row['country'] == $_row['country_code']) { print ' selected'; }
					print '>' . $_row['country_name'] . '</option>';
				}
			print '
			</select>	
			</div>
			<input type="submit" value="Submit">
		</form>
		</div>';
	}
	else if ($_SESSION['user']['role'] === 'administrator') {
		print '
		<h2 style="text-align:center">Users</h2>';
        $query  = "SELECT * FROM users";
	    $result = @mysqli_query($conn, $query);
        if ($result -> num_rows !== 0 ) {
        print'
		<div id="users">
			<table id="table">
					<tr>
                        <th></th>
						<th></th>
						<th>First name</th>
						<th>Last name</th>
						<th>E mail</th>
						<th>Country</th>
                        <th>Role</th>
					</tr>';
				while($row = @mysqli_fetch_array($result)) {
					print '
					<tr style="text-align:center">
                        <td><a href="index.php?menu=admin&amp;action='.$action.'&amp;edit=' .$row['id']. '"><i style="color:black" class="fas fa-edit"></i></a></td>
                        <td><a href="index.php?menu=admin&amp;action='.$action.'&amp;delete=' .$row['id']. '"><i style="color:black" class="fas fa-trash-alt"</a></td>
						<td><strong>' . $row['firstname'] . '</strong></td>
						<td><strong>' . $row['lastname'] . '</strong></td>
						<td>' . $row['email'] . '</td>
						<td>';
							$_query  = "SELECT * FROM countries";
							$_query .= " WHERE country_code='" . $row['country'] . "'";
							$_result = @mysqli_query($conn, $_query);
							$_row = @mysqli_fetch_array($_result, MYSQLI_ASSOC);
							print $_row['country_name'] . '
						</td>
                        <td> '. $row['role'] .'</td>
					</tr>';
				}
			print '
			</table>
		</div>';
    } else {
        print '<h3>There are no users yet!</h3>';
    }
	}
	
	# Close MySQL connection
	@mysqli_close($conn);
?>