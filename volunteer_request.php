<?php require('./config.php');
    global $pdo;
    session_start();
    $user_id = $_SESSION['user_id'];
    $event_id = $_POST['event_id'];
    $validate_check = $pdo->prepare("SELECT * FROM paritcipator WHERE event_id=? AND user_id=? LIMIT 1");
    $validate_check->execute(array(intval($event_id),intval($user_id)));
    $status = $validate_check->rowCount();
    if($status ==0){
        $result =$pdo->prepare("INSERT INTO paritcipator (event_id,user_id,status) VALUES(?,?,?)");
        $check = $result->execute(array(intval($event_id),intval($user_id),0)); 
        if($check){
            ?>
            <script>
                alert('Your request status pending');
                location.replace("./index.php");
            </script>
        <?php }
    }else{ ?>
            <script>
                alert('Opps! You all ready request send this event');
                location.replace("./index.php");
            </script>
    <?php }
    
?>