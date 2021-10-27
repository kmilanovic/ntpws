<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, inital-scale=1.0" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</head>

<body>
    <div class="container-fluid">
        <h2>Unesite ocjene kolokvija</h2>
        <form action="" method="GET">
            <div class="form-group">
                <label for="kol1">Kolokvij 1:</label>
                <input type="number" class="form-control" name="kol1" min="1" max="5" required style="width:100px">
            </div><br>
            <div class="form-group">
                <label for="kol2">Kolokvij 2:</label>
                <input type="number" class="form-control" name="kol2" min="1" max="5" required style="width:100px">
            </div><br>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

    <?php
    $kolokvij1 = !empty($_GET['kol1']) ? $_GET['kol1'] : 0;
    $kolokvij2 = !empty($_GET['kol2']) ? $_GET['kol2'] : 0;

    $ispis = "";
    $jedan = 1;
    if (!empty($kolokvij1) && !empty($kolokvij2)) {
        if ($kolokvij1 == 1 || $kolokvij2 == 1) 
        {
            $ispis =  "Srednja ocjena: " .$jedan;
        } else 
        {
            $srednja_ocjena = ($kolokvij1 + $kolokvij2) / 2;
            $ispis = "Srednja ocjena: " . $srednja_ocjena;
        }
    }
    ?>

    <div class="container-fluid">
        <h5><?php echo $ispis ?></h5> 
    </div>

</body>

</html>