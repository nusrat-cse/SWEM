<?php include('header.php'); ?>

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
            <a href="./forget-password.php?type=1" class="text-danger">Forgot your password?</a>
        </div>
        <div class="form d-flex justify-content-center">
            <button type="submit" id="login" class="w-50 btn btn-primary form_button">Log in</button>
        </div>
    </div>
</div>
<?php include('footer.php') ?>
<script>
    $('#login').on('click',()=>{
        var email = $('#email').val();
        var password = $("#password").val();
        $.ajax({
            type:"POST",
            url:"./login-check.php",
            data:{
                email:email,
                password : password,
                user_type: 1
            },
            success:(response)=>{
                var data = JSON.parse(response);
                if(data['status']=='success'){
                    alert('Logged in successfully');
                    if(data['user_type'] == '1'){
                        location.replace('./index.php');
                    }else if(data['user_type'] == '2'){
                        location.replace('./index.php');
                    }else if(data['user_type'] == '3'){
                        location.replace('./event-organizer/index.php');
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