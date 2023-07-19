<?php require('./config.php');
    session_start();
    global $pdo;
    // $user_type = $_SESSION['user_type'];
    
    // $result = $pdo->prepare("SELECT paritcipator.status AS e_status,event.* FROM paritcipator JOIN event ON event.id=paritcipator.event_id WHERE paritcipator.user_id=?");
    // $result->execute(array(intval($_SESSION['user_id'])));
    // $myparticipate= $result->fetchAll();


    // $donate = $pdo->prepare("SELECT SUM(amount) AS amount FROM donate WHERE user_id=?");
    // $donate->execute(array(intval($_SESSION['user_id'])));
    // $total_donate = $donate->fetch();

    // $totals = $pdo->prepare("SELECT count(id) AS totals FROM donate WHERE user_id=?");
    // $totals->execute(array(intval($_SESSION['user_id'])));
    // $total_event = $totals->fetch();
    

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

    <div class="px-3 bg-white" style="min-height:100vh">
        <div class="row">
            <div class="col-md-3 left_sidebar">
                <div class="d-flex justify-content-center flex-column align-items-center py-3" style="background: gainsboro;">
                    <div><img src="./public/image/img4.jpg" class="rounded-circle" style="width:100px;height:100px" alt=""></div>
                    <div style="font-size: 29px;text-transform: uppercase;"><?php if(isset($_SESSION['user_name'])){echo $_SESSION['user_name'];}else{echo 'user name';}  ?></div>
                </div>
                <div class="list-group py-2">
                    <a href="./index.php" class="list-group-item list-group-item-action  fs-4" aria-current="true">
                        Dashboard
                    </a>
                    <a href="./event-list.php" class="list-group-item list-group-item-action fs-4">Event List</a>
                    <a href="./create-event.php" class="list-group-item list-group-item-action fs-4">Create Event</a>
                    <a href="./donars.php" class="list-group-item list-group-item-action fs-4">Donar List</a>
                <a href="./volunteer.php" class="list-group-item list-group-item-action fs-4">Volunteer List</a>
                    <a href="./profile.php" class="list-group-item list-group-item-action fs-4">Profile</a>

                </div>
                <div class="list-group py-2">
                    <a href="./settings.php" class="list-group-item list-group-item-action active fs-4">Settings</a>
                    <a href="./logout.php" class="list-group-item list-group-item-action fs-4">Log-out</a>
                    
                </div>
            </div>
            <div class="col-md-9 p-0">
                <div class="dashboard_profile">
                    <h1>Settings</h1>
                </div>
                <div class=" px-2 py-2 " >
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