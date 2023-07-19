<?php
    include("./config.php");
    global $pdo;

    $id = $_REQUEST['id'];
    $chage_status = $pdo->prepare("UPDATE notification SET notification_status=? WHERE notification_id=? AND notification_status=?");
    $success = $chage_status->execute(array(2,intval($id),1));
    if($success){
        echo 'success';
    }else{
        echo 'error';
    }


?>