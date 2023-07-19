<?php require('./config.php');
    session_start();
    global $pdo;
    if(isset($_SESSION['user_type'])){
        $user_type = $_SESSION['user_type'];
    
        $result = $pdo->prepare("SELECT participator.status AS e_status,event.* FROM participator JOIN event ON event.id=participator.event_id WHERE participator.user_id=?");
        $result->execute(array(intval($_SESSION['user_id'])));
        $myparticipate= $result->fetchAll();


        $donate = $pdo->prepare("SELECT SUM(accounts.donation_amount) AS amount FROM accounts
            JOIN event ON event.id = accounts.event_id
         WHERE event.e_organizer=?");
        $donate->execute(array(intval($_SESSION['user_id'])));
        $total_donate = $donate->fetch();

        $totals = $pdo->prepare("SELECT count(id) AS totals FROM event WHERE e_organizer=?");
        $totals->execute(array(intval($_SESSION['user_id'])));
        $total_event = $totals->fetch();

        $complete_totals = $pdo->prepare("SELECT count(id) AS totals FROM event WHERE e_organizer=? AND event_status = ?");
        $complete_totals->execute(array(intval($_SESSION['user_id']),3));
        $complete_totals_event = $complete_totals->fetch();
        if($complete_totals_event['totals'] < 10){
            $result = $pdo->prepare("UPDATE event_organizer SET experience=? WHERE organizer_id=?");
            $result->execute(array(1,intval($_SESSION['user_id'])));
        }else if (($complete_totals_event['totals'] >= 10) and ($complete_totals_event['totals'] < 20)) {
            $result = $pdo->prepare("UPDATE event_organizer SET experience=? WHERE organizer_id=?");
            $result->execute(array(2,intval($_SESSION['user_id'])));
        }else{
            $result = $pdo->prepare("UPDATE event_organizer SET experience=? WHERE organizer_id=?");
            $result->execute(array(3,intval($_SESSION['user_id'])));
        }
        $result = $pdo->prepare("UPDATE event_organizer SET experience=? WHERE organizer_id=?");
            $result->execute(array(1,intval($_SESSION['user_id'])));
    }
    
    

?>
<?php include('./header.php');?>
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
<?php if(isset($_SESSION['user_id'])){ ?>

    <div class="px-3 bg-white" style="min-height:100vh">
        <div class="row m-0">
            <div class="col-md-3 left_sidebar">
                <div class="d-flex justify-content-center flex-column align-items-center py-3" style="background: gainsboro;">
                    <div><img src="./public/image/img4.jpg" class="rounded-circle" style="width:100px;height:100px" alt=""></div>
                    <div style="font-size: 29px;text-transform: uppercase;"><?php if(isset($_SESSION['user_name'])){echo $_SESSION['user_name'];}else{echo 'user name';}  ?></div>
                </div>
                <div class="list-group py-2">
                    <a href="./dashboard.php" class="list-group-item list-group-item-action active fs-4" aria-current="true">
                        Dashboard
                    </a>
                    <a href="./event-list.php" class="list-group-item list-group-item-action fs-4">Event List</a>
                    <a href="./create-event.php" class="list-group-item list-group-item-action fs-4">Create Event</a>
                    <a href="./donars.php" class="list-group-item list-group-item-action fs-4">Donar List</a>
                <a href="./volunteer.php" class="list-group-item list-group-item-action fs-4">Volunteer List</a>
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
                <div class="row px-2 py-2 justify-content-center" style="column-gap:5%">
                    
                    <a href="#" class="col-md-5 col-12 dashboard_link">
                        <div class="text">Donated events</div>
                        <div class="number"><?php if(isset($total_event)){echo  $total_event['totals'];}else{ echo "0";} ?></div>
                    </a>
                    <a href="#" class="col-md-5 col-12 dashboard_link">
                        <div class="text">Donations</div>
                        <div class="number"><?php if(isset($total_donate)){echo $total_donate['amount'];}else{ echo "0";} ?></div>
                    </a>
                    
                </div>
            </div>
        </div>
    </div>
<?php }else{ ?> 
<div class="row d-flex justify-content-center form-container">
    <div class="col-md-6 col-12 rg-background">
        <div class="p-2 sign-text">Sign In</div> 
        <div class="form">
            <label for="" class="form-label">Email Address</label>
            <input type="text" class="form-control" id="email" placeholder="email address">
        </div>
        
        <div class="form">
            <label for="" class="form-label">password</label>
            <input type="password" class="form-control" id="password" placeholder="password">
        </div>
        <div class="form d-flex justify-content-end">
            <a href="../forget-password.php?type=3" class="text-danger">Forgot your password?</a>
        </div>
        <div class="form d-flex justify-content-center">
            <button type="submit" id="login" class="w-50 btn btn-primary">Log in</button>
        </div>
    </div>
</div>
<?php } ?>

<?php include('./footer.php');?>
<script>
    $('#login').on('click',()=>{
        var email = $('#email').val();
        var password = $("#password").val();
        $.ajax({
            type:"POST",
            url:"./login-check.php",
            data:{
                email:email,
                password : password
            },
            success:(response)=>{
                var data = JSON.parse(response);
                if(data['status']=='success'){
                    alert('log-in success');
                    if(data['user_type'] == '3'){
                        location.replace('./index.php');
                    }else{
                        alert("Sorry, you are not event organizer");
                    }
                    
                }else if(data['status']=='pending'){
                    alert('Wait for approval please');
                }else if(data['status']=='inActive'){
                    alert('Opps ! your account in-active');
                }
            }
        })
    })
</script>