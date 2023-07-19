<?php 
    require('./config.php');
    global $pdo;
    $event_id = $_POST['event_id'];
    $cost_id = $_POST['cost_id'];
    $cost_title = $_POST['cost_title'];
    $cost_amount = $_POST['cost_amount'];

    if($event_id and $cost_id){
        $update = $pdo->prepare("UPDATE event_cost SET cost_text=?,cost_amount=? WHERE id=?");
        $result = $update->execute(array($cost_title,$cost_amount,$cost_id));
        if($result){
            echo "<script>alert('Update event cost successly')</script>";
            echo "<script>location.replace('./event-cost.php?id=".$event_id."')</script>";
        }
    }