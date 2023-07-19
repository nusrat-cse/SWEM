<?php include('./header.php');?>
<?php require('./config.php');
    global $pdo;
    $user_type = $_SESSION['user_type'];
    if($user_type == '1'){
        $result = $pdo->prepare("SELECT participator.status AS e_status,event.* FROM participator JOIN event ON event.id=participator.event_id WHERE participator.user_id=? AND (participator.status=? OR participator.status=?) ORDER BY participator.id DESC");
        $result->execute(array(intval($_SESSION['user_id']),0,2));
        $myparticipate= $result->fetchAll();
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
<?php if($user_type == '1'){
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
                    <a href="./request-events.php" class="list-group-item list-group-item-action active fs-4">Request Events</a>
                    <a href="./confirmed-events.php" class="list-group-item list-group-item-action fs-4">Confirmed Events</a>
                    <a href="./complete-events.php" class="list-group-item list-group-item-action fs-4">Complete Events</a>
                    <a href="./profile.php" class="list-group-item list-group-item-action fs-4">Profile</a>

                </div>
                <div class="list-group py-2">
                    <a href="./settings.php" class="list-group-item list-group-item-action fs-4">Settings</a>
                    <a href="./logout.php" class="list-group-item list-group-item-action fs-4">Log-out</a>
                    
                </div>
            </div>
            <div class="col-md-9 p-0">
                <div class="dashboard_profile">
                    <h1>Request Events</h1>
                </div>
                <div class=" px-2 py-2">
                    <table class="table table-bordered p-0 table-primary table-hover">
                        <thead>
                            <th scope="col" class="p-0 py-3 fs-5">Event Name</th>
                            <th scope="col" class="p-0 py-3 fs-5">Event Image</th>
                            <th scope="col" class="p-0 py-3 fs-5">Event Start</th>
                            <th scope="col" class="p-0 py-3 fs-5">Event End</th>
                            <th scope="col" class="p-0 py-3 fs-5">Status</th>
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
    </div>
<?php }?>



<?php include('./footer.php');?>