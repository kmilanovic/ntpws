<?php 
	
     function pickerDateToMysql($pickerDate){
		$date = DateTime::createFromFormat('Y-m-d H:i:s', $pickerDate);
		return $date->format('d. m. Y H:i:s');
	}

	if (isset($_POST['action']) && $_POST['action'] == 'add_news') {
		$_SESSION['message'] = '';
		$approved = 1;
		if ($_SESSION['user']['role'] === 'user') {
			$approved = 0;
		}
		$query  = "INSERT INTO news (title, description, date, is_approved)";
		$query .= " VALUES ('" . $_POST['title'] . "', '" . $_POST['description'] . "', '" . date("Y-m-d G:i") . "', '".$approved."')";
		$result = @mysqli_query($conn, $query);
        $ID = mysqli_insert_id($conn);
		$count = count($_FILES['picture']['name']);
		for($i = 0; $i < $count; $i++) {
			$ext = strtolower(strrchr($_FILES['picture']['name'][$i], "."));
            $_picture = $ID . '-' . rand(1,100) . $ext;
			copy($_FILES['picture']['tmp_name'][$i], "assets/".$_picture);	
			if ($ext == '.jpg' || $ext == '.png' || $ext == '.jpeg' || $ext == '.gif') {
				$_query  = "INSERT INTO pictures (description,img, newsId) VALUES ('". $_POST['imageDesc']. "','".$_picture."', '".$ID."')";
				$_result = @mysqli_query($conn, $_query);
			}
		}
		$_SESSION['message'] .= "<p>You successfully added ".$count." images!</p>";
		header("Location: index.php?menu=admin&action=2");
	}
	
	if (isset($_POST['action']) && $_POST['action'] == 'edit_news' && ($_SESSION['user']['role'] === 'administrator' || $_SESSION['user']['role'] === 'editor')) {
		$query  = "UPDATE news SET title='" .$_POST['title']. "', description='" .$_POST['description']. "', is_approved='".$_POST['approved']."'";
        $query .= " WHERE id=" . (int)$_POST['edit'];
        $query .= " LIMIT 1";
        $result = @mysqli_query($conn, $query);

		$ID = mysqli_insert_id($conn);
		$count = count($_FILES['picture']['name']);
		for($i = 0; $i < $count; $i++) {
			$ext = strtolower(strrchr($_FILES['picture']['name'][$i], "."));
            $_picture = $ID . '-' . rand(1,100) . $ext;
			if (empty($_FILES['picture'])) {
				copy($_FILES['picture']['tmp_name'][$i], "assets/".$_picture);
				if ($ext == '.jpg' || $ext == '.png' || $ext == '.jpeg' || $ext == '.gif') {
					$desc = "aaaa";
					$_query  = "INSERT INTO pictures (description,img, newsId) VALUES ('". $desc. "','".$_picture."', '".$ID."')";
					$_result = @mysqli_query($conn, $_query);
				}
			}
		}
		$_SESSION['message'] .= "<p>You successfully added ".$count." images!</p>";
		
		header("Location: index.php?menu=admin&action=2");
	}
	
	#Delete news
	if (isset($_GET['delete']) && $_GET['delete'] != '') {
		
		$newsId = $_GET['delete'];
		$query  = "DELETE FROM pictures WHERE newsId='".$newsId."'";
		$result = @mysqli_query($conn, $query);
		$file = "assets/".$newsId."*"."."."*";
		foreach(glob($file) as $img) {
			unlink($img);
		}
    	$query  = "DELETE FROM news WHERE id='".(int)$_GET['delete']."'";
		$result = @mysqli_query($conn, $query);

		$_SESSION['message'] = '<p>You successfully deleted news!</p>';
		
		header("Location: index.php?menu=admin&action=2");
	}
	
	if (isset($_GET['id']) && $_GET['id'] != '') {
		$query  = "SELECT * FROM news";
		$query .= " WHERE id=".$_GET['id'];
		$query .= " ORDER BY date DESC";
		$result = @mysqli_query($conn, $query);
		$row = @mysqli_fetch_array($result);
		print '
		<h2>News overview</h2>
		<div class="news">
			<img src="news/' . $row['picture'] . '" alt="' . $row['title'] . '" title="' . $row['title'] . '">
			<h2>' . $row['title'] . '</h2>
			' . $row['description'] . '
			<time datetime="' . $row['date'] . '">' . pickerDateToMysql($row['date']) . '</time>
			<hr>
		</div>
		<p><a href="index.php?menu=admin&amp;action='.$action.'">Back</a></p>';
	}

	
	#Add news
	else if (isset($_GET['add']) && $_GET['add'] != '') {
		print '
		<div class="form">
		<hr style="border-color:#f00000">
		<div>
		<h2>Add news</h2>
		<div class="form">
		<form action="" id="news_form" name="news_form" method="POST" enctype="multipart/form-data">
			<input type="hidden" id="action" name="action" value="add_news">
			
			<label for="title">Title</label>
			<input type="text" id="title" name="title" placeholder="News title" required>
			<label for="description">Description</label>
			<textarea rows="12" cols="80" id="description" name="description" placeholder="Description" required></textarea>
				
			<label for="picture[]">Picture</label>
			<input type="file" multiple id="picture" name="picture[]">
			<label for="imageDesc">Image description</label>
			<input required placeholder="Image description" type="text" id="imageDesc" name="imageDesc">
			<input type="submit" value="Submit">
		</form>
		</div>';
	}



	#Edit news
	else if (isset($_GET['edit']) && $_GET['edit'] != '' && ($_SESSION['user']['role'] === 'administrator' || $_SESSION['user']['role'] === 'editor')) {
		$query  = "SELECT * FROM news ";
		$query .= " WHERE id=".$_GET['edit'];
		$result = @mysqli_query($conn, $query);
		$row = @mysqli_fetch_array($result);

		print '
		<div class="form">
		<hr style="border-color:#f00000">
		<div>
		<h2>Edit news</h2>
		<div class="form">
		<form action="" method="POST" enctype="multipart/form-data">
			<input type="hidden" id="action" name="action" value="edit_news">
			<input type="hidden" id="edit" name="edit" value="' . $row['id'] . '">
			<label for="title">Title</label>
			<input type="text" id="title" name="title" value="' . $row['title'] . '" placeholder="Title" required>
			<label for="description">Description *</label>
			<textarea id="description" name="description" placeholder="Description" required>' . $row['description'] . '</textarea>
			<br>
			<label for="picture[]">Picture</label>
			<input type="file" id="picture" multiple name="picture[]">
			<label for="approved">Approved</label>
			<div class="select">
            <select class="countries" name="approved" id="approved">
			<option value="" selected disabled hidden>Select</option>
            <option value="1">Yes</option>
            <option value="0">No</option>
            </select>
			</div>	
			<input type="submit" value="Submit">
		</form>
		</div>';
	}
	else {
		print '
		<h2 style="text-align:center">News</h2>
		<div>
			<table id="table">
					<tr>
						'; 
						if ($_SESSION['user']['role'] === 'administrator') {
							print '
							<th></th>
							<th></th>
						<th></th>
						<th>Title</th>
						<th>Description</th>
						<th>Date</th>
						<th>Approved</th>';
						$query  = "SELECT * FROM news ";
				$query .= " ORDER BY date DESC";
				$result = @mysqli_query($conn, $query);
				while($row = @mysqli_fetch_array($result)) {
					print '
					<tr>
						<td><a href="index.php?menu=admin&amp;action='.$action.'&amp;id=' .$row['id']. '"></a></td>
							<td><a href="index.php?menu=admin&amp;action='.$action.'&amp;edit=' .$row['id']. '"><i style="color:black" class="fas fa-edit"></i></a></td>
							<td><a href="index.php?menu=admin&amp;action='.$action.'&amp;delete=' .$row['id']. '"><i style="color:black" class="fas fa-trash-alt"></i></a></td>
						<td>' . $row['title'] . '</td>
						<td>';
						if(strlen($row['description']) > 160) {
                            echo substr(strip_tags($row['description']), 0, 160).'...';
                        } else {
                            echo strip_tags($row['description']);
                        }
						print '
						</td>
						<td>' . pickerDateToMysql($row['date']) . '</td>
						<td>' . $row['is_approved'] . '</td>
					</tr>';
				}
					}
					else if ($_SESSION['user']['role'] === 'editor'){
						print '
						<th></th>
						<th></th>
						<th>Title</th>
						<th>Description</th>
						<th>Date</th>';
						$query  = "SELECT * FROM news WHERE is_approved='0'";
						$query .= " ORDER BY date DESC";
						$result = @mysqli_query($conn, $query);
						while($row = @mysqli_fetch_array($result)) {
							print '
							<tr>
								<td><a href="index.php?menu=admin&amp;action='.$action.'&amp;id=' .$row['id']. '"></a></td>
									<td><a href="index.php?menu=admin&amp;action='.$action.'&amp;delete=' .$row['id']. '"><i style="color:black" class="fas fa-trash-alt"></i></a></td>
								<td>' . $row['title'] . '</td>
								<td>';
								if(strlen($row['description']) > 160) {
									echo substr(strip_tags($row['description']), 0, 160).'...';
								} else {
									echo strip_tags($row['description']);
								}
								print '
								</td>
								<td>' . pickerDateToMysql($row['date']) . '</td>
							</tr>';
						}
					}
					else {
						print '	
						<th></th>
						<th>Title</th>
						<th>Description</th>
						<th>Date</th>';
						$query  = "SELECT * FROM news WHERE is_approved='0'";
						$query .= " ORDER BY date DESC";
						$result = @mysqli_query($conn, $query);
						while($row = @mysqli_fetch_array($result)) {
							print '
							<tr>
								<td><a href="index.php?menu=admin&amp;action='.$action.'&amp;id=' .$row['id']. '"></a></td>
								<td>' . $row['title'] . '</td>
								<td>';
								if(strlen($row['description']) > 160) {
									echo substr(strip_tags($row['description']), 0, 160).'...';
								} else {
									echo strip_tags($row['description']);
								}
								print '
								</td>
								<td>' . pickerDateToMysql($row['date']) . '</td>
							</tr>';
						}
					}
					print '
					</tr>';
			print '
			</table>		
		</div>
		<h4 style="display: flex;justify-content: center;">Add news</h4>
		<a style="display: flex;justify-content: center;margin-bottom:30px; text-decoration: none" href="index.php?menu=admin&amp;action=' . $action . '&amp;add=true"class="AddLink"><i style="color:black"class="far fa-plus-square fa-3x"></i></a>';
	}
	
	@mysqli_close($conn);
?>