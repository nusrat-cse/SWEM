<?php include('header.php'); ?>
<?php
    
    require('./config.php');
    global $pdo;
    require("vendor/autoload.php");
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    $success = null;
    $error = null;
    if(isset($_REQUEST['forgotpassword'])){
        $email = $_REQUEST['email'];
        $type = $_REQUEST['type'];
        if($type == 1){
            $sql = "SELECT email FROM volunteer WHERE email=? LIMIT 1";
        }
        if($type == 2){
            $sql = "SELECT email FROM donor WHERE email=? LIMIT 1";
        }
        if($type == 3){
            $sql = "SELECT email FROM event_organizer WHERE email=? LIMIT 1";
        }
        $checkEmail = $pdo->prepare($sql);
        $checkEmail->execute(array($email));
        $data = $checkEmail->rowCount();
        if($data > 0){
            $mail = new PHPMailer(true);
            // $mail->SMTPDebug = SMTP::DEBUG_SERVER;
            $mail->isSMTP();
            $mail->SMTPAuth = true;
            $mail->Host = "smtp.gmail.com";
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;
            $mail->isHTML(true);
            $token = base64_encode($email);
            $subject = 'Forgot Password on localhost/event';
           
            $link = 'http://localhost/event/create-new-forgot-password.php?token='.$token.'&type='.$type;
            $message = "
                <p>You're receiving this email because you requested a password reset for your user account at localhost:8000.</p>
                <p>Please go to the following page and choose a new password:</p>
                <p><a href='".$link."'>$link</a></p>
                <p>Your email, in case you've forgotten: $email</p>
                <p>Thanks for using our site!</p>
                
            ";
            // change
            $password = "gvmzetuwblfxmjah";
            $send_to_email = "limonraycse2020@gmail.com";
            $mail->Username = $send_to_email;
            $mail->Password = $password;
            // 'rphqofjqxqicwzvd'
            $mail->setFrom($send_to_email,"Admin");
            // end change
            $mail->addAddress($email);
            $mail->Subject = $subject;
            $mail->Body = $message;
            $mail_result = $mail->send();
            if($mail_result){
                $success  = "Check Your Email and Click on the link sent to your email";
            }
        }else{
            $error = "Invalid Email";
            
        }
    }

?>


<div class="row d-flex justify-content-center form-container">
    <div class="col-md-6 col-12 rg-background">
        <div class="p-2 sign-text">Forgot Password</div>
       <?php if($success != null){ ?>
           <p class="bg-success text-white"><?php echo $success; ?>
        <?php }else{ ?>
            <p class="bg-danger text-white"> <?php echo $error;?> </p>
        <?php } ?>
        <form  method="post">
            <div class="form">
                <label for="" class="form-label">Email Address</label>
                <input type="text" class="form-control" name="email" placeholder="email address">
            </div>
            <div class="form d-flex justify-content-center">
                <button type="submit" name="forgotpassword" class="w-50 btn btn-primary form_button">Submit</button>
            </div>
        </form>
    </div>
</div>
<?php include('footer.php') ?>