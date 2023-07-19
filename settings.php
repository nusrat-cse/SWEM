<?php include('./header.php');?>
<?php require('./config.php');
    global $pdo;
    $user_type = $_SESSION['user_type'];
    if($user_type == '1'){
        $result = $pdo->prepare("SELECT participator.status AS e_status,event.* FROM participator JOIN event ON event.id=participator.event_id WHERE participator.user_id=? AND participator.status=?");
        $result->execute(array(intval($_SESSION['user_id']),1));
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
    .volunter_text{

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
                    <a href="./request-events.php" class="list-group-item list-group-item-action fs-4">Requested Events</a>
                    <a href="./confirmed-events.php" class="list-group-item list-group-item-action fs-4">Confirmed Events</a>
                    <a href="./complete-events.php" class="list-group-item list-group-item-action fs-4">Completed Events</a>
                    <a href="./profile.php" class="list-group-item list-group-item-action fs-4">Profile</a>

                </div>
                <div class="list-group py-2">
                    <a href="./settings.php" class="list-group-item list-group-item-action fs-4 active">Settings</a>
                    <a href="./logout.php" class="list-group-item list-group-item-action fs-4">Log-out</a>
                    
                </div>
            </div>
            <div class="col-md-9 p-0">
                <div class="dashboard_profile">
                    <h1>Settings</h1>
                </div>
                <div class="px-2 py-2">
                    <div class="row d-flex justify-content-center">
                        <div class="volunter_text">Password Change</div>
                        <div class="col-md-12 col-12 password_chage_card">
                            <div class="form">
                                <label for="" class="form-label font_weight">Old password</label>
                                <input type="password" class="form-control" id="password" placeholder="old password">
                            </div>
                            <div class="form">
                                <label for="" class="form-label font_weight">New password</label>
                                <input type="password" class="form-control" id="new_password" placeholder="new password">
                            </div>
                            <div class="form d-flex justify-content-center">
                                <button type="submit" id="changePassword" class="w-50 btn btn-primary form_button">change password</button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php }?>

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
                    <a href="./donate-events.php" class="list-group-item list-group-item-action  fs-4">Donated Events</a>
                    <a href="./profile.php" class="list-group-item list-group-item-action fs-4">Profile</a>

                </div>
                <div class="list-group py-2">
                    <a href="./settings.php" class="list-group-item list-group-item-action fs-4 active">Settings</a>
                    <a href="./logout.php" class="list-group-item list-group-item-action fs-4">Log-out</a>
                    
                </div>
            </div>
            <div class="col-md-9 p-0">
                <div class="dashboard_profile">
                    <h1>Settings</h1>
                </div>
                <div class="px-2 py-2">
                    <div class="row d-flex justify-content-center">
                        <div class="volunter_text">Password Change</div>
                        <div class="col-md-12 col-12 password_chage_card">
                            <div class="form">
                                <label for="" class="form-label font_weight">Old password</label>
                                <input type="password" class="form-control" id="password" placeholder="old password">
                            </div>
                            <div class="form">
                                <label for="" class="form-label font_weight">New password</label>
                                <input type="password" class="form-control" id="new_password" placeholder="new password">
                            </div>
                            <div class="form d-flex justify-content-center">
                                <button type="submit" id="changePassword" class="w-50 btn btn-primary form_button">change password</button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php }?>
<?php include('./footer.php');?>
<script>
    $('#changePassword').on('click',()=>{
        var old = $('#password').val()
        var new_ = $('#new_password').val()
        if(new_.length >= 8){
            $.ajax({
                type:"POST",
                url:'change_password.php',
                data:{
                    old:old,
                    new:new_
                },
                success:(response)=>{
                    var data = JSON.parse(response)
                    if(data['status'] == 'success'){
                        alert("Password change successfully");
                        location.reload()
                    }else if(data['status'] == 'not_match'){
                        alert("Old password not match");
                    }else{
                        alert("Please login and try again ");
                    }
                    
                }
            })
        }else{
            alert("New Password minimum 8 length")
        }
        
    })
</script>