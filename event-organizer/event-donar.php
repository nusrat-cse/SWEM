<?php require('./config.php');
    global $pdo;
    session_start();
    $event_id = $_REQUEST['id'];
    $event= $pdo->prepare("SELECT * FROM event WHERE id=?");
    $event->execute(array(intval($event_id)));
    $event_data = $event->fetch();

    $donar = $pdo->prepare("SELECT user.*,donate.id AS id, donate.amount as amount FROM donate JOIN user ON user.id=donate.user_id WHERE donate.event_id=?");
    $donar->execute(array(intval($event_id)));
    $all_donar = $donar->fetchAll();
    $total_paritcipator = $donar->rowCount();
?>
<?php include('./header.php'); ?>

<div class="container my-4">
    <div>
        <div class="text-center" style="font-size: 45px;font-weight: 800;background: gainsboro;">Event Donars</div>
        <table class="table table-bordered" style=" color: white;">
            <thead>
                <th scope="col">User name</th>
                <th scope="col">Mobile number</th>
                <th scope="col">Amount</th>>
            </thead>
            <tbody>
                <?php
                    if(!empty($all_donar)){
                        foreach($all_donar as $volunteer){
                                
                            ?>
                            <tr>
                                <td scope="row"><?php echo $volunteer['user_name']; ?></td>
                                <td scope="row" style="text-align:center">
                                <?php echo $volunteer['mobile']; ?>
                                </td>
                                <td scope="row"><?php echo $volunteer['amount']; ?></td>
                                
                               
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