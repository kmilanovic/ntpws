<?php
print '
<h1>Contact</h1>
<iframe src="https://maps.google.com/maps?q=Zagreb,%20Trg%20bana%20Josipa%20Jela%C4%8Di%C4%87a&t=&z=13&ie=UTF8&iwloc=&output=embed"></iframe>

<div class="form">
<form action="">
  <label for="fname">First Name</label>
  <input type="text" id="fname" name="firstname" placeholder="Your first name" />

  <label for="lname">Last Name</label>
  <input type="text" id="lname" name="lastname" placeholder="Your last name" />

  <label for="email">Email</label>
  <input type="email" id="email" name="email" placeholder="Your email" />


  <label for="country">Country</label>
  <div class="select">
    <select class="countries">
      <option value="">Select country</option>
      <option value="Croatia">Croatia</option>
      <option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
      <option value="Serbia">Serbia</option>
    </select>
  </div>

  <input type="submit" value="Submit" />
</form>
</div>
<p>
Social media:<br />
<a href="https://www.facebook.com/profile.php?id=100043504936152" target="_blank"><i class="fab fa-facebook-f"></i></a>
<a href="https://www.instagram.com/milanovickristijan/" target="_blank"><i class="fab fa-instagram"></i></a>
</p>';
?>