<?php
print '
<h1>News</h1>
';

$query  = "SELECT * FROM news WHERE is_approved='1'";
$query .= " ORDER BY date DESC";
$result = @mysqli_query($conn, $query);

while($row = @mysqli_fetch_array($result)) {
    $queryImage = "SELECT * FROM pictures WHERE newsId='".$row['id']."' LIMIT 1";
    $resultImage = @mysqli_query($conn, $queryImage);
    $rowImage = @mysqli_fetch_array($resultImage);
    
print '
<div class="card__wrap--outer">
<div class="card__wrap--inner">
    <div class="card">
        <a href="index.php?article='. $row['id'] .'"><img src="assets/'.$rowImage['img'].'"></a>
        <div class="card__item">
            <h2>'. $row['title'] . '</h2>
        </div>
        <div class="card__date">
            <small>'. $row['date'] . '</small>
        </div>
        <div class="card__item flexible">
            <small class="description" ><span> '. $row['description'] . '</span></small>
        </div>
        <div class="card__footer">
            <a class="pull" href="index.php?article='. $row['id'] .'"><small>Read more</small></a>
        </div>
    </div>
</div>
</div>';}

print '<p>Social media:<br>
<a href="https://www.facebook.com/profile.php?id=100043504936152" target="_blank"><i class="fab fa-facebook-f"></i></a>
<a href="https://www.instagram.com/milanovickristijan/" target="_blank"><i class="fab fa-instagram"></i></a>
</p>'
?>