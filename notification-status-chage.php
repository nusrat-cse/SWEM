<?php
    include("./config.php");
    global $pdo;

    $user = $_REQUEST['user'];
    $type = $_REQUEST['type'];

    $chage_status = $pdo->prepare("UPDATE notification SET notification_status=? WHERE user_id=? AND user_type=? AND notification_status=?");
    $success = $chage_status->execute(array(1,intval($user),intval($type),0));
    if($success){
        echo 'success';
    }else{
        echo 'error';
    }


?>