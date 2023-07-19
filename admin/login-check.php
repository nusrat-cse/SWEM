<?php require('./config.php');
    global $pdo;
?>
<?php
    $email = $_POST['email'];
    $password = md5($_POST['password']);
    $checkValid = $pdo->prepare('SELECT * FROM admin WHERE email=? AND password=? ');
    $checkValid->execute(array($email,$password));
    $data = $checkValid->fetch();
    if($data){
        session_start();
        $_SESSION['user_name'] = $data['user_name'];
        $_SESSION['user_id'] = $data['admin_id'];
        $_SESSION['user_type'] = $data['user_type'];
        echo json_encode(['status'=>'success']);

    }else{
        echo 'invalid user';
    }
?>