<?php include('./header.php');?>
<?php require('./config.php');
    global $pdo;
    $user_type = $_SESSION['user_type'];
    if($user_type == '2'){
        $donate = $pdo->prepare("SELECT accounts.donation_amount AS amount,accounts.platform_fee AS admin_profit,event.*,event.id AS event_id FROM accounts JOIN event ON event.id = accounts.event_id WHERE accounts.donor_id=?");
        $donate->execute(array(intval($_SESSION['user_id'])));
        $total_donate = $donate->fetchAll();
    }
?>
<style>
    .dashboard_link{
        height: 200px;
        background: #af5c9d;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-decoration: none;
        color: white;
        border-radius: 12px;
        box-shadow: 1px 6px 2px 2px #1e1b1da8;
    }
    .dashboard_link:hover{
        background:pink;
        color:black
    }
    .dashboard_link .text{
        font-size: 25px;
        padding-bottom: 28px;
    }
    .dashboard_link .number{
        font-size: 25px;
        font-family: sans-serif;
        font-weight: 700;
    }
    .gap{
        column-gap: 11%;
        justify-content: center;
        row-gap: 2%;
    }
    .dashboard_profile{
        margin-left: 5px;
        height: 176px;
        background: gainsboro;
        display: flex;
        justify-content: center;
        align-items: center;
        font-family: sans-serif;
    }
    .dashboard_profile h1{
        font-size: 64px;
        text-align: center;
    }
    .list-group-item:hover{
        z-index: 2;
        color: white;
        background-color: #0d6efd;
        border-color: 0d6efd;
    }
</style>
<?php if($user_type == '2'){
    ?>
    <div class="px-3 bg-white" style="min-height:100vh">
        <div class="row">
            <div class="col-md-3 left_sidebar">
                <div class="d-flex justify-content-center flex-column align-items-center py-3" style="background: gainsboro;">
                    <div><img src="./public/image/img4.jpg" class="rounded-circle" style="width:100px;height:100px" alt=""></div>
                    <div style="font-size: 29px;text-transform: uppercase;"><?php echo $_SESSION['user_name'] ?></div>
                </div>
                <div class="list-group py-2">
                    <a href="./dashboard.php" class="list-group-item list-group-item-action fs-4" aria-current="true">
                        Dashboard
                    </a>
                    <a href="./donate-events.php" class="list-group-item list-group-item-action active fs-4">Donated Events</a>
                    <a href="./profile.php" class="list-group-item list-group-item-action fs-4">Profile</a>

                </div>
                <div class="list-group py-2">
                    <a href="./settings.php" class="list-group-item list-group-item-action fs-4">Settings</a>
                    <a href="./logout.php" class="list-group-item list-group-item-action fs-4">Log-out</a>
                    
                </div>
            </div>
            <div class="col-md-9 p-0">
                <div class="dashboard_profile">
                    <h1>Confirmed Events</h1>
                </div>
                <div class="px-2 py-2">
                    <table class="table table-bordered table-primary table-hover">
                        <thead>
                            <th scope="col">Event Name</th>
                            <th scope="col">Event Image</th>
                            <th scope="col">Donate </th>
                            <th scope="col">Event Status </th>
                            <th scope="col">Actions</th>
                            
                        </thead>
                        <tbody>
                            <?php
                                if(!empty($total_donate)){
                                    foreach($total_donate as $event){
                                        $status = '';
                                        if($event['event_status'] == 2){
                                            $status = 'Ongoing';
                                        }else if ($event['event_status'] == 3) {
                                            $status = 'Completed';
                                        }
                                        ?>
                                        <tr>
                                            <td scope="row"><?php echo $event['e_name']; ?></td>
                                            <td scope="row" style="text-align:center">
                                                <img style="width:75px;height:40px" src="./event_image/<?php echo $event['e_image']; ?>" alt="">
                                            </td>
                                            <td scope="row">
                                                <?php echo $event['amount'] + $event['admin_profit']; ?>
                                            </td>
                                            <td scope="row">
                                                <?php echo $status; ?>
                                            </td>
                                            <td scope="row">
                                                <a href="./event-details.php?id=<?php echo $event['event_id'] ?>" class="btn btn-primary">Details</a>
                                                <?php if($status == 'Completed'){ ?>
                                                    <a href="review-page.php?event=<?php echo $event['event_id']?>" class="btn btn-outline-dark">write a review</a>
                                                <?php } ?>
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
    </div>
<?php }?>


<?php include('./footer.php');?>