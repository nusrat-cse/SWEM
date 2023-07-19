<?php
    require('./config.php');
    global $pdo;
    $id = $_REQUEST['id'];
    $status = $_REQUEST['status'];
    if($id){
        $review = $pdo->prepare("SELECT * FROM event_review WHERE id=? LIMIT 1");
        $review->execute(array(intval($id)));
        $review_get = $review->fetch();
        $update = $pdo->prepare('UPDATE event_review SET review_status=? WHERE id=?');
        $update_success = $update->execute(array(intval($status),intval($id)));
        if($update_success){
            header("location:./event-review.php?id=".$review_get['event_id']);
        }
    }

?>