<?php
    require('./config.php');
    session_start();
    global $pdo;
    $old = md5($_REQUEST['old']);
    $new = md5($_REQUEST['new']);
    $user_id = $_SESSION['user_id'];
    if(isset($user_id)){
        $user_type = intval($_SESSION['user_type']);
        if($user_type == 1){
            $check = $pdo->prepare("SELECT * FROM volunteer WHERE volunteer_id=?");
        }   
        if($user_type == 2){
            $check = $pdo->prepare("SELECT * FROM donor WHERE donor_id=?");
        }
        if($user_type == 3){
            $check = $pdo->prepare("SELECT * FROM event_organizer WHERE organizer_id=?");
        }
        $check->execute(array(intval($user_id)));
        $user = $check->fetch();
        if($user['password'] == $old){
            
            if($user_type == 1){
                $update = $pdo->prepare("UPDATE volunteer SET password=? WHERE volunteer_id=?");
            }   
            if($user_type == 2){
                $update = $pdo->prepare("UPDATE donor SET password=? WHERE donor_id=?");
            }
            if($user_type == 3){
                $update = $pdo->prepare("UPDATE event_organizer SET password=? WHERE organizer_id=?");
            }
            $password_change = $update->execute(array($new,intval($user_id)));
            if($password_change){
                echo json_encode(['status'=>"success"]);
            }

        }else{
            echo json_encode(['status'=>"not_match"]); 
        }
    }else{
        echo json_encode(['status'=>"login"]);
    }


?>
