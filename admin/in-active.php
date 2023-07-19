<?php require('./config.php');
    global $pdo;
    if($_REQUEST['id']){
        $user_type = $_REQUEST['type'];
        $location = "";
        if($user_type == '1'){
            $update = $pdo->prepare("UPDATE volunteer SET account_status=? WHERE volunteer_id=?");
            $result = $update->execute(array(2,intval($_REQUEST['id'])));
            if($result){
                $location = "./volunteer.php" ;
            }
        }elseif ($user_type == '2') {
            
            $update = $pdo->prepare("UPDATE donar SET account_status=? WHERE donar_id=?");
            $result = $update->execute(array(2,intval($_REQUEST['id'])));
            if($result){
                $location = "./donar.php" ;
            }
        }elseif ($user_type == '3') {
           
            $update = $pdo->prepare("UPDATE event_organizer SET account_status=? WHERE organizer_id=?");
            $result = $update->execute(array(2,intval($_REQUEST['id'])));
            if($result){
                $location = "./event-organizer.php" ;   
            }
        }
        
        
        header("Location: ".$location);
        
    }
?>