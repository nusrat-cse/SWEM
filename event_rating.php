<?php require('./config.php');
session_start();
    global $pdo;
    if($_POST['action']){
        $user_id = $_SESSION['user_id'];
        $user_type = $_SESSION['user_type'];
        $event_id = $_POST['event_id'];
        $review_text = $_POST['review_text'];
        $rating = $_POST['rating'];
        $result = $pdo->prepare('INSERT INTO event_review(user_type,event_id,by_id,review,review_text) VALUES(?,?,?,?,?) ');
        $add_rating = $result->execute(array(intval($user_type),$event_id,intval($user_id),$rating,$review_text));
        if($add_rating){
            echo 'Success';
        }else{
            echo 'Error';
        }
    }else{
        printf('some error');
    }    
?>