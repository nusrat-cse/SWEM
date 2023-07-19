<?php include('header.php'); ?>
<?php
    
    require('./config.php');
    global $pdo;

    if(isset($_REQUEST['addNewPassword'])){
        $email = base64_decode($_GET['token']);
        $type = $_REQUEST['type'];
        $password = md5($_REQUEST['password']);
        $repassword = md5($_REQUEST['repassword']);
        if($password == $repassword){
            if($type == 1){
                $sql = "UPDATE volunteer SET password=? WHERE email=?";
                $checkEmail = $pdo->prepare($sql);
                $result = $checkEmail->execute(array($repassword,$email));
                if($result){
                    header('Location: http://localhost/event/volunteer-log-in.php');
                }
            }
            if($type == 2){
                $sql = "UPDATE donor SET password=?  WHERE email=?";
                $checkEmail = $pdo->prepare($sql);
                $result = $checkEmail->execute(array($repassword,$email));
                if($result){
                    header('Location: http://localhost/event/donar-log-in.php');
                }
            }
            if($type == 3){
                $sql = "UPDATE event_organizer SET password=? WHERE email=?";
                $checkEmail = $pdo->prepare($sql);
                $result = $checkEmail->execute(array($repassword,$email));
                if($result){
                    header('Location: http://localhost/event/event-organizer/index.php');
                }
            }
            
        }else{

        }

    }

?>


<div class="row d-flex justify-content-center form-container">
    <div class="col-md-6 col-12 rg-background">
        <div class="p-2 sign-text">Create new Password</div> 
        <form  method="post">
            <div class="form">
                <label for="" class="form-label">New Password</label>
                <input type="password" class="form-control" name="password" placeholder="new password">
            </div>
            <div class="form">
                <label for="" class="form-label">Confirm New Password </label>
                <input type="password" class="form-control" name="repassword" placeholder="confirm new password">
            </div>
            <div class="form d-flex justify-content-center">
                <button type="submit" name="addNewPassword" class="w-50 btn btn-primary form_button">Submit</button>
            </div>
        </form>
    </div>
</div>
<?php include('footer.php') ?>