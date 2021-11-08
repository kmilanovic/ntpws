<?php

if ($_POST['_action_'] == FALSE) {
  print '
  <h1>Login</h1>

  <div class="form">
    <form action="" method="POST">
      <label for="username">Username</label>
      <input type="text" id="username" name="username" placeholder="Username" />

      <label for="password">Password</label>
      <input type="password" id="password" name="password" placeholder="Password" />

      <input type="submit" value="Submit" />
    </form>';
}
else if ($_POST['_action_'] == TRUE) {
		
  $query  = "SELECT * FROM users";
  $query .= " WHERE username='" .  $_POST['username'] . "'";
  $result = mysqli_query($conn, $query);
  $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
  
  if (password_verify($_POST['password'], $row['password'])) {
    #password_verify https://secure.php.net/manual/en/function.password-verify.php
    $_SESSION['user']['valid'] = 'true';
    $_SESSION['user']['id'] = $row['id'];
    $_SESSION['user']['firstname'] = $row['firstname'];
    $_SESSION['user']['lastname'] = $row['lastname'];
    $_SESSION['message'] = '<p>Dobrodošli, ' . $_SESSION['user']['firstname'] . ' ' . $_SESSION['user']['lastname'] . '</p>';
    # Redirect to admin website
    header("Location: index.php?menu=admin");
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



