<?php require('./config.php');
    global $pdo;
?>
<?php
    $email = $_POST['email'];
    $password = md5($_POST['password']);
    $user_type = $_POST['user_type'];
    if($user_type == 1){
        $checkValid = $pdo->prepare('SELECT * FROM volunteer WHERE email=? AND password=? ');
    }
    if($user_type == 2){
        $checkValid = $pdo->prepare('SELECT * FROM donor WHERE email=? AND password=? ');
    }
    $checkValid->execute(array($email,$password));
    $data = $checkValid->fetch();
    if($data){
        session_start();
        // 'pending' = 0
        // 'Active' =1
        
        if($data['account_status'] == 0){
            echo json_encode(['status'=>'pending']);
        }else if( $data['account_status'] == 2){
            echo json_encode(['status'=>'inActive']);
        }else{
            $_SESSION['user_name'] = $data['user_name'];
            
            $_SESSION['user_type'] = $data['user_type'];
            $_SESSION['email'] = $data['email'];
            $_SESSION['phone'] = $data['mobile'];
            if($user_type == 1){
                $_SESSION['user_id'] = $data['volunteer_id'];
            }else{
                $_SESSION['user_id'] = $data['donor_id'];
            }
            echo json_encode(['status'=>'success','user_type'=>$data['user_type']]);
        }
    }else{
        echo 'invalid user';
    }
?>