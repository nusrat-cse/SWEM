<?php 
    include('./config.php');
    global $pdo;
    session_start();
    if(isset($_SESSION['user_id'])){
        $user_id = intval($_SESSION['user_id']);
        $user_type = intval($_SESSION['user_type']);
        $unseen_notification = $pdo->prepare("SELECT * FROM notification WHERE user_id=? AND user_type=? AND notification_status=?");
        $unseen_notification->execute(array($user_id,$user_type,0));
        $total_unseen_notification = $unseen_notification->rowCount();

        $notification = $pdo->prepare("SELECT notification.notification_id AS notification_id,notification.notification_status AS status,notification.event_id AS event_id,event.e_image AS image,event.e_name AS title FROM notification JOIN event ON event.id = notification.event_id WHERE user_id=? AND user_type=?");
        $notification->execute(array($user_id,$user_type));
        $notifications = $notification->fetchAll();
    }
    
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Charity</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
 
    <link rel="stylesheet" href="./public/css/style.css">
    <style>
        .notification{
            padding: 5px;
            border-radius: 6px;
        }
        .notification_active{
            background: #c1c1c1;
        }
        .notification_event{
            text-decoration: none;
            color: black;
        }
        .notification_event:hover{
            text-decoration: none;
            color: black;
        }
        .notification:hover{
            background: #d9d7d7;
        }
        
    </style>
</head>
  <body class="body">
    <nav class="navbar navbar-expand-lg bg-light d-flex flex-column ">
        <div class="d-flex w-100 justify-content-center logo_background">
            <a class="navbar-brand navbar_logo" href="./index.php"><img src="./public/image/logo.png" alt=""> RestoreEco</a>
        </div>
        <div class="container">
            <button class="navbar-toggler nav_toggle_button" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active link_font" aria-current="page" href="./index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link link_font" href="./events.php">Events</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link link_font" href="#">Projects</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link link_font" href="#">Post</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link link_font" href="#">Donate</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link link_font" href="#">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link link_font" href="#">Services</a>
                    </li>
                    
                </ul>
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 w-100 justify-content-end">
                    <?php if(isset($_SESSION['user_id'])){
                        ?>
                        <li class="nav-item d-flex justify-content-center align-items-center">
                            <button style="border:none;background:none;position: relative;" type="button" id="noticationSection" data-bs-toggle="dropdown">
                                <i class="fas fa-bell"></i>
                                <?php if($total_unseen_notification > 0){?>
                                    <span style="position: absolute;top: -32%;color:red"><?php echo $total_unseen_notification; ?></span>
                                <?php } ?>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="noticationSection" style="overflow: hidden;overflow-y: scroll;right: 0px;width: 24%;max-height: 69vh;left: inherit;">
                                <div style="text-align:center">Notifications</div>
                                <ul style="list-style-type: none;padding: 5px;">
                                    <?php foreach ($notifications as $notify) {
                                       ?>
                                        <li>
                                            <div class="notification <?php if($notify['status'] == 1){ ?>
                                                notification_active
                                                <?php } ?>">
                                                <a href="./event-details.php?id=<?php echo $notify['event_id'];?>" onclick="notification(<?php echo $notify['notification_id'];?>)" class="notification_event">
                                                    <div class="row">
                                                        <div class="col-4">
                                                            <img src="./event_image/<?php echo $notify['image']; ?>" style="width:100%;height:100px" alt="">
                                                        </div>
                                                        <div class="col-8">
                                                            <p><?php echo $notify['title'];?></p>
                                                        </div>
                                                    </div>
                                                </a>
                                                
                                            </div>
                                        </li>
                                    <?php } ?>
                                    
                                    
                                    
                                </ul>
                            </div>
                        </li>

                        <li class="nav-item">
                            <a href="./dashboard.php"  class="nav-link " ><?php echo $_SESSION['user_name'];?></a>
                            
                        </li>
                        <li class="nav-item">
                            <a href="./logout.php"  class="nav-link">Log out</a>
                        </li>
                    <?php }else{ ?>
                        <li class="nav-item">
                            <a href="./log-in.php"  class="nav-link">Log-in</a>
                        </li>
                        <li class="nav-item">
                            <a href="./register.php" class="nav-link">Register</a>
                        </li>
                    <?php  } ?>
                </ul>
            </div>
        </div>
    </nav>
        

    
