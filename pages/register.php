<?php

print '
<h1>Register</h1>';

if ($_POST['_action_'] == FALSE) {
  print '
      <div class="form">
        <form action="" method="POST">
        <input type="hidden" id="_action_" name="_action_" value="TRUE">
          <label for="fname">First Name</label>
          <input type="text" id="fname" name="firstname" placeholder="Your first name" required/>

          <label for="lname">Last Name</label>
          <input type="text" id="lname" name="lastname" placeholder="Your last name" required/>

          <label for="email">Email</label>
          <input type="email" id="email" name="email" placeholder="Your email" required/>


          <label for="country">Country</label>
          <div class="select">
            <select class="countries" name="country" required>
              <option value="">Select country</option>';
              $query = "SELECT country_name FROM countries";
              $records = mysqli_query($conn, $query);  

              while($data = mysqli_fetch_array($records))
              {
                  echo "<option value='". $data['country_name'] ."'>" .$data['country_name'] ."</option>"; 
              }
              mysqli_close($conn);  
          print '
          </select>
        </div>

      <label for="city">City</label>
      <input type="text" id="city" name="city" placeholder="City" required/>

      <label for="street">Street</label>
      <input type="text" id="street" name="street" placeholder="Street" required/>

      <label for="dob">Date of birth</label>
      <input type="date" id="dob" name="dob" placeholder="DOB" required/>

      <label for="username">Username</label>
			<input type="text" id="username" name="username" placeholder="Username" required/>

      <label for="password">Password</label>
      <input type="password" id="password" name="password" placeholder="Password" required/>

      <input type="submit" value="Submit" />
    </form>';
  }
  else if ($_POST['_action_'] == TRUE) 
  {

    $query  = "SELECT * FROM users";
    $query .= " WHERE email='" .  $_POST['email'] . "'";
    $query .= " OR username='" .  $_POST['username'] . "'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

    if (!is_array($row)) {
      # password_hash() creates a new password hash using a strong one-way hashing algorithm
      $pass_hash = password_hash($_POST['password'], PASSWORD_DEFAULT, ['cost' => 12]);
      
      $query  = "INSERT INTO users (firstname, lastname, email, country, city, street, dob, username, password)";
      $query .= " VALUES ('" . $_POST['firstname'] . "', '" . $_POST['lastname'] . "', '" . $_POST['email'] . "', '" . $_POST['country'] . "', '" . $_POST['city'] . "', '" . $_POST['street'] . "', '" . $_POST['dob'] . "', '" . $_POST['username'] . "', '" . $pass_hash . "')";
      $result = mysqli_query($conn, $query);
      
      # ucfirst() — Make a string's first character uppercase
      # strtolower() - Make a string lowercase
      echo '<p>' . $_POST['firstname'] . ' ' .  $_POST['lastname'] . ', thank you for registration </p>
      <hr>';
    }
    else 
    {
      echo '<p>User with this email or username already exist!</p>';
    }
  }

print '
</div>';
?>