<?php require('./config.php');
    global $pdo;
    $district = $pdo->prepare("SELECT * FROM districts");
    $district->execute();
    $all_districts = $district->fetchAll();
    $types  = $pdo->prepare("SELECT * FROM event_type");
    $types->execute();
    $all_types = $types->fetchAll();
    $donation_types = '';
    foreach($all_types as $type){
        $donation_types .='<option value="'.$type['id'].'">'.$type['name'].'</option>';
    }
?>
<?php include('header.php'); ?>
<style>
    .volunter_text{
        text-align: center;
        padding: 20px;
        background: green;
        font-size: 40px;
        font-weight: 600;
    }
    .font_weight{
        font-weight:700
    }
    .address{
        font-size:22px;
        color:white;
    }
</style>
<div class="row d-flex justify-content-center form-container">
    <div class="volunter_text">Donor Registration</div>
    <div class="col-md-6 col-12 rg-background">
        
        <div class="form">
            <label for="" class="form-label font_weight">User name</label>
            <input type="text" class="form-control font_weight" id='user_name' placeholder="Masud">
        </div>
        <div class="form">
            <label for="" class="form-label font_weight">Email Address</label>
            <input type="text" class="form-control font_weight" id="email" placeholder="restore@gmail.com">
        </div>
        <div class="form">
            <label for="" class="form-label font_weight">Mobile number</label>
            <input type="text" class="form-control font_weight" id="mobile" placeholder="0189XXXXXXX">
        </div>
        <div class="form">
            <label for="" class="form-label font_weight w-100">Address</label>
            <textarea name="address" id="address"  class="form-content w-100" rows="5" palchholder="House No- 3,Road-4,Dhaka"></textarea>
        </div>
        <div class="form">
            <label for="" class="form-label font_weight">password</label>
            <input type="password" class="form-control" id="password" placeholder="password">
        </div>
        <div class="form">
            <label for="" class="form-label font_weight">Confirm password</label>
            <input type="password" class="form-control" id="con_password" placeholder="confirm password">
        </div>
        <div class="form d-flex justify-content-center">
            <button type="submit" id="register" class="w-50 btn btn-primary form_button">Submit</button>
        </div>

    </div>
</div>
<?php include('footer.php') ?>
<script>
    $('#register').on('click',()=>{
        var user_name = $('#user_name').val();
        var email = $('#email').val();
        var mobile = $('#mobile').val();
        var user_type ='2';
        var password = $('#password').val();
        var con_password = $('#con_password').val()
        var address = $("#address").val();
       
        var check =0;
        if(address == ""){
            alert("Please add your present address");
            check =1;
        }

        if(email ==""){
            alert('Email is required');
            check =1;
        }
        if(mobile==""){
            alert('Mobile is required');
            check =1;
        }
        if((password.length >= 8) || (con_password.length >=  8)){
            if(password != con_password){
                alert('password and con-password not matching');
                check =1;
            }
        }else{
            alert('password minimum length 8');
            check =1;
        }
        
        if(check == 0){
            $.ajax({
                type:'POST',
                url:'./register_data_save.php',
                data:{
                    user_name:user_name,
                    email:email,
                    mobile:mobile,
                    user_type:user_type,
                    password:password,
                    con_password:con_password,
                    address: address,
                },
                success:(response)=>{
                    if(response == "success"){
                        alert("Your registration is successful");
                        location.replace('./log-in.php');
                    }else{
                        alert(response);
                    }
                    
                }
            });
        }
        
    });
    $("#district").on('change',()=>{
        var district_id = $('#district').val();
        $('#thana').empty();
        $.ajax({
            type:"POST",
            url:'./upazila.php',
            data:{
                district:district_id
            },
            success:(response)=>{
                
                var upazila = JSON.parse(response);
                var list_upazila ='';
                upazila['upazila'].forEach((upa)=>{
                    list_upazila +="<option value='"+upa['id']+"'>"+upa['name']+"</option>";
                })
                $('#thana').append(list_upazila)
                
            }

        })
    })
</script>