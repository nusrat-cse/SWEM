<?php require('./config.php');
    global $pdo;
    session_start();
    $event_id = $_REQUEST['id'];
    $event= $pdo->prepare("SELECT * FROM event WHERE id=?");
    $event->execute(array(intval($event_id)));
    $event_data = $event->fetch();
    $participator = $pdo->prepare("SELECT user.*,paritcipator.status AS status,paritcipator.id AS id FROM paritcipator JOIN user ON user.id=paritcipator.user_id WHERE paritcipator.event_id=?");
    $participator->execute(array(intval($event_id)));
    $all_paritcipator = $participator->fetchAll();
    $total_paritcipator = $participator->rowCount();
?>
<?php include('./header.php'); ?>

<div class="container my-4">
    <div>
        <div class="text-center" style="font-size: 45px;font-weight: 800;background: gainsboro;">Event paritcipators</div>
        <table class="table table-bordered"  style=" color: white;" >
            <thead>
                <th scope="col">User name</th>
                <th scope="col">Mobile number</th>
                <th scope="col">Occupation</th>
                <th scope="col">Status</th>
                <th scope="col">Actions</th>
            </thead>
            <tbody>
                <?php
                    if(!empty($all_paritcipator)){
                        foreach($all_paritcipator as $volunteer){
                                $text = '';
                                $color ='';
                                if($volunteer['status'] == 0){
                                    $text = "Pending";
                                    $color = "primary";
                                }else if($volunteer['status'] == 1){
                                    $text = "Approve";
                                    $color = "success";
                                }else if($volunteer['status'] == 2){
                                    $text = "Not Approve";
                                    $color = "warning";
                                }
                            ?>
                            <tr>
                                <td scope="row"><?php echo $volunteer['user_name']; ?></td>
                                <td scope="row" style="text-align:center">
                                <?php echo $volunteer['mobile']; ?>
                                </td>
                                <td scope="row"><?php echo $volunteer['v_occupation']; ?></td>
                                <td scope="row" class="text-<?php echo $color;?>"><?php echo $text; ?></td>
                                <td scope="row">
                                    <a href="./approve.php?id=<?php echo $volunteer['id'] ?>&event_id=<?php echo $event_id;?>" class="btn btn-primary">Approve</a> 
                                     
                                    <a href="./not-approve.php?id=<?php echo $volunteer['id']?>&event_id=<?php echo $event_id;?>" class="btn btn-danger">Not Approve</a>    
                                </td>
                            </tr>
                            
                            <?php
                        }
                    }
                ?>
            </tbody>
        </table>
    </div>

</div>
<?php include('./footer.php'); ?>