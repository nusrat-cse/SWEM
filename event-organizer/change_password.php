<?php
    require('./config.php');
    session_start();
    global $pdo;
    $old = md5($_REQUEST['old']);
    $new = md5($_REQUEST['new']);
    $user_id = $_SESSION['user_id'];
    if(isset($user_id)){
        $check = $pdo->prepare("SELECT * FROM user WHERE id=?");
        $check->execute(array(intval($user_id)));
        $user = $check->fetch();
        if($user['password'] == $old){
            $update = $pdo->prepare("UPDATE user SET password=? WHERE id=?");
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
