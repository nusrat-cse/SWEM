<?php require('./config.php'); 
    
?>
<?php
    global $pdo;
    $username = $_POST['user_name'];
    $mobile = $_POST['mobile'];
    $usertype = $_POST['user_type'];
    $password = md5($_POST['password']);
    $conpassword = md5($_POST['con_password']);
    $email = $_POST["email"];
    $address = $_POST['address'];
    
    // if($usertype == "1"){
    //     $occupation = $_POST['occupation'];
    //     $education = $_POST['education'];
    //     $skill = $_POST['skill'];
    // }
    // if($usertype == '2'){
    //     $donation_type = $_POST['donation_type'];
    // }
    $check=0;
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "Invalid email format"; 
            $check =1;
        }

    if(!empty($_POST['mobile'])){
        if(!preg_match('/^[0]{1}[0-9]{10}+$/', $mobile)){
            echo "Only numeric value allowed ";
            $check =1;
        };
    }
    
    if(strlen($mobile) != 11){
        echo "Mobile number must contain 11 digits";
        $check =1;
    }
        
    
    $checkpassword = $password == $conpassword;
    if($check == 0){
        if($checkpassword){
            if($usertype == '2'){
                $sql = "SELECT * FROM donar WHERE email=?";
                $checkemail = $pdo->prepare($sql);
                $checkemail->execute(array($email));
                $emailStatus = $checkemail->rowCount();
                $sqlm = "SELECT * FROM donar WHERE mobile=?";
                $checkmobile = $pdo->prepare($sqlm);
                $checkmobile->execute(array($mobile));
                $mobileStatus = $checkmobile->rowCount();

                if(($mobileStatus < 1) and ($emailStatus < 1)){
                    $adduser = $pdo->prepare("INSERT INTO donar (user_name,email,mobile,password,address,account_status) VALUES(?,?,?,?,?,?)");
                    $result = $adduser->execute(array($username,$email,strval($mobile),$conpassword,$address,0));
                    if($result){
                        echo 'success';
                    }else{
                        echo "error";
                    }
                }else{
                    echo "All ready add";
                }
            }
            if($usertype == '1'){
                $sql = "SELECT * FROM volunteer WHERE email=?";
                $checkemail = $pdo->prepare($sql);
                $checkemail->execute(array($email));
                $emailStatus = $checkemail->rowCount();
                $sqlm = "SELECT * FROM volunteer WHERE mobile=?";
                $checkmobile = $pdo->prepare($sqlm);
                $checkmobile->execute(array($mobile));
                $mobileStatus = $checkmobile->rowCount();

                $skill = $_POST['skill'];
                $skill_array = explode(',',$skill);
                $interest_event = $_POST['interest'];
                $interest_array = explode(',',$interest_event);




                if(($mobileStatus < 1) and ($emailStatus < 1)){


                    $adduser = $pdo->prepare("INSERT INTO volunteer (user_name,email,mobile,password,address,account_status) VALUES(?,?,?,?,?,?)");
                    $result = $adduser->execute(array($username,$email,strval($mobile),$conpassword,$address,0));
                    $last_id = $pdo->lastInsertId();
                    foreach ($skill_array as $value) {
                        $v_skill = $pdo->prepare("INSERT INTO volunteer_skill(volunteer_id,skill_id) VALUES(?,?)");
                        $v_skill->execute(array(intval($last_id),intval($value)));
                    }
                    foreach ($interest_array as $value) {
                        $v_interest = $pdo->prepare("INSERT INTO volunteer_interest(volunteer_id,event_type_id) VALUES(?,?)");
                        $v_interest->execute(array(intval($last_id),intval($value)));
                    }
                    
                    if($result){
                        echo 'success';
                    }else{
                        echo "error";
                    }
                }else{

                    echo "All ready add";
                }
            }
        }else{
            echo "Password don't match";
        }  
        
    }
?>