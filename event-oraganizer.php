<?php require('./config.php');
    global $pdo;

?>
<?php
    global $pdo;
    $error_array = array();
    if($_SERVER['REQUEST_METHOD']== "POST"){
        $username = $_POST['user_name'];
        $mobile = $_POST['mobile'];
        $password = md5($_POST['password']);
        $conpassword = md5($_POST['con_password']);
        $email = $_POST["email"];
        $address = $_POST['address'];
        $organization = $_POST['organization'];

        $image_dir = "./organizer-document/";
        $valid = 0;

        if($password != $conpassword){
            array_push($error_array,"password and confirm password not match");  
            $valid = 1;
        }
        if(strlen($conpassword) <= 8){
            array_push($error_array,"password minimum length 8");  
            $valid = 1;
        }
        if(empty($username)){
            array_push($error_array,"Please add user name");  
            $valid = 1;
        }
        if(empty($mobile)){
            array_push($error_array,"Please add mobile number");  
            $valid = 1;
        }
        if(!empty($_POST['mobile'])){
            if(!preg_match('/^[0]{1}[0-9]{10}+$/', $mobile)){
                array_push($error_array,"Only numeric value allowed ");
                $check =1;
            };
        }
        if(strlen($mobile) != 11){
            array_push($error_array,"Mobile number must contain 11 digits");
            $check =1;
        }
        if(empty($organization)){
            array_push($error_array,"Please add your organization name");  
            $valid = 1;
        }
        if(empty($address)){
            array_push($error_array,"Please add your address");  
            $valid = 1;
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            array_push($error_array,"Invalid email format"); 
            $check =1;
        }
        $checkemail = checkValue('email',$email,$pdo); 
        $checkmobile = checkValue('mobile',$mobile,$pdo);

        if($valid == 0){
            if(($checkmobile < 1) and ($checkemail < 1)){
                $adduser = $pdo->prepare("INSERT INTO event_organizer (organization_name,user_name,email,mobile,password,address,account_status) VALUES(?,?,?,?,?,?,?)");
                $result = $adduser->execute(array($organization,$username,$email,strval($mobile),$conpassword,$address,0));
                if($result){
                    ?>
                    <script>
                        alert('Hurray ! Your registration is successful');
                        location.replace('./log-in.php');
                    </script>
                <?php } 
            }else{
                array_push($error_array,'opps mobile number or email all ready add');
            }
             
        }

         
    }
    function checkValue($column,$checkdata,$pdo){
        $sql = "SELECT * FROM event_organizer WHERE ".$column."=?";
        $checkemail = $pdo->prepare($sql);
        $checkemail->execute(array($checkdata));
        return $checkemail->rowCount();
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
    <div class="volunter_text">Event Organizer Registration</div>
    <div class="col-md-6 col-12 rg-background">
        <?php 
            if(!empty($error_array)){
                foreach($error_array as $error){
                ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Opps!</strong> <?php echo $error;?> .
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php }}
        
        ?>
        <?php 
            if(!empty($success)){
                
                ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Hurray!</strong> <?php echo $success;?> .
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php }
        
        ?>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data"> 
            <div class="form">
                <label for="" class="form-label font_weight">Email Address</label>
                <input type="text" class="form-control font_weight" name="email" placeholder="restore@gmail.com">
            </div>
            <div class="form">
                <label for="" class="form-label font_weight">Mobile number</label>
                <input type="text" class="form-control font_weight" name="mobile" placeholder="0189XXXXXXX">
            </div>
            
            <div class="form">
                <label for="" class="form-label font_weight">Founder Name</label>
                <input type="text" class="form-control font_weight" name='user_name' placeholder="Masud">
            </div>
            <div class="form">
                <label for="" class="form-label font_weight">Organization Name</label>
                <input type="text" class="form-control font_weight" name='organization' placeholder="Restore Limited">
            </div>
            <div class="form">
                <label for="" class="form-label font_weight w-100">Address</label>
                <textarea name="address" name="address"  class="form-content w-100" rows="5" palchholder="House No- 3,Road-4,Dhaka"></textarea>
            </div>
            <div class="form">
                <label for="" class="form-label font_weight">password</label>
                <input type="password" class="form-control" name="password" placeholder="password">
            </div>
            <div class="form">
                <label for="" class="form-label font_weight">Confirm password</label>
                <input type="password" class="form-control" name="con_password" placeholder="confirm password">
            </div>
            <div class="form d-flex justify-content-center">
                <button type="submit" class="w-50 btn btn-primary form_button">Submit</button>
            </div>
        </form>
    </div>
</div>
<?php include('footer.php') ?>
<script>
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
                // console.log(list_upazila)
            }

        })
    })
</script>