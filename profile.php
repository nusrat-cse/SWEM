<?php include('./header.php');?>
<?php require('./config.php');
    global $pdo;
    $user_type = intval($_SESSION['user_type']);
    if($user_type == 1){
        $result = $pdo->prepare("SELECT * FROM volunteer WHERE volunteer_id=?");
    }   
    if($user_type == 2){
        $result = $pdo->prepare("SELECT * FROM donor WHERE donor_id=?");
    }
    if($user_type == 3){
        $result = $pdo->prepare("SELECT * FROM event_organizer WHERE organizer_id=?");
    }
    
    $result->execute(array(intval($_SESSION['user_id'])));
    $user= $result->fetch();
    
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

<div class="px-3 bg-white" style="min-height:100vh">
    <div class="row">
        <div class="col-md-3 " style="min-height:100vh;padding-right:0px">
            <div class="d-flex justify-content-center flex-column align-items-center py-3" style="background: gainsboro;">
                <div><img src="./public/image/img4.jpg" class="rounded-circle" style="width:100px;height:100px" alt=""></div>
                <div style="font-size: 29px;text-transform: uppercase;"><?php echo $_SESSION['user_name'] ?></div>
            </div>
            <div class="list-group py-2">
                <a href="./dashboard.php" class="list-group-item list-group-item-action fs-4" aria-current="true">
                    Dashboard
                </a>
                <?php if($user_type == '1'){
                    ?>
                    <a href="./request-events.php" class="list-group-item list-group-item-action fs-4">Requested Events</a>
                    <a href="./confirmed-events.php" class="list-group-item list-group-item-action fs-4">Confirmed Events</a>
                    <a href="./complete-events.php" class="list-group-item list-group-item-action fs-4">Completed Events</a>
                <?php } ?>
                <?php if($user_type == '2'){
                    ?>
                    <a href="./donate-events.php" class="list-group-item list-group-item-action fs-4">Donated Events</a>
                <?php } ?>
                
                
                <a href="./profile.php" class="list-group-item list-group-item-action fs-4 active">Profile</a>

            </div>
            <div class="list-group py-2">
                <a href="./settings.php" class="list-group-item list-group-item-action fs-4">Settings</a>
                <a href="./logout.php" class="list-group-item list-group-item-action fs-4">Log-out</a>
                
            </div>
        </div>
        <div class="col-md-9 p-0">
            <div class="dashboard_profile">
                <h1>Profile</h1>
            </div>
            <div class="gap px-2 py-2">
                <table class="table table-striped-columns table-hover">
                    <tbody style="    background: ghostwhite;">
                        <tr>
                            <td class="col-3 text-bold">User Name</td>
                            <td class=""><?php echo $user['user_name'] ?></td>
                        </tr>
                        <tr>
                            <td class="col-3">Email Address</yd>
                            <td class=""><?php echo $user['email'] ?></td>
                        </tr>
                        <tr>
                            <td class="col-3">Phone Number</yd>
                            <td class=""><?php echo $user['mobile'] ?></td>
                        </tr>
                        <tr>
                            <td class="col-3">Present Address</yd>
                            <td class="">
                                <textarea name="" id="" cols="30" rows="10" disabled>
                                    <?php echo $user['address'] ?>,
                                    
                                </textarea>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>




<?php include('./footer.php');?>