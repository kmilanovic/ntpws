<header>
  <div class="hero-image"></div>
  <nav>
    <ul>
      <?php
      $nav_menu = array('home', 'news', 'contact', 'about', 'gallery');
      for ($i = 0; $i < count($nav_menu); $i++) {
        echo '<li><a href="index.php?menu=' . $nav_menu[$i] . '">' . strtoupper($nav_menu[$i]) . '</a></li>';
      }
      ?>
    </ul>
  </nav>
</header>