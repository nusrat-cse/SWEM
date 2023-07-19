<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="./public/css/style.css">
</head>
  <body class="body">

    <div class="container-fluid m-0 p-0">
        <nav class="navbar navbar-expand-lg bg-light">
            <div class="container">
                <a class="navbar-brand" href="./index.php">Navbar</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="./index.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Events</a>
                        </li>
                        
                        
                    </ul>
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 w-100 justify-content-end">
                        <?php if(isset($_SESSION['user_name'])){
                            ?>
                            <li class="nav-item">
                                <a href="./index.php"  class="nav-link"><?php echo $_SESSION['user_name'];?></a>
                            </li>
                            <li class="nav-item">
                                <a href="./logout.php"  class="nav-link">Log out</a>
                            </li>
                        <?php }else{ ?>
                            <li class="nav-item">
                                <a href="./log-in.php"  class="nav-link">Log-in</a>
                            </li>
                        <?php  } ?>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
    <div class="container-fluied">

    
