<?php include('./header.php');?>
<?php require('./config.php');
    global $pdo;
    $user_type = $_SESSION['user_type'];
    if($user_type == '1'){
        $result = $pdo->prepare("SELECT paritcipator.status AS e_status,event.* FROM paritcipator JOIN event ON event.id=paritcipator.event_id WHERE paritcipator.user_id=?");
        $result->execute(array(intval($_SESSION['user_id'])));
        $myparticipate= $result->fetchAll();
    }
    if($user_type == '2'){
        $donate = $pdo->prepare("SELECT donate.amount AS amount,event.*,event.id AS event_id FROM donate JOIN event ON event.id = donate.event_id WHERE donate.user_id=?");
        $donate->execute(array(intval($_SESSION['user_id'])));
        $total_donate = $donate->fetchAll();
    }
?>
<?php if($user_type == '1'){
    ?>
    <div class="container">

        <div class="py-4">
            
            <div>
                <div class="text-center" style="font-size: 45px;font-weight: 800;background: gainsboro;">Events</div>
                <table class="table table-bordered p-0 table-primary table-hover">
                    <thead>
                        <th scope="col" class="p-0 fs-5">Event Name</th>
                        <th scope="col" class="p-0 fs-5">Event Image</th>
                        <th scope="col" class="p-0 fs-5">Event Start</th>
                        <th scope="col" class="p-0 fs-5">Event End</th>
                        <th scope="col" class="p-0 fs-5">Status</th>
                    </thead>
                    <tbody>
                        <?php
                            if(!empty($myparticipate)){
                                foreach($myparticipate as $event){
                                    $status_text = '';
                                    $button_color = '';
                                    if($event['e_status'] == 0){
                                        $status_text = "Pending";
                                        $button_color = 'primary';
                                    }else if($event['e_status'] == 1){
                                        $status_text = "Participate";
                                        $button_color = 'success';
                                    }else if($event['e_status'] == 2){
                                        $status_text = "Not Participate";
                                        $button_color = 'danger';
                                    }
                                    ?>
                                    <tr>
                                        <td scope="row" class="p-0 py-1 text-capitalize fs-5 px-2"><?php echo $event['e_name']; ?></td>
                                        <td scope="row" class="p-0 py-1 fs-5" style="text-align:center">
                                            <img style="width:75px;height:40px" src="./event_image/<?php echo $event['e_image']; ?>" alt="">
                                        </td>
                                        <td scope="row" class="p-0 py-1 fs-5"><?php echo date('d-m-Y H:s',strtotime($event['e_start'])) ?></td>
                                        <td scope="row" class="p-0 py-1 fs-5"><?php echo date('d-m-Y H:s',strtotime($event['e_end'])); ?></td>
                                        <td scope="row" class="p-0 py-1 fs-5">
                                            <button class="btn w-100 btn-<?php echo $button_color; ?>"><?php echo $status_text; ?></button>
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
    </div>
<?php }?>

<?php if($user_type == '2'){ ?>
    <div class="container">

        <div class="py-4">
            
            <div>
                <div class="text-center" style="font-size: 45px;font-weight: 800;background: gainsboro;">Donate Events</div>
                <table class="table table-bordered">
                    <thead>
                        <th scope="col">Event Name</th>
                        <th scope="col">Event Image</th>
                        <th scope="col">Donate </th>
                        <th scope="col">Event Start</th>
                        <th scope="col">Event End</th>
                        <th scope="col">Actions</th>
                        
                    </thead>
                    <tbody>
                        <?php
                            if(!empty($total_donate)){
                                foreach($total_donate as $event){
                                    ?>
                                    <tr>
                                        <td scope="row"><?php echo $event['e_name']; ?></td>
                                        <td scope="row" style="text-align:center">
                                            <img style="width:75px;height:40px" src="./event_image/<?php echo $event['e_image']; ?>" alt="">
                                        </td>
                                        <td scope="row">
                                            <?php echo $event['amount']; ?>
                                        </td>
                                        <td scope="row"><?php echo date('d-m-Y',strtotime($event['e_start'])); ?></td>
                                        <td scope="row"><?php echo date('d-m-Y',strtotime($event['e_end'])); ?></td>
                                        <td scope="row">
                                            <a href="./event-details.php?id=<?php echo $event['event_id'] ?>" class="btn btn-primary">Details</a>
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
    </div>
<?php } ?>

<?php include('./footer.php');?>