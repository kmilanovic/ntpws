<?php
$query  = "SELECT * FROM news WHERE id=". htmlspecialchars($_GET["article"])."";
$result = @mysqli_query($conn, $query);
$row = @mysqli_fetch_array($result);

print '
<main>
      <h1>' . $row['title'] . '</h1>
      <div class="gallery">';
      $queryImages = "SELECT * FROM pictures WHERE newsId='".$_GET['article']."'";
      $resultImages = @mysqli_query($conn, $queryImages);
      while ($rowImages = @mysqli_fetch_array($resultImages)) {
        print '
        <figure id="galleryFigure">
          <a target="_blank" href="assets/'.$rowImages['img'].'">
            <img/img src="assets/'.$rowImages['img'].'" alt="'.$rowImages['description'].'" width="600" height="400">
          </a>
          <figcaption>'.$rowImages['description'].'</figcaption>
        </figure>
      </div>
      <p>'.$row['description'].'</p>';}
     print '
    </main>';
?>