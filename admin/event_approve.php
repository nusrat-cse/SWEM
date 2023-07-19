<?php
    require('../config.php');
    global $pdo;
    $id = $_REQUEST['id'];

    $data = $pdo->prepare("UPDATE event SET status=? WHERE id=?");
    $result = $data->execute(array(1,intval($id)));
    if($result){
        $event = $pdo->prepare("SELECT event_status FROM event WHERE id=? LIMIT 1");
        $event->execute(array($id));
        $event_check = $event->fetch();
        if($event_check['event_status'] == 0){
            $update_status = $pdo->prepare("UPDATE event SET event_status=? WHERE id=?");
            $update_status->execute(array(1,intval($id)));
            $event_type = $pdo->prepare("SELECT * FROM event_type WHERE name=? LIMIT 1");
            $event_type->execute(array($event_check['e_type']));
            $type = $event_type->fetch();


            $volunteer_user = $pdo->prepare("SELECT volunteer_id FROM volunteer_interest WHERE event_type_id=?");
            $volunteer_user->execute(array(intval($type['id'])));
            $volunteers = $volunteer_user->fetchAll();

            foreach ($volunteers as $v_user) {

                $notification = $pdo->prepare("INSERT INTO notification(event_id,user_id,user_type,notification_status) VALUES(?,?,?,?)");
                $notification->execute(array(intval($id),$v_user['volunteer_id'],1,0));
            }
            $donar_user = $pdo->prepare("SELECT donar_id FROM donar");
            $donar_user->execute();
            $donars = $donar_user->fetchAll();

            foreach ($donars as $d_user) {
                $notification = $pdo->prepare("INSERT INTO notification(event_id,user_id,user_type,notification_status) VALUES(?,?,?,?)");
                $notification->execute(array(intval($id),$d_user['donar_id'],2,0));
            }

        }
        header("Location: ./events.php");
    }else{
        ?>
        <script>
            alert('Some Error')
            location.reload()
        </script>
   <?php } ?>