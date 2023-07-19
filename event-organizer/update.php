<?php 
    require('../config.php');
    global $pdo;
?>
<?php
    if($_POST['event_name']){
        $name = $_POST['event_name'];
        $type = $_POST['event_type'];
        $location = $_POST['location'];
        if(empty( $_POST['start_date'])){
            $start = $_POST['old_start_date'];
        }else{
            $start = $_POST['start_date'];
        }
        if(empty($_POST['end_date'])){
            $end = $_POST['old_end_date'];
        }else{
            $end = $_POST['end_date'];
        }
        
        $description = $_POST['description'];
        $e_id = $_POST['event_id'];
        if(empty($_POST['priority'])){
            $priority = 1;
        }else{
            $priority = $_POST['priority'];
        }
        $update_event = $pdo->prepare("UPDATE event SET e_name=?,e_type=?,e_location=?,priority=?,e_description=?,e_start=?,e_end=? WHERE id=?");
        $result = $update_event->execute(array($name,$type,$location,$priority,$description,$start,$end,intval($e_id)));
        if($result){
            ?>
            <script>
                alert('Update successly');
                location.replace('./index.php');
            </script>
           <?php 
        }else{ ?>
            <script>
                alert('Update some error');
                location.replace('./index.php');
            </script>
        <?php }
        
    }
 
    


    
?>


