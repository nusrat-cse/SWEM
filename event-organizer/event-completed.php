<?php
    require('./config.php');
    global $pdo;
    $id = $_REQUEST['id'];

    if($id){
        $update = $pdo->prepare("UPDATE event SET event_status=? WHERE id=?");
        $result = $update->execute(array(3,$id));
        if($result){
            echo "<script>alert('Update event status successly')</script>";
            echo "<script>location.replace('./event-list.php')</script>";
        }
    }


?>