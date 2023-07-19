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
    $district = $_POST['district'];
    $thana = $_POST['thana'];
    $address = $_POST['address'];
    if($usertype == "1"){
        $occupation = $_POST['occupation'];
        $education = $_POST['education'];
    }
    
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
        
    $checkemail = checkValue('email',$email,$pdo); 
    $checkmobile = checkValue('mobile',$mobile,$pdo);
    $checkpassword = $password == $conpassword;
    if($check == 0){
        if(($checkmobile < 1) and ($checkemail < 1)){
            if($usertype == '2'){
                $adduser = $pdo->prepare("INSERT INTO user (user_name,email,mobile,user_type,password,thana_id,district_id,address,account_status) VALUES(?,?,?,?,?,?,?,?,?)");
                $result = $adduser->execute(array($username,$email,strval($mobile),intval($usertype),$conpassword,intval($thana),intval($district),$address,0));
                if($result){
                    echo 'success';
                }else{
                    echo "error";
                }
            }
            if($usertype == '1'){
                $adduser = $pdo->prepare("INSERT INTO user (v_occupation,v_education,user_name,email,mobile,user_type,password,thana_id,district_id,address,account_status) VALUES(?,?,?,?,?,?,?,?,?,?,?)");
                $result = $adduser->execute(array($occupation,$education,$username,$email,strval($mobile),intval($usertype),$conpassword,intval($thana),intval($district),$address,0));
                if($result){
                    echo 'success';
                }else{
                    echo "error";
                }
            }
        }else{

            echo "All ready add";
        }
    }
    

    function checkValue($column,$checkdata,$pdo){
        $sql = "SELECT * FROM user WHERE ".$column."=?";
        $checkemail = $pdo->prepare($sql);
        $checkemail->execute(array($checkdata));
        return $checkemail->rowCount();
    } 

?>