<?php require('./config.php');
    global $pdo;
    if($_REQUEST['id']){
        $user_type = $_REQUEST['type'];
        $location = "";
        if($user_type == '1'){
            $update = $pdo->prepare("DELETE FROM volunteer WHERE volunteer_id=?");
            $result = $update->execute(array(intval($_REQUEST['id'])));
            if($result){
                $location = "./volunteer.php" ;
            }
        }elseif ($user_type == '2') {
            
            $update = $pdo->prepare("DELETE FROM donar WHERE donar_id=?");
            $result = $update->execute(array(intval($_REQUEST['id'])));
            if($result){
                $location = "./donar.php" ;
            }
        }elseif ($user_type == '3') {
           
            $update = $pdo->prepare("DELETE FROM event_organizer WHERE organizer_id=?");
            $result = $update->execute(array(intval($_REQUEST['id'])));
            if($result){
                $location = "./event-organizer.php" ;   
            }
        }
        
        
        header("Location: ".$location);
        
    }
?>