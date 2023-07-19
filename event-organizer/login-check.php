<?php require('./config.php');
    global $pdo;
?>
<?php
    $email = $_POST['email'];
    $password = md5($_POST['password']);
    $checkValid = $pdo->prepare('SELECT * FROM event_organizer WHERE email=? AND password=? ');
    $checkValid->execute(array($email,$password));
    $data = $checkValid->fetch();
    if($data){
        session_start();
        if($data['user_type'] == 3){
            if($data['account_status'] == 0){
                echo json_encode(['status'=>'pending']);
            }else if( $data['account_status'] == 2){
                echo json_encode(['status'=>'inActive']);
            }else{
                $_SESSION['user_name'] = $data['user_name'];
                $_SESSION['user_id'] = $data['organizer_id'];
                $_SESSION['user_type'] = $data['user_type'];
                echo json_encode(['status'=>'success','user_type'=>$data['user_type']]);
            }
        }else{
            
            echo json_encode(['status'=>'type_error']);
        }

    }else{
        echo json_encode(['status'=>'invalid']);
    }
?>