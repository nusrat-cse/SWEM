<?php require('./config.php');
    global $pdo;
    if($_REQUEST['id']){
        $update = $pdo->prepare("UPDATE paritcipator SET status=? WHERE id=?");
        $result = $update->execute(array(2,intval($_REQUEST['id'])));
        if($result){
            $location = "./event-details.php?id=".$_REQUEST['event_id'] ;
            header("Location: ".$location);
        }
    }
?>