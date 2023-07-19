<?php include('./header.php');?>
<?php require('./config.php');
    global $pdo;
    $user_type = $_SESSION['user_type'];
    if($user_type == '1'){
        $result = $pdo->prepare("SELECT participator.status AS e_status,event.* FROM participator JOIN event ON event.id=participator.event_id WHERE participator.user_id=?");
        $result->execute(array(intval($_SESSION['user_id'])));
        $myparticipate= $result->fetchAll();

        $re_events = $pdo->prepare('SELECT * FROM participator WHERE status=? AND user_id=?');
        $re_events->execute(array(0,$_SESSION['user_id']));
        $total_request = $re_events->rowCount();

        $con_events = $pdo->prepare('SELECT * FROM participator WHERE status=? AND user_id=?');
        $con_events->execute(array(1,$_SESSION['user_id']));
        $total_confirm= $con_events->rowCount();

        $com_events = $pdo->prepare('SELECT * FROM participator WHERE status=? AND user_id=?');
        $com_events->execute(array(3,$_SESSION['user_id']));
        $total_request_ = $com_events->rowCount();
    }
    if($user_type == '2'){
        $donate = $pdo->prepare("SELECT SUM(donation_amount) AS amount,SUM(platform_fee) AS fee FROM accounts WHERE donor_id=?");
        $donate->execute(array(intval($_SESSION['user_id'])));
        $total_donate = $donate->fetch();

        $totals = $pdo->prepare("SELECT count(donor_id) AS totals FROM accounts WHERE donor_id=?");
        $totals->execute(array(intval($_SESSION['user_id'])));
        $total_event = $totals->fetch();

        // $new_events = $pdo->prepare("SELECT * FROM event WHERE (id NOT IN (SELECT event_id FROM show_event WHERE user_id=?) AND status=?)");
        // $new_events->execute(array(intval($_SESSION['user_id']),1));
        // $total_new_events = $new_events->rowCount();
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
                    <a href="./dashboard.php" class="list-group-item list-group-item-action active fs-4" aria-current="true">
                        Dashboard
                    </a>
                    <a href="./request-events.php" class="list-group-item list-group-item-action fs-4">Requested Events</a>
                    <a href="./confirmed-events.php" class="list-group-item list-group-item-action fs-4">Confirmed Events</a>
                    <a href="./complete-events.php" class="list-group-item list-group-item-action fs-4">Completed Events</a>
                    <a href="./profile.php" class="list-group-item list-group-item-action fs-4">Profile</a>

                </div>
                <div class="list-group py-2">
                    <a href="./settings.php" class="list-group-item list-group-item-action fs-4">Settings</a>
                    <a href="./logout.php" class="list-group-item list-group-item-action fs-4">Log-out</a>
                    
                </div>
            </div>
            <div class="col-md-9 p-0">
                <div class="dashboard_profile">
                    <h1>Dashboard</h1>
                </div>
                <div class="row gap px-2 py-2">
                    
                    <a href="#" class="col-md-3 col-12 dashboard_link">
                        <div class="text">Requested Events</div>
                        <div class="number"><?php echo $total_request; ?> </div>
                    </a>
                    <a href="#" class="col-md-3 col-12 dashboard_link">
                        <div class="text">Confirmed Events</div>
                        <div class="number"><?php echo $total_confirm; ?> </div>
                    </a>
                    <a href="#" class="col-md-3 col-12 dashboard_link">
                        <div class="text">Complete Events</div>
                        <div class="number"><?php echo $total_request_; ?> </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
<?php }?>

<?php if($user_type == '2'){ ?>
    <div class="px-3 bg-white" style="min-height:100vh">
        <div class="row">
            <div class="col-md-3 left_sidebar">
                <div class="d-flex justify-content-center flex-column align-items-center py-3" style="background: gainsboro;">
                    <div><img src="./public/image/img4.jpg" class="rounded-circle" style="width:100px;height:100px" alt=""></div>
                    <div style="font-size: 29px;text-transform: uppercase;"><?php echo $_SESSION['user_name'] ?></div>
                </div>
                <div class="list-group py-2">
                    <a href="./dashboard.php" class="list-group-item list-group-item-action active fs-4" aria-current="true">
                        Dashboard
                    </a>
                    <a href="./donate-events.php" class="list-group-item list-group-item-action fs-4">Total Events</a>
                    <a href="./profile.php" class="list-group-item list-group-item-action fs-4">Profile</a>

                </div>
                <div class="list-group py-2">
                    <a href="./settings.php" class="list-group-item list-group-item-action fs-4">Settings</a>
                    <a href="./logout.php" class="list-group-item list-group-item-action fs-4">Log-out</a>
                    
                </div>
            </div>
            <div class="col-md-9 p-0">
                <div class="dashboard_profile">
                    <h1>Dashboard</h1>
                </div>
                <div class="row px-2 py-2 justify-content-center" style="column-gap:5%;row-gap:15px">
                    
                    <a href="#" class="col-md-5 col-12 dashboard_link">
                        <div class="text">Total Events</div>
                        <div class="number"><?php echo  $total_event['totals'] ?></div>
                    </a>
                   
                    <a href="#" class="col-md-5 col-12 dashboard_link">
                        <div class="text">Donations</div>
                        <div class="number"><?php echo $total_donate['amount'] + $total_donate['fee'] ?></div>
                    </a>
                    
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<?php include('./footer.php');?>