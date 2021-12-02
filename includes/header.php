<header>
  <div class="hero-image"></div>
  <nav>
    <ul>
      <?php
      $nav_menu = array('home', 'news', 'contact', 'about', 'gallery', 'register', 'login', 'table-api');
      $nav_menu_admin = array('home', 'news', 'contact', 'about', 'gallery', 'admin', 'logout', 'table-api');
      
      if (!isset($_SESSION['user']['valid']) || $_SESSION['user']['valid'] == 'false') {
        for ($i = 0; $i < count($nav_menu); $i++) {
          echo '<li><a href="index.php?menu=' . $nav_menu[$i] . '">' . strtoupper($nav_menu[$i]) . '</a></li>';
        }
      }
      else if ($_SESSION['user']['valid'] == 'true') {
        for ($i = 0; $i < count($nav_menu); $i++) {
          echo '<li><a href="index.php?menu=' . $nav_menu_admin[$i] . '">' . strtoupper($nav_menu_admin[$i]) . '</a></li>';
        }
      }
      ?>
    </ul>
  </nav>
</header>