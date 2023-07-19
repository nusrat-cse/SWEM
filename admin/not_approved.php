<?php
    require('../config.php');
    global $pdo;
    $id = $_REQUEST['id'];

    $data = $pdo->prepare("UPDATE event SET status=? WHERE id=?");
    $result = $data->execute(array(2,intval($id)));
    if($result){
        header("Location: ./events.php");
    }else{
        ?>
        <script>
            alert('Some Error')
            location.reload()
        </script>
   <?php } ?>