<?php require('./config.php');
    global $pdo;
    $event_id = $_GET['id'];
    $select_event = $pdo->prepare("SELECT * FROM event WHERE id=? LIMIT 1");
    $select_event->execute(array($event_id));
    $event = $select_event->fetch();
    $image_path = $event['e_image'];
    if($image_path){
        unlink("../event_image/$image_path");
        $select_event = $pdo->prepare("DELETE FROM event WHERE id=? LIMIT 1");
        $result = $select_event->execute(array($event_id));
        if($result){
            ?>
            <script>
                alert('Delete succes');
                location.replace('./index.php');
            </script>
        <?php }
    }
?>