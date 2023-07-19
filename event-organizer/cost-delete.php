<?php require('./config.php');
    global $pdo;
    $cost_id = $_REQUEST['id'];
    $event_id = $_REQUEST['event_id'];
    $delete = $pdo->prepare("DELETE FROM event_cost WHERE id=?");
    $result = $delete->execute(array($cost_id));
    if($result){
        echo "<script>alert('Event cost Delete successly')</script>";
        echo "<script>location.replace('./event-cost.php?id=".$event_id."')</script>";
    }else{
        echo "<script>alert('Some Errors')</script>";
        echo "<script>location.replace('./event-cost.php?id=".$event_id."')</script>";
    }