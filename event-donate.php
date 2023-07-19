<?php require('./config.php');
    session_start();
    global $pdo;
    if($_REQUEST['action'] == "donate"){
        $event = $_REQUEST['event'];
        $amount = $_REQUEST['amount'];
        $use_id = $_SESSION['user_id'];
        $select = $pdo->prepare("SELECT * FROM donate WHERE event_id=?");
        $select->execute(array(intval($event)));

        $check_donate = $select->fetch();
        if($check_donate){
            $total_amount = $check_donate['amount'] + intval($amount);
            $result = $pdo->prepare("UPDATE donate SET amount=? WHERE event_id=?");
            $data = $result->execute(array($total_amount,$event));
            if($data){
                echo json_encode(['status'=>'success']);
            }else{
                echo json_encode(['status'=>'error']);  
            }
        }else{
            $result = $pdo->prepare("INSERT INTO donate(user_id,event_id,amount,payment_by) VALUES(?,?,?,?)");
            $data = $result->execute(array($use_id,$event,$amount,"Bkash"));
            if($data){
                echo json_encode(['status'=>'success']);
            }else{
                echo json_encode(['status'=>'error']);  
            }
        }
        
    }
?>